<?php
session_start();
$tit='items';
if(isset($_SESSION['user'])){
    include('init.php');
$do='';

$do=isset($_GET['do']) ? $_GET['do'] : 'manage';

if($do=='manage')
{
  $stmt=$con->prepare("SELECT items.* ,cats.name AS CATname ,users.Username FROM `items` 
  INNER JOIN cats ON items.Cat_id= cats.ID
  INNER JOIN users ON items.Member_id= users.UserID
  ");
  $stmt->execute();
  $rows=$stmt->fetchAll();
  
  ?>
              <h1 class=text-center>Manage Items</h1>
              <div class='container'>
                  <div class='table-responsive'>
                          <table class="main-table text-center table  table-bordered " >
                        <tr> 
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Discription</th>
                        <th>Price</th>
                        <th>member</th>
                        <th>category</th>
                        <th> ADD_Date</th>
                        <th>control</th>
                        </tr>


                                <?php
                                foreach($rows as $r){
                                    echo "<tr>";
                                    echo "<td>".$r['ID']."</td>";
                                    echo "<td>".$r['Name']."</td>";
                                    echo "<td>".$r['Disc']."</td>";
                                    echo "<td>".$r['Price']."</td>";
                                    echo "<td>".$r['Username']."</td>";
                                    echo "<td>".$r['CATname']."</td>";
                                    echo "<td>".$r['Add_Date']."</td>";
                                    echo "<td>
                                    <a href='?do=Edit&itemId=".$r['ID']."' class='btn btn-success'><i class='far fa-edit'></i> Edit</a>
                                    <a  href='?do=delete&itemId=".$r['ID']."' class='btn btn-danger del'><i class='fas fa-trash-alt'></i> Delete</a>";
                                    if ($r['Aprove'] == 0) {
                                        echo "<a 
                                             style='margin-left:5px'   href='items.php?do=Activate&itemId=" . $r['ID'] . "' 
                                                class='btn btn-info activate'>
                                                <i class='fa fa-check'></i> Activate</a>";
                                    }
                                    echo  "</td>";
                                    echo "</tr>";
                                }
                                
                                
                                ?>
                                </table>

                                </div>  
                                <a href='?do=add' class='btn btn-primary'>+Add Item</a>  


                                
                                </div>

                                <?php
                                
                                }




elseif($do=='add'){
    ?>
                    <h1 class=text-center>Add new categori</h1>
                    <div class='container'>
                    <form action="?do=insert" class="form-horizontal" method='POST'>
                    
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>name</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='name' class='form-control' required='required' placeholder='name of the item'>
                        </div>
                    </div>
                    <!--  -->

                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Discription</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="type" name='discription' class='form-control'  placeholder='type items Discription' >   
                    </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Price</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='price' class='form-control'  required='required' placeholder='price of the item'>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Country made</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='country' class='form-control' required='required'   placeholder='Country of made'>
                        </div>
                    </div>
                    <!--  -->
                        <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>TAGS</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='tags' class='form-control'>
                        </div>
                    </div>
                    <!--  -->
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Status</label>
                        <div class='col-sm-10 col-md-7'>
                       <select name="status" class='form-control' >
                       <option value="....">....</option>
                        <option value="1">new</option>
                        <option value="2">like old</option>
                        <option value="3">Used</option>
                        <option value="4">very old</option>
                       </select>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Member</label>
                        <div class='col-sm-10 col-md-7'>
                       <select name="member" class='form-control' >
                       <option value="....">....</option>
                       <?php
                        $allMembers = getAllFrom("*", "users", "", "", "UserID");
                        foreach ($allMembers as $user) {
                            echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                        }
								?>
                       </select>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Catiegory</label>
                        <div class='col-sm-10 col-md-7'>
                       <select name="cat" class='form-control' >
                       <option value="....">....</option>
                       <?php
                        $allMembers = getAllFrom("*", "cats", "where parent=0", "", "ID");
                        foreach ($allMembers as $user) {
                            echo "<option value='" . $user['ID'] . "'>" . $user['name'] . "</option>";
                            $childs = getAllFrom("*", "cats", "where parent={$user['ID']}", "", "ID");
                            foreach($childs as $ch){
                                echo "<option value='" . $ch['ID'] . "'> >> " . $ch['name'] . "</option>";      
                            }
                        }
                       

								?>
                       </select>
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


/* end of ADD */
elseif($do=='insert'){ if($_SERVER['REQUEST_METHOD']=='POST'){
    echo " <h1 class='text-center'> Update members </h1> <div class='container'>";
   $name=$_POST['name'];
   $disc=$_POST['discription'];
   $price=$_POST['price'];
   $country=$_POST['country'];
   $stat=$_POST['status']; 
   $member=$_POST['member'];
   $cat=$_POST['cat'];
   $tags=$_POST['tags'];  


  $errors=[];
       if(empty($name)){
           $errors[]='name cannot be empty';
       }
    if(empty($price)){
        $errors[]='price cannot be empty';
    }
    if(empty($country)){
        $errors[]='country field cannot be empty';
    }
    if($stat==0){
        $errors[]='status field cannot be empty';
    }
       foreach($errors as $er){
           echo "<div class='alert alert-danger'style='margin-top:15px;'>".$er."</div>";
       }
 
       if(empty($errors)){
            $stmt = $con->prepare("INSERT INTO 
            items(Name, Disc, Price,Country,Status,Member_id,Cat_id,tags, Add_Date)
        VALUES(:zname, :zdisc, :zprice, :zcountry,:zstatus,:zmem,:zcat,:ztags,now()) ");
$stmt->execute(array(

            'zname' 	=> $name,
            'zdisc' 	=> $disc,
            'zprice' 	=> $price,
            'zcountry' 	=> $country,
            'zstatus' 	=> $stat,
            'zmem' 	=> $member,
            'zcat' 	=> $cat,
            'ztags' 	=> $tags


)); 
     
      $mas="<div class='alert alert-success'style='margin-top:15px;'>". $stmt->rowCount().' record inserted'."</div>";
      redirectHome($mas,'back',4);  
      
    
    }
}else{
    $mas= '<br><div class="alert alert-danger">you cannot browse here</div>';
    redirectHome($mas,4);
}
echo "<div/>";



}
/* END INSERT */


/* START edit */
elseif($do=='Edit'){
    $itemId =isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;

                    $stmt = $con->prepare("SELECT *FROM items WHERE  ID=?");
                    $stmt->execute(array($itemId));
                    $row=$stmt->fetch();
                    $count=$stmt->rowcount();

                    if($count>0){?> 
                    <h1 class=text-center>Edit items</h1>
                    <div>
                    <form action="?do=update" class="form-horizontal" method='POST'>
                    
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>name</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='name' class='form-control' value="<?php echo $row['Name']?>" placeholder='name of the item'>
                        </div>
                    </div>
                    <!--  -->

                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Discription</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="type" name='discription' class='form-control' value="<?php echo $row['Disc']?>"   placeholder='type items Discription' >   
                    </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Price</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='price' class='form-control'  value="<?php echo $row['Price']?>"  placeholder='price of the item'>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Country made</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='country' class='form-control' value="<?php echo $row['Country']?>"   placeholder='Country of made'>
                        </div>
                    </div>
                    <!--  -->
                      <!--  -->
                      <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>TAGS</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='tags' value="<?php echo $row['tags']?>"  class='form-control'>
                        </div>
                    </div>
                    <!--  -->
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Status</label>
                        <div class='col-sm-10 col-md-7'>
                       <select name="status" class='form-control' >
                        <option value="1" value="<?php if($row['Status']==1) echo 'selected';?>" >new</option>
                        <option value="2">like old</option>
                        <option value="3">Used</option>
                        <option value="4">very old</option>
                       </select>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Member</label>
                        <div class='col-sm-10 col-md-7'>
                       <select name="member" class='form-control' >
                       <option value="....">....</option>
                       <?php
                        $allMembers = getAllFrom("*", "users", "", "", "UserID");
                        foreach ($allMembers as $user) {
                           echo "<option value='".$user['UserID']."'";
                           if($row['Member_id']==$user['UserID']){echo 'selected';};
                           echo ">".$user['Username']."</option>";
                        }
								?>
                       </select>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Catiegory</label>
                        <div class='col-sm-10 col-md-7'>
                       <select name="cat" class='form-control' >
                       <option value="....">....</option>
                       <?php
                       $allMembers = getAllFrom("*", "cats", "", "", "ID");
                        foreach ($allMembers as $cat) {
                           echo "<option value='".$cat['ID']."'";
                           if($row['Cat_id']==$cat['ID']){echo 'selected';};
                           echo ">".$cat['name']."</option>";
                        }
								?>
                       </select>
                        </div>
                    </div>
                    <!--  -->


                    <div class="form-group">
                        <div class='col-sm-10 col-sm-offset-2 col-md-7'>
                        <input type="submit" value='save' class=' btn btn-primary btn-lg'>
                        </div>
                    </div>
                    <input type="hidden" name='itid' value='<?php echo $row['ID']?>'>
                    </form>

                 <?php   $stmt=$con->prepare("SELECT comments.*  ,users.Username FROM `comments` 
                         INNER JOIN users ON comments.com_mem= users.UserID WHERE  com_item=$itemId" );
        $stmt->execute();
        $rows=$stmt->fetchAll();
    if(!empty($rows)){
        ?>
                    <h1 class=text-center>Manage [<?php echo $row['Name']?>] comments</h1>
                        <div class='table-responsive'>
                                <table class="main-table text-center table  table-bordered " >
                                        <tr> 
                                          <th>comment</th>
                                          <th>username</th>
                                          <th>date</th>
                                          <th>control</th>
                                          </tr>

                                         <?php
                                        foreach($rows as $r){
                                           echo "<tr>";
                                           echo "<td>".$r['comment']."</td>";
                                           echo "<td>".$r['Username']."</td>";
                                           echo "<td>".$r['com_date']."</td>";
                                           echo "<td>
                                           <a href='comments.php?do=Edit&comId=".$r['C_ID']."' class='btn btn-success'><i class='far fa-edit'></i> Edit</a>
                                           <a  href='comments.php?do=delete&comId=".$r['C_ID']."' class='btn btn-danger del'><i class='fas fa-trash-alt'></i> Delete</a>";

                                           if ($r['status'] == 0) {
											echo "<a 
													href='comments.php?do=Activate&comId=" . $r['C_ID'] . "' 
												style='margin-left:5px;'	class='btn btn-info'>
													<i class='fa fa-check'></i> Activate</a>";
										}
                                          echo  "</td>";
                                           echo "</tr>";
                                        }
                                         
                                    }  
                                         ?>
                                </table>
                                </div>
                                <?php}?>

                   </div>
                    <?php
                    }
                    else{
                        $mas= "<div class='alert alert-danger>no such member</div>";
                        redirectHome($mas);  
                 
}}



elseif($do=='update'){ 
   if ($_SERVER['REQUEST_METHOD']=='POST'){
    echo " <h1 class='text-center'> Update members </h1> <div class='container'>";
   $name=$_POST['name'];
   $disc=$_POST['discription'];
   $price=$_POST['price'];
   $country=$_POST['country'];
   $stat=$_POST['status']; 
   $member=$_POST['member'];
   $cat=$_POST['cat'];
   $IteId=$_POST['itid']; 
   $tags=$_POST['tags']; 
  $errors=[];
       if(empty($name)){
           $errors[]='name cannot be empty';
       }
    if(empty($price)){
        $errors[]='price cannot be empty';
    }
    if(empty($country)){
        $errors[]='country field cannot be empty';
    }
    if($stat==0){
        $errors[]='status field cannot be empty';
    }
       foreach($errors as $er){
           echo "<div class='alert alert-danger'style='margin-top:15px;'>".$er."</div>";
       }
 
       if(empty($errors)){
        $stmt=$con->prepare("UPDATE items SET Name=?,Disc=?,Price=?,Country=?,tags=?,Status=? ,Member_id=?,Cat_id=? WHERE ID=?");
        $stmt->execute(array($name,$disc,$price,$country,$tags,$stat,$member,$cat,$IteId));  
     
      $mas="<div class='alert alert-success'style='margin-top:15px;'>". $stmt->rowCount().' record updated'."</div>";
      redirectHome($mas,'back',4);  
      
    
    }
}else{
    $mas= '<br><div class="alert alert-danger">you cannot browse here</div>';
    redirectHome($mas,4);
}
echo "<div/>";



}
elseif ($do == 'delete') {

    echo "<h1 class='text-center'>Delete Item</h1>";
    echo "<div class='container'>";

        // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

        $Itid = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;

        // Select All Data Depend On This ID

        $check = check('ID', 'items', $Itid);

        // If There's Such ID Show The Form

        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM items WHERE ID = :zid");

            $stmt->bindParam(":zid", $Itid);

            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

            redirectHome($theMsg, 'back');

        } else {

            $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

            redirectHome($theMsg);

        }

    echo '</div>';

}
elseif ($do == 'Activate') {

    echo "<h1 class='text-center'>Activate Item</h1>";
    echo "<div class='container'>";

    
        // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

        $Itid = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;

        // Select All Data Depend On This ID

        $check = check('ID', 'items', $Itid);

        // If There's Such ID Show The Form

        if ($check > 0) {

            $stmt = $con->prepare("UPDATE items SET Aprove = 1 WHERE ID = ?");

            $stmt->execute(array($Itid));

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';

            redirectHome($theMsg,'back');

        } else {

            $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

            redirectHome($theMsg);

        }

    echo '</div>';

}




else
echo " Error no category with name  ".$_GET['do'];
include $tpl.'footer.php';
}
else{
    header('location:index.php');
    exit();
}

?>