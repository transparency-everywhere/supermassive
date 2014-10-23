<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_media
 *
 * @author Transparency Everywhere
 */
class media {
    //put your code here
    public function addFile(){
        $userGroups = new usergroups();
        if($userGroups->authorize('uploadFiles')){
            
        }
    }
    
    public function deleteFile($file_id){
        $userGroups = new usergroups();
        if($userGroups->authorize('deleteFiles')){
            $fileData = $this->select($file_id);
            unlink('../assets/'.$fileData['filename']);
            $db = new db();
            return $db->delete('files',  array('id', $file_id));
        }
    }
    
    /**
    *Inserts record with $options into db $table 
    *@param int $file_id Name of table
    *@return array result array
    */
    public function select($file_id=null){
        $userGroups = new usergroups();
        if($userGroups->authorize('seeFiles')){
            $db = new db();
            if($file_id != null){
                $result = $db->select('files', array('id', $file_id));
            }else{
                $result = $db->select('files');
                if(!is_array($result)){
                    $result = array(array());
                }else if(isset($result['id'])){
                    $temp = $result;
                    unset($result);
                    $result[0] = $temp;
                }
            }
            return $result;
        }
        
    }
    
    /**
    *Updates file so that it's not temporary anymore
    *@param int $file_id db-id of the file
    *@return array result array
    */
    function moveFileFromTemp($file_id){
        $db  = new db();
        $values['temp'] = 0;
        $db->update('files', $values, array('id',$file_id));
    }
    
    /**
    *...
    *@param int $file_id db-id of the file
    *@return string filename
    */
    function idToTitle($file_id){
        $fileData = $this->select($file_id);
        if(isset($fileData['filename']))
            return $fileData['filename'];
        else
            return false;
    }
    
    /**
    *...
    *@param int $file_id db-id of the file
    *@return string filename
    */
    function idToFilename($file_id){
        $fileData = $this->select($file_id);
        if(isset($fileData['filename']))
            return $fileData['filename'];
        else
            return false;
    }
    
    /**
    *...
    *@param array $file $_FILE object
    *@param int $file_id db-id of the file
    *@return string filename
    */
    function uploadFile($file, $title='', $alternative_text='', $temp=true){
        $userGroups = new usergroups();
        if($userGroups->authorize('uploadFiles')){	 	
            //upload file
            $target_path = basename( $file['tmp_name']);
            $filename = $file['name'];
            $thumbname = "$filename.thumb";
            $size = $file['size'];
            $time = time();

            //move uploaded file to choosen folder and add .temp 
            move_uploaded_file($file['tmp_name'], "../assets/".$file['name']);
            rename( "../assets/".$file['name'], "../assets/".$file['name']);

            $values['filename'] = $filename;
            $values['title'] = $title;
            $values['alternative_text'] = $alternative_text;
            $values['timestamp'] = time();
            $values['temp'] = true;

            //add db entry and add temp value
            $db = new db();
            return $db->insert('files', $values);
        }
    }
    
    /**
    *Updates every file which is listed in a comma separeted string to temp=0
    *@param str $str String with comma separed file id´s
    */
    function updateTempByStr($str){
        $file_ids = explode(',', $str);
        foreach($file_ids AS $file_id){
            $this->moveFileFromTemp($file_id);
        }
    }
	
    /**
    *Updates every file which is listed in a comma separeted string to temp=0
    *@param str $str String with comma separed file id´s
    */
    function generateImageGallery($str){
            
        $file_ids = explode(',', $str);
        
        $html = '<ul style="list-style:none;">';
        foreach($file_ids AS $file_id){
            if(!empty($file_id))
                $html .= '<li><img src="assets/'.$this->idToFilename($file_id).'" style="max-width:60px;max-height:60px;"/></li>';
        }
        $html .= '</ul>';
        
        return $html;
    }
}
