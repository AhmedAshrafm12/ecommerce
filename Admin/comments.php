<?php
session_start();
$tit='comments,';
if(isset($_SESSION['user'])){
    include('init.php');
    $do='';

    $do=isset($_GET['do']) ? $_GET['do'] : 'manage';
    
    if($do=='manage'){


            $stmt=$con->prepare("1qw44
        INNER JOIN users ON comments.com_mem= users.UserID" );
        $stmt->execute();
        $rows=$stmt->fetchAll();
     if(!empty($rows)){
        ?>
                    <h1 class=text-center>Manage comments</h1>
                    <div class='container'>
                 
                        <div class='table-responsive'>
                                <table class="main-table text-center table  table-bordered " >
                                        <tr> 
                                          <th>ID</th>
                                          <th>comment</th>
                                          <th>username</th>
                                          <th>itemName</th>
                                          <th>date</th>
                                          <th>control</th>
                                          </tr>

                                         <?php
                                        
                                        foreach($rows as $r){
                                           echo "<tr>";
                                           echo "<td>".$r['C_ID']."</td>";
                                           echo "<td>".$r['comment']."</td>";
                                           echo "<td>".$r['com_mem']."</td>";
                                           echo "<td>".$r['CATname']."</td>";
                                           echo "<td>".$r['Username']."</td>";
                                           echo "<td>
                                           <a href='?do=Edit&comId=".$r['C_ID']."' class='btn btn-success'><i class='far fa-edit'></i> Edit</a>
                                           <a  href='?do=delete&comId=".$r['C_ID']."' class='btn btn-danger del'><i class='fas fa-trash-alt'></i> Delete</a>";

                                           if ($r['status'] == 0) {
											echo "<a 
													href='comments.php?do=Activate&comId=" . $r['C_ID'] . "' 
												style='margin-left:5px;'	class='btn btn-info'>
													<i class='fa fa-check'></i> Activate</a>";
										}
                                          echo  "</td>";
                                           echo "</tr>";
                                        }
                                         
                                         
                                         ?>
                                </table>

                        </div>  
                
                   
    </div>

<?php
    }else{
        echo "<div class='alert alert-info'>no comments to show</div>";
    }}

     elseif($do=='add'){?>
                    <h1 class=text-center>Add new member</h1>
                    <div class='container'>
                    <form action="?do=insert" class="form-horizontal" method='Post'>
                    
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
           $user=$_POST['username'];
           $pass=$_POST['password'];
           $email=$_POST['email'];
           $fname=$_POST['full'];
           $hashpas=sha1($_POST['password']);
        
        
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
                    users(UserName, Password, Email, FullName,RegStatus, Date)
                VALUES(:zuser, :zpass, :zmail, :zname,1,now()) ");
$stmt->execute(array(

'zuser' 	=> $user,
'zpass' 	=> $hashpas,
'zmail' 	=> $email,
'zname' 	=> $fname,

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
                    $comid =isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
                    $stmt = $con->prepare("SELECT *FROM comments WHERE  C_ID=? LIMIT 1");
                    $stmt->execute(array($comid));
                    $row=$stmt->fetch();
                    $count=$stmt->rowcount();

                    if($count>0){?> 
                    <h1 class=text-center>Edit comment</h1>
                    <div>
                    <form action="?do=update" class="form-horizontal" method='Post'>
                    <input type="hidden" value="<?php echo $row['C_ID'];?>" name='id'>
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>comment</label>
                        <div class='col-sm-10 col-md-7'>
                        <textarea name="comment" class="form-control" ><?php echo $row['comment'];?></textarea>
                        </div>
                    </div>
                
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
   $com=$_POST['comment'];
   $coid=$_POST['id'];



        $stmt=$con->prepare("UPDATE comments SET comment=? WHERE C_ID=?");
        $stmt->execute(array($com,$coid)); 
     
        $themas="<div class='alert alert-success'style='margin-top:15px;'>". $stmt->rowCount().' record updated'."</div>";
        redirectHome($themas,'back',4);  
    
 
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

        $coid = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;

        // Select All Data Depend On This ID

        $check = check('C_ID', 'comments', $coid);

        // If There's Such ID Show The Form

        if ($check > 0) {

            $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE C_ID = ?");

            $stmt->execute(array($coid));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

            redirectHome($theMsg,'back',4);

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

        $coID = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;

        // Select All Data Depend On This ID

        $check = check('C_ID', 'comments', $coID);

        // If There's Such ID Show The Form

        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zid");

            $stmt->bindParam(":zid", $coID);

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