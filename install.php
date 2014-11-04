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


    include('./admin/inc/functions.php');
    if(isset($_POST['submit'])){
        if(isset($_POST['set_debugmode']))
            $set_debugmode = $_POST['set_debugmode'];
        else 
            $set_debugmode = false;
        
        if(!isset($_POST['set_debugmode']))
            $_POST['set_debugmode'] = FALSE;
        
        //database settings
        $cms = new cms();
        $cms->installCms($_POST['set_host'], $_POST['set_database'], $_POST['set_db_user'], $_POST['set_db_pass'], $_POST['set_db_port'], $_POST['set_debugmode'], $_POST['set_admin_mail'], $_POST['set_admin_username'], $_POST['set_admin_password'], $_POST['page_title']);
            ?>




            <html>
                <head>
                    <link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.min.css"/>
                    <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
                    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
                    <style>
                        body{margin:40px; font-weight:200!important;}
                        td{ font-weight:200!important;}
                        
                        .logo{
                            position: absolute;
                            margin-top: -52px;
                            width: 175px;
                            margin-left: -31px;
                        }
                        
                        .stepwizard-step p {
                            margin-top: 10px;    
                        }

                        .stepwizard-row {
                            display: table-row;
                        }

                        .stepwizard {
                            display: table;     
                            width: 100%;
                            position: relative;
                        }

                        .stepwizard-step button[disabled] {
                            opacity: 1 !important;
                            filter: alpha(opacity=100) !important;
                        }

                        .stepwizard-row:before {
                            top: 14px;
                            bottom: 0;
                            position: absolute;
                            content: " ";
                            width: 100%;
                            height: 1px;
                            background-color: #ccc;
                            z-order: 0;

                        }

                        .stepwizard-step {    
                            display: table-cell;
                            text-align: center;
                            position: relative;
                        }

                        .btn-circle {
                          width: 30px;
                          height: 30px;
                          text-align: center;
                          padding: 6px 0;
                          font-size: 12px;
                          line-height: 1.428571429;
                          border-radius: 15px;
                        }

                        tr{
                            height:45px;
                        }

                        .step{
                            display:none;
                        }

                        .stepOne{
                            display:table-row;
                        }
                    </style>
                    <script>
                        function changeStep(step){
                            $('.step').hide();
                            $('.step'+step).show();

                            $('.stepwizard .btn').removeClass('btn-primary');
                            $('.stepwizard .btn').addClass('btn-default');
                            $('.btn'+step).removeClass('btn-default');
                            $('.btn'+step).addClass('btn-primary');
                        }
                    </script>
                </head>
                <body>
                    <iframe name="submitter" style="display:none"></iframe>
                    <div class="container">
                        <div style="border: 1px solid rgba(180,180,180,0.8); padding:25px; margin: 100px auto; max-width: 600px;color: #979797;">
                            <img src="admin/img/logo.png" class="logo"/>
                            <div class="stepwizard">
                                <div class="stepwizard-row">
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-primary btn-circle btnOne">1</button>
                                        <p>Server Config</p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-default btn-circle btnTwo">2</button>
                                        <p>Website Information</p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-default btn-circle btnThree">3</button>
                                        <p>Admin Details</p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <button type="button" class="btn btn-default btn-circle btnThree" disabled="disabled">4</button>
                                        <p>Ready</p>
                                    </div>
                                </div>
                            </div>
                            <form action="" method="post" target="submitter">
                                <div>
                                    <h2>You successfully installed your CMS.</h2>
                                    <p>Please remember that you still need to delete your install.php</p>
                                    <p>Have fun with your new website.</p>
                                </div>
                                <div class="step stepThree" style="display: block;padding: 10px;padding-top: 0;">
                                    <a href="./" class="btn btn-success pull-right">Visit your site</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </body>
            </html>



            <?php
        

        
    }else{
        //check before installation
        if(!is_writable('admin/../')){
            echo 'cms dir is not writable';
        }
        else if(!is_writable('admin/')){
            echo 'dir /admin is not writable';
        }
        else if(!is_writable('config/')){
            echo 'dir /config is not writable';
        }
        else if(!is_writable('assets/')){
            echo 'dir /assets is not writable';
        }
        else if(!is_readable('template/')){
            echo 'dir /templates is not readable';
        }
        else if(!is_readable('plugins/')){
            echo 'dir /plugin is not readable';
        }
?>
<html>
    <head>
        <link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.min.css"/>
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
        <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
        <style>
           
                        body{margin:40px; font-weight:200!important;}
                        td{ font-weight:200!important;}
            
            .logo{
                position: absolute;
                margin-top: -52px;
                width: 175px;
                margin-left: -31px;
            }

            .stepwizard-step p {
                margin-top: 10px;    
            }

            .stepwizard-row {
                display: table-row;
            }

            .stepwizard {
                display: table;     
                width: 100%;
                position: relative;
            }

            .stepwizard-step button[disabled] {
                opacity: 1 !important;
                filter: alpha(opacity=100) !important;
            }

            .stepwizard-row:before {
                top: 14px;
                bottom: 0;
                position: absolute;
                content: " ";
                width: 100%;
                height: 1px;
                background-color: #ccc;
                z-order: 0;

            }

            .stepwizard-step {    
                display: table-cell;
                text-align: center;
                position: relative;
            }

            .btn-circle {
              width: 30px;
              height: 30px;
              text-align: center;
              padding: 6px 0;
              font-size: 12px;
              line-height: 1.428571429;
              border-radius: 15px;
            }
            
            tr{
                height:45px;
            }
            
            .step{
                display:none;
            }
            
            .stepOne{
                display:table-row;
            }
        </style>
        <script>
            function changeStep(step){
                $('.step').hide();
                $('.step'+step).show();
                
                $('.stepwizard .btn').removeClass('btn-primary');
                $('.stepwizard .btn').addClass('btn-default');
                $('.btn'+step).removeClass('btn-default');
                $('.btn'+step).addClass('btn-primary');
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div style="border: 1px solid rgba(180,180,180,0.8); padding:25px; margin: 100px auto; max-width: 600px;color: #979797;">
                <img src="admin/img/logo.png" class="logo"/>
                <div class="stepwizard">
                    <div class="stepwizard-row">
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-primary btn-circle btnOne">1</button>
                            <p>Server Config</p>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-default btn-circle btnTwo">2</button>
                            <p>Website Information</p>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-default btn-circle btnThree" disabled="disabled">3</button>
                            <p>Admin Details</p>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-default btn-circle btnFour">4</button>
                            <p>Ready</p>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    <table class="table table-striped" style="color: #979797;">
                        <tr class="step stepTwo">
                            <td>Website Title:</td>
                            <td><input type="text" name="page_title"/></td>
                        </tr>
                        <tr class="step stepOne">
                            <td>Host:</td>
                            <td><input type="text" name="set_host"/></td>
                        </tr>
                        <tr class="step stepOne">
                            <td>Database name:</td>
                            <td><input type="text" name="set_database" /></td>
                        </tr>
                        <tr class="step stepOne">
                            <td>Database user:</td>
                            <td><input type="text" name="set_db_user" /></td>
                        </tr>
                        <tr class="step stepOne">
                            <td>Database password:</td>
                            <td><input type="password" name="set_db_pass" /></td>
                        </tr>
                        <tr class="step stepOne">
                            <td>Database port:</td>
                            <td><input type="text" name="set_db_port" /></td>
                        </tr>
                        <tr class="step stepOne">
                            <td>Activate debugmode?</td>
                            <td><input type="checkbox" value="1" name="set_debugmode" /></td>
                        </tr>
                        <tr class="step stepThree">
                            <td>Admin Mail</td>
                            <td><input type="text" name="set_admin_mail" /></td>
                        </tr>
                        <tr class="step stepThree">
                            <td>Admin Username</td>
                            <td><input type="text" name="set_admin_username" /></td>
                        </tr>
                        <tr class="step stepThree">
                            <td>Admin Password</td>
                            <td><input type="password" name="set_admin_password" /></td>
                        </tr>
                    </table>
                    <div class="step stepOne" style="display: block;padding: 10px;padding-top: 0;">
                        <a href="#" onclick="changeStep('Two');" class="btn btn-success pull-right">Next Step</a>
                    </div>
                    <div class="step stepTwo" style="display:block;padding: 10px;padding-top: 0;display:none;">
                        <a href="#" onclick="changeStep('One');" class="btn btn-primary pull-left">Last Step</a>
                        <a href="#" onclick="changeStep('Three');" class="btn btn-success pull-right">Next Step</a>
                    </div>
                    <div class="step stepThree" style="display: block;padding: 10px;padding-top: 0;display:none">
                        <a href="#" onclick="changeStep('Two');" class="btn btn-primary pull-left">Last Step</a>
                        <input type="submit" value="Install" name="submit" class="btn btn-success pull-right" />
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php    
    }
?>