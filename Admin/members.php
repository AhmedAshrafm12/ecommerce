<?php
session_start();
$tit='members';
if(isset($_SESSION['user'])){
    include('init.php');
    $do='';

    $do=isset($_GET['do']) ? $_GET['do'] : 'manage';
    
    if($do=='manage'){
        $query='';
          if(isset($_GET['page'])&& $_GET['page']=='pending'){
            $query="AND RegStatus=0";
          }

            $stmt=$con->prepare("SELECT * FROM users WHERE groupId!=1 $query");
            $stmt->execute();
            $rows=$stmt->fetchAll();
        
        ?>
                    <h1 class=text-center>Manage members</h1>
                    <div class='container'>
                        <div class='table-responsive'>
                                <table class="main-table text-center table  table-bordered " >
                                        <tr> 
                                          <th>#ID</th>
                                          <th>avatar</th>
                                          <th>username</th>
                                          <th>Email</th>
                                          <th>FullName</th>
                                          <th>regesterd date</th>
                                          <th>control</th>
                                          </tr>

                                         <?php
                                        foreach($rows as $r){
                                           echo "<tr>";
                                           echo "<td>".$r['UserID']."</td>";
                                           echo "<td> <img  class='avat'src='uploads/avatar/";
                                           if(!empty($r['avatar'])){echo $r['avatar'];}else{echo "av.png";}
                                           echo "'></td>";
                                           echo "<td>".$r['Username']."</td>";
                                           echo "<td>".$r['Email']."</td>";
                                           echo "<td>".$r['FullName']."</td>";
                                           echo "<td>".$r['Date']."</td>";
                                           echo "<td>
                                           <a href='?do=Edit&UserID=".$r['UserID']."' class='btn btn-success'><i class='far fa-edit'></i> Edit</a>
                                           <a  href='?do=delete&UserID=".$r['UserID']."' class='btn btn-danger del'><i class='fas fa-trash-alt'></i> Delete</a>";

                                           if ($r['RegStatus'] == 0) {
											echo "<a 
													href='members.php?do=Activate&userid=" . $r['UserID'] . "' 
													class='btn btn-info activate'>
													<i class='fa fa-check'></i> Activate</a>";
										}
                                          echo  "</td>";
                                           echo "</tr>";
                                        }
                                         
                                         
                                         ?>
                                </table>

                        </div>  
                        <a href='?do=add' class='btn btn-primary'>+Add member</a>  
    </div>

<?php
    }

     elseif($do=='add'){?>
                    <h1 class=text-center>Add new member</h1>
                    <div class='container'>
                    <form action="?do=insert" class="form-horizontal" method='Post' enctype="multipart/form-data">
                    
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>username</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='username' class='form-control' required='required' placeholder='Type username to login'>
                        </div>
                    </div>
                    <!--  -->

                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>password</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="password" name='password' class='form-control password' required='required' placeholder='password must be strong and complex' >
                        <i class="fas fa-eye show-pass fa-2x"></i>    
                    </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Email</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="email" name='email' class='form-control'  required='required' placeholder='Emaill must be valid'>
                        </div>
                    </div>
                        <!--  -->
                        <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>FullName</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="text" name='full' class='form-control'  required='required'  placeholder='FullName appears in your page'>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>user avatar</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="file" name='avatar' class='form-control'    >
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group">
                        <div class='col-sm-10 col-sm-offset-2 col-md-7'>
                        <input type="submit" value='save' class=' btn btn-primary btn-lg'>
                        </div>
                    </div>
                    </form></div>    

            <?php



     }

     /* Insert member */
     elseif($do=='insert'){
       
        if($_SERVER['REQUEST_METHOD']=='POST'){
            echo " <h1 class='text-center'> Update members </h1> <div class='container'>";
            $avatarname=$_FILES['avatar']['name'];
            $avatartype=$_FILES['avatar']['type'];
            $avatartmp=$_FILES['avatar']['tmp_name'];
            $avatarsize=$_FILES['avatar']['size'];

           

   $Ex=@strtolower(end(explode('.',$avatarname)));


  
$r=rand(0,1000);
$avatar=$r.'_'.$avatarname;

move_uploaded_file($avatartmp,"uploads\avatar\\".$avatar);


           $user=$_POST['username'];
           $pass=$_POST['password'];
           $email=$_POST['email'];
           $fname=$_POST['full'];
           $hashpas=sha1($_POST['password']);
        
        
          $errors=[];
               if(empty($user)){
                   $errors[]='username cannot be empty';
               }
               if(empty($avatarname)){
                $errors[]='u must add image';
            }
               if(empty($email)){
                $errors[]='email cannot be empty';
            }
            if(empty($fname)){
                $errors[]='fname cannot be empty';
            }
            if(empty($pass)){
                $errors[]='password cannot be empty';
            }
          
               foreach($errors as $er){
                   echo "<div class='alert alert-danger'style='margin-top:15px;'>".$er."</div>";
               } 
               
            
         
               if(empty($errors)){
                   $check=check("userName","users",$user);
                   if($check>0){
                       echo "username is exist";
                   }else{
                    $stmt = $con->prepare("INSERT INTO 
                    users(UserName, Password, Email, FullName,avatar,RegStatus, Date)
                VALUES(:zuser, :zpass, :zmail, :zname,:zav,1,now())");
$stmt->execute(array(

'zuser' 	=> $user,
'zpass' 	=> $hashpas,
'zmail' 	=> $email,
'zname' 	=> $fname,
'zav'    	=> $avatar,
)); 
             
              $mas="<div class='alert alert-success'style='margin-top:15px;'>". $stmt->rowCount().' record inserted'."</div>";
              redirectHome($mas,'back',4);  
            }
            }
        }else{
            $mas= '<br><div class="alert alert-danger">you cannot browse here</div>';
            redirectHome($mas,4);
        } 
        echo "<div/>";



     }



     /* Edit members */

    elseif($do=='Edit'){
                    $UserID =isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;
                    $stmt = $con->prepare("SELECT *FROM users WHERE  UserID=? LIMIT 1");
                    $stmt->execute(array($UserID));
                    $row=$stmt->fetch();
                    $count=$stmt->rowcount();

                    if($count>0){?> 
                    <h1 class=text-center>Edit member</h1>
                    <div>
                    <form action="?do=update" class="form-horizontal" method='Post'>
                    
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>username</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='username' class='form-control' value="<?php echo $row['Username'];?>" required='required'>
                        </div>
                    </div>
                    <!--  -->

                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>password</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="password" name='newpassword' class='form-control'>
                        <input type="hidden" name='oldpassword' value='<?php echo $row['password'];?>'>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Email</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="email" name='email' class='form-control'  value="<?php echo $row['Email'];?>" required='required'>
                        </div>
                    </div>
                        <!--  -->
                        <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>FullName</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="text" name='full' class='form-control'  value="<?php echo $row['FullName'];?>" required='required'>
                        </div>
                    </div>

                <!--  -->
                    <div class="form-group">
                        <div class='col-sm-10 col-sm-offset-2 col-md-7'>
                        <input type="submit" value='save' class=' btn btn-primary btn-lg'>
                        </div>
                    </div>
                   <input type='hidden' value='<?php echo $UserID;?>' name='UserID'>
                    </form></div>
                    <?php
                    }
                    else{
                        $mas= "<div class='alert alert-danger>no such member</div>";
                        redirectHome($mas);  
                    }
                }

elseif($do=='update'){

    echo " <h1 class='text-center'> Update members </h1> <div class='container'>";
if($_SERVER['REQUEST_METHOD']=='POST'){
   $user=$_POST['username'];
   $email=$_POST['email'];
   $fname=$_POST['full'];
   $uId=$_POST['UserID'];



   $Pass='';
   if(empty($_POST['newpassword'])){
       $Pass=$_POST['oldpassword'];
       }
       else{
        $Pass=sha1($_POST['newpassword']); 
       }


  $errors=[];
       if(empty($user)){
           $errors[]='username cannot be empty';
       }
       if(empty($email)){
        $errors[]='email cannot be empty';
    }
    if(empty($fname)){
        $errors[]='fname cannot be empty';
    }
       foreach($errors as $er){
           echo "<div class='alert alert-danger'style='margin-top:15px;'>".$er."</div>";
       }
 
       if(empty($errors)){
        $stmt2=$con->prepare("SELECT *from users  where userName=? and UserID!=? ");
        $stmt2->execute(array($user,$uId)); 
         $count=$stmt2->rowcount()
if($count==0){
    
         $stmt=$con->prepare("UPDATE users SET userName=?,FullName=?,email=?,password=? WHERE UserID=?");
        $stmt->execute(array($user,$fname,$email,$Pass,$uId)); 
     
        $themas="<div class='alert alert-success'style='margin-top:15px;'>". $stmt->rowCount().' record updated'."</div>";
        redirectHome($themas,'back',4); 
}else{
    $themas= '<div class="alert alert-danger">this user is exist</div>';
    redirectHome($themas,4);

}
  
    }
 
}else{
   $themas= '<div class="alert alert-danger">you cannot browse here</div>';
   redirectHome($themas,4);
}
echo "<div/>";

}

elseif ($do == 'Activate') {

    echo "<h1 class='text-center'>Activate Member</h1>";
    echo "<div class='container'>";

        // Check If Get Request userid Is Numeric & Get The Integer Value Of It

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        // Select All Data Depend On This ID

        $check = check('userid', 'users', $userid);

        // If There's Such ID Show The Form

        if ($check > 0) {

            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

            $stmt->execute(array($userid));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

            redirectHome($theMsg);

        } else {

            $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

            redirectHome($theMsg);

        }

    echo '</div>';

}
elseif ($do == 'delete') {

    echo "<h1 class='text-center'>Delete member</h1>";
    echo "<div class='container'>";

        // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

        $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;

        // Select All Data Depend On This ID

        $check = check('UserID', 'users', $userid);

        // If There's Such ID Show The Form

        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zid");

            $stmt->bindParam(":zid", $userid);

            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

            redirectHome($theMsg, 'back');

        } else {

            $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

            redirectHome($theMsg);

        }

    echo '</div>';

}



    
   include $tpl.'footer.php';
}
else{
    header('location:index.php');
    exit();
};






?>