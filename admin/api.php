<?php
/*
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
include('inc/functions.php');

if(isset($_GET['action']))
	$action = $_GET['action'];
else if(isset($_POST['action']))
	$action = $_POST['action'];

switch($action){
//users    
    case'getUser':
        $users = new users();
        echo $users->whoAmI();
        break;
    case 'getCurrentUsergroup':
        $users = new users();
        echo $users->getCurrentUserGroup();
        break;
        
    
    
    case'logout':
        $users = new users();
        echo $users->logout();
        
        break;
    
    case'createUser':
        $class_user = new users();
        echo $class_user->create($_POST['username'], $_POST['usergroup'], $_POST['password'], $_POST['firstname'], $_POST['lastname']);
        break;
    case'updateUser':
        $class_user = new users();
        echo $class_user->update($_POST['user_id'], $_POST['username'], $_POST['usergroup'], $_POST['firstname'], $_POST['lastname']);
        break;
    case'deleteUser':
        $class_user = new users();
        echo $class_user->delete($_GET['user_id']);
        break;
    case'getUserData':
        $class_users = new users();
        echo json_encode($class_users->getUserData($_POST['user_id']));
        break;
    case'getUsers':
        $class_users = new users();
        echo json_encode($class_users->getUsers());
        break;
    case'updateUserPassword':
        
        $userGroups = new usergroups();
        if($userGroups->authorize('editUsers')||$_POST['userid'] == getUser()){
            $class_users = new users();
            $class_users->updatePasswordDB($_POST['password'], $_POST['user_id']);
        }
        
        break;

//usergroups
    case'createUsergroup':
        $usergroups = new usergroups();
        echo $usergroups->create($_POST['title'], (array)json_decode($_POST['rightArray']));
        break;
    case'updateUsergroup':
        $usergroups = new usergroups();
        echo $usergroups->update($_POST['group_id'], $_POST['title'], (array)json_decode($_POST['rightArray']));
        break;
    case'getUsergroups':
        $usergroups = new usergroups();
        echo json_encode($usergroups->getUsergroups());
        break;
    case'getUsergroupRights':
        //get rights for a specific usergroup
        $usergroups = new usergroups();
        echo json_encode($usergroups->getRights($_POST['group_id']));
        break;
    case'getRightList':
        //get possible rights
        $usergroups = new usergroups();
        echo json_encode($usergroups->getRightList());
        break;
    case'getUsergroupTitle':
        //get possible rights
        $usergroups = new usergroups();
        echo ($usergroups->getTitle($_POST['group_id']));
        break;
    case'deleteUsergroup':
        $usergroups = new usergroups();
        echo ($usergroups->delete($_GET['group_id']));
        break;

//contents    
    case'createContent':
        $class_content = new content();
        echo $class_content->create($_POST['parent_navigation_id'], $_POST['title'], $_POST['keywords'], $_POST['description'], $_POST['content'], $_POST['template'], $_POST['active'], $_POST['template_vars']);
        break;
    case'selectContent':
        $class_content = new content();
        echo json_encode($class_content->select($_POST['content_id']));
        break;
    case'updateContent':
        $class_content = new content($_POST['content_id']);
        echo $class_content->update($_POST['parent_navigation_id'], $_POST['title'], $_POST['keywords'], $_POST['description'], $_POST['content'], $_POST['template'], $_POST['active'], $_POST['template_vars']);
        break;
    case'deleteContent':
        $class_content = new content($_GET['content_id']);
        echo $class_content->delete();
        break;
    
//widgets    
    case'createWidget':
        echo widget::create($_POST['title'], $_POST['type'], $_POST['content']);
        break;
    case'updateWidget':
        $class_widget = new widget($_POST['widget_id']);
        echo $class_widget->update($_POST['title'], $_POST['type'], $_POST['content']);
        break;
    case'selectWidget':
        echo json_encode(widget::select($_POST['widget_id']));
        break;
    case'deleteWidget':
        $class_widget = new widget($_GET['widget_id']);          
        echo $class_widget->delete();
        break;
    case'addWidgetToContent':
        $class_widget = new widget($_POST['widget_id']);          
        echo $class_widget->addToWidgetArea($_POST['content_id'], $_POST['template_widget_area_id']);
        break;
    case'removeWidgetFromContent':
        $class_widget = new widget($_POST['widget_id']);          
        echo $class_widget->removeFromWidgetArea($_POST['content_id'], $_POST['template_widget_area_id']);
        
        break;
    case'getWidgetsForWidgetArea':
        echo json_encode((array)widget::getWidgetsForWidgetArea($_POST['content_id'], $_POST['template_widget_area_id']));
        break;
    case'widgetIdToWidgetTitle':
        $widget = new widget($_POST['widget_id']);
        echo $widget->getTitle();
        break;
    case'loadWidget':
        $widget = new widget();
        echo widget::generateWidget($_POST['widget_id']);
        break;
    
//navigations
    case'createNavigation':
        $class_navigation = new navigation();
        echo $class_navigation->create($_POST['title'], $_POST['parent_id'], $_POST['template_navigation_id']);
        break;
    case'selectNavigation':
        $class_navigation = new navigation();
        echo json_encode($class_navigation->select($_POST['navigation_id']));
        break;
    case'updateNavigation':
        $class_navigation = new navigation($_POST['navigation_id']);
        echo $class_navigation->update($_POST['title'], $_POST['parent_id'], '', ''); //template_id and file empty as long as they are useless
        break;
    case'deleteNavigation':
        $class_navigation = new navigation($_GET['navigation_id']);
        echo $class_navigation->delete();
        break;
    
    case'getItemByOrderId':
        
        $class_navigation = new navigation(1);
        var_dump($class_navigation->getItemByOrderId(1));
        break;
    case'changeOrder':
        $navDbId = navigation::templateNavIdToDbNavId($_POST['navigation_id']);;
        $navigation = new navigation($navDbId);
        $navigation->changeOrder($_POST['oldOrderId'], $_POST['newOrderId']);
        break;
//navigation links
    case'createNavigationLink':
        $class_navigation = new navigation_link();
        echo $class_navigation->create($_POST['navigation_id'], $_POST['target_type'], $_POST['target_id'], $_POST['caption']);
        break;
    case'updateNavigationLink':
        $class_navigation = new navigation_link($_POST['navigation_link_id']);
        echo $class_navigation->update($_POST['navigation_id'], $_POST['target_type'], $_POST['target_id'], $_POST['caption']);
        break;
    case'deleteNavigationLink':
        $class_navigation = new navigation_link($_POST['navigation_link_id']);
        echo $class_navigation->delete();
        break;
    
    case'getConfig':
        $class_cms = new cms();
        echo json_encode($class_cms->getConfig());
        break;
    case'updateConfig':
        $class_cms = new cms();
        echo $class_cms->updateConfig($_POST['pageTitle'], $_POST['keywords'], $_POST['templateId'], $_POST['home_page'], $_POST['webmaster_mail_adress'], $_POST['analytic_script']);
        break;
    
//templates
    
    case'changeTemplate':
        $class_cms = new cms();
        echo $class_cms->changeTemplate($_POST['newTemplateId']);
        break;
    case'addTemplate':
        $template = new template();
        echo $template->add($_POST['file_id']);
        break;
    case'deleteTemplate':
        $template = new template();
        echo $template->delete($_GET['template_id']);
        break;
    
    case'selectPlugins':
        $class_db = new db();
        $result = $class_db->select('plugins', array('active', '1'));
        if(isset($result['id'])){
            $temp = $result;
            unset($result);
            $result[0] = $temp;
        }
        
        //add js class name to result
        if(is_array($result)){
            $i=0;
            $plugins = new plugins();
            foreach($result AS $pluginData){
                $config = $plugins->getConfig($pluginData['plugin_folder_name']);
                $result[$i]['js_class_name'] = $config['js_class_name'];
            }
        }else{
            return array();
        }
        echo json_encode($result);
        break;
    case'selectTemplates':
        $userGroups = new usergroups();
        if(true){
            $class_db = new db();
            $result = $class_db->select('templates');
            if(isset($result['id'])){
                $temp = $result;
                unset($result);
                $result[0] = $temp;
            }
            echo json_encode($result);
        }
        break;    
    case'selectContents':
        $class_db = new db();
        $result = $class_db->select('contents');
        if(isset($result['id'])){
            $temp = $result;
            unset($result);
            $result[0] = $temp;
        }
        echo json_encode($result);
        break;     
    case'selectWidgets':
        $class_db = new db();
        $result = $class_db->select('widgets');
        if(isset($result['id'])){
            $temp = $result;
            unset($result);
            $result[0] = $temp;
        }
        if(!is_array($result))
            $result = array();
        echo json_encode($result);
        break;    
    case'selectNavigations':
        $class_db = new db();
        $result = $class_db->select('navigations');
        if(isset($result['id'])){
            $temp = $result;
            unset($result);
            $result[0] = $temp;
        }
        echo json_encode($result);
        break;
        
    case 'getTemplateVars':
        $class_template = new template($_POST['template_id']);
        $config = $class_template->getConfig();
        $return = array_values($config['template_vars']);
        echo json_encode($return);
        break;
//plugins
    case'callPluginApi':
        $className = $_POST['className'];
        $class_reference = new $className();
        echo $class_reference->api($_POST['plugin_action'], (array)json_decode($_POST['parameters']));
        break;
    case'addPlugin':
        $plugins = new plugins();
        echo $plugins->add($_POST['file_id']);
        break;

//updates
    case'updateRequired':
        $cms = new cms();
        echo $cms->updateRequired();
        break;
    
    case'uploadFile':
        $media = $media = new media();
        $file_id = $media->uploadFile($_FILES['Filedata']);
        //$media->moveFileFromTemp($file_id);
        echo $file_id;
        break;
    case'fileIdToFileTitle':
        $media = $media = new media();
       echo $media->idToTitle($_POST['file_id']);
        break;
    case'selectFiles':
        $class_db = new db();
        $result = $class_db->select('files');
        if(isset($result['id'])){
            $temp = $result;
            unset($result);
            $result[0] = $temp;
        }
        if(!is_array($result))
            $result = array();
        echo json_encode($result);
        break;
    case 'updateTempFilesByStr':
        
        $media = new media();
        $media->updateTempByStr($_POST['string']);
        
        break;
    
    case 'tester':
        
        
        $cms = new cms();
        $cmsConfigArray = $cms->parseEverything();
        var_dump($cmsConfigArray);
//
//        
//        $plugins = new plugins('slider_creator');
//        $plugins->install();
        
//        function test($var1, $var2){
//            return $var1.' '.$var2;
//        }
//        $contents = 'asdasd  %widget_area[2]% dadada';
//        $contents = preg_replace("/%widget_area\[(.+?)\]%/e", "test('".'huppta'."','$1')", $contents);
//        echo $contents;
//        
//        
//           $widget = new widget(1);
//           $widget->addToWidgetArea(1, 1);
	break;
}



?>