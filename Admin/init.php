<?php
// route 
$tpl='includes/templets/';
$css='Layout/css/';
$js='Layout/js/';
$lang='includes/langs/';
$fun='includes/funcs/';
include $lang."eng.php";
include $fun.'fun.php';
include $tpl."header.php";
if(!isset($nonavbar)){include $tpl."navbar.php";}
include('config.php');
?>