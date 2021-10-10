<?php 
session_start();
$nonavbar=' ';
$tit='Admin';
if(isset($_SESSION['user'])){
    header('location:dashboard.php');
    exit();   
}
include ("init.php")?>
<?php include $tpl.'header.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $hashedpass=sha1($pass);
    
$stmt = $con->prepare("SELECT userName,
                        password,userId
                        FROM 
                        users 
                        WHERE
                        userName = ? AND password = ? And groupId=1 LIMIT 1");
$stmt->execute(array($user,$hashedpass));
$row=$stmt->fetch();
$count=$stmt->rowcount();
if($count>0){
    $_SESSION['user']=$user;
    $_SESSION['uid']=$row['userId'];
    header('location:dashboard.php');
     exit();
}


}


?>



<form action="<?php echo $_SERVER['PHP_SELF']?>" class="login" method='post'>
    <h4 class='text-center'>Admin login</h4>
<input class="form-control input-lg" type="text" name="user" placeholder="username" autocomplete="off">
<input class="form-control input-lg" type="password" name="pass" placeholder="password" autocomplete="new-password">
<button class="btn btn-primary btn-block btn-lg" type="submit">Submit</button>
</form>

<?php include $tpl.'footer.php';?>