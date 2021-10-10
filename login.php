
<?php
session_start();
$tit='Login|signUp';
if(isset($_SESSION['username'])){
    header('location:index.php');
    exit();   
}
include('init.php')?>


<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['login'])){
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $hashedpass=sha1($pass);
    
$stmt = $con->prepare("SELECT userName,
                        password,userId
                        FROM 
                        users 
                        WHERE
                        userName = ? AND password = ? ");
$stmt->execute(array($user,$hashedpass));
$get=$stmt->fetch();
$count=$stmt->rowcount();
if($count>0){
    $_SESSION['username']=$user;
    $_SESSION['uid']=$get['userId'];
    echo $user.$pass;
   header('location:index.php');
     exit(); 
}}
else{
    $user=$_POST['user'];
    $pass=$_POST['passowrd'];
    $pass2=$_POST['passowrd2'];
    $email=$_POST['Email'];
    $hashpas=sha1($_POST['passowrd']);


    $errors=array();
if(isset($_POST['user'])){
    $Fuser=filter_var($_POST['user'],FILTER_SANITIZE_STRING);
   if(strlen($Fuser)<4) {$errors[]='username must be laeger than 4 chars';};
}
if(isset($_POST['passowrd']) && isset($_POST['passowrd2'])){
if($_POST['passowrd']!==$_POST['passowrd2']){$errors[]='passowrd must match';}

}
if(isset($_POST['Email'])){
    $Fmail=filter_var($_POST['Email'],FILTER_SANITIZE_EMAIL);
    if(filter_var($_POST['Email'],FILTER_VALIDATE_EMAIL) !=true){
        $errors[]='Eamil not valid';
    }
}

            

               if(empty($errors)){
                   $check=check("userName","users",$user);
                   if($check>0){
                       echo "username is exist";
                   }else{
                    $stmt = $con->prepare("INSERT INTO 
                    users(UserName, Password, Email,RegStatus, Date)
                VALUES(:zuser, :zpass, :zmail,0,now()) ");
                    $stmt->execute(array(
                    'zuser' => $user,
                    'zpass' => $hashpas,
                    'zmail' => $email,

                    )); 
            $succs="<p> welcome u r regestierd now now</p>";

            }
            }
        




}

}
?>


<div class='container cont'>
<h1 class='text-center'> <span class='select' data-class='login'>login</span> | <span data-class='signup'>sinup</span>  </h1>


<form action="<?php echo $_SERVER['PHP_SELF']?>" class="log  login" method='post'>
<input class="form-control input-lg" type="text" name="user" placeholder="username" autocomplete="off">
<input class="form-control input-lg" type="password" name="pass" placeholder="password" autocomplete="new-password">
<button class="btn btn-primary btn-block btn-lg" name='login' type="submit">log in</button>
</form>


<form action="<?php echo $_SERVER['PHP_SELF']?>" class="log signup" method='post'>

<div class='form-group'><input class="form-control input-lg" type="text" name="user" placeholder="username" autocomplete='off' required='required'  autocomplete="off"></div>
<div class='form-group'><input class="form-control input-lg" type="password" name="passowrd" placeholder="password" required='required' autocomplete="new-password"></div>
<div class='form-group'><input class="form-control input-lg" type="password" name="passowrd2" placeholder="confirm ur password" required='required' autocomplete="new-password"></div>
<div class='form-group'><input class="form-control input-lg" type="text" name="Email" placeholder="Email" required='required' autocomplete="new-password"></div>
<button class=" btn-success btn-block btn-lg" type="submit">Sin up</button>
</form>
<div class='errors'> 
 <?php
 if(isset($errors)){
 foreach($errors as $er){
     echo "<p>".$er."</p>";
 }}
 if(isset($succs)){
     echo $succs;
 }
 ?>
</div>
</div>
<?php include($tpl.'footer.php')?>
