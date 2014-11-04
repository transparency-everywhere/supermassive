<?php
include('../admin/inc/functions.php');
$cms = new cms();
$cms->sendMailToWebmaster($_POST['title'], $_POST['text']);
?>
