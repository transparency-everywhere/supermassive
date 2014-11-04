<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_plugin
 *
 * @author Transparency Everywhere
 */
class plugins{
    
   public $plugin_folder_name;
    
   public function __construct($plugin_folder_name=''){
       if(!empty($plugin_folder_name)){
            $this->plugin_folder_name = $plugin_folder_name;
       }
   }
    
   /**
   *Inserts record with $options into db $table 
   *@param string $plugin_folder_name name of the folder in ./plugins which contains the plugindata
   *@return array with configdata 
   */
   public function getConfig($plugin_folder_name=NULL){
       
        if((empty($this->plugin_folder_name))&&($plugin_folder_name===NULL))
             return 'no folder name selected';
        
        if($plugin_folder_name==NULL)
            $plugin_folder_name = $this->plugin_folder_name;
        // gets contents of a config.xml into a string
        $filename = dirname(__FILE__) . '/../../plugins/' . $plugin_folder_name . "/config.xml";
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        $xml = new SimpleXMLElement($contents);
        
        $configArray['plugin_name'] = (string)$xml->plugin_name;
        $configArray['plugin_folder_name'] = (string)$xml->plugin_folder_name;
        $configArray['php_class_name'] = (string)$xml->php_class_name;
        $configArray['php_class_contains_installer'] = (boolean)$xml->php_class_contains_installer;
        $configArray['js_class_name'] = (string)$xml->js_class_name;
        $configArray['link_type'] = (string)$xml->link_type;
        $configArray['link_caption'] = (string)$xml->link_caption;
        return $configArray;
   }
   /**
   *Inserts record with $options into db $table 
   *@param bool $active
   *@return bool success
   */
   public function install($active=true){
       $db = new db();
       $checkSQL = $db->select('plugins', array('plugin_folder_name', $this->plugin_folder_name));
       if(is_array($checkSQL)){
           echo 'There allready is a plugin with the folder_name '.$this->plugin_folder_name.'.';
           return false;
       }
       include(dirname(__FILE__) . '/../../plugins/' . $this->plugin_folder_name . "/functions.php");
       $plugin_config = $this->getConfig();
       if($plugin_config['php_class_contains_installer']){
           $classname = $plugin_config['php_class_name'];
           $class_reference = new $classname();
           $class_reference->install();
       }
       if($plugin_config['link_type'] == 'navigation'){
           //!!the navigation is added into navigation with id 1. Just a temporary solution
           $parent_navigation = 1;
           //create navigation in which products can be parsed
           $navigationId = navigation::create($plugin_config['plugin_name'], '-1');
           $navigation_link_id = navigation_link::create($parent_navigation, 'navigation', $navigationId, $plugin_config['link_caption']);
           $values['link_id'] = $navigation_link_id;
           
           cms::parseNavigations();
       }
       
       $values['plugin_name'] = $plugin_config['plugin_name'];
       $values['plugin_folder_name'] = $plugin_config['plugin_folder_name'];
       $values['active'] = $active;
       
       $db->insert('plugins', $values);
       
   }
   public function getPluginTargetId(){
       $pluginData = db::select('plugins', array('plugin_folder_name', $this->plugin_folder_name));
       $linkData = db::select('navigation_links', array('id', $pluginData['link_id']));
       return $linkData['target_id'];
   }
   public function getPluginNavigationId(){
       return $this->getPluginTargetId();
   }
   public function includePlugins(){
       //get all plugins
        $class_db = new db();
        $result = $class_db->select('plugins');
        if(isset($result['id'])){
            $temp = $result;
            unset($result);
            $result[0] = $temp;
        }
        
        //add js class name to result
        if(is_array($result)){
            $i=0;
            foreach($result AS $pluginData){
                include(dirname(__FILE__) . '/../../plugins/' . $pluginData['plugin_folder_name'] . "/functions.php");
            }
        }
   }
   public function add($file_id){
        
        $media = new media();
        $filename = $media->idToFilename($file_id);
        echo $file_id.' '.$filename;
        $zip = new ZipArchive;
        $res = $zip->open(dirname(__FILE__) . '/../../assets/'.$filename);
        if ($res === TRUE) {
        mkdir(dirname(__FILE__) . '/../../plugins/temp');
        $zip->extractTo(dirname(__FILE__) . '/../../plugins/temp');
        $zip->close();

        $plugins = new plugins('temp');
        $config = $plugins->getConfig();
        $plugin_folder_name = $config['plugin_folder_name'];
        $plugin_name = $config['plugin_name'];

        //create template folder
        //mkdir(dirname(__FILE__) . '/../../template/'.$template_title);

        //move files to template folder
        rename(dirname(__FILE__) . '/../../plugins/temp/', dirname(__FILE__) . '/../../plugins/'.$plugin_folder_name.'/');
        
        //install uploaded plugin
        $this->plugin_folder_name = $plugin_folder_name;
        $this->install();
          
        } else {
          echo 'An error occured!';
          echo $res;
          
        }
        
    }
}

