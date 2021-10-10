<div class="upper-bar">
  <div class='container'>
  <?php
  if(isset($_SESSION['username'])){
?>
<img class="my-image img-thumbnail img-circle" src="av.png" alt="" />
				<div class="btn-group my-info">
					<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<?php echo $_SESSION['username']?>
						<span class="caret"></span>
					</span>
					<ul class="dropdown-menu">
						<li><a href="profile.php">My Profile</a></li>
						<li><a href="Add_Item.php">New Item</a></li>
						<li><a href="profile.php#my-ads">My Items</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div>


 <?php 
 } else{
  ?>
    <a href="login.php">
    <span class='pull-right'>login|signUp</span>
    </a><?php } ?>


</div>
</div>


<nav class="navbar  navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?php echo "HomePage"?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right ">
    <?php
    foreach (GetCat() as $c) {
     echo "<li><a href='categ.php?catID=".$c['ID']."'></i> ".$c['name']."</a></li>";
    }
    
    ?>
      </ul>
     

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>