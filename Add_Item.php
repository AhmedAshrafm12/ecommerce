<?php 
session_start();
include ("init.php");
  if(isset($_SESSION['username'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $Fname=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $Fdisc=filter_var($_POST['discription'],FILTER_SANITIZE_STRING);
        $Fprice=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $fcountry=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        $fcat=filter_var($_POST['cat'],FILTER_SANITIZE_NUMBER_INT);
        $fstatus=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);

       $err=array();

       if(strlen($Fname)<4){
           $err[]='name must be more than 4 chars';
       }
       if(strlen($Fdisc)<10){
        $err[]='discription must be more than 10 chars';
    }
    if(strlen($fcountry)<2){
        $err[]='country name must be more than 4 chars';
    }

    if(empty($err)){
        $stmt = $con->prepare("INSERT INTO 
        items(Name, Disc, Price,Country,Status,Member_id,Cat_id, Add_Date)
    VALUES(:zname, :zdisc, :zprice, :zcountry,:zstatus,:zmem,:zcat,now()) ");
                    $stmt->execute(array(

                            'zname' 	=> $Fname,
                            'zdisc' 	=> $Fdisc,
                            'zprice' 	=> $Fprice,
                            'zcountry' 	=> $fcountry,
                            'zstatus' 	=> $fstatus,
                            'zmem' 	=> $_SESSION['uid'],
                            'zcat' 	=> $fcat

                    )); 
                    
  echo "success regesterd";
  

}


    }
?>

<div class='information'>
<div class='container'>
      <h1 class='text-center'>Create New Item</h1>
                <div class='panel panel-primary'>
                <div class='panel-heading'>
                Add Item
                </div>
                <div class='panel-body'>
               <div class='row'>
                    <div class='col-md-8'>
                    <form action="<?php $_SERVER['PHP_SELF']?>" class="form-horizontal" method='POST'>
                    
                    <div class="form-group form-group-lg">
                        <label class='col-sm-3 control-label'>name</label>
                        <div class='col-sm-10 col-md-9'>
                        <input type="text" name='name' class='form-control live-name'  placeholder='name of the item'>
                        </div>
                    </div>
                    <!--  -->

                    <div class="form-group form-group-lg">
                        <label class='col-sm-3 control-label'>Discription</label>
                        <div class='col-sm-10 col-md-9 '>
                        <input type="type" name='discription' class='form-control live-disc'  placeholder='type items Discription' >   
                    </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-3 control-label'>Price</label>
                        <div class='col-sm-10 col-md-9'>
                        <input type="text" name='price' class='form-control live-price'   placeholder='price of the item'>
                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-3 control-label'>Country made</label>
                        <div class='col-sm-10 col-md-9'>
                        <input type="text" name='country' class='form-control'    placeholder='Country of made'>
                        </div>
                    </div>
                    <!--  -->
                    <!--  -->
                    <div class="form-group form-group-lg">
                        <label class='col-sm-3 control-label'>Status</label>
                        <div class='col-sm-10 col-md-9'>
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
                        <label class='col-sm-3 control-label'>Catiegory</label>
                        <div class='col-sm-10 col-md-9'>
                       <select name="cat" class='form-control' >
                       <option value="....">....</option>
                       <?php
                        $allMembers = getAllFrom("*", "cats", "", "", "ID");
                        foreach ($allMembers as $user) {
                            echo "<option value='" . $user['ID'] . "'>" . $user['name'] . "</option>";
                        }
								?>
                       </select>
                        </div>
                    </div>
                    <!--  -->


                    <div class="form-group">
                        <div class='col-sm-10 col-sm-offset-2 col-md-9'>
                        <input type="submit" value='save' class=' btn btn-primary btn-lg'>
                        </div>
                    </div>
                    </form>
                    </div>



       <!-- img -->
                    <div class='col-md-4'>
                   <div class='thumbnail it-box live-prev'>
                    <span class='Price pr'>$0</span>
                   <img src="av.png" class="img-responsive">
                    <div class='thumbnail'>
                   <h3>Title</h3>
                   <p>discription</p>
                    </div>
                   </div>

                    </div>
               </div>
               <div class='er'>
               <?php 
               if(isset($err)){
                   foreach($err as $e){
                       echo "<div class='alert alert-danger'>".$e."</div>";
                   }
               }
               ?>
               </div>
                </div>
                </div>

               
               

<?php 
  }





include $tpl.'footer.php';?>