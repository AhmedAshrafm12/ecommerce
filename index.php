<?php 
session_start();
include ("init.php");?>

<div class='container'>
<div class='row'>

<?php
$items = GetALl('items','ID','where Aprove = 1');
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


?>
</div>
</div>


<?php include $tpl.'footer.php';?>