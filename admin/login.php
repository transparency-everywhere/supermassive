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
include("inc/functions.php");
        $class_user = new users();
        if($class_user->authorize($_POST['username'], $_POST['password'])){
        ?>
        <script>
            top.window.location.href='panel.html';
        </script>
        <?php
        }else{
        ?>
        <script>alert('Wrong username or password');</script>
        <?php
            
        }
?>
