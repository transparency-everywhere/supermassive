<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_navigation
 *
 * @author Transparency Everywhere
 */
class navigation{
    public $navigation_id;
    
    function __construct($id=NULL){
        if($id != NULL){
           $this->navigation_id = $id;
        }
    }
    
    /**
    * Write record into DB and parse navigations
    * @param $title string
    * @param $parent_id int id of parent navigation
    * @param $template_navigation_id int
    * @param $file int linked file_ids
    * @return int id of new record
    */
    function create($title, $parent_id, $template_navigation_id=NULL, $file=NULL){
        $userGroups = new usergroups();
        if($userGroups->authorize('createNavigations')){
            if($parent_id == 0){
                $order_id = -1;//$order_id will be set +1 in the insert function so the inserted value will be 0
            }else{
                $navigationClass = new navigation($parent_id);
                $order_id = $navigationClass->getHighestOrderId();
            }
            
            $values['title'] = $title;
            $values['parent_id'] = $parent_id;
            $values['template_navigation_id'] = $template_navigation_id;
            $values['file'] = $file;
            $values['order_id'] = ($order_id+1);

            
            $db = new db();
            $navigationId = $db->insert('navigations', $values);
            
            $cms = new cms();
            $cms->parseNavigations();
            
            return $navigationId;
        }     
    }
    
    /**
    * Update DB record and parse navigations
    * @param $title string
    * @param $parent_id int id of parent navigation
    * @param $template_navigation_id int
    * @param $file int linked file_ids
    * @return allways returns true
    */
    function update($title, $parent_id, $template_navigation_id, $file){
        $userGroups = new usergroups();
        if($userGroups->authorize('updateNavigations')){ 
            if(!empty($title))
                $values['title'] = $title;
            if(!empty($parent_id))
                $values['parent_id'] = $parent_id;
            if(!empty($template_navigation_id))
                $values['template_navigation_id'] = $template_navigation_id;
            if(!empty($file))
                $values['file'] = $file;

            $db = new db();
            $db->update('navigations', $values, array('id',$this->navigation_id));

            $cms = new cms();
            $cms->parseNavigations();

            return true;
        }
    }
    
    
    
    /*
    * Update DB record and parse navigations
    * @param $title string
    * @param $parent_id int id of parent navigation
    * @param $template_navigation_id int
    * @param $file int linked file_ids
    * @return allways returns true
    */
    function delete(){
        $userGroups = new usergroups();
        if($userGroups->authorize('deleteNavigations')){ 
            $db = new db();
            $db->delete('navigations', array('id',$this->navigation_id));


            $cms = new cms();
            $cms->parseNavigations();
        }
    }
    
    /*
    * Update DB record and parse navigations
    * @param $id id of specific record
    * @param $parent_id if of records you want to select
    * @return array with record(s)
    */
    function select($id = NULL, $parent_id = NULL){
        $userGroups = new usergroups();
        if($userGroups->authorize('seeNavigations')){ 
            $db = new db();
            if($parent_id != NULL){
                return $db->select('navigations', array('parent_id',$parent_id));
            }
            if($id != NULL){
                return $db->select('navigations', array('id',$id));
            }
            if(($id == NULL)&&($parent_id == NULL)){
            return $db->select('navigations');
        }
        }
    }

    function dropdown($preselected=NULL, $parent_id=NULL){
        $navigations = $this->select();
        $i=0;
        $result = "<select name=\"navigation\">";

        foreach($navigations AS $navigationData){

            if($preselected == $navigationData['id'])
                $selected = 'selected="selected"';

            else
                $selected = '';

            $result .= "<option value=\"$navigationData[id]\" $selected>";
            $result .= "$navigationData[title]";
            $result .= "</option>";
            $i++;
        }

        if($i == 0){
            $result .= "<option value=\"\">";
            $result .= "Bitte ausw&auml;hlen";
            $result .= "</option>";
        }

        $result .= "</select>";
        return $result;
    }
    
    function createDirectories($navigation_id) {
        $select = $this->select($navigation_id);
        $id = $select['parent_id'];
        $dirs[$navigation_id] = $select['title'];
        while ($id != '0'){
            $newData = $this->select($id);
            if ($newData['parent_id'] != '0')
                $dirs[$id] = $newData['title'];
            $id = $newData['parent_id'];
        }
        $dirs2 = array_reverse($dirs, true);
        
        $path = dirname(__FILE__) . '/../../';

        $class_cms = new cms();
        $restrictedDirNames = $class_cms->getRestrictedDirectoryNames();
        $i = 0;
        
        foreach ($dirs2 as $value) {
            $path .= $value . "/";
            if ((in_array($value, $restrictedDirNames)&&($i == 0))) {
                echo "The navigation title <b>$value</b> is a restricted title.";
                return false;
            } else {
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $i++;
            }
        }
    }
	
    function generateUL($navigation_id){
        $db = new db();
        $select = $db->select('navigations', array('parent_id', $navigation_id));

        //select contents which are linked directly to the navigations
        $selectContents = $db->select('contents', array('parent_navigation_id', $navigation_id));

        //select navigation links (contents & navigation_links)
        $selectNavigationLinks = $db->select('navigation_links', array('navigation_id', $navigation_id));
        $output = '';
        if(is_array($select)||is_array($selectContents)){

                $output .= '<ul data-id="'.$navigation_id.'">';
                if(isset($select['title'])){
                        $temp = $select;
                        unset($select);
                        $navigations[0] = $temp;
                }else{
                        $navigations = $select;
                }

                if(isset($selectContents['title'])){
                        $temp = $selectContents;
                        unset($selectContents);
                        $selectContents[0] = $temp;
                }else{
                        $selectContents = $selectContents;
                }

                if(isset($selectNavigationLinks['id'])){
                        $temp = $selectNavigationLinks;
                        unset($selectNavigationLinks);
                        $selectNavigationLinks[0] = $temp;
                }else{
                        $selectNavigationLinks = $selectNavigationLinks;
                }


                if(is_array($select)){
                    foreach($navigations AS $navData){
                        if($navData['id'] != 't')
                            $output .= '<li data-type="navigation" data-id="'.$navData['id'].'"><a href="#">'.$navData['title'].'</a>'.$this->generateUL($navData['id']).'</li>';
                    }
                }
                if(is_array($selectContents)){
                    foreach($selectContents AS $contentData)
                            $output .= '<li data-type="content" data-id="'.$contentData['id'].'"><a href="'.urlencode($contentData['title']).'.html">'.$contentData['title'].'</a></li>';

                }
                if(is_array($selectNavigationLinks)){
                    foreach($selectNavigationLinks AS $linkData){
                        if($linkData['target_type'] == 'content'){
                            $content = new content();
                            $contentData = $content->select($linkData['target_id']);
                            $output .= '<li data-type="content" data-id="'.$contentData['id'].'"><a href="'.urlencode($contentData['title']).'.html">'.$contentData['title'].'</a></li>';
                        }   
                    }
                }
                $output .= '</ul>';
        }
        return $output;
    }
    
    /*
    * parses navigationlevel
    * @param $navigation_id db-id of navigation that is supposed to be parsed
    * @param $template undefined id or folder_name of template that is used
    * @param $parent_template_navigation_id int config navigation id of parent navigation
    * @param $level int level that is used
    * @return string level html
    */
    public function parseNavigationLevel($navigation_id, $template, $parent_template_navigation_id, $depth){
        
        //get config for level that needs to be parsed
        $templateClass = new template($template);
        
        $levelConfig[$depth] = $templateClass->getNavigationLevelConfig($parent_template_navigation_id, $depth);
        
        
        $db = new db();
        $select = $db->select('navigations', array('parent_id', $navigation_id));

        //select contents which are linked directly to the navigations
        $selectContents = $db->select('contents', array('parent_navigation_id', $navigation_id));

        //select navigation links (contents & navigation_links)
        $selectNavigationLinks = $db->select('navigation_links', array('navigation_id', $navigation_id));
        $output = '';
        if(is_array($select)||is_array($selectContents)){

                
                //$output .= '<ul data-id="'.$navigation_id.'">';
                $output .= str_replace('%navigation_id%', $navigation_id, $levelConfig[$depth]['containerOpen']);
                if(isset($select['title'])){
                        $temp = $select;
                        unset($select);
                        $navigations[0] = $temp;
                }else{
                        $navigations = $select;
                }

                if(isset($selectContents['title'])){
                        $temp = $selectContents;
                        unset($selectContents);
                        $selectContents[0] = $temp;
                }else{
                        $selectContents = $selectContents;
                }

                if(isset($selectNavigationLinks['id'])){
                        $temp = $selectNavigationLinks;
                        unset($selectNavigationLinks);
                        $selectNavigationLinks[0] = $temp;
                }else{
                        $selectNavigationLinks = $selectNavigationLinks;
                }


                if(is_array($navigations)){
                    foreach($navigations AS $navData){
                        if($navData['id'] != 't'){
                            $navigationHTML = $levelConfig[$depth]['navigation'];
                            $navigationHTML = str_replace('%caption%', $navData['title'], $navigationHTML);
                            $navigationHTML = str_replace('%link%', '#', $navigationHTML);
                            $navigationHTML = str_replace('%navigation_id%', $navigation_id, $navigationHTML);
                            $navigationHTML = str_replace('%navigation%', navigation::parseNavigationLevel($navData['id'], $template, $parent_template_navigation_id, ((int)$depth+1)), $navigationHTML);
             
                            
                            
                            $order_id = $navData['order_id'];
                            $navigationElements[$order_id] = $navigationHTML;
                            
                        }
                    }
                }
                if(is_array($selectContents)){
                    foreach($selectContents AS $contentData){
                        
                            $contentHTML = $levelConfig[$depth]['content'];
                            $contentHTML = str_replace('%caption%', $contentData['title'], $contentHTML);
                            $contentHTML = str_replace('%content_id%', $contentData['id'], $contentHTML);
                            $contentHTML = str_replace('%link%', urlencode($contentData['title']).'.html', $contentHTML);
                           
                            
                            $order_id = $contentData['order_id'];
                            $navigationElements[$order_id] = $contentHTML;
                            //$output .= '<li data-type="content" data-id="'.$contentData['id'].'"><a href="'.urlencode($contentData['title']).'.html">'.$contentData['title'].'</a></li>';

                    }
                }
                if(is_array($selectNavigationLinks)){
                    foreach($selectNavigationLinks AS $linkData){
                        if($linkData['target_type'] == 'content'){
                            $content = new content();
                            $contentData = $content->select($linkData['target_id']);
                            $contentHTML = $levelConfig[$depth]['content'];
                            $contentHTML = str_replace('%caption%', $contentData['title'], $contentHTML);
                            $contentHTML = str_replace('%content_id%', $contentData['id'], $contentHTML);
                            $contentHTML = str_replace('%link%', urlencode($contentData['title']).'.html', $contentHTML);
                            
                            $order_id = $linkData['order_id'];
                            $navigationElements[$order_id] = $contentHTML;
                            
                            
                            //$output .= '<li data-type="content" data-id="'.$contentData['id'].'"><a href="'.urlencode($contentData['title']).'.html">'.$contentData['title'].'</a></li>';
                        }   
                    }
                }
                
                //order all elements by given order id, which is the index of $navigationElements
                ksort($navigationElements);
                foreach($navigationElements AS $index=>$navigationElement){
                    $output .= $navigationElement;
                }
                
                $output .= $levelConfig[$depth]['containerClose'];
        }
        return $output;
                     
    }
    public function parseNavigationLevelOld($navigation_id, $template, $parent_template_navigation_id, $depth){
        
        //get config for level that needs to be parsed
        $templateClass = new template($template);
        
        $levelConfig[$depth] = $templateClass->getNavigationLevelConfig($parent_template_navigation_id, $depth);
        
        
        $db = new db();
        $select = $db->select('navigations', array('parent_id', $navigation_id));

        //select contents which are linked directly to the navigations
        $selectContents = $db->select('contents', array('parent_navigation_id', $navigation_id));

        //select navigation links (contents & navigation_links)
        $selectNavigationLinks = $db->select('navigation_links', array('navigation_id', $navigation_id));
        $output = '';
        if(is_array($select)||is_array($selectContents)){

                
                //$output .= '<ul data-id="'.$navigation_id.'">';
                $output .= str_replace('%navigation_id%', $navigation_id, $levelConfig[$depth]['containerOpen']);
                if(isset($select['title'])){
                        $temp = $select;
                        unset($select);
                        $navigations[0] = $temp;
                }else{
                        $navigations = $select;
                }

                if(isset($selectContents['title'])){
                        $temp = $selectContents;
                        unset($selectContents);
                        $selectContents[0] = $temp;
                }else{
                        $selectContents = $selectContents;
                }

                if(isset($selectNavigationLinks['id'])){
                        $temp = $selectNavigationLinks;
                        unset($selectNavigationLinks);
                        $selectNavigationLinks[0] = $temp;
                }else{
                        $selectNavigationLinks = $selectNavigationLinks;
                }


                if(is_array($select)){
                    foreach($navigations AS $navData){
                        if($navData['id'] != 't'){
                            $navigationHTML = $levelConfig[$depth]['navigation'];
                            $navigationHTML = str_replace('%caption%', $navData['title'], $navigationHTML);
                            $navigationHTML = str_replace('%navigation_id%', $navigation_id, $navigationHTML);
                            $navigationHTML = str_replace('%navigation%', $this->parseNavigationLevel($navData['id'], $template, $parent_template_navigation_id, ((int)$depth+1)), $navigationHTML);
                            $output .= $navigationHTML;
                        }
                    }
                }
                if(is_array($selectContents)){
                    foreach($selectContents AS $contentData){
                        
                            $contentHTML = $levelConfig[$depth]['content'];
                            $contentHTML = str_replace('%caption%', $contentData['title'], $contentHTML);
                            $contentHTML = str_replace('%content_id%', $contentData['id'], $contentHTML);
                            $contentHTML = str_replace('%link%', urlencode($contentData['title']).'.html', $contentHTML);
                            $output .= $contentHTML;
                            //$output .= '<li data-type="content" data-id="'.$contentData['id'].'"><a href="'.urlencode($contentData['title']).'.html">'.$contentData['title'].'</a></li>';

                    }
                }
                if(is_array($selectNavigationLinks)){
                    foreach($selectNavigationLinks AS $linkData){
                        if($linkData['target_type'] == 'content'){
                            $content = new content();
                            $contentData = $content->select($linkData['target_id']);
                            $contentHTML = $levelConfig[$depth]['content'];
                            $contentHTML = str_replace('%caption%', $contentData['title'], $contentHTML);
                            $contentHTML = str_replace('%content_id%', $contentData['id'], $contentHTML);
                            $contentHTML = str_replace('%link%', urlencode($contentData['title']).'.html', $contentHTML);
                            $output .= $contentHTML;
                            //$output .= '<li data-type="content" data-id="'.$contentData['id'].'"><a href="'.urlencode($contentData['title']).'.html">'.$contentData['title'].'</a></li>';
                        }   
                    }
                }
                $output .= $levelConfig[$depth]['containerClose'];
        }
        return $output;
                     
    }

    function parseNavigation($template_navigation_id){
        //open file handler. the file is saved in the root dir of the cms and the name is navigation_$template_navigation_id(e.g. navigation_1)
        $path = dirname(__FILE__) . '/../../navigation_' . $template_navigation_id . '.html';
        $html_file = fopen("$path", "w") or die("Unable to open file!");


        $db = new db();

        $cms = new cms();
        $cmsConfig = $cms->getConfig();
        $template = new template($cmsConfig['template_id']);
        $templateConfig = $template->getConfig();
        
        //get navigationconfig
        foreach($templateConfig['navigations'] AS $navigationData){
            if($navigationData['navigation_id'] == $template_navigation_id)
                $templateNavigationData = $navigationData;
        }
        if(!isset($templateNavigationData['navigation_ul_class']))
            $templateNavigationData['navigation_ul_class'] = '';

        //get record from the table navigations where template_navigation_id=t$emplate_navigation_id
        $select = $db->select('navigations', array('template_navigation_id', $template_navigation_id));		
        //get all the children
        if(isset($select['id'])){
            
            $output = $this->parseNavigationLevel($select['id'], $cmsConfig['template_id'], $template_navigation_id, 0);
            
        }else{
            $output = '<ul></ul>';
        }

        fwrite($html_file, $output);
        fclose($html_file);

        return true;
    }

    function createNavigations(){
        //get number of navigations
        $cms = new cms();
        $cmsConfig = $cms->getConfig();

        $template = new template($cmsConfig['template_id']);
        $templateConfig = $template->getConfig();
        foreach($templateConfig['navigations'] AS $navigationData){
                $this->parseNavigation($navigationData['navigation_id']);
            }
    }
    public function getItemByOrderId($order_id){
        $navigation_id = $this->navigation_id;
        $type = 'navigation';    
        $sql = mysql_query("SELECT * FROM `navigations` WHERE `parent_id`='".mysql_real_escape_string($navigation_id)."' AND `order_id`='".mysql_real_escape_string($order_id)."'");
        $data = mysql_fetch_array($sql);
        if(!$data){
           
            $type = 'content';
            $sql = mysql_query("SELECT * FROM `contents` WHERE `parent_navigation_id`='".mysql_real_escape_string($navigation_id)."' AND `order_id`='".mysql_real_escape_string($order_id)."'");
            $data = mysql_fetch_array($sql);
        }
        if($data == false){
            
            $type = 'navigation_link';
            $sql = mysql_query("SELECT * FROM `navigation_links` WHERE `parent_navigation_id`='".mysql_real_escape_string($navigation_id)."' AND `order_id`='".mysql_real_escape_string($order_id)."'");
            $data = mysql_fetch_array($sql);
        }
        
        if($sql)
            return array($type, $data);
        else
            return false;
                
    }
    public function getHighestOrderId(){
        $highestInContents = mysql_fetch_array(mysql_query("SELECT MAX(order_id) AS order_id FROM contents"));
        $highestInContents = $highestInContents[0];
        
        $highestInNavigations = mysql_fetch_array(mysql_query("SELECT MAX(order_id) AS order_id FROM navigations"));
        $highestInNavigations = $highestInNavigations[0];
        
        $highestInLinks = mysql_fetch_array(mysql_query("SELECT MAX(order_id) AS order_id FROM navigation_links"));
        $highestInLinks = $highestInLinks[0];
        
        $highest = max($highestInLinks, $highestInNavigations, $highestInContents);
        
        return $highest;
    }
    public function updateOrderId($type, $itemid, $newOrderId){
        $db = new db();
        
        $values['order_id'] = $newOrderId; //define new value for update function
        $primary = array('id', $itemid); //the primary is called id in all three tables so it only needs to be defined once
        
        switch($type){
            case'content':
                $affectedRows = $db->update('contents', $values, $primary);
                break;
            case'navigation':
                $affectedRows = $db->update('navigations', $values, $primary);
                break;
            case'navigationLink':
                $affectedRows = $db->update('navigation_links', $values, $primary);
                break;
        }
        
        return $affectedRows;
    }
    public function exchangeOrderId($oldOrderId, $newOrderId, $parse=true){
        if(absDif($oldOrderId, $newOrderId) > 1)
                return false;
        
        $oldOrderIdElement = $this->getItemByOrderId($oldOrderId);
        $newOrderIdElement = $this->getItemByOrderId($newOrderId);
        
        
        $oldType = $oldOrderIdElement[0];
        $oldId = $oldOrderIdElement[1]['id'];
        
        $newType = $newOrderIdElement[0];
        $newId = $newOrderIdElement[1]['id'];
        
        
        //update item from the old position to order_id = new position id
        $this->updateOrderId($oldType, $oldId, $newOrderId);
        
        
        //update item from the new position to order_id = old position id
        $this->updateOrderId($newType, $newId, $oldOrderId);
        
        
        if($parse){
            $cms = new cms();
            $cms->parseNavigations();
        }
    }
    
    public function changeOrder($oldOrderId, $newOrderId){
            if($oldOrderId == $newOrderId){
                return true;
            }else{
                
                
                
                
                $i = $oldOrderId;
                $totalCounter = 0;
                while(($i != $newOrderId)||($totalCounter >= 1337)){
                    $index = $i;
                    if($newOrderId > $oldOrderId){
                        $i++;
                    }else if($newOrderId < $oldOrderId){
                        $i--;
                    }
                    $this->exchangeOrderId($index, $i, false);
                    $totalCounter++;//emergency escape
                    $i;
                }
                
                //change last Order and parse navigations
                if($newOrderId > $oldOrderId){
                    $i++;
                }else if($newOrderId < $oldOrderId){
                    $i--;
                }
                $this->exchangeOrderId($index, $i, false); //parse navigations
                
                        $this->createNavigations();
            }
        
        
        
    }
    
    public function templateNavIdToDbNavId($template_nav_id){
            
        $navData = db::select('navigations', array('template_navigation_id', $template_nav_id));
        if(isset($navData['id']))
            return $navData['id'];
        else
            return false;
    }
}
