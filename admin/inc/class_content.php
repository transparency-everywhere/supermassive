<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_content
 *
 * @author stefan
 */
class content{
    public $id;
    
    function __construct($id=NULL){
        if($id != NULL){
            $this->id = $id;
        }
            
    }
    function create($parent_navigation_id, $title, $keywords, $description, $content, $template=NULL, $active=true, $template_vars='NULL', $basepath=''){
        $userGroups = new usergroups();
        if($userGroups->authorize('createContents')){ 
 	if($template == NULL){
            $cmsConfig = cms::getConfig();
            $template = $cmsConfig['template_id'];
        }
        $navigation = new navigation($parent_navigation_id);
        $orderId = $navigation->getHighestOrderId();
        
            $contentData['parent_navigation_id'] = $parent_navigation_id;
            $contentData['title'] = $title;
            $contentData['keywords'] = $keywords;
            $contentData['description'] = $description;
            $contentData['content'] = $content;        
            $contentData['template'] = $template;
            $contentData['active'] = $active;
            $contentData['order_id'] = ($orderId+1);
            $contentData['template_vars'] = $template_vars;
            if(!empty($basepath))
                $contentData['basepath'] = $basepath;

            $db = new db();
            $contentId = $db->insert('contents', $contentData);
            $contentData['id'] = $contentId;

            $class_template = new template($template);
            $class_template->parse($contentData);

            $class_cms = new cms();
            $class_cms->parseNavigations();

            return $contentId;
        }
    }
    function update($parent_navigation_id, $title, $keywords, $description, $content, $template, $active, $template_vars){
        $userGroups = new usergroups();
        if($userGroups->authorize('updateContents')){
            //set array
            $contentData['parent_navigation_id'] = $parent_navigation_id;
            $contentData['title'] = $title;
            $contentData['keywords'] = $keywords;
            $contentData['description'] = $description;
            $contentData['content'] = $content;        
            $contentData['template'] = $template;
            $contentData['active'] = $active;
            $contentData['id'] = $this->id;
            $contentData['template_vars'] = $template_vars;

            //delete old html file
            $oldContentData = $this->select($this->id);
            if (file_exists(dirname(__FILE__) . '/../../'.urlencode($oldContentData['title']).".html")){
                unlink(dirname(__FILE__) . '/../../'.urlencode($oldContentData['title']).".html");
            }

            //update db table contents
            $db = new db();
            $db->update('contents', $contentData, array('id',$this->id));

            //parse updated content to html
            $class_template = new template($template);
            $class_template->parse($contentData);

            //parse navigations
            $class_cms = new cms();
            $class_cms->parseNavigations();
        }
    }
    function select($id=NULL,$parent_id=NULL){
        $userGroups = new usergroups();
        if(true){
            $db = new db();
            if($parent_id != NULL){
                return $db->select('contents', array('parent_navigation_id',$parent_id));
            }
            if($id != NULL){
                $return = $db->select('contents', array('id',$id));
                return $return;
            }
            if($id == NULL){
            return $db->select('contents');
            }
        }
    }
    function delete(){
        $userGroups = new usergroups();
        if($userGroups->authorize('deleteContents')){
            $contentData = $this->select($this->id);
            if(unlink(dirname(__FILE__) . '/../../'.urlencode($contentData['title']).".html")){
            $db = new db();
            $db->delete('contents', array('id',$this->id));
            
            $class_cms = new cms();
            $class_cms->parseNavigations();
            return true;
        }else{
            return false;
        }
        }
    }

}

