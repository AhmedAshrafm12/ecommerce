<?php 
session_start();
include ("init.php");
  if(isset($_SESSION['username'])){
    $st=$con->prepare("SELECT * from users where Username=?");
    $st->execute(array($sesuser));
    $user=$st->fetch();

  
?>

<div class='information'>
<div class='container'>
                <div class='panel panel-primary'>
                <div class='panel-heading'>
                my informations
                </div>
                <div class='panel-body'>
                    <ul class='list-unstyled'>
               <li> <i class='fa fa-unlock-alt fa-fw'></i> <span>Logname</span>:<?php echo $user['Username'] ?></li>
               <li><i class='fa fa-envelope fa-fw'></i> <span>Email</span>:<?php echo $user['Email'] ?></li>
               <li><i class='fa fa-user fa-fw'></i> <span>fullName</span>:<?php echo $user['FullName'] ?></li>
               <li><i class='fa fa-calendar-alt fa-fw'></i> <span>regDate</span>:<?php echo $user['Date'] ?></li>
               <li><i class='fa fa-tags fa-fw'></i> <span>fav cat</span>:<?php echo $user['Username'] ?></li>
  </ul>
                </div>
                </div>

                <div class='panel panel-primary' id='my-ads'>
                <div class='panel-heading'>
                my latest adds
                </div>
                <div class='panel-body'>
                <div class='row'>

                    <?php
                
                    foreach(GetITems('Member_id',$user['UserID'],'1') as $it){
                        echo "<div class='col-md-3 col-sm-6'>";
                    echo "<div class='thumbnail it-box'>";
                    if($it['Aprove']==0){ echo "<span class='np'>not approved</span>";}
                    echo "<span class='Price'>".$it['Price']."</span>";
                    echo '<img src="av.png" class="img-responsive">';
                    echo "<div class='thumbnail'>";
                    echo "<h3>  <a href='shitems.php?itemId=".$it['ID']."' >".$it['Name']."</a></h3>";
                   
                    echo "<p>".$it['Disc']."</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";



                    }


                    ?>
                    </div>
                </div>
                </div>

                <div class='panel panel-primary'>
                <div class='panel-heading'>
                my latest comments
                </div>
                <div class='panel-body'>
                <?php   $stmt=$con->prepare("SELECT comment from comments  WHERE  com_mem=?" );
                        $stmt->execute(array($user['UserID']));
                        $rows=$stmt->fetchAll();
                        
                    if(!empty($rows)){
                        foreach($rows as $r){
                        ?>
                        <p>.<?php echo $r['comment']; ?>. </p>
                        
                    <?php } ?>
                        </div>

                </div>
</div>
<?php }
else{
    echo "null";
}?>
</div>

<?php 
  }



include $tpl.'footer.php';?>