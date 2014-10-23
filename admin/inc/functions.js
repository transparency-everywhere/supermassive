/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function() {
    
    
    console.log('welcome, this is the transpev cms!');
    
    
    localStorage.clear();
    currentUser.init();
    var menuHTML;
                var pluginArray = plugins.getPlugins();
                var pluginHTML = '';
                if(pluginArray){
                    pluginHTML += '<li class="headline">Apps <ul>';
                    $.each(pluginArray[0], function(index, value){

                        pluginHTML += '<li onclick="'+pluginArray[4][index]+'.showOverview();">'+pluginArray[1][index]+'</a></li>';
                    });
                    
                    pluginHTML += '</ul></li>';
                }
    
        
                    
                menuHTML = '<div id="cms_menu"> ';
                        menuHTML += '<img src="img/logo.png" style="width:175px;margin-left: 2px;margin-top: 6px;"/>';
                        menuHTML += '<ul>';
                                menuHTML += '<li class="userField">'+adminPanel.generateUserNavField()+'</li>';
                                if(currentUser.hasRight('readUsers')){
                                    menuHTML += '<li class="headline">Users';
                                            menuHTML += '<ul>';
                                                    menuHTML += '<li onclick="adminPanel.showCreateUserForm();">Create User</li>';
                                                    menuHTML += '<li onclick="adminPanel.showUserOverview();">Show Overview</li>';
                                            menuHTML += '</ul>';
                                    menuHTML += '</li>';
                                }
                                
                                if(currentUser.hasRight('readUsergroups')){
                                    menuHTML += '<li class="headline">Usergroups';
                                        menuHTML += '<ul>';
                                            menuHTML += '<li onclick="adminPanel.showCreateUsergroupForm();">Create Usergroup</li>';
                                            menuHTML += '<li onclick="adminPanel.showUsergroupOverview();">Show Overview</li>';
                                        menuHTML += '</ul>';
                                    menuHTML += '</li>';
                                }
                                
                                menuHTML += pluginHTML;
                                
                                
                                if(currentUser.hasRight('seeNavigations')){
                                    menuHTML += '<li class="headline">Navigations';
                                        menuHTML += '<ul>';
                                                menuHTML += '<li onclick="adminPanel.showCreateNavigationForm();">Create Navigations</li> ';
                                                menuHTML += '<li onclick="adminPanel.showNavigationOverview();">Show Overview</li>';
                                        menuHTML += '</ul>';
                                    menuHTML += '</li>';
                                }
                                if(currentUser.hasRight('seeContents')){
                                    menuHTML += '<li class="headline">Contents';
                                            menuHTML += '<ul>';
                                                    menuHTML += '<li onclick="adminPanel.showCreateContentForm();">Create Content</li>';
                                                    menuHTML += '<li onclick="adminPanel.showContentOverview();">Show Overview</li>';
                                                    menuHTML += '<li class="spacer"></li>';
                                                    menuHTML += '<li onclick="adminPanel.showCreateContentForm();">Startpage</li>';
                                            menuHTML += '</ul>';
                                    menuHTML += '</li>';
                                }
                                
                                if(currentUser.hasRight('readWidgets')){
                                    menuHTML += '<li class="headline">Widgets';
                                            menuHTML += '<ul>';
                                                    menuHTML += '<li onclick="adminPanel.showCreateWidgetForm();">Create Widget</li>';
                                                    menuHTML += '<li onclick="adminPanel.showWidgetOverview();">Show Overview</li>';
                                            menuHTML += '</ul>';
                                    menuHTML += '</li>';
                                }
                                
                                if(currentUser.hasRight('seeFiles')){
                                    menuHTML += '<li class="headline">Files';
                                            menuHTML += '<ul>';
                                                    menuHTML += '<li onclick="adminPanel.showUploadFileForm();">Upload File</li>';
                                                    menuHTML += '<li onclick="adminPanel.showFileOverview();">Show Overview</li>';
                                                    menuHTML += '<li class="spacer"></li>';
                                            menuHTML += '</ul>';
                                    menuHTML += '</li>';
                                }
                                if(currentUser.hasRight('seeTemplates')){
                                    menuHTML += '<li class="headline">Templates';
                                            menuHTML += '<ul>';
                                                    menuHTML += '<li onclick="adminPanel.showChangeTemplateForm();">Change Template</li>';
                                                    menuHTML += '<li onclick="adminPanel.showTemplateOverview();">Show Overview</li>';
                                                    menuHTML += '<li class="spacer"></li>';
                                            menuHTML += '</ul>';
                                    menuHTML += '</li>';
                                }
                                menuHTML += '<li class="headline">Settings';
                                        menuHTML += '<ul>';
                                                menuHTML += '<li onclick="adminPanel.showUpdateCmsConfigForm();">General</li>';
                                                menuHTML += '<li onclick="adminPanel.showUpdateHomePageForm();">Starpage</li>';
                                                menuHTML += '<li onclick="adminPanel.showChangeTemplateForm();">Change Template</li>';
                                        menuHTML += '</ul>';
                                menuHTML += '</li>';
                            menuHTML += '</ul>'
                            menuHTML += '</div>';
    
    $( 'body' ).append( menuHTML );
    
    $('#cmsMenu tr a').click(function(){
        adminPanel.toggleMenu();
    });
    
    
    $('#cmsMenu .toggleMenu').click(function(){
        adminPanel.toggleMenu();
    });
    adminPanel.init();
});


function addAdminLinks(){
    if(!window.menuIsLoading){
        $('.cms_navigation ul').each(function(){
            if((!$(this).hasClass('dropdown-menu')) && (!$(this).hasClass('menu-added'))){
                //console.log($(this).hasClass('dropdown-menu'));
                $(this).addClass('menu-added');
                var id = $(this).data('id');
                console.log('id'+id);
                $(this).append('<div class="cms_dropdown"> <header> <img src="img/options_icon.png"/> </header> <ul> <li onclick="adminPanel.showCreateContentForm(\''+id+'\');">Create Content</li> <li onclick="adminPanel.showCreateNavigationForm(\''+id+'\');">Create Navigation</li> </ul> </div>');
                //console.log('loading nav');
            }
        });
        $('.cms_navigation li').each(function(){

            var type = $(this).data('type');

            var id = $(this).data('id');
            var href = $(this).attr('href');

            if(type === 'content'){

                $(this).children('a').click(function(e){
                    e.preventDefault();
                    adminPanel.showUpdateContentForm(id);
                });

                $(this).append('<div class="cms_dropdown"> <header> <img src="img/options_icon.png"/> </header> <ul> <li onclick="adminPanel.showUpdateContentForm(\''+id+'\');">Update Content</li> <li onclick="adminPanel.verifyContentRemoval(\''+id+'\');">Delete Content</li>  <li onclick="adminPanel.showAddContentToNavigationForm(\''+id+'\');">Add to Navigation</li> </ul> </div>');

            }else if(type === 'navigation'){

                $(this).children('a').click(function(e){
                    e.preventDefault();
                    alert(id);
                });

                $(this).append('<div class="cms_dropdown"> <header> <img src="img/options_icon.png"/> </header> <ul> <li onclick="adminPanel.showCreateContentForm(\''+id+'\');">Create Content</li> <li onclick="adminPanel.showCreateNavigationForm(\''+id+'\');">Create Navigation</li> </ul> </div>');
            }

        });
        
        $('.dropdown-toggle').click(function(){
            $(this).next('ul').toggle();
        });
    
    }
};


var users = new function(){
    
    this.generateUserNavField = function(){
        //get userdata for currently shown user
        var userData = users.getUserData(users.getUser());
        
        var shownName, output;
        
        if(String(userData.firstname).length > 0)
            shownName = userData.firstname;
        else
            shownName = userData.username;
        
        output = 'Welcome to the adminpanel,'+shownName+'.<br><a href="#logout" onclick="adminPanel.logout();">logout</a>&nbsp;-&nbsp;<a href="#logout" onclick="adminPanel.showUpdateUserForm('+users.getUser()+');">change info</a><br>'
        return output;
            
    };
    
    //returns userid of currently logged in user
    this.getUser = function(){
        if(typeof localStorage.userid !== 'undefined')
            return localStorage.userid;
        
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=getUser",
            success:function(data){
                result = data;
                localStorage.userid = data;
            },
            async:false
        });
        return result;
    };
    
    
    this.create = function(username, usergroup, password, firstname, lastname){
        $.post( "api.php?action=createUser", { username: username, usergroup: usergroup, password: password, firstname: firstname, lastname: lastname }, function(data){
            console.log(data);
        });
    };
    this.update = function(user_id, username, usergroup, firstname, lastname){
        $.post( "api.php?action=updateUser", { user_id: user_id, username: username, usergroup: usergroup, firstname: firstname, lastname: lastname }, function(data){
            console.log(data);
        });
    };
    this.updatePassword = function(user_id, password){
        $.post( "api.php?action=updateUserPassword", { user_id: user_id, password: password}, function(data){
            console.log(data);
        });
    };
    this.delete = function(user_id){
        $.post( "api.php?action=deleteUser", { user_id: user_id }, function(data){
            console.log(data);
        });
    };
    this.getUserData = function(user_id){
        var result;
        
        $.ajax({
            type: 'POST',
            url: "api.php?action=getUserData",
            data: { user_id: user_id },
            success:function(data){result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.getUsers = function(){
        //returns array with all users user info
        var result;
        
        $.ajax({
            url: "api.php?action=getUsers",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
        
    };
    
};

var currentUser = new function(){
    this.userid;
    this.usergroup;
    this.rights;
    this.init = function(){
        this.userid = users.getUser();
        this.usergroup = this.getUserGroup();
        this.rights = this.getUserRightArray();
        
    };
    this.getUserGroup = function(){
        var result;
        
        $.ajax({
            url: "api.php?action=getCurrentUsergroup",
            success:function(data){
                result = data},
            async:false
        });
        return result;
    };
    this.getUserRightArray = function(){
        
        usergroups.getRightList();
        var rights =  usergroups.getRights(this.usergroup);
        return rights;
        
    };
    this.hasRight = function(right){
        var rightArray = this.rights;
        if(rightArray[right] == 1)
            return true;
        else
            return false;
    };
    
};

var usergroups = new function(){
    this.create = function(title, rightArray){
         var jsonString = JSON.stringify(rightArray);
          $.post( "api.php?action=createUsergroup", { 
              title:  title, 
              rightArray: jsonString
          }, function(data){
            console.log(data);
          });
     };
    this.update = function(group_id, title, rightArray){
         
         var jsonString = JSON.stringify(rightArray);
          $.post( "api.php?action=updateUsergroup", {
              group_id: group_id,
              title:  title, 
              rightArray: jsonString
          }, function(data){
            console.log(data);
          });
     };
    this.delete = function(content_id){
        $.post( "api.php?action=deleteUsergroup", { group_id: group_id }, function(data){
            console.log(data);
        });
    };
    this.getUsergroupRightArray = function(){
        var result;
        
        $.ajax({
            url: "api.php?action=getUsergroupRightArray",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;        
    };
    this.getUsergroups = function(){
        //returns array with all usergroups id´s and titles
        var result;
        
        $.ajax({
            url: "api.php?action=getUsergroups",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.getTitle = function(group_id){
        var ret;
        //gets rights for a specific group
        $.ajax({
            type: 'POST',
            url: "api.php?action=getUsergroupTitle",
            data: { group_id: group_id },
            success:function(data){
               ret = data;},
            async:false
        });
        return ret;
    }

    
    this.getRights = function(group_id){
        //gets rights for a specific group
        var result;
        
        $.ajax({
            type: 'POST',
            url: "api.php?action=getUsergroupRights",
            data: { group_id: group_id },
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.getRightList = function(){
        //gets all possible rights
        
        var result;
        
        $.ajax({
            type: 'POST',
            url: "api.php?action=getRightList",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
};

var files = new function(){
    this.removeFileFromUploader = function(inputName, file_id){
        $('#' + inputName + '_fileList .file_'+file_id).remove();
        String($('#'+inputName).val()).replace(file_id+',','');
    };
    this.idToTitle = function(file_id){
        
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=fileIdToFileTitle",
            data: {file_id:file_id},
            success:function(data){
                result = data;},
            async:false
        });
        return result;
    };
    this.getFiles = function(){
        
        var contentData = db.selectFiles();
        
        
        var ids =  [];
        var titles = [];
        var i = 0;
        $.each(contentData, function( key, value ) {
            ids[i] =  value['id'];
            titles[i] = value['title'];
            i++;
        });

        return [ids, titles];
    };
    this.updateTempByStr = function(str){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=updateTempFilesByStr",
            data: {string:str},
            success:function(data){
                result = data;
            },
            async:false
        });
        return result;
    };
};

var contents = new function(){
    this.create = function(parent_navigation_id, title, keywords, description, content, template, active){
        $.post( "api.php?action=createContent", { parent_navigation_id:  parent_navigation_id, title: title, keywords: keywords, description: description, content: content, template: template, active: active }, function(data){
            console.log(data);
        });
 
    };
    this.select = function(content_id){
        var result;
        
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectContent",
            data: { content_id: content_id },
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
 
    };
    this.update = function(content_id, parent_navigation_id, title, keywords, description, content, template, active){
        var content = base64_encode(content);
        $.post( "api.php?action=updateContent", { content_id: content_id, parent_navigation_id:  parent_navigation_id, title: title, keywords: keywords, description: description, content: content, template: template, active: active }, function(data){
            console.log(data);
        });
 
    };
    this.delete = function(content_id){
        $.post( "api.php?action=deleteContent", { content_id: content_id }, function(data){
            console.log(data);
        });
    };
    this.getContents = function(){
        var contentData = db.selectContents();
        
        
        var ids =  [];
        var titles = [];
        var i = 0;
        $.each(contentData, function( key, value ) {
            ids[i] =  value['id'];
            titles[i] = value['title'];
            i++;
        });

        return [ids, titles];
    };
};

var navigations = new function(){
    this.create = function(title, parent_id){
        $.post( "api.php?action=createNavigation", { title: title, parent_id: parent_id }, function(data){
            console.log(data);
        });
    };
    this.select = function(navigation_id){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectNavigation",
            data: { navigation_id: navigation_id },
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.update = function(navigation_id, title, parent_id){
        $.post( "api.php?action=updateNavigation", { navigation_id: navigation_id, title: title, parent_id: parent_id }, function(data){
            console.log(data);
        });
    };
    this.delete = function(navigation_id){
        $.post( "api.php?action=deleteNavigation", { navigation_id: navigation_id }, function(data){
            console.log(data);
        });
    };
    this.getNavigations = function(){
        var templateData = db.selectNavigations();
        
        console.log(templateData);
        
        var ids =  [];
        var titles = [];
        var i = 0;
        $.each(templateData, function( key, value ) {
            ids[i] =  value['id'];
            titles[i] = value['title'];
            i++;
        });

        console.log([ids, titles]);
        return [ids, titles];
        
    };
    this.changeOrder = function(navigation_id, oldOrderId, newOrderId){
        
        $.post( "api.php?action=changeOrder", { navigation_id: navigation_id, oldOrderId: oldOrderId, newOrderId:newOrderId }, function(data){
            console.log(data);
        });
    }
};

var widgets = new function(){
    this.create = function(title, type, content){
        $.post( "api.php?action=createWidget", { title: title, type: type, content: content }, function(data){
            console.log(data);
        });
    };
    this.select = function(widget_id){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectWidget",
            data: { widget_id: widget_id },
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.update = function(widget_id, title, type, content){
        $.post( "api.php?action=updateWidget", { widget_id: widget_id, title: title, type: type, content: content}, function(data){
            console.log(data);
        });
    };
    this.delete = function(widget_id){
        $.post( "api.php?action=deleteWidget", { widget_id: widget_id }, function(data){
            
        });
    };
    this.AddWidgetToContent = function(widget_id, content_id, template_widget_area_id){
        $.post( "api.php?action=addWidgetToContent", { widget_id: widget_id, content_id:content_id, template_widget_area_id:template_widget_area_id }, function(data){
            console.log(data);
        });
    };
    this.getWidgets = function(){
        var templateData = db.selectWidgets();
        
        
        var ids =  [];
        var titles = [];
        var i = 0;
        $.each(templateData, function( key, value ) {
            ids[i] =  value['id'];
            titles[i] = value['title'];
            i++;
        });

        return [ids, titles];
        
    };
    this.getWidgetsForWidgetArea = function(content_id, template_widget_area_id){
        
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=getWidgetsForWidgetArea",
            data: {content_id: content_id, template_widget_area_id:template_widget_area_id},
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.idToTitle = function(widget_id){
        
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=widgetIdToWidgetTitle",
            data: {widget_id:widget_id},
            success:function(data){
                result = data;},
            async:false
        });
        return result;
    };
    this.load = function(widget_id){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=loadWidget",
            data: {widget_id:widget_id},
            success:function(data){
                result = data;},
            async:false
        });
        return result;
    };
    this.generateTypeDropdownArray = function(){
        var types = [];
        var captions = [];
        types[0] = 'HTML';
        captions[0] = 'HTML';
        
        return [types, captions];
    };
};

var navigation_links = new function(){
    this.create = function(navigation_id, target_type, target_id, caption){
        $.post( "api.php?action=createNavigationLink", { navigation_id: navigation_id, target_type: target_type, target_id: target_id, caption: caption }, function(data){
            console.log(data);
        });
    };
    this.update = function(navigation_link_id, navigation_id, target_type, target_id, caption){
        $.post( "api.php?action=updateNavigationLink", { navigation_link_id: navigation_link_id, navigation_id: navigation_id, target_type: target_type, target_id: target_id, caption: caption }, function(data){
            console.log(data);
        });
    };
    this.delete = function(navigation_link_id){
        $.post( "api.php?action=updateNavigationLink", { navigation_link_id: navigation_link_id }, function(data){
            console.log(data);
        });
    };
};

var cms = new function(){
    this.getConfig = function(){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=getConfig",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.updateConfig = function(pageTitle, keywords, templateId, home_page, webmaster_mail_adress, analytic_script){
        $.post( "api.php?action=updateConfig", { pageTitle: pageTitle, keywords: keywords, templateId: templateId, home_page: home_page, analytic_script: analytic_script, webmaster_mail_adress: webmaster_mail_adress}, function(data){
            console.log(data);
        });
    };
    this.changeTemplate = function(newTemplateId){
        $.post( "api.php?action=changeTemplate", { newTemplateId: newTemplateId }, function(data){
            console.log(data);
        });
    };
};

var templates = new function(){
    this.getTemplates = function(){
        var templateData = db.selectTemplates();
        
        
        var ids =  [];
        var titles = [];
        var i = 0;
        $.each(templateData, function( key, value ) {
            ids[i] =  value['id'];
            titles[i] = value['title'];
            i++;
        });

        return [ids, titles];
        
    };
    this.addTemplate = function(file_id){
        
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=addTemplate",
            data: {file_id: file_id},
            success:function(data){
                result = data;},
            async:false
        });
        return result;
    };
};

var plugins = new function(){
    this.initPlugins = function(){
        var plugin_array = this.getPlugins();
        if(!gui){
        gui.loadScript('inc/functions.js');
            
        }
        $.each(plugin_array[0], function(index,value){
            gui.loadScript('../plugins/'+plugin_array[2][index]+'/functions.js');
        });
    };
    this.getPlugins = function(){
        var pluginData = db.selectPlugins();
        if((typeof pluginData !== 'string') && (typeof pluginData !== 'undefined')){
            
        
            var ids =  [];
            var plugin_names = [];
            var folder_names = [];
            var js_class_names = [];
            var active_array = [];
            var i = 0;

            $.each(pluginData, function( key, value ) {
                ids[i] =  value['id'];
                plugin_names[i] = value['plugin_name'];
                folder_names[i] = value['plugin_folder_name'];
                active_array[i] = value['active'];
                js_class_names[i] = value['js_class_name'];
                i++;
            });

            return [ids, plugin_names, folder_names, active_array, js_class_names];
        }else{
            return false;
        }
        
    };
    this.addTemplate = function(file_id){
        
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=addPlugin",
            data: {file_id: file_id},
            success:function(data){
                result = data;},
            async:false
        });
        return result;
    };
};

var db = new function(){
    this.selectTemplates = function(){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectTemplates",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.selectPlugins = function(){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectPlugins",
            success:function(data){
                if(!empty(data))
                    result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.selectContents = function(){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectContents",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.selectFiles = function(){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectFiles",
            success:function(data){
                result = JSON.parse(data);
            },
            async:false
        });
        return result;
    };
    this.selectNavigations = function(){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectNavigations",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
    this.selectWidgets = function(){
        var result;
        $.ajax({
            type: 'POST',
            url: "api.php?action=selectWidgets",
            success:function(data){
                result = JSON.parse(data);},
            async:false
        });
        return result;
    };
};

var gui = new function(){
    this.initWysiwyg = false; //is used in generateField and createForm to check if wysiwyg needs to be initialized
    this.initializeUploadify = false;
    this.toggleAdvanced = function(){
        if($('.advanced').hasClass('open')){
            $('.advanced .advancedField').hide();
            $('.advanced').removeClass('open');
        }else{
            $('.advanced .advancedField').show();
            $('.advanced').addClass('open');
        }
    };
    this.generateField = function(fieldData, tr_class){
        if(typeof fieldData['value'] === 'undefined')
            fieldData['value'] = '';
        else{
            var temp;
            temp = String(fieldData['value']);
            fieldData['value'] = temp.replace(/\"/g, '&quot;');
        }
            
        var mainHTML = '';
        mainHTML += '<tr class='+tr_class+'>';
        if(fieldData['type'] !== 'wysiwyg')
            mainHTML += '<td>&nbsp;' + fieldData.caption + ':</td><td>&nbsp;</td>';

                    switch(fieldData['type']){
                        case 'text':
                            if(!fieldData['value']){
                                fieldData['value'] = '';
                            }
                            var disabled = '';
                            if(typeof fieldData['disabled'] != 'undefined'){
                                if(fieldData['disabled']){
                                    disabled = 'disabled="disabled"';
                                }else{
                                    disabled = '';
                                }
                            }
                            mainHTML += '<td><input type="text" name="' + fieldData.inputName + '" id="' + fieldData.inputName + '" value="' + fieldData['value'] + '" '+disabled+'/></td>';
                            break;
                        case 'textarea':
                            if(!fieldData['value']){
                                fieldData['value'] = '';
                            }
                            mainHTML += '<td><input type="text" name="' + fieldData.inputName + '" id="' + fieldData.inputName + '" value="' + fieldData['value'] + '"/></td>';
                            break;
                        case 'password':
                            mainHTML += '<td><input type="password" name="' + fieldData.inputName + '" id="' + fieldData.inputName + '"/></td>';
                            break;
                        case 'checkbox':
                            var checked;
                            if(fieldData.checked === true){
                                checked = 'checked="checked"';
                            }else{
                                checked = '';
                            }
                            mainHTML += '<td><input type="checkbox" value="' + fieldData.value + '" name="' + fieldData.inputName + '" id="' + fieldData.inputName + '" '+ checked +'/></td>';
                            break;
                        case 'radio':
                            mainHTML += '<td><input type="text" name="' + fieldData.inputName + '" id="' + fieldData.inputName + '"/></td>';
                            break;
                        case 'dropdown':
                            mainHTML += '<td><select name="' + fieldData.inputName + '" id="' + fieldData.inputName + '">';
                            mainHTML += gui.createDropdown(fieldData.values, fieldData.captions, fieldData.preselected);
                            mainHTML += '</select></td>';
                            break;
                        case 'space':
                            mainHTML += '<td></td>';
                            break;
                        case 'wysiwyg':
                            gui.initWysiwyg = true;
                            mainHTML += '<td colspan="3"><div class="wysiwyg" id="' + fieldData.inputName + '" contenteditable="true">'+fieldData.value+'</div></td>';
                            break;
                        case 'button':
                            mainHTML += '<td colspan="1"><a href="#" onclick="'+fieldData.actionFunction+'" class="btn btn-default">'+fieldData.value+'</a></td>';
                            break;
                        case 'file':
                            gui.initializeUploadify = true;
                            
                            var fileGallery = '';
                            var fieldValue = '';
                            if(fieldData.value){
                                fieldValue = fieldData.value;
                                fileGallery = gui.generateFileGallery(fieldData.value, fieldData.inputName);
                            }
                            mainHTML += '<td colspan="1">'+fileGallery+'<ul id="' + fieldData.inputName + '_fileList"></ul><input type="hidden" name="' + fieldData.inputName + '" id="' + fieldData.inputName + '" value="'+fieldValue+'"><div id="' + fieldData.inputName + '_fileField"></div></td>';
                            break;
                    }
        mainHTML += '</tr>'; 
        return mainHTML;
    };
    this.createForm = function($selector, fields, options){

        var mainHTML = '';
        var advancedHTML = '';
        
        //reset init var
        this.initWysiwyg = false;
        $.each(fields, function(index, fieldData){
            console.log(fieldData['advanced']);
            if((typeof fieldData['advanced'] === 'undefined')||fieldData['advanced'] === false){
                mainHTML += gui.generateField(fieldData, '');
            }
            else if(fieldData['advanced'] === true){
                advancedHTML += gui.generateField(fieldData, 'advancedField');
            }
           
        });


        var html =  '<form id="dynForm" class="dynForm">';
        if(advancedHTML.length > 0){
            html += '<table class="advanced">';
            html += advancedHTML;
            html += '<tr><td colspan="3" align="center"><a href="#" class="toggle" onclick="gui.toggleAdvanced();"><i class="glyphicon glyphicon-chevron-down""></i><i class="glyphicon glyphicon-chevron-up""></i></a></td></tr>';
            html += '</table>';
        }
        if(options['headline'].length > 0)
            html +=  '<h1>' + options['headline'] + '</h1>';
        html +=  '<table>';
        html += mainHTML;
        html += '<tr><td colspan="3"><a href="#" onclick="history.back();" class="btn btn-primary" style="margin-right:15px;">Back</a><input type="submit" value="' + options['buttonTitle'] + '" name="submit" id="submitButton" class="btn btn-success"></td></tr>';
        html += '</table>';
        html += '</form>';
        
        $($selector).html(html);
        if (typeof options['action'] == 'function'){
            $('#dynForm').submit(function(e){
                e.preventDefault();
                options['action']();
            });
        }
        if(this.initWysiwyg){
            $('.wysiwyg').ckeditor(function(){}, {allowedContent: true});
        }
        if(this.initializeUploadify){
            $.each(fields, function(index, fieldData){
                if(fieldData['type'] == 'file'){
                    gui.initUploadify('#'+fieldData['inputName']+'_fileField',fieldData['inputName']);
                }
            });
        }
        return html;
    };
    this.createDropdown = function(values, captions, preselected){
        var html = '';
        $.each(values, function( index, value ) {
            var selected;
            if(typeof preselected !== 'undefined'){
                if(preselected == value)
                    {selected = 'selected="selected"';}
                else
                    {selected = '';}
            }
            html += '<option value="' + value + '" '+selected+'>' + captions[index] + '</option>';
        });
        return html;
    };
    this.createOverview = function($selector, ids, captions, actions, title){
        
        var html;
        html = '<h3 class="pull-left">'+title+'</h3>';
        if((typeof actions['add'] !== 'undefined') ||(typeof actions[0] !== 'undefined')){
            if(typeof actions[0] === 'object'){
                $.each(actions, function(index, value){
                   console.log(index);
                   console.log(value);
                   html += '<a href="#" onclick="'+value['onclick']+'" class="btn btn-success pull-right">'+value['caption']+'</a>'; 
                });
            }else{
                html += '<a href="#" onclick="'+actions['add']['onclick']+'" class="btn btn-success pull-right">'+actions['add']['caption']+'</a>';
            }
        }
        html += '<table class="table table-striped">';
        $.each(ids, function( index, value ) {
            
            var actionHTML = '';
            
            if(typeof actions['update'] !== 'undefined'){
                actionHTML += '<a href="#" class="btn btn-default" onclick="'+actions['update']['onclick']+'('+value+')'+'"><span class="glyphicon glyphicon-pencil"></span></a>';
            }
            if(typeof actions['delete'] !== 'undefined'){
                actionHTML += '<a href="#" class="btn btn-default" onclick="'+actions['delete']['onclick']+'('+value+')'+'"><span class="glyphicon glyphicon-remove-circle"></span></a>';
            }
            if(actionHTML.length > 0){
                actionHTML = '<div class="btn-group">'+actionHTML+'</div>';
            }
            
            if(!empty(captions[index])){
                html += '<tr>';
                    html += '<td>'+captions[index]+'</td>';
                    html += '<td align="right">'+actionHTML+'</td>';
                html += '</tr>';
            }
        });
        
        html += '</table>';
        $($selector).html(html);
        return true;
        
    };
    this.verifyRemoval = function(type, link){
        
	Check = confirm("Are you sure to delete this "+type+" ?");
	if (Check == true){
            $.ajax({
                  url: link,
                  type: "GET",
                  async: false,
                  success: function(data) {
                                    alert('The '+type+' has been deleted');
                                    window.location.href = window.location.href;
                  }
            });
	}
    };
    this.loadScript = function(url){
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url;
            var x = document.getElementsByTagName('head')[0];
            x.appendChild(s);
    };
    this.initUploadify = function($selector, inputName){
              
	            $($selector).uploadify({
	                    'formData'     : {
	                            'timestamp' : 'timestamp',
	                            'token'     : ''
	                    },
	                    'swf'      : 'inc/plugins/uploadify/uploadify.swf',
	                    'uploader' : 'api.php?action=uploadFile',
				        'onUploadSuccess' : function(file, data, response) {
				        	
				        	if(response){
                                                        $('#'+inputName+'_fileList').append('<li class="file_'+data+'">'+files.idToTitle(data)+'<a href="#" onclick="files.removeFileFromUploader(\''+inputName+'\',\''+data+'\');">x</a></li>')
                                                        $('#'+inputName).val($('#'+inputName).val()+data+',');
                                                    
				        	}
				        },
	                    'onUploadError' : function(file, errorCode, errorMsg, errorString) {
	                        alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
	                    }
	            });
               
    };
    this.createPanel = function($selector, ids, captions, actions, title){
        
        var html;
        
        
        var html="";
        html += "<div class=\"panel\">";
        html += "<div class=\"panel-heading\">";
        html += "    <span class=\"glyphicon glyphicon-list\"><\/span>"+title;
        html += "    <div class=\"pull-right action-buttons\">";
        html += "        <div class=\"btn-group pull-right\">";
        html += "            <button type=\"button\" class=\"btn btn-default btn-xs dropdown-toggle\" data-toggle=\"dropdown\">";
        html += "                <span class=\"glyphicon glyphicon-cog\" style=\"margin-right: 0px;\"><\/span>";
        html += "            <\/button>";

        if((typeof actions['add'] !== 'undefined') ||(typeof actions[0] !== 'undefined')){
            html += "<ul class=\"dropdown-menu slidedown\">";
            if(typeof actions[0] === 'object'){
                $.each(actions, function(index, value){
                   
                   html += "<li><a href=\"#\" onclick=\""+value['onclick']+"\"><span class=\"glyphicon glyphicon-pencil\"><\/span>"+value['caption']+"\<\/a><\/li>";
                });
            }else{
                html += "<li><a href=\"#\" onclick=\""+actions['add']['onclick']+"\"><span class=\"glyphicon glyphicon-pencil\"><\/span>"+actions['add']['caption']+"\<\/a><\/li>";
            }
            html += "<\/ul>";
        }
        html += "         <\/div>";
        html += "     <\/div>";
        html += " <\/div>";
        html += " <div class=\"panel-body\">";
        html += "     <ul class=\"list-group panel_"+title+"\">";

        
        var numberOfItems = ids.length;
        var multiPaging = false;
        var page = 0;
        var itemsPerPage = 5;
        if(numberOfItems > 10){
            multiPaging = true;
            
        }
        
        
        var i = 0;
        $.each(ids, function( index, value ) {
            
            var actionHTML = '';
            var pageClass = '';
            var itemStyle = '';
            
            if(typeof actions['update'] !== 'undefined'){
                actionHTML += '<a href="#" onclick="'+actions['update']['onclick']+'('+value+')'+'"><span class="glyphicon glyphicon-pencil"></span></a>';
            }
            if(typeof actions['delete'] !== 'undefined'){
                actionHTML += '<a href="#" onclick="'+actions['delete']['onclick']+'('+value+')'+'"><span class="glyphicon glyphicon-remove-circle"></span></a>';
            }
            if(actionHTML.length > 0){
                actionHTML = actionHTML+'';
            }
            if(!empty(captions[index])){
                if(multiPaging){
                    if(i>=itemsPerPage){ 
                        if(i%itemsPerPage == 0){
                            page++;
                        }
                    }
                    pageClass = 'page_'+page;
                    if(page === 0){
                        itemStyle = 'display:block;';
                    }else{
                        itemStyle = 'display:none';
                    }
                }else{
                    pageClass = '';
                }
                html += "                        <li class=\"list-group-item page "+pageClass+"\" style="+itemStyle+">";
                html += captions[index];
                html += "                           <div class=\"pull-right action-buttons\">";
                html += actionHTML;
                html += "                            <\/div>";
                html += "                        <\/li>";
            }
            i++;
        });
        
        //add footer
        html += "    <\/ul>";
        html += "<\/div>";
        html += "<div class=\"panel-footer\">";
        html += "    <div class=\"row\">";
        html += "        <div class=\"col-md-6\">";
        html += "            <h6>";
        html += "                Total Count <span class=\"label label-info\">"+numberOfItems+"<\/span><\/h6>";
        html += "        <\/div>";
        if(page > 0){
        html += "        <div class=\"col-md-6\">";
        html += "            <ul class=\"pagination pagination-sm pull-right\">";
        html += "                <li><a href=\"gui.showPanelPage('"+title+"', "+(page-1)+")\">&laquo;<\/a><\/li>";
        
            if(numberOfItems > 5){
                var i = 1;
                var page = 1;
                
                
                html += '<li class="active"><a href="javascript:gui.showPanelPage(\''+title+'\', '+(page-1)+')">'+(page)+'</a></li>';
            
                
                while(i < numberOfItems){
                    if(i%itemsPerPage == 0){
                        page++;
                        html += '<li class="active"><a href="javascript:gui.showPanelPage(\''+title+'\', '+(page-1)+')">'+page+'</a></li>';
            
                    }
                    i++;
                }
                
            }
        
        html += "                <li><a href=\"javascript:gui.swapPanelPage(\'"+title+"\','up')\">&raquo;<\/a><\/li>";
        html += "            <\/ul>";
        html += "        <\/div>";
        }
        html += "    <\/div>";
        html += "<\/div>";
        $($selector).html(html);
        return true;
        
    };
    this.showPanelPage = function(panelTitle, page){
        $('.panel_'+panelTitle).attr('data-currentpage',page);
        $('.panel_'+panelTitle+' .page').hide();
        $('.panel_'+panelTitle+' .page_'+page).show();
        
    };
    this.swapPanelPage = function(panelTitle, direction){
        var currentPage = parseInt($('.panel_'+panelTitle).attr('data-currentpage'));
        console.log(currentPage);
        if(direction === 'down'){
            currentPage--;
        }else if(direction === 'up'){
            currentPage++;
        }
        
        this.showPanelPage(panelTitle, currentPage);
        return true;
        
    }
    
    
    /**
    *Generates html for file gallery
    *@param str fileStr String with comma separed file id´s
    *@param str fieldName String with id of the field from which the file_id needs to be removed
    *@return str html with file gallery for gui.createForm
    */
    this.generateFileGallery = function(fileStr, fieldName){
        var html = '<ul>';
        var fileArray = explode(',', fileStr);
        $.each(fileArray, function(key, value){
            if(value){
                html += '<li class="file_'+value+'">'+files.idToTitle(value)+'<a href="#" class="btn btn-default" onclick="gui.removeFileFromGallery('+value+', \''+fieldName+'\');"><span class="glyphicon glyphicon-remove-circle"></span></a></li>';
            }});
        html += '</ul>';
        return html;
    };
    this.removeFileFromGallery = function(file_id, fieldName){
        Check = confirm("Are you sure to delete this file?");
	if (Check === true){
            var field = String(fieldName);
            var newValue = $('#'+field).val();
            newValue.replace(String(file_id+','),'');
            $('#'+field).val(newValue);
            $('.file_'+file_id).remove();
	};
        
    }
};

var adminPanel = new function(){
    
    
    this.logout = function(){
        $.ajax({
            type: 'POST',
            url: "api.php?action=logout",
            success:function(data){
                window.location = 'index.php';
            },
            async:false
        });
        localStorage.clear();
        
        
    }
    this.generateUserNavField = function(){
        //get userdata for currently shown user
        var userData = users.getUserData(users.getUser());
        
        var shownName, output;
        
        if(String(userData.firstname).length > 0)
            shownName = userData.firstname;
        else
            shownName = userData.username;
        
        output = 'Hello '+shownName+'!<br><a href="#logout" onclick="adminPanel.showUpdateUserForm('+users.getUser()+');">change info</a><br><a href="#logout" onclick="adminPanel.logout();">logout</a>'
        return output;
            
    };
    this.showCreateUserForm = function(){
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Create user';
        options['action'] = function(){
            users.create($('#username').val(), $('#usergroup').val(), $('#password').val(), $('#firstname').val(), $('#lastname').val());
            alert('Submitted');
            adminPanel.showUserOverview();
        };
        options['buttonTitle'] = 'Save';
        
        
        var field0 = [];
        field0['caption'] = 'Username';
        field0['inputName'] = 'username';
        field0['type'] = 'text';
        fieldArray[0] = field0;
        
        var usergroupData = usergroups.getUsergroups();
        var captions = [];
        var group_ids = [];
        var i = 0;
        $.each(usergroupData, function(index, usergroup){
            captions[i] = usergroup.title;
            group_ids[i] = usergroup.id;
            i++;
        });
        
        var field1 = [];
        field1['caption'] = 'Usergroup';
        field1['inputName'] = 'usergroup';
        field1['values'] = group_ids;
        field1['captions'] = captions;
        field1['type'] = 'dropdown';
        fieldArray[1] = field1;
        
        var field2 = [];
        field2['caption'] = 'Firstname';
        field2['inputName'] = 'firstname';
        field2['type'] = 'text';
        fieldArray[2] = field2;
        
        var field3 = [];
        field3['caption'] = 'Lastname';
        field3['inputName'] = 'lastname';
        field3['type'] = 'text';
        fieldArray[3] = field3;
               
        var field4 = [];
        field4['caption'] = 'Password';
        field4['inputName'] = 'password';
        field4['type'] = 'password';
        fieldArray[4] = field4;
        
        var field5 = [];
        field5['caption'] = 'Repeat password';
        field5['inputName'] = 'repeat_password';
        field5['type'] = 'password';
        fieldArray[5] = field5;
        
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showUpdateUserForm = function(user_id){
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Update user';
        options['action'] = function(){
            users.update(user_id, $('#username').val(), $('#usergroup').val(), $('#firstname').val(), $('#lastname').val());
            alert('Updated');
            adminPanel.showUserOverview();
        };
        options['buttonTitle'] = 'Save';
        
        var userData = users.getUserData(user_id);
        
        console.log(userData);
        
        
        var field0 = [];
        field0['caption'] = 'Username';
        field0['inputName'] = 'username';
        field0['type'] = 'text';
        field0['value'] = userData['username'];
        fieldArray[0] = field0;
        
        var usergroupData = usergroups.getUsergroups();
        var captions = [];
        var group_ids = [];
        var i = 0;
        $.each(usergroupData, function(index, usergroup){
            captions[i] = usergroup.title;
            group_ids[i] = usergroup.id;
            i++;
        });
        
        var field1 = [];
        field1['caption'] = 'Usergroup';
        field1['inputName'] = 'usergroup';
        field1['values'] = group_ids;
        field1['captions'] = captions;
        field1['preselected'] = userData['usergroup'];
        field1['type'] = 'dropdown';
        fieldArray[1] = field1;
        
        var field2 = [];
        field2['caption'] = 'Firstname';
        field2['inputName'] = 'firstname';
        field2['type'] = 'text';
        field2['value'] = userData['firstname'];
        fieldArray[2] = field2;
        
        var field3 = [];
        field3['caption'] = 'Lastname';
        field3['inputName'] = 'lastname';
        field3['type'] = 'text';
        field3['value'] = userData['lastname'];
        fieldArray[3] = field3;
               
        var field4 = [];
        field4['caption'] = '';
        field4['inputName'] = 'changePassword';
        field4['value'] = 'Change Password';
        field4['type'] = 'button';
        field4['actionFunction'] = 'adminPanel.showUpdateUserPasswordForm(\''+user_id+'\')';
        fieldArray[4] = field4;
        
        
        
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showUpdateUserPasswordForm = function(user_id){
        
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Update user password';
        options['action'] = function(){
            if($('#password').val() === $('#repeat_password').val()){
                
                users.updatePassword(user_id, $('#password').val());
                alert('Updated');
                adminPanel.showUserOverview();
                
            }else{
                alert('The passwords dont match');
            }
        };
        options['buttonTitle'] = 'Save';
        
        var field0 = [];
        field0['caption'] = 'Password';
        field0['inputName'] = 'password';
        field0['type'] = 'password';
        fieldArray[0] = field0;
        
        var field1 = [];
        field1['caption'] = 'Repeat password';
        field1['inputName'] = 'repeat_password';
        field1['type'] = 'password';
        fieldArray[1] = field1;
        
        gui.createForm('#adminPanel',fieldArray, options);
    };
    this.verifyUserRemoval = function(user_id){
        var link = 'api.php?action=deleteUser&user_id='+user_id;
        gui.verifyRemoval('user', link);
        this.showUserOverview();
    };
    this.showUserOverview = function(){
        
        var actions = [];
        
        actions['add'] = [];
        actions['add']['onclick'] = 'adminPanel.showCreateUserForm()';
        actions['add']['caption'] = 'Add User';
        
        
        actions['update'] = [];
        actions['update']['onclick'] = 'adminPanel.showUpdateUserForm';
        actions['update']['caption'] = 'Update User';
        
        actions['delete'] = [];
        actions['delete']['onclick'] = 'adminPanel.verifyUserRemoval';
        actions['delete']['caption'] = 'Delete User';
        
        
        var userData = users.getUsers();
        var captions = [];
        var userids = [];
        var i = 0;
        $.each(userData, function(index, singleUser){
            captions[i] = singleUser.username;
            userids[i] = singleUser.userid;
            i++;
        });
        console.log(userids);
        gui.createOverview('#adminPanel', userids,  captions, actions, 'Users');
        
    };
    
    //usergroups
    this.showCreateUsergroupForm = function(){
        var rightList = usergroups.getRightList();
        
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Create usergroup';
        options['action'] = function(){
            var rightsArray = {};
            $.each(rightList, function(index, value){
                value = String(value);
                if($('#right_'+value).is(':checked'))
                    rightsArray[value] = '1';
                else
                    rightsArray[value] = '0';
            });
            console.log(rightsArray);
            usergroups.create($('#groupTitle').val(), rightsArray);
            alert('Usergroup created');
            adminPanel.showUsergroupOverview();
        };
        options['buttonTitle'] = 'Save';
        
        var field0 = [];
        field0['caption'] = 'Title';
        field0['inputName'] = 'groupTitle';
        field0['type'] = 'text';
        field0['value'] = '';
        fieldArray[0] = field0;
        
        $.each(rightList, function(index,value){
           var arrayCounter = index+1;
            fieldArray[arrayCounter] = [];
            fieldArray[arrayCounter]['caption'] = value;
            fieldArray[arrayCounter]['inputName'] = 'right_'+value;
            fieldArray[arrayCounter]['type'] = 'checkbox';
            fieldArray[arrayCounter]['value'] = '1';
            fieldArray[arrayCounter]['checked'] = false;
        });
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showUpdateUserGroupForm = function(group_id){
        var groupTitle = usergroups.getTitle(group_id);
        var rightList = usergroups.getRightList();
        var groupRights = usergroups.getRights(group_id);
        
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Update usergroup';
        options['action'] = function(){
            
            var rightsArray = {};
            $.each(rightList, function(index, value){
                value = String(value);
                if($('#right_'+value).is(':checked'))
                    rightsArray[value] = '1';
                else
                    rightsArray[value] = '0';
            });
            console.log(rightsArray);
            usergroups.update(group_id,$('#groupTitle').val(), rightsArray);
            //users.update(user_id, $('#username').val(), $('#usergroup').val(), $('#firstname').val(), $('#lastname').val());
            alert('Updated');
            adminPanel.showUsergroupOverview();
        };
        options['buttonTitle'] = 'Save';
        
        var field0 = [];
        field0['caption'] = 'Title';
        field0['inputName'] = 'groupTitle';
        field0['type'] = 'text';
        field0['value'] = groupTitle;
        fieldArray[0] = field0;
        
        $.each(rightList, function(index,value){
           var arrayCounter = index+1;
            fieldArray[arrayCounter] = [];
            fieldArray[arrayCounter]['caption'] = value;
            fieldArray[arrayCounter]['inputName'] = 'right_'+value;
            fieldArray[arrayCounter]['type'] = 'checkbox';
            fieldArray[arrayCounter]['value'] = '1';
            if(groupRights[value] == '1'){
            fieldArray[arrayCounter]['checked'] = true;
            }
        });
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    }
    this.showUsergroupOverview = function(){
        
        var actions = [];
        
        actions['add'] = [];
        actions['add']['onclick'] = 'adminPanel.showCreateUsergroupForm()';
        actions['add']['caption'] = 'Add Usergroup';
        
        
        actions['update'] = [];
        actions['update']['onclick'] = 'adminPanel.showUpdateUserGroupForm';
        actions['update']['caption'] = 'Update User';
        
        actions['delete'] = [];
        actions['delete']['onclick'] = 'adminPanel.verifyUsergroupRemoval';
        actions['delete']['caption'] = 'Delete User';
        
        
        var usergroupData = usergroups.getUsergroups();
        var captions = [];
        var userids = [];
        var i = 0;
        $.each(usergroupData, function(index, usergroup){
            captions[i] = usergroup.title;
            userids[i] = usergroup.id;
            i++;
        });
        gui.createOverview('#adminPanel', userids,  captions, actions, 'Usergroups');
        
    };
    
    this.verifyUsergroupRemoval = function(group_id){
        var link = 'api.php?action=deleteUsergroup&group_id='+group_id;
        gui.verifyRemoval('usergroup', link);
        this.showUsergroupOverview();
    };
    
    //contents
    this.showCreateContentForm = function(){
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Create content';
        options['action'] = function(){
            
            var description = $('#description').val();
            if ($('#active').prop('checked') === '1'){
                var isactive = '1';
            } else {
                var isactive = '0';
            }
            if(description.length === 0){
                description = $('#content').text();
                description = description.substr(0,100);
            }
            contents.create($('#parent_navigation_id').val(), $('#title').val(), $('#keywords').val(), description, base64_encode($('#content').html()), $('#template').val(), isactive);
            alert('Submitted');
            adminPanel.showContentOverview();
        };
        options['buttonTitle'] = 'Save';
        
        
        var field0 = [];
        field0['caption'] = 'Title';
        field0['inputName'] = 'title';
        field0['type'] = 'text';
        fieldArray[0] = field0;
        
        
        var field1 = [];
        field1['caption'] = 'Keywords';
        field1['inputName'] = 'keywords';
        field1['type'] = 'text';
        field1['advanced'] = true;
        fieldArray[1] = field1;
        
        var field2 = [];
        field2['caption'] = 'Description';
        field2['inputName'] = 'description';
        field2['type'] = 'textarea';
        field2['advanced'] = true;
        fieldArray[2] = field2;
        
        var field3 = [];
        field3['caption'] = 'Content';
        field3['inputName'] = 'content';
        field3['type'] = 'wysiwyg';
        fieldArray[3] = field3;
               
        var field4 = [];
        field4['caption'] = 'Active';
        field4['inputName'] = 'active';
        field4['type'] = 'checkbox';
        field4['value'] = '1';
        field4['checked'] = true;
        field4['advanced'] = true;
        fieldArray[4] = field4;
        
        var navigationArray = navigations.getNavigations();
        var field5 = [];
        field5['caption'] = 'Parent navigation';
        field5['inputName'] = 'parent_navigation_id';
        field5['values'] = navigationArray[0];
        field5['captions'] = navigationArray[1];
        field5['type'] = 'dropdown';
        field5['advanced'] = true;
        fieldArray[5] = field5;
        
        var templateArray = templates.getTemplates();
        var field6 = [];
        field6['caption'] = 'Choose template';
        field6['inputName'] = 'template';
        field6['values'] = templateArray[0];
        field6['captions'] = templateArray[1];
        field6['type'] = 'dropdown';
        field6['advanced'] = true;
        fieldArray[6] = field6;
        
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showUpdateContentForm = function(content_id){
        var fieldArray = [];
        var options = [];

        options['headline'] = '';
        options['action'] = function(){
            var description = $('#description').val();
            
            if ($('#active').prop('checked') == '1'){
                var isactive = '1';
            } else {
                var isactive = '0';
            }
            if(description.length === 0){
                description = $('#content').text();
                description = description.substr(0,100);
            }
            contents.update(content_id, $('#parent_navigation_id').val(), $('#title').val(), $('#keywords').val(), description, $('#content').html(), $('#template').val(), isactive);
            alert('Updated');
            adminPanel.showContentOverview();
            
            $('.cms_widget_area').html('');
        };
        options['buttonTitle'] = 'Save';

        var contentData = contents.select(content_id);
        
        

        var field0 = [];
        field0['caption'] = 'Title';
        field0['value'] = contentData['title'];
        field0['inputName'] = 'title';
        field0['type'] = 'text';
        field0['advanced'] = false;
        fieldArray[0] = field0;
        
        
        var field1 = [];
        field1['caption'] = 'Keywords';
        field1['value'] = contentData['keywords'];
        field1['inputName'] = 'keywords';
        field1['type'] = 'text';
        field1['advanced'] = true;
        fieldArray[1] = field1;
        
        var field2 = [];
        field2['caption'] = 'Description';
        field2['value'] = contentData['description'];
        field2['inputName'] = 'description';
        field2['type'] = 'textarea';
        field2['advanced'] = true;
        fieldArray[2] = field2;
        
        var field3 = [];
        field3['caption'] = 'Content';
        field3['value'] = base64_decode(contentData['content']);
        field3['inputName'] = 'content';
        field3['type'] = 'wysiwyg';
        fieldArray[3] = field3;
        
        var ischecked;    
        if(contentData['8'] === '1'){
            ischecked = true;
        } else {
            ischecked = false;
        }
        
        var field4 = [];
        field4['caption'] = 'Active';
        field4['inputName'] = 'active';
        field4['type'] = 'checkbox';
        field4['value'] = '1';
        field4['checked'] = ischecked;
        field4['advanced'] = true;
        fieldArray[4] = field4;
        
        var navigationArray = navigations.getNavigations();
        var field5 = [];
        field5['caption'] = 'Parent navigation';
        field5['inputName'] = 'parent_navigation_id';
        field5['values'] = navigationArray[0];
        field5['captions'] = navigationArray[1];
        field5['preselected'] = contentData['parent_navigation_id'];
        field5['type'] = 'dropdown';
        field5['advanced'] = true;
        fieldArray[5] = field5;
        
        var templateArray = templates.getTemplates();
        var field6 = [];
        field6['caption'] = 'Choose template';
        field6['inputName'] = 'template';
        field6['values'] = templateArray[0];
        field6['captions'] = templateArray[1];
        field6['preselected'] = contentData['template'];
        field6['type'] = 'dropdown';
        field6['advanced'] = true;
        fieldArray[6] = field6;
        
        var field7 = [];
        field7['caption'] = 'Add to Navigation';
        field7['inputName'] = 'addToNavButton';
        field7['type'] = 'button';
        field7['value'] = 'Add to Navigation';
        field7['advanced'] = true;
        field7['actionFunction'] = 'adminPanel.showAddContentToNavigationForm(\''+content_id+'\')';
        fieldArray[7] = field7;
        
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
        
        
        $.each($('.cms_widget_area'), function(){
            var template_widget_area_id = String($(this).data('textarea-id'));
            var listHTML = '<ul><li>Widgets:</li>';
            var widgetsForArea = widgets.getWidgetsForWidgetArea(content_id,template_widget_area_id);
            $.each(widgetsForArea,function(index, value){
                listHTML += '<li id="widget_'+value['widget_id']+'_'+content_id+'_'+template_widget_area_id+'"><a href="#" onclick="adminPanel.verifyWidgetRemovalFromContent('+value['widget_id']+','+content_id+','+template_widget_area_id+');"><i class="glyphicon glyphicon-remove"></i></a>'+widgets.load(value['widget_id'])+'</li>';
            });
            listHTML += '</ul>';
            
            var buttonHtml = '<a href="#" onclick="adminPanel.showAddWidgetToContentForm('+content_id+', '+template_widget_area_id+')">Add Widget</a>';
            $(this).html(listHTML+buttonHtml);
        });
        
    };
    this.verifyContentRemoval = function(content_id){
        var link = 'api.php?action=deleteContent&content_id='+content_id;
        gui.verifyRemoval('content', link);
        this.showContentOverview();
    };
    this.showContentOverview = function(){
        
        var actions = [];
        
        actions['add'] = [];
        actions['add']['onclick'] = 'adminPanel.showCreateContentForm()';
        actions['add']['caption'] = 'Add Content';
        
        
        actions['update'] = [];
        actions['update']['onclick'] = 'adminPanel.showUpdateContentForm';
        actions['update']['caption'] = 'Update Content';
        
        actions['delete'] = [];
        actions['delete']['onclick'] = 'adminPanel.verifyContentRemoval';
        actions['delete']['caption'] = 'Delete Content';
        
        
        var contentData = contents.getContents();
        gui.createOverview('#adminPanel', contentData[0],  contentData[1], actions, 'Contents');
        
    };
    this.showAddContentToNavigationForm = function(content_id){
        
        var fieldArray = [];
        var options = [];

        var contentData = contents.select(content_id);
        options['headline'] = 'Add Content To Navigation';
        options['action'] = function(){
            navigation_links.create($('#navigation_id').val(), 'content', content_id, contentData['title']);
            alert('Link added');
            adminPanel.showNavigationOverview();
        };
        options['buttonTitle'] = 'Save';

        
        

        var field0 = [];
        field0['caption'] = 'Content';
        field0['value'] = contentData['title'];
        field0['inputName'] = 'title';
        field0['type'] = 'text';
        field0['disabled'] = true;
        fieldArray[0] = field0;
        
        var navigationArray = navigations.getNavigations();
        var field1 = [];
        field1['caption'] = 'Navigation';
        field1['inputName'] = 'navigation_id';
        field1['values'] = navigationArray[0];
        field1['captions'] = navigationArray[1];
        field1['preselected'] = contentData['navigation_id'];
        field1['type'] = 'dropdown';
        field1['advanced'] = false;
        fieldArray[1] = field1;
        
        
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    
    
    //files(raw)
    this.showUploadFileForm = function(){
        var fieldArray = [];
        var options = [];

        options['headline'] = 'Upload File';
        options['action'] = function(){
            files.updateTempByStr($('#file').val());
            alert('File(s) added');
            adminPanel.showContentOverview();
        };
        options['buttonTitle'] = 'Save';

        
        

        var field0 = [];
        field0['caption'] = 'file';
        field0['inputName'] = 'file';
        field0['type'] = 'file';
        fieldArray[0] = field0;
        
        var field1 = [];
        field1['caption'] = 'title';
        field1['inputName'] = 'title';
        field1['type'] = 'text';
        fieldArray[1] = field1;
        
        
        
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showFileOverview = function(){
        
        var actions = [];
        
        actions['add'] = [];
        actions['add']['onclick'] = 'adminPanel.showUploadFileForm()';
        actions['add']['caption'] = 'Upload File';
        
        actions['update'] = [];
        actions['update']['onclick'] = 'adminPanel.showUpdateFileForm';
        actions['update']['caption'] = 'Update Content';
        
        actions['delete'] = [];
        actions['delete']['onclick'] = 'adminPanel.verifyFileRemoval';
        actions['delete']['caption'] = 'Delete Content';
        
        
        var contentData = files.getFiles();
        gui.createOverview('#adminPanel', contentData[0],  contentData[1], actions, 'Files');
        
    };
    this.verifyFileRemoval = function(file_id){
        
        var link = 'api.php?action=deleteFile&file_id='+file_id;
        gui.verifyRemoval('content', link);
        this.showContentOverview();
    }

    //navigations
    this.showCreateNavigationForm = function(){
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Create navigation';
        options['action'] = function(){
            navigations.create($('#title').val(), $('#parent_id').val());
            alert('Submitted');
            adminPanel.showNavigationOverview();
        };
        options['buttonTitle'] = 'Save';
        
        
        var field0 = [];
        field0['caption'] = 'Title';
        field0['inputName'] = 'title';
        field0['type'] = 'text';
        fieldArray[0] = field0;

        
        var navigationArray = navigations.getNavigations();
       
        var field1 = [];
        field1['caption'] = 'Parent navigation';
        field1['inputName'] = 'parent_id';
        field1['values'] = navigationArray[0];
        field1['captions'] = navigationArray[1];
        field1['type'] = 'dropdown';
        fieldArray[1] = field1;
        
//        var field2 = [];
//        field2['caption'] = 'Template navigation id';
//        field2['inputName'] = 'template_navigation_id';
//        field2['type'] = 'text';
//        fieldArray[2] = field2;
               
//        var field3 = [];
//        field3['caption'] = 'File';
//        field3['inputName'] = 'file';
//        field3['type'] = '';
//        fieldArray[3] = field3;
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showUpdateNavigationForm = function(navigation_id){
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Update navigation';
        options['action'] = function(){
            navigations.update(navigation_id, $('#title').val(), $('#parent_id').val());
            alert('Updated');
            adminPanel.showNavigationOverview();
        };
        options['buttonTitle'] = 'Save';

        var navigationData = navigations.select(navigation_id);
        
        console.log(navigationData);        
        
        var field0 = [];
        field0['caption'] = 'Title';
        field0['inputName'] = 'title';
        field0['value'] = navigationData['title'];
        field0['type'] = 'text';
        fieldArray[0] = field0;
        
        
        var navigationArray = navigations.getNavigations();
       
        var field1 = [];
        field1['caption'] = 'Parent navigation';
        field1['inputName'] = 'parent_id';
        field1['values'] = navigationArray[0];
        field1['captions'] = navigationArray[1];
        field1['preselected'] = navigationData['parent_id'];
        field1['type'] = 'dropdown';
        fieldArray[1] = field1;
        

        
//        var field2 = [];
//        field2['caption'] = 'Template navigation id';
//        field2['inputName'] = 'template_navigation_id';
//        field2['type'] = 'text';
//        fieldArray[2] = field2;
               
//        var field3 = [];
//        field3['caption'] = 'File';
//        field3['inputName'] = 'file';
//        field3['type'] = '';
//        fieldArray[3] = field3;
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showNavigationOverview = function(){
        
        var navigationArray = navigations.getNavigations();
        
        
        var actions = [];
        
        actions['add'] = [];
        actions['add']['onclick'] = 'adminPanel.showCreateNavigationForm()';
        actions['add']['caption'] = 'Add Navigation';
        
        
        actions['update'] = [];
        actions['update']['onclick'] = 'adminPanel.showUpdateNavigationForm';
        actions['update']['caption'] = 'Update Navigation';
        
        actions['delete'] = [];
        actions['delete']['onclick'] = 'adminPanel.verifyNavigationRemoval';
        actions['delete']['caption'] = 'Delete Navigation';
        
        
        var navigationArray = navigations.getNavigations();
        gui.createOverview('#adminPanel', navigationArray[0],  navigationArray[1], actions, 'Navigations');
    }
    this.verifyNavigationRemoval = function(navigation_id){
        var link = 'api.php?action=deleteNavigation&navigation_id='+navigation_id;
        gui.verifyRemoval('navigation', link);
        this.showNavigationOverview();
    };
    
    //widgets
    this.showCreateWidgetForm = function(){
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Create Widget';
        options['action'] = function(){
            widgets.create($('#title').val(), $('#type').val(), $('#content').val());
            alert('Submitted');
            adminPanel.showWidgetOverview();
        };
        options['buttonTitle'] = 'Save';
        
        
        var field0 = [];
        field0['caption'] = 'Title';
        field0['inputName'] = 'title';
        field0['type'] = 'text';
        fieldArray[0] = field0;
        
        var typeArray = widgets.generateTypeDropdownArray();
        var field1 = [];
        field1['caption'] = 'Type';
        field1['inputName'] = 'type';
        field1['type'] = 'dropdown';
        field1['values'] = typeArray[0];
        field1['captions'] = typeArray[1];
        fieldArray[1] = field1;
        
        var field2 = [];
        field2['caption'] = 'Content';
        field2['inputName'] = 'content';
        field2['type'] = 'textarea';
        fieldArray[2] = field2;

        
       
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showUpdateWidgetForm = function(widget_id){
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Update widget';
        options['action'] = function(){
            widgets.update(widget_id, $('#title').val(), $('#type').val(), $('#content').val());
            alert('Updated');
            adminPanel.showWidgetOverview();
        };
        options['buttonTitle'] = 'Save';

        var widgetData = widgets.select(widget_id);
        console.log(widgetData);
        
        var field0 = [];
        field0['caption'] = 'ID';
        field0['inputName'] = 'widget_wid';
        field0['value'] = widgetData['id'];
        field0['type'] = 'text';
        field0['disabled'] = true;
        fieldArray[0] = field0;
        
        var field1 = [];
        field1['caption'] = 'Title';
        field1['inputName'] = 'title';
        field1['value'] = widgetData['title'];
        field1['type'] = 'text';
        fieldArray[1] = field1;
        
        var typeArray = widgets.generateTypeDropdownArray();
        var field2 = [];
        field2['caption'] = 'Type';
        field2['inputName'] = 'type';
        field2['type'] = 'dropdown';
        
        field1['preselected'] = widgetData['type'];
        field2['values'] = typeArray[0];
        field2['captions'] = typeArray[1];
        fieldArray[2] = field2;
        
        var field3 = [];
        field3['caption'] = 'Content';
        field3['inputName'] = 'content';
        field3['value'] = widgetData['content'];
        field3['type'] = 'textarea';
        fieldArray[3] = field3;
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showWidgetOverview = function(){
        
        var actions = [];
        
        actions['add'] = [];
        actions['add']['onclick'] = 'adminPanel.showCreateWidgetForm()';
        actions['add']['caption'] = 'Add Widget';
        
        
        actions['update'] = [];
        actions['update']['onclick'] = 'adminPanel.showUpdateWidgetForm';
        actions['update']['caption'] = 'Update Widget';
        
        actions['delete'] = [];
        actions['delete']['onclick'] = 'adminPanel.verifyWidgetRemoval';
        actions['delete']['caption'] = 'Delete Widget';
        
        
        var widgetArray = widgets.getWidgets();
        gui.createOverview('#adminPanel', widgetArray[0],  widgetArray[1], actions, 'Widgets');
    }
    this.verifyWidgetRemoval = function(widget_id){
        var link = 'api.php?action=deleteWidget&widget_id='+widget_id;
        gui.verifyRemoval('widget', link);
        this.showWidgetOverview();
    };
    this.showAddWidgetToContentForm =function(content_id, template_widget_area_id){
        
        $('.cms_widget_area').html('');
        
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Add Widget to Content';
        options['action'] = function(){
            widgets.AddWidgetToContent($('#widget_id').val(), $('#content_id').val(), template_widget_area_id);
            alert('Submitted');
            adminPanel.showWidgetOverview();
        };
        options['buttonTitle'] = 'Save';
        
        
       
        var widgetArray = widgets.getWidgets();
        if(widgetArray[0].length > 0){
            var field0 = [];
            field0['caption'] = 'Widget';
            field0['inputName'] = 'widget_id';
            field0['values'] = widgetArray[0];
            field0['captions'] = widgetArray[1];
            field0['type'] = 'dropdown';
            field0['advanced'] = false;
            fieldArray[0] = field0;

            var contentArray = contents.getContents();
            var field1 = [];
            field1['caption'] = 'Content';
            field1['inputName'] = 'content_id';
            field1['values'] = contentArray[0];
            field1['captions'] = contentArray[1];
            field1['preselected'] = content_id;
            field1['type'] = 'dropdown';
            field1['advanced'] = false;
            fieldArray[1] = field1;





            var content = gui.createForm('#adminPanel',fieldArray, options);
        }else{
            $('#adminPanel').html('<h2>Add Widget to Content</h2>You need to create a Widget before you can add it to a content.<br><br><a href="#" onclick="adminPanel.showCreateWidgetForm();" class="btn btn-success">Create Widget</a>');
        }
    };
    this.verifyWidgetRemovalFromContent = function(widget_id, content_id, template_widget_area_id){
        
        $.post( "api.php?action=removeWidgetFromContent", { widget_id: widget_id, content_id:content_id,template_widget_area_id:template_widget_area_id }, function(data){
            $('#widget_'+widget_id+'_'+content_id+'_'+template_widget_area_id).remove();
        });
    };
    
    //generall cms stuff
    this.showUpdateCmsConfigForm = function(){

        var cmsConfig = cms.getConfig();
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Update settings in cms_config.xml';
        options['action'] = function(){
            cms.updateConfig($('#pageTitle').val(), $('#keywords').val(), cmsConfig['template_id'], cmsConfig['home_page'], $('#webmaster_mail_adress').val(), $('#analytics').val());
            alert('Updated');
            adminPanel.showContentOverview();
        };
        options['buttonTitle'] = 'Save';
        
        console.log(cmsConfig);        
        
        var field0 = [];
        field0['caption'] = 'Page title';
        field0['inputName'] = 'pageTitle';
        field0['value'] = cmsConfig['page_title'];
        field0['type'] = 'text';
        fieldArray[0] = field0;
        
        
        var field1 = [];
        field1['caption'] = 'Keywords';
        field1['inputName'] = 'keywords';
        field1['value'] = cmsConfig['keywords'];
        field1['type'] = 'text';
        fieldArray[1] = field1;
        
        var field2 = [];
        field2['caption'] = 'Page Owner Mail';
        field2['inputName'] = 'webmaster_mail_adress';
        field2['value'] = cmsConfig['webmaster_mail_adress'];
        field2['type'] = 'text';
        fieldArray[2] = field2;
        
        var field3 = [];
        field3['caption'] = 'Analytic Script(s)';
        field3['inputName'] = 'analytics';
        field3['value'] = cmsConfig['analytic_script'];
        field3['type'] = 'text';
        fieldArray[3] = field3;
      
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };
    this.showUpdateHomePageForm = function(){

        var cmsConfig = cms.getConfig();
        var fieldArray = [];
        var options = [];
        options['headline'] = 'Update Home Page';
        options['action'] = function(){
            cms.updateConfig(cmsConfig['home_page'], cmsConfig['keywords'], cmsConfig['template_id'], $('#homePage').val());
            alert('Updated');
            adminPanel.showContentOverview();
        };
        options['buttonTitle'] = 'Save';
        
        console.log(cmsConfig);        
        
        var contentData = contents.getContents();
        var field0 = [];
        field0['caption'] = 'Home Page';
        field0['inputName'] = 'homePage';
        field0['values'] = contentData[0];
        field0['captions'] = contentData[1];
        field0['preselected'] = cmsConfig['home_page'];
        field0['type'] = 'dropdown';
        fieldArray[0] = field0;
        
        
        
      
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };  
    
    //templates
    this.showChangeTemplateForm = function(){

        var fieldArray = [];
        var options = [];
        options['headline'] = 'Change template';
        options['action'] = function(){
            cms.changeTemplate($('#template').val());
            alert('Template changed!');
            adminPanel.showTemplateOverview();
        };
        options['buttonTitle'] = 'Save';
        
        var cmsConfig = cms.getConfig();
        var templateArray = templates.getTemplates();
        
        console.log(cmsConfig['template_id'])
        
        var field0 = [];
        field0['caption'] = 'Choose template';
        field0['inputName'] = 'template';
        field0['values'] = templateArray[0];
        field0['captions'] = templateArray[1];
        field0['preselected'] = cmsConfig['template_id'];
        field0['type'] = 'dropdown';
        fieldArray[0] = field0;
        
      
        var content = gui.createForm('#adminPanel',fieldArray, options);
    };    
    this.showTemplateOverview = function(){
        
        
        var actions = [];
        
        actions['change'] = [];
        actions['change']['onclick'] = 'adminPanel.showChangeTemplateForm();';
        actions['change']['caption'] = 'Change Template';
        
        actions['add'] = [];
        actions['add']['onclick'] = 'adminPanel.showAddTemplateForm();';
        actions['add']['caption'] = 'Add Template';
        
        
        actions['delete'] = [];
        actions['delete']['onclick'] = 'adminPanel.verifyTemplateRemoval';
        actions['delete']['caption'] = 'Delete Template';
        
        var formActions = [];
        formActions[0] = actions['change'];
        formActions[1] = actions['add'];
        formActions['delete'] = actions['delete'];
        
        
        var templateArray = templates.getTemplates();
        gui.createOverview('#adminPanel', templateArray[0],  templateArray[1], formActions, 'Templates');
        
    };
    this.showAddTemplateForm = function(){
        
        var fieldArray = [];
        var options = [];

        options['headline'] = 'Add Template';
        options['action'] = function(){
            templates.addTemplate($('#template_file').val());
            alert('File(s) added');
            adminPanel.showTemplateOverview();
        };
        options['buttonTitle'] = 'Save';

        
        

        var field0 = [];
        field0['caption'] = 'file';
        field0['inputName'] = 'template_file';
        field0['type'] = 'file';
        fieldArray[0] = field0;
        
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
        
    };
    this.verifyTemplateRemoval = function(template_id){
        var cmsConfig = cms.getConfig();
        var current_template = parseInt(cmsConfig['template_id']);
        if(current_template == template_id){
            
            alert('You can not delete the active template');
        }else{
            var link = 'api.php?action=deleteTemplate&template_id='+template_id;
            gui.verifyRemoval('template', link);
            adminPanel.showTemplateOverview();
        }
    };
    
    
    //apps
    this.showAddPluginform = function(){
        var fieldArray = [];
        var options = [];

        options['headline'] = 'Add Plugin';
        options['action'] = function(){
            plugins.addPlugin($('#plugin_file').val());
            alert('File(s) added');
            adminPanel.showContentOverview();
        };
        options['buttonTitle'] = 'Save';

        
        

        var field0 = [];
        field0['caption'] = 'file';
        field0['inputName'] = 'plugin_file';
        field0['type'] = 'file';
        fieldArray[0] = field0;
        
        
        var content = gui.createForm('#adminPanel',fieldArray, options);
    }
    
    
    this.init = function(){
        $('.cms_navigation').each(function(){
           var nav_id;
           nav_id = $(this).data('nav-id');
           window.menuIsLoading = true;
           
           var $navigation = $(this);
           
           $navigation.load('../navigation_'+nav_id+'.html',function(){
               window.menuIsLoading = false;

                
                var $listsInMenu = $navigation.children('ul');
                
                $listsInMenu.children('li').each(function(index) {
                  $(this).attr('id', 'number_' + index);
                });
                
                addAdminLinks();
                //$(this).children(':not(li)').remove();
                $(this).children('ul').sortable({
                    start: function( event, ui ){
                        $(ui.item).addClass("selected").siblings().removeClass('selected');
                        console.log('started at:'+$(ui.item).parent('ul').children('li').index($('.selected')));
                        $('.selected').attr('data-oldindex', $(ui.item).parent('ul').children('li').index($('.selected')));
                    },
                    update: function( event, ui ) {
                        $(ui.item).addClass("selected").siblings().removeClass('selected');
                        var oldindex = parseInt($('.selected').attr('data-oldindex'))+1;
                        var newindex = parseInt($(ui.item).parent('ul').children('li').index($('.selected')))+1;
                        navigations.changeOrder(nav_id, oldindex, newindex);
                        console.log('started at: '+$('.selected').attr('data-oldindex')+'dropped at:'+$(ui.item).parent('ul').children('li').index($('.selected')));
                    }
                });
                
           });
        });
        
        
        
        var grid = '';
        grid += '<div class="row">';
        grid += '<div class="col-md-12">';
        grid += '<h2>Admin Panel</h2>';
        grid += '<p>This is the Admin Panel.</p>';
        grid += '</div>';
        grid += '</div>';
        grid += '<div class="row">';
        grid += '<div id="contentPanel" class="col-md-6"></div>';
        grid += '<div id="navigationPanel" class="col-md-6"></div>';
        grid += '</div>';
        grid += '<div class="row">';
        grid += '<div id="widgetPanel" class="col-md-6"></div>';
        grid += '<div id="filePanel" class="col-md-6"></div>';
        grid += '</div>';
        grid += '<div class="row">';
        grid += '<div id="userPanel" class="col-md-6"></div>';
        grid += '<div id="userGroupPanel" class="col-md-6"></div>';
        grid += '</div>';
                
        
        
        $('#adminPanel').html(grid);
        
        if(currentUser.hasRight('readUsers')){
            //users
            var actions = [];
            actions['add'] = [];
            actions['add']['onclick'] = 'adminPanel.showCreateUserForm()';
            actions['add']['caption'] = 'Add User';


            actions['update'] = [];
            actions['update']['onclick'] = 'adminPanel.showUpdateUserForm';
            actions['update']['caption'] = 'Update User';

            actions['delete'] = [];
            actions['delete']['onclick'] = 'adminPanel.verifyUserRemoval';
            actions['delete']['caption'] = 'Delete User';


            var userData = users.getUsers();
            var captions = [];
            var userids = [];
            var i = 0;
            $.each(userData, function(index, singleUser){
                captions[i] = singleUser.username;
                userids[i] = singleUser.userid;
                i++;
            });
            console.log(userids);
            gui.createPanel('#userPanel', userids,  captions, actions, 'Users');
        }
        
        
        if(currentUser.hasRight('seeContents')){
            //contents
            var actions = [];

            actions['add'] = [];
            actions['add']['onclick'] = 'adminPanel.showCreateContentForm()';
            actions['add']['caption'] = 'Add Content';


            actions['update'] = [];
            actions['update']['onclick'] = 'adminPanel.showUpdateContentForm';
            actions['update']['caption'] = 'Update Content';

            actions['delete'] = [];
            actions['delete']['onclick'] = 'adminPanel.verifyContentRemoval';
            actions['delete']['caption'] = 'Delete Content';


            var contentData = contents.getContents();
            gui.createPanel('#contentPanel', contentData[0],  contentData[1], actions, 'Contents');
        }
        
        
        if(currentUser.hasRight('seeNavigations')){
            //navigations
            var navigationArray = navigations.getNavigations();
            var actions = [];

            actions['add'] = [];
            actions['add']['onclick'] = 'adminPanel.showCreateNavigationForm()';
            actions['add']['caption'] = 'Add Navigation';


            actions['update'] = [];
            actions['update']['onclick'] = 'adminPanel.showUpdateNavigationForm';
            actions['update']['caption'] = 'Update Navigation';

            actions['delete'] = [];
            actions['delete']['onclick'] = 'adminPanel.verifyNavigationRemoval';
            actions['delete']['caption'] = 'Delete Navigation';


            var navigationArray = navigations.getNavigations();
            gui.createPanel('#navigationPanel', navigationArray[0],  navigationArray[1], actions, 'Navigations');
        }
        
        
        
        if(currentUser.hasRight('readUsergroups')){
            var actions = [];

            actions['add'] = [];
            actions['add']['onclick'] = 'adminPanel.showCreateUsergroupForm()';
            actions['add']['caption'] = 'Add Usergroup';


            actions['update'] = [];
            actions['update']['onclick'] = 'adminPanel.showUpdateUserGroupForm';
            actions['update']['caption'] = 'Update User';

            actions['delete'] = [];
            actions['delete']['onclick'] = 'adminPanel.verifyUsergroupRemoval';
            actions['delete']['caption'] = 'Delete User';


            var usergroupData = usergroups.getUsergroups();
            var captions = [];
            var userids = [];
            var i = 0;
            $.each(usergroupData, function(index, usergroup){
                captions[i] = usergroup.title;
                userids[i] = usergroup.id;
                i++;
            });
            gui.createPanel('#userGroupPanel', userids,  captions, actions, 'Usergroups');
        }
        
        
        
        if(currentUser.hasRight('readWidgets')){
        
            //widgets

            var actions = [];

            actions['add'] = [];
            actions['add']['onclick'] = 'adminPanel.showCreateWidgetForm()';
            actions['add']['caption'] = 'Add Widget';


            actions['update'] = [];
            actions['update']['onclick'] = 'adminPanel.showUpdateWidgetForm';
            actions['update']['caption'] = 'Update Widget';

            actions['delete'] = [];
            actions['delete']['onclick'] = 'adminPanel.verifyWidgetRemoval';
            actions['delete']['caption'] = 'Delete Widget';


            var widgetArray = widgets.getWidgets();
            gui.createPanel('#widgetPanel', widgetArray[0],  widgetArray[1], actions, 'Widgets');
        }
        
        
        
        if(currentUser.hasRight('seeFiles')){
            //files

            var actions = [];

            actions['add'] = [];
            actions['add']['onclick'] = 'adminPanel.showUploadFileForm()';
            actions['add']['caption'] = 'Upload File';

            actions['update'] = [];
            actions['update']['onclick'] = 'adminPanel.showUpdateFileForm';
            actions['update']['caption'] = 'Update Content';

            actions['delete'] = [];
            actions['delete']['onclick'] = 'adminPanel.verifyFileRemoval';
            actions['delete']['caption'] = 'Delete Content';


            var contentData = files.getFiles();
            gui.createPanel('#filePanel', contentData[0],  contentData[1], actions, 'Files');
        }
        
        plugins.initPlugins();
        
        
    }
    this.toggleMenu = function(){
        if($('#cmsMenu').hasClass('left')){
               $( "#cmsMenu" ).animate({
                marginLeft: '-248px'
              }, 500, function() {
                  $('#cmsMenu').removeClass('left');
                  
                  $('#cmsMenu .toggleMenu .glyphicon').removeClass('glyphicon-chevron-left');
                  $('#cmsMenu  .toggleMenu .glyphicon').addClass('glyphicon-chevron-right');
              });
        }else{
               $( "#cmsMenu" ).animate({
                marginLeft: 0
              }, 500, function() {
                  $('#cmsMenu').addClass('left');
                  $('#cmsMenu .toggleMenu .glyphicon').removeClass('glyphicon-chevron-right');
                  $('#cmsMenu .toggleMenu .glyphicon').addClass('glyphicon-chevron-left');
              });
        }
    };
    this.initSettingsBar = function(){
            $('.settingsBar .toggle').click(function(){
                toggleSettingsBar.toggleMenu();
            });
    };
    this.toggleSettingsBar = function(){
        
        if($('.settingsBar').hasClass('down')){
               $( ".settingsBar" ).animate({
                marginTop: '-47px'
              }, 500, function() {
                  $('.settingsBar').removeClass('down');
                  
                  $('.settingsBar .toggle').removeClass('glyphicon-chevron-up');
                  $('.settingsBar .toggle').addClass('glyphicon-chevron-down');
              });
        }else{
               $( ".settingsBar" ).animate({
                marginTop: 0
              }, 500, function() {
                  $('.settingsBar').addClass('down');
                  $('.settingsBar .toggle').removeClass('glyphicon-chevron-down');
                  $('.settingsBar .toggle').addClass('glyphicon-chevron-up');
              });
        }
    };
};

var api = new function(){
    this.className;
    
    this.setClassName = function(plugin_file_name){
        this.className = plugin_file_name;
    }
    this.query = function(action, parameters, callback){
        var async;
        if(typeof callback !== 'undefined'){
            async = true;
        }else{
            async = false;
        };
        
        var className = this.className;
        var ajax_parameters = JSON.stringify(parameters);
        $.ajax({
            type: 'POST',
            url: "api.php?action=callPluginApi",
            data: { className: className, plugin_action: action, parameters: ajax_parameters},
            success:function(data){
                if(!async)
                    result = JSON.parse(data);
                else
                    result = callback(data);
            },
            async:async
        });
        return result;
    };
};


function explode(delimiter, string, limit) {
  //  discuss at: http://phpjs.org/functions/explode/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //   example 1: explode(' ', 'Kevin van Zonneveld');
  //   returns 1: {0: 'Kevin', 1: 'van', 2: 'Zonneveld'}

  if (arguments.length < 2 || typeof delimiter === 'undefined' || typeof string === 'undefined') return null;
  if (delimiter === '' || delimiter === false || delimiter === null) return false;
  if (typeof delimiter === 'function' || typeof delimiter === 'object' || typeof string === 'function' || typeof string ===
    'object') {
    return {
      0: ''
    };
  }
  if (delimiter === true) delimiter = '1';

  // Here we go...
  delimiter += '';
  string += '';

  var s = string.split(delimiter);

  if (typeof limit === 'undefined') return s;

  // Support for limit
  if (limit === 0) limit = 1;

  // Positive limit
  if (limit > 0) {
    if (limit >= s.length) return s;
    return s.slice(0, limit - 1)
      .concat([s.slice(limit - 1)
        .join(delimiter)
      ]);
  }

  // Negative limit
  if (-limit >= s.length) return [];

  s.splice(s.length + limit);
  return s;
}

function empty(mixed_var) {
  //  discuss at: http://phpjs.org/functions/empty/
  // original by: Philippe Baumann
  //    input by: Onno Marsman
  //    input by: LH
  //    input by: Stoyan Kyosev (http://www.svest.org/)
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Onno Marsman
  // improved by: Francesco
  // improved by: Marc Jansen
  // improved by: Rafal Kukawski
  //   example 1: empty(null);
  //   returns 1: true
  //   example 2: empty(undefined);
  //   returns 2: true
  //   example 3: empty([]);
  //   returns 3: true
  //   example 4: empty({});
  //   returns 4: true
  //   example 5: empty({'aFunc' : function () { alert('humpty'); } });
  //   returns 5: false

  var undef, key, i, len;
  var emptyValues = [undef, null, false, 0, '', '0'];

  for (i = 0, len = emptyValues.length; i < len; i++) {
    if (mixed_var === emptyValues[i]) {
      return true;
    }
  }

  if (typeof mixed_var === 'object') {
    for (key in mixed_var) {
      // TODO: should we check for own properties only?
      //if (mixed_var.hasOwnProperty(key)) {
      return false;
      //}
    }
    return true;
  }

  return false;
}