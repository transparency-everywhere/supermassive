CMS
=========

The Transparency Everywhere CMS is a lightweight content management system.

It is developed for the following requirements:
*   _Fast and reliable websitests on small servers_
* Every content is directly parsed into a html file when it is created or updated. That way the server only doesn't need to be generated dynamically on every request.

*_Easy and fast template integration_
*Standalone HTML pages can be converted into a template within minutes. You only need to replace the navigation, the meta- and the contentaera and thats it.

*_An easy administration_
*Your design will automatically be the admin panel. That way users, who need to configure the website doesn't get used to two systems

Installation
============

1. Download the source code and move it to your webserver with PHP(version) and mySQL

2. Ensure that those folders fulfill the following requests:
    the root, the config and the admin folder need to be writable
    we highly recommend a server side redirect to a secure connection(https)
    (see here how it works)

3. Run the Install.php

  
Templating
==========

To build a template you have to follow these steps:

You can create a template out of a HTML site within a minute without reading much docu. You only need to define the meta, the content and the navigation structure in your template and your done. 

1.  Move your template into a folder.

    The template HTML should be in a HTML file called "index.html".
    

2.  Replace dynamic parts

    Your template probably has some parts which are supposed to be dynamically generated by the cms.

    *For example the meta and the content area*

```
<html>
<head>

<title>My Website Title</title>
<meta name="keywords" content="HTML, CSS, XML, XHTML, JavaScript">
<meta name="description" content="Some description">

</head>
<body>
    <div id="content">
        <p>Here should be the content in my template</p>
    </div>
</body>
</html>
```

Should be replaced with:

```
<html>
<head>

%meta%

</head>
<body>
    <div id="content">
        %content
    </div>
</body>
</html>
```

_Navigations_
Like most websites, your template probably contains navigations. To let the cms generate those navigations dynamically in your template you only have to do those two steps:

Replace the navigations in your index.html:
```
<div id="headerNav">
    <ul>
        <li>Page One</li>
        <li>Page Two</li>
        <li>Category One
            <ul>
                <li>Page Three</li>
            </ul>
        </li>
    </ul>
</div>
...
<div id="footerNav">
    <ul>
        <li>Page One</li>
        <li>Page Two</li>
        <li>Category One
            <ul>
                <li>Page Three</li>
            </ul>
        </li>
    </ul>
</div>
```

with

```
<div id="headerNav">
%navigations[1]%
</div>
...
<div id="footerNav">
%navigations[2]%
</div>
```
Now you need to add those navigations to the config.xml:
```
<?xml version="1.0" encoding="UTF-8"?>
<template>
    <template_title>Naturboden</template_title>
    <number_of_navigations>2</number_of_navigations>
    <navigations>
        <navigation>
            <navigation_id>1</navigation_id>
            <navigation_ul_class></navigation_ul_class>
            <navigation_title>Header Navigation</navigation_title>
        </navigation>
        <navigation>
            <navigation_id>2</navigation_id>
            <navigation_ul_class></navigation_ul_class>
            <navigation_title>Footer Navigation</navigation_title>
        </navigation>
    </navigations>
</template>
```



Creating Plugins
================
Plugins are an easy way to modify and/or automatize the creation of contents and widgets.
Plugins should contain at least the following files:
functions.php
functions.js
config.xml

1.  _functions.php_, which contains a class which name needs to be linked later inside the config.xml of your plugin.
```
<?php

class basic_shop{
    public function install(){
        DB Statements, etc.
    }
    public function uninstal(){
        DB Statements, contens, etc.
    }
    public function api($action, $parameters){
        switch($action){
            case 'example':
                return $this->anyOutput($parameters['param1'],$parameters['param2']);
                break;
            
        }
    }
    public function anyOutput($param1,$param2){
        //some action
    }
}

?>
```

2.  _functions.js_, which will be loaded inside the admin panel, after the plugin has been installed. This file contains all forms and actions for the admin panel.

A simple plugin, with a form which sends the parameters to the api could look like this:
```
var example_plugin = new function(){
    this.showOverview = function(){
        api.setClassName('php_class_name');
        var adminPanelHTML = '<div id="productOverview"></div><div id="productCategoryOverview"></div>';
        $('#adminPanel').html(');
        
    };


    this.addExampleCategory = function(title){
        api.setClassName('php_class_name');
        var parameters = {};
        parameters['title'] = title;
        
        api.query('addExampleCategory', parameters);
    };
    this.getExampleCategories = function(){
        api.setClassName('php_class_name');
        var parameters = {};
        var categoryData = api.query('getExampleCategories', parameters);
        
        var ids =  [];
        var titles = [];
        var i = 0;
        $.each(categoryData, function( key, value ) {
            ids[i] =  value['id'];
            titles[i] = value['title'];
            i++;
        });

        return [ids, titles];
        
    };
    
    this.showAddExampleCategoryForm = function(){
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Add product category';
        options['action'] = function(){
            basic_shop.addExampleCategory($('#title').val());
            alert('Example category added');
            example_plugin.showOverview();
        };
        options['buttonTitle'] = 'Save';
        
        
        var field0 = [];
        field0['caption'] = 'Title';
        field0['inputName'] = 'title';
        field0['type'] = 'text';
        fieldArray[0] = field0;
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
};
```

3.  config.xml, which contains all the information the cms needs to run your plugin:
```
<?xml version="1.0" encoding="UTF-8"?>
<plugin>
    <plugin_name>Example Plugin</plugin_name>
    <plugin_folder_name>example_plugin</plugin_folder_name>
    <php_class_name>example_plugin</php_class_name>
    <js_class_name>example_plugin</js_class_name>
    
    <php_class_contains_installer>1</php_class_contains_installer>
    <link_type>navigation</link_type>
    <link_caption>Products</link_caption>
    <nav_id>0</nav_id>
</plugin>

```
4.Zip the files and your plugin is ready to install.