<?php 
session_start();
include ("init.php");

if(isset($_GET['name'])){
$tagname  =$_GET['name'];?>

<div class='container'>
<div class='row'>
<h1 class='text-center'> <?php echo $tagname?></h1>

<?php 
$items= getAllFrom('*', 'items', "where tags like '%$tagname%'",'','ID');
foreach($items as $it){
   echo "<div class='col-md-3 col-sm-6'>";
   echo "<div class='thumbnail it-box'>";
   echo "<span class='Price'>".$it['Price']."</span>";
   echo '<img src="av.png" class="img-responsive">';
   echo "<div class='thumbnail'>";
   echo "<h3>  <a href='shitems.php?itemId=".$it['ID']."' >".$it['Name']."</a></h3>";
   echo "<p>".$it['Disc']."</p>";
   echo "</div>";
   echo "</div>";
   echo "</div>";



}


} ?>
</div>


<?php include $tpl.'footer.php';?>