<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_widgets
 *
 * @author niczem for transpev
 */
class widget {
    public $widget_id;
    
    function __construct($id=NULL){
        if($id != NULL){
           $this->widget_id = $id;
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
    function create($title, $type, $content){

            $values['title'] = $title;
            $values['type'] = $type;
            $values['content'] = $content;

            $db = new db();
            $navigationId = $db->insert('widgets', $values);
            
            
            return $navigationId;

    }
    
    /**
    * Update DB record and parse navigations
    * @param $title string
    * @param $parent_id int id of parent navigation
    * @param $template_navigation_id int
    * @param $file int linked file_ids
    * @return allways returns true
    */
    function update($title, $type, $content){
        
        if(!empty($title))
            $values['title'] = $title;
        if(!empty($type))
            $values['type'] = $type;
        if(!empty($content))
            $values['content'] = $content;
        
        $db = new db();
        $db->update('widgets', $values, array('id',$this->widget_id));

        return true;

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
        $db = new db();
        $db->delete('widgets', array('id',$this->widget_id));

    }
    /*
    * Update DB record and parse navigations
    * @param $id id of specific record
    * @return array with record(s)
    */
    function select($id = NULL){
        $db = new db();
        if($id != NULL){
            $return = $db->select('widgets', array('id',$id));
        }
        if(($id == NULL)){
            $return = $db->select('widgets');
        }
        
        if(!is_array($return))
            $return = array();
        return $return;
    }
    
    function getTitle($id=NULL){
        if($id == NULL)
            $id = $this->widget_id;
        $data = $this->select($id);
        return $data['title'];
    }
    
    function getWidgetsForWidgetArea($content_id, $template_widget_area_id){
        $sql = mysql_query("SELECT * FROM widgets_in_contents WHERE template_widget_area_id='".$template_widget_area_id."' AND content_id='".$content_id."'");
        
        $return = array();
        if($sql){
        while($widgetData = mysql_fetch_array($sql)){
            $return[] = $widgetData;
        }
        
        }
        return $return;
    }
    
    function addToWidgetArea($content_id, $template_widget_area_id){
        $values['content_id'] = $content_id;
        $values['template_widget_area_id'] = $template_widget_area_id;
        $values['widget_id'] = $this->widget_id;
        $db = new db();
        $db->insert('widgets_in_contents', $values);
    }
    function removeFromWidgetArea($content_id, $template_widget_area_id){
        mysql_query("DELETE FROM `widgets_in_contents` WHERE `widget_id` = '$this->widget_id' AND `content_id` ='$content_id' AND `template_widget_area_id` = '$template_widget_area_id'");
    }
    
    function generateWidget($id=NULL){
        if($id == NULL)
            $id = $this->widget_id;
        
        $widgetData = widget::select($id);
        
        switch($widgetData['type']){
            case'HTML':
                return $widgetData['content'];
                break;
        }
        
    }
    function generateWidgetArea($content_id, $template_widget_area_id){
        //$db = new db();
        //$widgets = $db->select('widgets', array('template_widget_area_id', $template_widget_area_id));
        $output = '';
        $sql = mysql_query("SELECT * FROM `widgets_in_contents` WHERE `template_widget_area_id`='".$template_widget_area_id."' AND `content_id`='".$content_id."'");
        if($sql){
        while($widgetData = mysql_fetch_array($sql)){
                $output .= widget::generateWidget($widgetData['widget_id']);
        }
        }else{
            $output = 'empty';
        }
            
        return $output;
    }
}

?>
