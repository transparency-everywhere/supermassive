<?php
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
