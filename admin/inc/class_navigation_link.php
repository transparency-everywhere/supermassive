<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Resposnible for linking contents and navigations into navigations.
 *
 * @author Transparency Everywhere
 */
class navigation_link{
    public $navigation_link_id;
    
    /**
     * Sets navigation_link_id
     * @param int $navigation_id id of the navigaion, the navigation_linl is linked to
     * @param $target_type string: 'content' or 'navigation'
     * @param $target_id int: Id of the target
    */
    function __construct($id=NULL){
        if($id != NULL){
           $this->navigation_link_id = $id;
        }
    }
    
    
    /**
     * Writes entry into the db. Parses all the navigation
     * @param int $navigation_id id of the navigaion, the navigation_linl is linked to
     * @param $target_type string: 'content' or 'navigation'
     * @param $target_id int: Id of the target
     * @param caption  string caption that is shown in the navigation
    */
    function create($navigation_id, $target_type, $target_id, $caption){

        
            if($parent_id == 0){
                $order_id = -1;//$order_id will be set +1 in the insert function so the inserted value will be 0
            }else{
                $navigationClass = new navigation($parent_id);
                $order_id = $navigationClass->getHighestOrderId();
            }
        
            $values['navigation_id'] = $navigation_id;
            $values['target_type'] = $target_type;
            $values['target_id'] = $target_id;
            $values['caption'] = $caption;
            $values['order_id'] = ($order_id+1);

            $db = new db();
            $navigation_link_Id = $db->insert('navigation_links', $values);
            
            
            $cms = new cms();
            $cms->parseNavigations();
            
            return $navigation_link_Id;
    }
    /**
     * Updates entry in the db. Parses all the navigations
     * @param int $navigation_id id of the navigaion, the navigation_linl is linked to
     * @param $target_type string: 'content' or 'navigation'
     * @param $target_id int: Id of the target
     * @param caption  string caption that is shown in the navigation
    */
    function update($navigation_id, $target_type, $target_id, $caption){
        
        if(!empty($navigation_id))
            $values['navigation_id'] = $navigation_id;
        if(!empty($target_type))
            $values['target_type'] = $target_type;
        if(!empty($target_id))
            $values['target_id'] = $target_id;
        if(!empty($caption))
            $values['caption'] = $caption;

        $db = new db();
        $db->update('navigation_links', $values, array('id',$this->navigation_link_id));

        $cms = new cms();
        $cms->parseNavigations();

        return true;

    }
    /**
    * Deletes entry from DB, parses all navigations
    */
    function delete(){
        $db = new db();
        $db->delete('navigation_links', array('id',$this->navigation_link_id));


        $cms = new cms();
        $cms->parseNavigations();

    }
    /**
    * Select entries from DB
    * @param int $id id of the navigaion_id you want to select
    * @return array with db record(s)
    */
    function select($id = NULL){
        $db = new db();
        if($id != NULL){
            return $db->select('navigations', array('id',$id));
        }
        if(($id == NULL)){
            return $db->select('navigations');
        }
    }
}
?>