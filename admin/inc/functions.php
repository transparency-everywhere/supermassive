<?php
/**
This file is published by transparency-everywhere with the best deeds.
Check transparency-everywhere.com for further information.

Licensed under the CC License, Version 4.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    https://creativecommons.org/licenses/by/4.0/legalcode

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.


@author nicZem for tranpanrency-everywhere.com
*/
/**
 * The functions.php is used to define unsorted functions bundle all classes in one big file
 *
 */


define("systemSalt", "wabadabadubaduuu");
if(file_exists(dirname(__FILE__).'/../../config/database_config.php')){
    
    include(dirname(__FILE__).'/../../config/database_config.php');

    //mysql connect	or die
    mysql_connect(dbHost,dbUser,dbPass);
    mysql_select_db(db);

    if(!mysql_connect(dbHost,dbUser,dbPass) OR !mysql_select_db(db)) {
    die("Something went wrong with the Database...");
    }
}
session_start();

function absDif($number1, $number2){
    return abs($number1-$number2);
}

function relToAbs($text, $base)
{
  if (empty($base))
    return $text;
  // base url needs trailing /
  if (substr($base, -1, 1) != "/")
    $base .= "/";
  // Replace links
  $pattern = "/<a([^>]*) " .
             "href=\"[^http|ftp|https|mailto]([^\"]*)\"/";
  $replace = "<a\${1} href=\"" . $base . "\${2}\"";
  $text = preg_replace($pattern, $replace, $text);
  // Replace images
  $pattern = "/<img([^>]*) " . 
             "src=\"[^http|ftp|https]([^\"]*)\"/";
  $replace = "<img\${1} src=\"" . $base . "\${2}\"";
  $text = preg_replace($pattern, $replace, $text);
  // Replace links
  $pattern = "/<link([^>]*) " .
             "href=\"[^http|ftp|https|mailto]([^\"]*)\"/";
  $replace = "<link\${1} href=\"" . $base . "\${2}\"";
  $text = preg_replace($pattern, $replace, $text);
  // Replace images
  $pattern = "/<script([^>]*) " . 
             "src=\"[^http|ftp|https]([^\"]*)\"/";
  $replace = "<script\${1} src=\"" . $base . "\${2}\"";
  $text = preg_replace($pattern, $replace, $text);
  // Done
  return $text;
}

function is_absolute_path($path) {
    if(filter_var($path, FILTER_VALIDATE_URL))
        return 1;
    else
        return 0;
}


function _rewrite_url($url, $bool=true){
    
    //cut away './'
    if(substr($url, 0,2) === './')
            $url = substr($url, 2);
    
    if(is_absolute_path($url))
        return $url;
    else
        return $bool.$url;
}

function parseLinks($content,$baseURL){
    
    
    if (empty($baseURL))
      return $content;
    // base url needs trailing /
    if (substr($baseURL, -1, 1) != "/")
      $baseURL .= "/";

    $_config['url_var_name'] = 'q';
    $_tags =array(
	'a' => array('href'),
	'img' => array('src', 'longdesc'),
	'image' => array('src', 'longdesc'),
	'body' => array('background'),
	'base' => array('href'),
	'frame' => array('src', 'longdesc'),
	'iframe' => array('src', 'longdesc'),
	'head' => array('profile'),
	'layer' => array('src'),
	'input' => array('src', 'usemap'),
	'form' => array('action'),
	'area' => array('href'),
	'link' => array('href', 'src', 'urn'),
	'param' => array('value'),
	'applet' => array('codebase', 'code', 'object', 'archive'),
	'object' => array('usermap', 'codebase', 'classid', 'archive', 'data'),
	'select' => array('src'),
	'script' => array('src'),
	'hr' => array('src'),
	'table' => array('background'),
	'tr' => array('background'),
	'th' => array('background'),
	'td' => array('background'),
	'bgsound' => array('src'),
	'blockquote' => array('cite'),
	'del' => array('cite'),
	'embed' => array('src'),
	'fig' => array('src', 'imagemap'),
	'ilayer' => array('src'),
	'ins' => array('cite'),
	'note' => array('src'),
	'overlay' => array('src', 'imagemap'),
	'q' => array('cite'),
	'ul' => array('src'));
    if(preg_match_all('#<(' . implode('|', array_keys($_tags)) . ')((?:\s*[a-z\-]+\s*=\s*(?:\"[^\"]*\"|\'[^\']*\'|[^\s\>]*)|\s*[a-z\-]+)+)+.*?>#si', $content, $_matches)) {
		$_newinx = count($_matches);
		$_matches[$_newinx] = array();
		foreach($_matches[0] as $_key => $_match) {
			$_tag = strtolower($_matches[1][$_key]);
			if(!isset($_tags[$_tag])) {
				unset($_matches[0][$_key], $_matches[1][$_key], $_matches[2][$_key]);
				continue;
			}
			$get = false;
			$_action = '';
			$_pairs = array();
			if(preg_match_all('#\s*(' . implode('|', $_tags[$_tag]) . ')\s*=\s*(\"[^\"]*\"|\'[^\']*\'|[^\s\>]*)#si', $_matches[2][$_key], $_ms)) {
				foreach($_ms[2] as $_k => $_m) {
					$_wrapper = '';
					if($_m{0} == '"' and $_m{strlen($_m) - 1} == '"') {
						$_wrapper = '"';
						$_m = trim($_m, '"');
					} else if($_m{0} == '\'' and $_m{strlen($_m) - 1} == '\'') {
						$_wrapper = '\'';
						$_m = trim($_m, '\'');
					}
					
					
                                        $_m = _rewrite_url($_m, $baseURL);
				}
				$_pairs[] = ' ' . $_ms[1][$_k] . '=' . $_wrapper . $_m . $_wrapper;
			}
			$_matches[$_newinx][$_key] = str_replace($_ms[0], $_pairs, $_matches[0][$_key]) . ($get ? '<input type="hidden" name="' . $_config['url_var_name'] . '" value="' . $_action . '" />' : '');
		}
		return str_replace($_matches[0], $_matches[$_newinx], $content);
	}
};

function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        else unlink("$dir/$file");
    }
    rmdir($dir);
}


function proofLogin(){
         if(isset($_SESSION['userid'])){
         return true;
         }else{
         return false;
         }
    ;
}

function replaceTags($startPoint, $endPoint, $newText, $source) {
    return preg_replace('#('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')#si', '$1'.$newText.'$3', $source);
}


function getUser(){
        if(isset($_SESSION['userid'])){
                return $_SESSION['userid'];
        }else{
                return 1;
        }
}

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}



function createSalt($type, $itemId, $receiverType, $receiverId, $salt){
        //stores encrypted salt in db
        //delete all old salts
        mysql_query("DELETE FROM `salts` WHERE `type`='$type' AND itemId='$itemId'");

        if(mysql_query("INSERT INTO `salts` (`type`, `itemId`, `receiverType`, `receiverId`, `salt`) VALUES ('$type', '$itemId', '$receiverType', '$receiverId', '$salt')"))
                return true;
        else 
                return false;
}


function updateSalt($type, $itemId, $salt){
        mysql_query("UPDATE  `salts` SET salt='".save($salt)."' WHERE `type`='".save($type)."' AND itemId='".save($itemId)."'");
}


function getSalt($type, $itemId){
        $type = save($type);
        $itemId = save($itemId);

        $data = mysql_fetch_array(mysql_query("SELECT * FROM `salts` WHERE `type`='$type' AND itemId='$itemId' LIMIT 1"));
        return $data['salt'];
}

function countdim($array)
{
    if (is_array(reset($array)))
    {
        $return = countdim(reset($array)) + 1;
    }

    else
    {
        $return = 1;
    }

    return $return;
}



include('class_users.php');

include('class_usergroups.php');

include('class_db.php');

include('class_content.php');

include('class_widget.php');

include('class_navigation.php');

include('class_navigation_link.php');

include('class_media.php');

include('class_template.php');

include('class_cms.php');

include('class_plugins.php');


    $plugins = new plugins();
    $plugins->includePlugins();
?>