<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of class_usergroups
 *
 * @author stefan
 */
class usergroups{
    public function create($title, $rights){
        if($this->authorize('addUsergroups')){
            $values['title'] = $title;
            $values = array_merge($values, $rights);

            $db = new db();
            $db->insert('usergroups', $values);
        }
    }

    public function update($id, $title, $rights){
        if($this->authorize('editUsergroups')){
            $values['title'] = $title;
            $usergroups = new usergroups();
            $rightList = $usergroups->getRightList();
            foreach($rightList AS $rightTitle){
                    if ((array_key_exists($rightTitle, $rights))&&($rights[$rightTitle] == true)) {
                            $rightsDB[$rightTitle] = 1;
                    }else{
                            $rightsDB[$rightTitle] = 0;
                    }

            }
            $values = array_merge($values, $rightsDB);

            $db = new db();
            $db->update('usergroups', $values, array('id',$id));
        }
    }

    public function getData($groupId){
        if($this->authorize('readUsergroups')){
            $groupData = mysql_query("SELECT * FROM `usergroups` WHERE id='".save($groupId)."'");
            $dataArray = mysql_fetch_array($groupData);

            return $dataArray;
        }
    }

    public function getTitle($groupId){
        if($this->authorize('readUsergroups')){
            $data = $this->getData($groupId);
            return $data['title'];
        }
    }

    public function updateRights($groupId, $rights){
        if($this->authorize('editUsergroups')){
            $db = new db();
            $db->update('userGroups', $rights, array('id',$id));
        }
    }

    //returns right for usergroup
    public function getRights($groupId){
        $groupData = mysql_query("SELECT * FROM `usergroups` WHERE id='".save($groupId)."'");
        $dataArray = mysql_fetch_array($groupData);

        //dirty but you cant select all rows except for title and id in mysql
        foreach($dataArray as $key => $value){
            if($key != 'title' && $key != 'id'){
                    if(!is_numeric($key))
                            $return[$key] = $value;
            }
        }
        return $return;
    }

    //returns array with all possible rights
    public function getRightList(){
        if($this->authorize('readUsergroups')){
            $groupData = mysql_query("SELECT * FROM `usergroups` LIMIT 1");
            $dataArray = mysql_fetch_array($groupData);

            //dirty but you cant select all rows except for title and id in mysql
            foreach($dataArray as $key => $value){
                if($key != 'title' && $key != 'id'){
                        if(!is_numeric($key))
                                $return[] = $key;
                }
            }
            return $return;
        }
    }

    //returns array with id and title of all groups
    public function get(){
        if($this->authorize('readUsergroups')){
            $sql = mysql_query("SELECT `id`, `title` FROM `usergroups` ORDER BY `id` ASC");
            while($data = mysql_fetch_array($sql)){
                    $id = $data['id'];
                    $return[$id] = $data['title'];
            }
            return $return;
        }
    }

    public function delete($id){
        if($this->authorize('deleteUsergroups')){
            mysql_query("DELETE FROM `usergroups` WHERE id='".save($id)."'");
            return true;
        }
    }

    public function joinGroup($userid, $groupid){
        if($this->authorize('editUsergroups')){
            mysql_query("INSERT INTO `users_in_groups` (`userid`, `groupid`) VALUES ('$userid', '$groupid');");
        }
    }

    public function getUsergroups(){
        if($this->authorize('readUsergroups')){
            $return = array();
            $sql = mysql_query("SELECT id, title FROM `usergroups`");
            while($data = mysql_fetch_array($sql)){
                $userData['id'] = $data['id'];
                $userData['title'] = $data['title'];
                $return[] = $userData;
                unset($userData);
            }
            return $return;
        }
    }

    /**
    * proofs if user with (userid = $_SESSION['userid']) is in any usergroup where right $right = true
    * @param $right
    * @return bool
    */
    public function authorize($right){
        return true;
        if(isset($_SESSION['userid'])){
            $userid = $_SESSION['userid'];

            $userClass = new users();
            $userdata = $userClass->getUserData($userid);

            $groupRights = $this->getRights($userdata['usergroup']);
            if ($groupRights[$right] == 1) {
                return true;
            } else {
                return false;
            } 
        }
    }
}

