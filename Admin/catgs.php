<?php
session_start();
$tit='Categories';
if(isset($_SESSION['user'])){
    include('init.php');

$do='';

$do=isset($_GET['do']) ? $_GET['do'] : 'manage';


if($do=='manage'){


    $sort='ASC';
    $order='ordering';
    $so=array('ASC','DESC');
    if(isset($_GET['sort'])&& in_array($_GET['sort'],$so)){
        $sort=$_GET['sort'];
    }

   $stmt=$con->prepare("SELECT * from cats  where parent = 0 ORDER BY $order $sort");
   $stmt->execute();
   $cats=$stmt->fetchAll();
   

   
   ?>
   <h1 class='text-center'>Manage Categories</h1>
   <div class='container categories'>
   <div class="panel panel-default">
                        <div class="panel-heading"><i class="fas fa-tag"></i> latest items
                        <div class="option pull-right">Ordering: 
							<a class="<?php if ($sort == 'ASC') { echo 'active'; } ?>" href="?sort=ASC">Asc</a> | 
							<a class="<?php if ($sort == 'DESC') { echo 'active'; } ?>" href="?sort=DESC">Desc</a> 
                            <span data-cl='full' class='active'>Full </span>|<span> classic</span>
						</div>
                     
                    </div>
                        <div class="panel-body">
                         <?php
                         
							foreach($cats as $cat) {
                                echo "<div class='cat'>";
                                echo "<div class='hidden-buttons'>";
                                echo "<a href='catgs.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                echo "<a href='catgs.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";                            
                                echo "</div>";
                                    echo "<h3>" . $cat['name'] . '</h3>';
                                    echo "<div class='full-veiw'>";
										echo "<p>"; if($cat['Description'] == '') { echo 'This category has no description'; } else { echo $cat['Description']; } echo "</p>";
										if($cat['visibility'] == 1) { echo '<span class="visibility cat-span">Hidden</span>'; } 
										if($cat['Allow_com'] == 1) { echo '<span class="commenting cat-span">Comment Disabled</span>'; }
										if($cat['Allow_ads'] == 1) { echo '<span class="advertises cat-span">Ads Disabled</span>'; }  
                                    echo "</div>";
                                    $childs= getAllFrom('*', 'cats', "where parent = {$cat['ID']}",'','ID');
                                    if(!empty($childs)){
                                      echo " <h4 class='ch-head'>child cats</h4>";
                                        echo "<ul class='list-unstyled ch-list'>";
                                foreach($childs as $c){
                                    echo "<li><a href='catgs.php?do=Edit&catid=" . $c['ID'] ."'>" . $c['name']."</a></li>";
                                }
                                echo "</ul>";
                            }   
                                    echo "<hr>";
                                    echo "</div>";}
                                    ?>
                        </div>
                        </div> 
                        <a class="add-category btn btn-primary" href="catgs.php?do=add"><i class="fa fa-plus"></i> Add New Category</a>
                    </div>
<?php


}
elseif($do=='add')

{ $all= getAllFrom('*', 'cats', 'where parent = 0','','ID') ;

?>
                    <h1 class=text-center>Add new categori</h1>
                    <div class='container'>
                    <form action="?do=insert" class="form-horizontal" method='POST'>
                    
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>name</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='name' class='form-control' required='required' placeholder='name of the categori'>
                        </div>
                    </div>
                    <!--  -->

                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Discription</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="type" name='discription' class='form-control'  placeholder='type categori Discription' >   
                    </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Ordering</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='ordering' class='form-control'   placeholder='number to arrange the categori'>
                        </div>
                    </div>
                        <!--  -->


                         <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>parent ?</label>
                        <div class='col-sm-10 col-md-7'>
                        <select name="parent" class='form-control' id="">
                        <option value="0">none</option>
                        <?php
                        foreach($all as $it)
                        {
                            echo " <option value='".$it['ID']."'>".$it['name']."</option>";
                        }
                        ?>
                        
                        </select>
                        </div>
                    </div>
                        <!--  -->
                        <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Visible</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="visibility" value="0" checked />
								<label for="vis-yes">Yes</label> 
							</div>
							<div>
								<input id="vis-no" type="radio" name="visibility" value="1" />
								<label for="vis-no">No</label> 
							</div>
						</div>
					</div>
                    <!--  -->

                     <!--  -->
                     <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="commenting" value="0" checked />
								<label for="com-yes">Yes</label> 
							</div>
							<div>
								<input id="com-no" type="radio" name="commenting" value="1" />
								<label for="com-no">No</label> 
							</div>
						</div>
					</div>
                    <!--  -->

                     <!--  -->
                     <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" checked />
								<label for="ads-yes">Yes</label> 
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" />
								<label for="ads-no">No</label> 
							</div>
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


elseif($do=='Edit'){
    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

    // Select All Data Depend On This ID

    $stmt = $con->prepare("SELECT * FROM cats WHERE ID = ?");

    // Execute Query

    $stmt->execute(array($catid));

    // Fetch The Data

    $cat = $stmt->fetch();

    // The Row Count

    $count = $stmt->rowCount();
    if($count>0){?> 
        <h1 class=text-center>Edit member</h1>
        <div>
        <form action="?do=update" class="form-horizontal" method='POST'>
                    
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>name</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='name' class='form-control' value="<?php echo $cat['name']?>"  placeholder='name of the categori'>
                        </div>
                    </div>
                    <!--  -->

                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Discription</label>
                        <div class='col-sm-10 col-md-7 '>
                        <input type="type" name='discription' class='form-control' value="<?php echo $cat['Description']?>"   placeholder='type categori Discription' >   
                    </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Ordering</label>
                        <div class='col-sm-10 col-md-7'>
                        <input type="text" name='ordering' class='form-control'  value="<?php echo $cat['ordering']?>"   placeholder='number to arrange the categori'>
                        <input type="hidden" name='hid'   value="<?php echo $cat['ID']?>"   placeholder='number to arrange the categori'>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>parent ?</label>
                        <div class='col-sm-10 col-md-7'>
                        <select name="parent" class='form-control' id="">
                        <option value="0">none</option>
                        <?php
                        $all= getAllFrom('*', 'cats', 'where parent = 0','','ID') ;
                        foreach($all as $i)
                        {
                            echo $i['ID'];
                            echo " <option"; 
                            if( $cat['parent']==$i['ID'] ){echo " selected ";}
                            echo " value='".$i['ID']."'>";
                            echo $i['name'];
                            echo "</option>";
                        }
                        ?>
                        
                        </select>
                        </div>
                    </div>
                        <!--  -->
                        <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Visible</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['visibility'] == 0) { echo 'checked'; } ?>  />
								<label for="vis-yes">Yes</label> 
							</div>
							<div>
								<input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['visibility'] == 1) { echo 'checked'; } ?>  />
								<label for="vis-no">No</label> 
							</div>
						</div>
					</div>
                    <!--  -->

                     <!--  -->
                     <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_com'] == 0) { echo 'checked'; } ?>  />
								<label for="com-yes">Yes</label> 
							</div>
							<div>
								<input id="com-no" type="radio" name="commenting" value="1"<?php if ($cat['Allow_com'] == 1) { echo 'checked'; } ?>  />
								<label for="com-no">No</label> 
							</div>
						</div>
					</div>
                    <!--  -->

                     <!--  -->
                     <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_ads'] == 0) { echo 'checked'; } ?>  />
								<label for="ads-yes">Yes</label> 
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_ads'] == 1) { echo 'checked'; } ?>  />
								<label for="ads-no">No</label> 
							</div>
						</div>
					</div>
                    <!--  -->
                    <div class="form-group">
                        <div class='col-sm-10 col-sm-offset-2 col-md-7'>
                        <input type="submit" value='save' class=' btn btn-primary btn-lg'>
                        </div>
                    </div>
                    </form>
       </div>
        <?php
        }
        else{
            $mas= "<div class='alert alert-danger>no such member</div>";
            redirectHome($mas);  
        }

}/*t end of edit */


/* start of update */
elseif($do=='update'){

    echo " <h1 class='text-center'> Update members </h1> <div class='container'>";
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_POST['name'];
    $disc=$_POST['discription'];
    $ord=$_POST['ordering'];
    $vis=$_POST['visibility'];
    $com=$_POST['commenting'];
    $ads=$_POST['ads'];
    $uid=$_POST['hid']; 
    $parent=$_POST['parent'];   
  

  
 
      
        $stmt=$con->prepare("UPDATE cats SET name=?,Description=?,ordering=?,parent=?,visibility=?,Allow_com=?,Allow_ads=? WHERE ID=?");
        $stmt->execute(array($name,$disc,$ord,$parent,$vis,$com,$ads,$uid)); 
     
        $themas="<div class='alert alert-success'style='margin-top:15px;'>". $stmt->rowCount().' record updated'."</div>";
        redirectHome($themas,'back',4);  
    
 
}else{
   $themas= '<div class="alert alert-danger">you cannot browse here</div>';
   redirectHome($themas,4);
}
echo "<div/>";

}

/* end of update */





elseif($do=='insert'){
       
    if($_SERVER['REQUEST_METHOD']=='POST'){
        echo " <h1 class='text-center'> insert categori </h1> <div class='container'>";
        
       $name=$_POST['name'];
       $disc=$_POST['discription'];
       $ord=$_POST['ordering'];
       $vis=$_POST['visibility'];
       $com=$_POST['commenting'];
       $ads=$_POST['ads'];
       $parent=$_POST['parent'];
        
    

     
    
               $check=check("name","cats",$name);
               if($check>0){
                   $themas= "<div class='alert alert-danger'style='margin-bottom:15px;'>categori  is exist</div>";
                   redirectHome($themas,'back'); 
               }else{
                $stmt = $con->prepare("INSERT INTO 

                cats(name, Description, parent, ordering, visibility, Allow_com, Allow_ads)

            VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads)");

            $stmt->execute(array(
                'zname' 	=> $name,
                'zdesc' 	=> $disc,
                'zparent' 	=> $parent,
                'zorder' 	=> $ord,
                'zvisible' 	=> $vis,
                'zcomment' 	=> $com,
                'zads'		=> $ads
            ));
                        
                $mas="<div class='alert alert-success'style='margin-top:15px;'>". $stmt->rowCount().' record inserted'."</div>";
                redirectHome($mas,'back');  
                
        }
    }else{
        $mas= '<br><div class="alert alert-danger">you cannot browse here</div>';
        redirectHome($mas,4);
    }
    echo "<div/>";



 }

/* end of insert */

/* start delete */


elseif ($do == 'Delete') {

    echo "<h1 class='text-center'>Delete Category</h1>";
    echo "<div class='container'>";

        // Check If Get Request Catid Is Numeric & Get The Integer Value Of It

        $Catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        // Select All Data Depend On This ID

        $check = check('ID', 'cats', $Catid);

        // If There's Such ID Show The Form

        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM cats WHERE ID = :zid");

            $stmt->bindParam(":zid", $Catid);

            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

            redirectHome($theMsg, 'back');

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
};
?>