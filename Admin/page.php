<?php
session_start();
$tit='items';
if(isset($_SESSION['user'])){
    include('init.php');
$do='';

$do=isset($_GET['do']) ? $_GET['do'] : 'manage';

if($do=='manage')
echo "welcome in manage category page<br><a href='?do=add'>Add categoriy</a>";
elseif($do=='add'){
    
}
echo "welcome in add category page";
elseif($do=='insert')
echo "welcome in insert category page";
else
echo " Error no category with name  ".$_GET['do'];
include $tpl.'footer.php';
}
else{
    header('location:index.php');
    exit();
}

?>