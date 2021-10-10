<?php

// error reporting

ini_set('display_errors','On');
error_reporting(E_ALL);
$sesuser='';
if(isset($_SESSION['username'])){
    $sesuser= $_SESSION['username'];  
}

// route 
$tpl='includes/templets/';
include('Admin/config.php');
$css='Layout/css/';
$js='Layout/js/';
$lang='includes/langs/';
$fun='includes/funcs/';
include $lang."eng.php";
include $fun.'fun.php';
include $tpl."header.php";

?>