<?php
include 'init.php';?>

<div class='container'>
<h1 class='text-center'><?php echo  "show cat";?></h1>
<div class='row'>

<?php
foreach(GetITems('Cat_id',$_GET['catID']) as $it){
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