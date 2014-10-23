//<div class="cms_navigations"></div>
function initNavigations(){
    $('.cms_navigation').each(function(){
       var nav_id;
       nav_id = $(this).data('nav-id');
       
       $(this).load('navigation_'+nav_id+'.html');
    });
}

function initAdminNavigation(){
    $('.cms_navigation li').each(function(){
        
        var type = $(this).data('type');
        
        var id = $(this).data('id');
        
        if(type === 'content'){
            
            $(this).children('a').click(function(e){
                e.preventDefault();
                adminPanel.showUpdateContentForm(id);
            });
            
            $(this).append('<a href="#">-</a>');
            
        }else if(type === 'navigations'){
            
            $(this).children('a').click(function(e){
                e.preventDefault();
                alert(id);
            });
            
            $(this).append('<a href="#">-</a>');
        }
        
    });
    $('.cms_navigation ul').each(function(){
        $(this).append('<a href="#" onclick="adminPanel.showCreateContentForm();" title="Add Content"><i class="glyphicon glyphicon glyphicon-file"></i></a>');
        $(this).append('<a href="#" onclick="adminPanel.showCreateNavigationForm();" title="Add Navigation"><i class="glyphicon glyphicon-plus"></i></a>');
    });
}