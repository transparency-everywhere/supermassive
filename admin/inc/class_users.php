<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_users
 *
 * @author stefan
 */

class users{
    /**
    *Returns all userdata
    *@return array with all userdata
    */
    public function all(){
        $userGroups = new usergroups();
        if($userGroups->authorize('readUsers')){
            $sql = mysql_query("SELECT * FROM `users` ORDER BY userid ASC");
            while($data = mysql_fetch_array($sql)){
                    $userid = $data['userid'];
                    $return[$userid] = $data;
            }
            return $return;
        }
    }

    /**
    *...
    *@param string $username
    *@return int userid
    */
    public function usernameToUserid($username){
        $userGroups = new usergroups();
        if($userGroups->authorize('readUsers')){
            $sql = mysql_query("SELECT userid FROM `users` WHERE username='$username'");
            $data = mysql_fetch_array($sql);
            return $data['userid'];
        }
    }

    /**
    *Creates a user
    *@param string $username
    *@param int $usergroup
    *@param string $password
    *@param string $firstname
    *@param string $lastname
    *@return int userid
    */
    public function create( $username, $usergroup, $password, $firstname, $lastname){
        $userGroups = new usergroups();
        if($userGroups->authorize('addUsers')){
            $username = save($username);
            $password = sha1($password.systemSalt);

            $sql = mysql_query("SELECT `username` FROM `users` WHERE username='$username'");
            $data = mysql_fetch_array($sql);

            if(empty($data['username'])){
                    $time = time();
                    mysql_query("INSERT INTO `users` (`password`, `username`, `usergroup`, `regdate`, `lastactivity`, `firstname`, `lastname`) VALUES ('$password', '$username', '$usergroup', '$time', '$time', '$firstname', '$lastname')");
                    $userid = mysql_insert_id();
                    return $userid;
            }else{
                    return false;
            }
        }
    }

    /**
    *Updates user record
    *@param int $userid
    *@param string $username
    *@param int $usergroup
    *@param string $password
    *@param string $firstname
    *@param string $lastname
    */
    public function update($userid, $username, $usergroup, $firstname, $lastname){
        $userGroups = new usergroups();
        if($userGroups->authorize('editUsers')){
            $values['username'] = $username;
            $values['usergroup'] = $usergroup;
            $values['firstname'] = $firstname;
            $values['lastname'] = $lastname;

            $db = new db();
            $db->update('users', $values, array('userid',$userid));
        }
    }

    public function updatePasswordDB($password, $userid=NULL){
        $userGroups = new usergroups();
        if($userGroups->authorize('editUsers')){
            if($userid == NULL){
                    $userid = getUser();
            }
            $password = sha1($password.systemSalt);
            mysql_query("UPDATE `users` SET  `password`='$password' WHERE userid='$userid'");
            return true;
        }
    }

    public function updatePassword($oldPassword, $newPassword, $userid=NULL){
        $userGroups = new usergroups();
        if($userGroups->authorize('editUsers')){
            if($userid == NULL){
                    $userid = getUser();
            }
            $oldPassword = sha1($oldPassword.systemSalt);

            $userData = $this->getUserData($userid);
            if($userData['password'] == $oldPassword){
                    $this->updatePasswordDB($newPassword, $userid);
                    return true;
            }else{
                    return 'Old Password was wrong';
            }
        }
    }
    
    
    /**
    *Proofs if request comes from a user, which is logged in
    *@return bool
    */
    public function proofLogin(){
        if(isset($_SESSION['userid']))
            return true;
        
        return false;
            
    }
    
    /**
    *Returns userid of users, which is logged in
    *@return int userid
    */
    public function whoAmI(){
        return $_SESSION['userid'];
    }
    
    public function getCurrentUsergroup(){
        $userData = $this->getUserData($this->whoAmI());
        return $userData['usergroup'];
    }
    
    /**
    *Gets userdata from ALL USERS from db
    *@return array with userdata of all users
    */
    public function getUsers(){
        $return = array();
        $sql = mysql_query("SELECT userid, firstname, lastname, username FROM `users`");
        while($data = mysql_fetch_array($sql)){
            $userData['userid'] = $data['userid'];
            $userData['username'] = $data['username'];
            $userData['firstname'] = $data['firstname'];
            $userData['lastname'] = $data['lastname'];
            $return[] = $userData;
            unset($userData);
        }
        return $return;
    }

    /**
    *Gets userdata from db
    *@param int $userid
    *@return array with userdata
    */
    public function getUserData($userid=NULL){
        if(empty($userid)){
                $userid = getUser();
        }
        $userData = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE userid='$userid'"));
        return $userData;
    }

    public function getUserGroups($userid){
        $userGroups = new usergroups();
        if($userGroups->authorize('readUsergroups')){
            $sql = mysql_query("SELECT * FROM `users_in_groups` WHERE `userid` = '$userid'");
            $return = array();
            while($data = mysql_fetch_array($sql)){
                    $return[] = $data['groupid'];
            }
            return $return;
        }
    }

    /**
    *Deletes user from db
    *@param int $userid
    *@return bool
    */
    public function delete($userid){
        $userGroups = new usergroups();
        if($userGroups->authorize('deleteUsers')){
            mysql_query("DELETE FROM `users` WHERE userid='".save($userid)."'");
            return true;
        }
    }

    public function authorize($username, $password){
        $userid = $this->usernameToUserid($username);
        $userData = $this->getUserData($userid);
        if(sha1($password.systemSalt) == $userData['password']){
            $_SESSION['userid'] = $userid;
            return true;
        }else{
            return false;
        }
    }
    
    public function logout(){
        unset($_SESSION['userid']);
        return !isset($_SESSION['userid']);
    }
}
?>
