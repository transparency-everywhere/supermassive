<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class_cms
 *
 * @author Transparency Everywhere
 */
class cms{
    /**
    * installs CMS with given settings: creates config.xml and database_config.php with input data
    *
    * @param string $set_host
    * @param string $set_database
    * @param string $set_db_user
    * @param string $set_db_pass
    * @param string $set_db_port
    * @param bool $set_debugmode
    */
    function installCms($set_host, $set_database, $set_db_user, $set_db_pass, $set_db_port, $set_debugmode, $set_webmaster_mail_address, $admin_user, $admin_pw, $set_page_title){

        
        $pathToCmsConfig = dirname(__FILE__) . '/../../config/cms_config.xml';
        if (file_exists($pathToCmsConfig)) {
            echo "Die Datei $pathToCmsConfig existiert bereits";
        } else {
            //create database_config.php
            $output = '<?php' . "\n";
            $output .= '$host = ' . "'$set_host'" . ';'  . '// MySQL Hostname' . "\n";
            $output .= '$database = ' . "'$set_database'" . ';' . '// MySQL Database' . "\n"; 
            $output .= '$db_user = ' . "'$set_db_user'" . ';' . '// MySQL Username' . "\n";  
            $output .= '$db_pass = ' . "'$set_db_pass'" . ';' . '// MySQL Password' . "\n";
            $output .= '$db_port = ' . "'$set_db_port'" . ';' . '// Database port - could be empty - default 3306' . ';' .  "\n" . "\n"; 
            $output .= "define('dbHost', " . '$host)' . ';' . "\n";
            $output .= "define('db', " . '$database)' . ';' . "\n";
            $output .= "define('dbUser', " . '$db_user)' . ';' . "\n";
            $output .= "define('dbPass', " . '$db_pass)' . ';' . "\n";
            $output .= "define('dbPort', " . '$db_port)' . ';' . "\n" . "\n";
            $output .= '$debugmode = ' . "'$set_debugmode'" . ';' . "\n";
            $output .= '?>';

            $path = dirname(__FILE__) . '/../../config/database_config.php';
            $database_config = fopen("$path", "w");
            fwrite($database_config, $output);
            fclose($database_config);

            //create database        
            $pathToSql = dirname(__FILE__) . '/../../config/cms.sql';
            $handle = fopen("$pathToSql", "r");
            $sql = fread($handle, filesize($pathToSql));
            fclose($handle);
            mysql_connect($set_host, $set_db_user, $set_db_pass) or die('Error connecting to MySQL server: ' . mysql_error());
            mysql_select_db($set_database) or die('Error selecting MySQL database: ' . mysql_error());

            //ausm netz kopiert, deswegen eingerückt
                // Temporary variable, used to store current query
                $templine = '';
                // Read in entire file
                $lines = file($pathToSql);
                // Loop through each line
                foreach ($lines as $line)
                {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;

                // Add this line to the current segment
                $templine .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';')
                {
                    // Perform the query
                    mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                    // Reset temp variable to empty
                    $templine = '';
                }
                }
                echo "Tables imported successfully";



            //cms_config settings
            $set_pageTitle = 'website title';
            $set_keywords = 'website, standard, keywords';
            $set_templateId = 0;

            //create cms_config.xml
            $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $output .= '<cms_config>' . "\n";
            $output .= '<page_title>' . $set_pageTitle . '</page_title>' . "\n";
            $output .= '<keywords>' . $set_keywords . '</keywords>' . "\n";
            $output .= '<template_id>' . $set_templateId . '</template_id>' . "\n";
            $output .= '<home_page>1</home_page>' . "\n";
            $output .= '<webmaster_mail_address>'.$set_webmaster_mail_address.'</webmaster_mail_address>' . "\n";
            $output .= '<analytic_script>1</analytic_script>' . "\n";
            $output .= '</cms_config>' . "\n";

            $path = dirname(__FILE__) . '/../../config/cms_config.xml';
            $cms_config = fopen("$path", "w");
            fwrite($cms_config, $output);
            fclose($cms_config);

            //set standard template
            $this->changeTemplate('1', true);
            
            
            //parse admin panel
            $this->parseAdmin();
            
            
            //create admin uuser
            $userClass = new users();
            $userClass->create($admin_user, 1, $admin_pw, '', '');
        
        }
    }
    function updateRequired(){
        $ch = curl_init("http://http://updates.transparency-everywhere.com/products/supermassive/stable/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $version = curl_exec($ch);
        curl_close($ch);
        
        if($version == $this->getVersion())
            return true;
        else
            return false;
    }
    function installUpdate(){
        
    }
    function getVersion(){
        return '0.1';
    }
    
    /**
    *Gets contents of cms_config.xml
    *@return array with all config data
    */
    function getConfig(){
        
        $filename = dirname(__FILE__) . '/../../config/cms_config.xml';
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        $cmsConfig = new SimpleXMLElement($contents);  
        
        $cmsConfigArray['page_title'] = (string)$cmsConfig->page_title;
        $cmsConfigArray['keywords'] = (string)$cmsConfig->keywords;        
        $cmsConfigArray['template_id'] = (string)$cmsConfig->template_id;      
        $cmsConfigArray['home_page'] = (int)$cmsConfig->home_page;        
        
        $cmsConfigArray['webmaster_mail_adress'] = (string)$cmsConfig->webmaster_mail_address;
        $cmsConfigArray['analytic_script'] = (string)$cmsConfig->analytics_script;
        
        return $cmsConfigArray;
    }
    /**
    *Updates contents of cms_config.xml
    *@param string $pageTitle
    *@param string $keywords
    *@param int $templateID DB-id of template that is used as standard
    *@param int $home_page DB-id of content that is used as startpage
    *@param string $webmaster_mail_adress
    *@param string $analytic_script
    *
    */
    function updateConfig($pageTitle, $keywords, $templateId, $home_page, $webmaster_mail_adress='', $analytic_script=''){
        $userGroups = new usergroups();
        if(true){
            $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $output .= '<cms_config>' . "\n";
            $output .= '<page_title>' . $pageTitle . '</page_title>' . "\n";
            $output .= '<keywords>' . $keywords . '</keywords>' . "\n";
            $output .= '<template_id>' . $templateId . '</template_id>' . "\n";
            $output .= '<home_page>' . $home_page . '</home_page>' . "\n";
            $output .= '<webmaster_mail_adress>' . $webmaster_mail_adress . '</webmaster_mail_adress>' . "\n";
            $output .= '<analytics_script>' . $analytic_script . '</analytics_script>' . "\n";
            $output .= '</cms_config>' . "\n";

            $path = dirname(__FILE__) . '/../../config/cms_config.xml';
            unlink($path);
            $xml_file = fopen("$path", "w");
            fwrite($xml_file, $output);
            fclose($xml_file);

            $this->parseContents();
        }
    }
    /**
    *Generates meta head while parsing
    *@param array $ContentData
    *@param bool $parseAdmin
    *@return string $meta
    */
    function generateMeta($contentData, $parseAdmin = false){
        $cms = new cms();
        $cmsConfigArray = $cms->getConfig();
        $meta = '<meta name="keywords" content="' . $cmsConfigArray['keywords'] . ', ' . $contentData['keywords'] . '"/>'."\n";
        if(isset($cmsConfigArray['description']))
            $meta = '<meta name="description" content="' . $cmsConfigArray['description'] . '"/>'."\n";
        $meta .= '<meta name="title" content="' . $contentData['title'] . ' - ' . $cmsConfigArray['page_title'] . '"/>'."\n";
        if($parseAdmin){
            $meta .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>';
            
        $meta .= '<link rel="stylesheet" type="text/css" href="inc/style.css"/>'."\n";
        $meta .= '<link rel="stylesheet" type="text/css" href="inc/plugins.css"/>'."\n";
        }else{
            $meta .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>';
            $meta .= "<script type=\"text/javascript\">eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\\\b'+e(c)+'\\\\b','g'),k[c])}}return p}('$(\\'8\\').7(1(){\\$(\\'.a\\').6(1(){5 0;0=$(2).9(\\'h-b\\');4.3=g;$(2).e(\\'c\\'+0+\\'.d\\',1(){4.3=f})})});',18,18,'nav_id|function|this|menuIsLoading|window|var|each|ready|document|data|cms_navigation|id|navigation_|html|load|false|true|nav'.split('|'),0,{}))</script>";
        }
        return $meta;
    }
    
    /**
    *Changes the standard template of the cms installation
    *@param int $newTemplateId DB-id of templat that will be installed
    *@param bool $install This functions is also used in $cms->install. In that case the function will run slightly different
    */
    function changeTemplate($newTemplateId, $install = false){
        $userGroups = new usergroups();
        if(true){
            $cms_config = $this->getConfig();

            $this->updateConfig($cms_config['page_title'], $cms_config['keywords'], $newTemplateId, $cms_config['home_page'], $cms_config['webmaster_mail_adress'], $cms_config['analytic_script']);


            if($install){
                $oldConfig['number_of_navigations'] = '0';
            }else{

                $classTemplate = new template($cms_config['template_id']);
                $oldConfig = $classTemplate->getConfig();
            }

            $classTemplate2 = new template($newTemplateId);
            $newConfig = $classTemplate2->getConfig();



            $navigation = new navigation();
            if ($install){
                $select = array();
            } else {
                $select = $navigation->select(NULL, '0');
            }

            if($oldConfig['number_of_navigations'] == $newConfig['number_of_navigations']){
    //            eintraege in table navigations umbenennen
                $i = 0;
                foreach($select AS $selectData){
                    $class_navigation = new navigation($selectData['id']);
                    $update = $class_navigation->update($newConfig['navigations'][$i]['navigation_title'], '', $newConfig['navigations'][$i]['navigation_id'], '');
                    $i++;
                }

            } else if ($oldConfig['number_of_navigations'] < $newConfig['number_of_navigations']){
    //            eintraege umbenennen und weitere hinzufuegen
                $i = 0;
                if (!empty($select)){
                    foreach($select AS $selectData){
                        $class_navigation = new navigation($selectData['id']);
                        $update = $class_navigation->update($newConfig['navigations'][$i]['navigation_title'], '', $newConfig['navigations'][$i]['navigation_id'], '');
                        $i++;
                    }
                }
                while ($i < $newConfig['number_of_navigations']){
                    $navigation->create($newConfig['navigations'][$i]['navigation_title'], '0', ($i+1));
                    $i++;
                }
            } else if ($oldConfig['number_of_navigations'] > $newConfig['number_of_navigations']){
    //            eintraege umbenennen und bei uebrigen parent_id auf -1 setzen
                $i = 0;
                foreach($select AS $selectData){
                    if(!empty($newConfig['navigations'][$i])){
                        $class_navigation = new navigation($selectData['id']);
                        $update = $class_navigation->update($newConfig['navigations'][$i]['navigation_title'], '', $newConfig['navigations'][$i]['navigation_id'], '');
                        $i++;
                    } else {
                        $class_navigation = new navigation($selectData['id']);
                        $update = $class_navigation->update('', '-1', '', '');                   
                    }

                }
            } else {
                echo 'Something went wrong...';
            }



            $class_content = new content();
            $allContents = $class_content->select();
            if(isset($allContents['title'])){
                $temp = $allContents;
                unset($allContents);
                $allContents[0] = $temp;
            }

    //        i = 0;
            foreach ($allContents as $value) {
                $class_content = new content($value['id']);
                $class_content->update($value['parent_navigation_id'], $value['title'], $value['keywords'], $value['description'], $value['content'], $newTemplateId, $value['active'], $value['template_vars']);
            }

            $this->parseEverything();

        }
    }
    
    /**
    *Parses all contents
    */
    function parseContents(){
        //parse all contents
        $content = new content();
        $contents = $content->select();
        
        if(isset($contents['id'])){
            $temp = $contents;
            unset($contents);
            $contents[0] = $temp;
        }
            foreach($contents AS $contentData){

                    $class_template = new template($contentData['template']);
                    $class_template->parse($contentData);

            }
        
        //parse admin panel
        $this->parseAdmin();
    }
    
    /**
    *Parses all navigations
    */
    function parseNavigations(){
        //create all navigations
        $navigation = new navigation();
        $navigation->createNavigations();    
    }
    
    /**
    *Parses all contents and navigations
    */
    function parseEverything(){
        //create all navigations
        $this->parseNavigations();
        
        //parse all contents
        $this->parseContents();
    }
    
    /**
    *Changes the home page to a content
    *@var int $content_id DB-id of the content
    */
    function changeHomePage($content_id){
        
        $cmsConfig = $this->getConfig();
        $this->updateConfig($cmsConfig['pageTitle'], $cmsConfig['keywords'], $cmsConfig['templateId'], $content_id);

        $contents = new contents();
        $contentData = $contents->select($content_id);
        
        //parse updated content
        $class_template = new template($template);
        $class_template->parse($contentData);
    }
    function getRestrictedDirectoryNames(){
        $return[] = 'admin';
        $return[] = 'config';
        $return[] = 'template';
        return $return;
    }
    function sendMailToWebmaster($title, $mailtext){
        
        $cmsConfig = $this->getConfig();
        
        $email_to=$cmsConfig['webmaster_mail_adress'];
        $email_subject=$title;
        $email_message=$mailtext;
        $headers = "From: Naturboden-Aurich\r\n".
        "Reply-To: info@naturboden-aurich\r\n'" .
        "X-Mailer: PHP/" . phpversion();
        echo str_replace(',', '<br>',"$email_to, $email_subject, $email_message, $headers");
        mail($email_to, $email_subject, $email_message, $headers);  
    }
    
    /**
    *Parses the admin panel
    */
    function parseAdmin(){
        $cmsConfig = $this->getConfig();
        $contentData['id'] = 0;
        $contentData['title'] = 'panel';
        $contentData['keywords'] = '';
        $contentData['content'] = base64_encode('<div id="adminPanel">Welcome! This is the admin panel!</div>');        
        $contentData['template'] = $cmsConfig['template_id'];
        $contentData['active'] = true;
        $contentData['parent_navigation_id'] = 1;
        
        $template = new template($cmsConfig['template_id']);
        $template->parse($contentData, true);
    }
}

