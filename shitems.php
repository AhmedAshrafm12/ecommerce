<?php 
session_start();
include ("init.php");

$itemId =isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;

$stmt=$con->prepare("SELECT items.* ,cats.name AS CATname ,users.Username FROM `items` 
  INNER JOIN cats ON items.Cat_id= cats.ID
  INNER JOIN users ON items.Member_id= users.UserID
  WHERE items.ID=?
  And 
  Aprove=1
  ");
  $stmt->execute(array($itemId));
$row=$stmt->fetch();
$count=$stmt->rowcount();

  if($count>0){
?>
<h1 class='text-center'><?php echo $row['Name']?></h1>
<div class='container'>
<div class='row'>
            <div class='col-md-3'><img src="av.png" class="img-responsive center-block"></div>
            <div class='col-md-9 item-info'>
            <h2><?php echo $row['Name']?></h2>
            <p><?php echo $row['Disc']?></p>
          <ul class='list-unstyled'>
            <li><?php echo $row['Add_Date']?></li>
            <li>Price: $<?php echo $row['Price']?></li>
            <li>Made in: <?php echo $row['Country']?></li>
            <li>Categoriy: <?php echo "<a href='categ.php?catID=".$row['Cat_id']."''>".$row['CATname']."</a>"?></li>
            <li>Added by: <?php echo $row['Username']?></li>
            <li>tags : <?php $tags=explode(',',$row['tags']);
            foreach($tags as $tag)
            {
            if(!empty($tag)){
              echo "<a href='tags.php?name=".$tag."'>".$tag." | </a>";}
            }
            
            ?></li>
            </ul>
            </div></div>
<?php } else{
  echo "<div class='alert alert-danger'>This item not approved yet </div>";}?>


<?php include $tpl.'footer.php';?>