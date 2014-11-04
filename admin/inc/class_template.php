<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_template
 *
 * @author stefan
 */
class template{
    public $templateName;
    public $templateId;
    function __construct($constructorValue=NULL){
        if($constructorValue != NULL){
            if (is_numeric($constructorValue)){
            $db = new db();
            $templateData = $db->select('templates', array('id', $constructorValue));
                if(isset($templateData['id'])){
                    $this->templateId = $templateData['id'];
                    $this->templateName = $templateData['title'];
                }
            } else {
                $this->templateName = $constructorValue;
        }
        }
    }    
    function add($file_id){
        
        $media = new media();
        $filename = $media->idToFilename($file_id);
        echo $file_id.' '.$filename;
        $zip = new ZipArchive;
        $res = $zip->open(dirname(__FILE__) . '/../../assets/'.$filename);
        if ($res === TRUE) {
          mkdir(dirname(__FILE__) . '/../../template/temp');
          $zip->extractTo(dirname(__FILE__) . '/../../template/temp');
          $zip->close();
          
          $template = new template('temp');
          $config = $template->getConfig();
          $template_title = $config['template_title'];
          
          //create template folder
          //mkdir(dirname(__FILE__) . '/../../template/'.$template_title);
          
          //move files to template folder
          rename(dirname(__FILE__) . '/../../template/temp/', dirname(__FILE__) . '/../../template/'.$template_title.'/');
          //unlink temp folder
          $db = new db();
          echo $db->insert('templates', array('title'=>$template_title));
          
        } else {
          echo 'doh!';
          echo $res;
          
        }
        
    }
    function delete($template_id){
        
        $path = dirname(__FILE__) . '/../../template/' . $this->templateName . "/";
        deleteDir($path);
        $db = new db();
        $db->delete('templates', array('id', $template_id));
        
    }
    function getConfig(){
        // gets contents of a config.xml into a string
        $filename = dirname(__FILE__) . '/../../template/' . $this->templateName . "/config.xml";
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        $xml = new SimpleXMLElement($contents);
        
        
        //navigations
        $navigations = $xml->navigations->navigation;
        //echo var_dump($navigations);
        //$navigation = $xml->navigations->navigation;
        //echo var_dump($navigation);
        //return false;
        foreach($navigations AS $navigationData){
            unset($temp);
            $temp['navigation_id'] = (string)$navigationData->navigation_id;
            $temp['navigation_ul_class'] = (string)$navigationData->navigation_ul_class;
            $temp['navigation_title'] = (string)$navigationData->navigation_title;
            if($navigationData->parsing_information){
                $temp['parsing_information'] = json_decode(json_encode($navigationData->parsing_information), true); //json en- and decode is used to transform nested object into array
            }
            $navigationArray[] = $temp;
        }
        
        //template vars
        
        $templateVars = $xml->variables->var;
        foreach($templateVars AS $templateVar){
            unset($temp);
            $temp['var_id'] = (string)$templateVar->var_id;
            $temp['var_title'] = (string)$templateVar->var_title;
            $temp['var_default'] = (string)$templateVar->var_default;
            $template_var_array[] = $temp;
        }
        
        
        $configArray['template_title'] = (string)$xml->template_title;
        $configArray['number_of_navigations'] = (int)$xml->number_of_navigations;
        $configArray['navigations'] = $navigationArray;
        $configArray['template_vars'] = $template_var_array;
        return $configArray;
    }
    function getNavigationLevelConfig($parent_template_navigation_id, $depth){
        $templateConfig = $this->getConfig();
        foreach($templateConfig['navigations'] AS $navigationData){
            if($navigationData['navigation_id'] == $parent_template_navigation_id){
                if(isset($navigationData['parsing_information'])){
                    
                            $levels = $navigationData['parsing_information']['levels'];
                            foreach($levels['level'] AS $levelData){
                                if(isset($levelData['depth']))
                                    if($levelData['depth'] == $depth){

                                        return $levelData;

                                    } 
                            }
                }
            }
        }
        
        return array('depth'=>$depth, 'containerOpen'=>'<ul data-id="%navigation_id%">', 'containerClose'=>'</ul>', 'content'=>'<li data-type="content" data-id="%content_id%"><a href="%link%">%caption%</a></li>', 'navigation'=>'<li data-type="navigation" data-id="%navigation_id%"><a href="%link%">%caption%</a>%navigation</li>');
    }
    function generateNavigationOld($parent_navigation_id){
        $db = new db();
        var_dump($navigationContent = $db->select('contents', array('parent_navigation_id', $parent_navigation_id)));
        $getConfig = $this->getConfig();
        $templateData = $db->select('navigations', array('id', $parent_navigation_id));
        $template_navigation_id = $templateData['template_navigation_id'];
        $navigation_ul_class = $getConfig['navigations'][$template_navigation_id]['navigation_ul_class']; 
        $navigation = '<ul class="' . $navigation_ul_class . '">' . "\n";
        foreach($navigationContent AS $contentData){
            $navigation .= '<li> <a href="' . urlencode($contentData['title']) . '.html">' . htmlentities($contentData['title']) . '</a></li>' . "\n";
        }
        $navigation .= '</ul>' . "\n";
        return $navigation;
    }
    function generateNavigation($parent_navigation_id=''){
        $output = '<div class="cms_navigation" data-nav-id="'.$parent_navigation_id.'"></div>';
        return $output;
    }
    /**
    * Parses Template
    *
    * @param array $contentData array with all contentdata.
    * @param bool $parseAdmin defines if function is used to parse the adminpanel.
    * @return bool.
    */
    function parse($contentData, $parseAdmin = false){
        //get cms config
        $cms = new cms();
        $cmsConfigArray = $cms->getConfig();
        
        $homePage = false;
        //check if parsed page is startpage(index)
        
        if(isset($contentData['id'])&&($cmsConfigArray['home_page'] == $contentData['id'])){
            $homePage = true;
        }
        $contents = '';
        if($this->templateName){
            //read template file
            if($homePage){
                $filename = dirname(__FILE__) . '/../../template/' . $this->templateName . '/index.html';
            }else{
                $filename = dirname(__FILE__) . '/../../template/' . $this->templateName . '/content.html';
            }
            $handle = fopen($filename, "r");
            $contents = fread($handle, filesize($filename));
            fclose($handle);
        }else{
            $contents = '%content%';
        }
        
        if($this->templateName){
            //get template config
            $templateConfig = $this->getConfig();
        }
        
        //urlencode title
        $contentData['title'] = urlencode($contentData['title']);
        
        //generate path
        if($parseAdmin){
            $path = dirname(__FILE__) . '/../../admin/' . $contentData['title'] . '.html';
        }else{
            $path = dirname(__FILE__) . '/../../' . $contentData['title'] . '.html';
        }
        
        //open file handler
        $html_file = fopen("$path", "w") or die("Unable to open file!");
        
        
        //generate meta
        $meta = $cms->generateMeta($contentData, $parseAdmin);
        
        if($parseAdmin == true){
            $templatePath = '../template/' . $this->templateName;
        }else{
            if(empty($contentData['basepath']))
                $templatePath = 'template/' . $this->templateName;
            else{
                $templatePath = $contentData['basepath'];
                echo $templatePath;
                $forceLinkParsing = true;
            }
        }
        
        $site_content = base64_decode($contentData['content']);
        
        $contents = str_replace("%title%", htmlentities($contentData['title']) . ' - ' . htmlentities($cmsConfigArray['page_title']), $contents);
        $contents = str_replace('%path%', '', $contents);
        if($this->templateName||$forceLinkParsing)
            $contents = parseLinks($contents,$templatePath);
        
        
        //parse widget areas
        if($parseAdmin == true)
            $contents = preg_replace("/%widget_area\[(.+?)\]%/", '<div class="cms_widget_area" data-textarea-id="$1"></div>', $contents);
        else{
            if($this->templateName){
            $contents = preg_replace("/%widget_area\[(.+?)\]%/e", "widget::generateWidgetArea('".$contentData['id']."','$1')", $contents);
            }
        }
        //add widget to contents
        $site_content = preg_replace("/%widget\[(.+?)\]%/e", "widget::generateWidget('$1')", $site_content);
        
        $site_content = str_replace("&Acirc;", '', $site_content);
        
        if($parseAdmin == true){
            $contents= str_replace("</body>", '<script type="text/javascript" src="inc/jquery-1.11.1.min.js"></script><script type="text/javascript" src="inc/plugins.js"></script><script type="text/javascript" src="inc/functions.js"></script></body>', $contents);
        }else{
            $contents = str_replace("</body>", $cmsConfigArray['analytic_script'].'</body>', $contents);
        }
        
        if(isset($templateConfig['navigations'])){
            foreach($templateConfig['navigations'] AS $navigationData){
                $nav_id = $navigationData['navigation_id'];
                $db = new db();
                $navData = $db->select('navigations', array('template_navigation_id', $nav_id));
                if(isset($navData['id'])){
                    $contents = str_replace("%navigation[$nav_id]%", $this->generateNavigation($navData['id']), $contents);
                }else{
                    $contents = str_replace("%navigation[$nav_id]%", $this->generateNavigation(), $contents);
                }

            }
        }
        if(isset($templateConfig['template_vars'])){
            if(isset($contentData['template_vars'])){
                $varValues = json_decode($contentData['template_vars']);
                foreach($templateConfig['template_vars'] AS $templateVarData){
                    $var_id = $templateVarData['var_id'];
                    if(isset($varValues[$var_id]))
                        $var_value = $varValues[$var_id];
                    else
                        $var_value = $templateVarData['var_default'];
                    $contents = str_replace("%var[".$templateVarData['var_id']."]%", $var_value, $contents);
                }
            }
        }
        
        $contents = str_replace("%content%", $site_content, $contents);
        
        $contents = str_replace("%content_title%", $contentData['title'], $contents);
        $contents = str_replace("%meta%", $meta, $contents);
        
        fwrite($html_file, $contents);
        
        fclose($html_file);
        if(isset($contentData['id'])){
            if(($homePage) && ($contentData['title'] != 'index')){
                $contentData['title'] = 'index';
                $this->parse($contentData);
            }
        }
    }
    
}

