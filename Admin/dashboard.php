<?php
session_start();
$tit='Dashboard';
if(isset($_SESSION['user'])){
    include('init.php');
    $lim=5;
   $latest=getlatest("*",'users',"UserID",$lim);
   
   $Itnum=5;
   $latestIt=getlatest("*",'items',"ID",$Itnum);
   $comnum=3;
   

   ?>
<div class='home-stats'>   
    <div class='container text-center'>
        <h1>Dashboard</h1>
        <div class="row">
					<div class="col-md-3">
						<div class="stat st-mem">
							<i class="fa fa-users"></i>
							<div class="info">
								Total Members
								<span>
									<a href="members.php"><?php echo countItems('UserID', 'users') ?></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-pen">
							<i class="fa fa-user-plus"></i>
							<div class="info">
								Pending Members
								<span>
									<a href="members.php?do=manage&page=pending">
										<?php echo check("RegStatus", "users", 0) ?>
									</a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-it">
							<i class="fa fa-tag"></i>
							<div class="info">
								Total Items
								<span>
									<a href="items.php"><?php echo countItems('ID', 'items') ?></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-com">
							<i class="fa fa-comments"></i>
							<div class="info">
								Total Comments
								<span>
								<?php echo countItems('C_ID', 'comments') ?>
								</span>
							</div>
						</div>
					</div>
				</div></div></div>

 
                
                 <div class='latest'>   
    <div class='container'>
                 <div class='row'>
                       <div class='col-sm-6'>
					   <div class="panel panel-default">
                       <div class="panel-heading">
								<i class="fa fa-users"></i> 
								Latest <?php echo $lim ?> Registerd Users 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>                        <div class="panel-body">
								<ul class="list-unstyled latest-users">
								<?php
								
										foreach ($latest as $user) {
											echo '<li>';
                                                echo $user['Username'];
												echo '<a href="members.php?do=Edit&UserID=' . $user['UserID'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> Edit';
														if ($user['RegStatus'] == 0) {
															echo "<a 
                                                            href='members.php?do=Activate&userid=" . $user['UserID'] . "' 
                                                            class='btn btn-info activate'>
                                                            <i class='fa fa-check'></i> Activate</a>";
														}
													echo '</span>';
												echo '</a>';
											echo '</li>';
										}
									
								?>
								</ul>
							</div>
                        </div></div>
                        
                        <div class='col-sm-6'>
                            <div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i> Latest <?php echo $Itnum ?> Items 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>                        <div class="panel-body">
                        <ul class="list-unstyled latest-users">
								<?php
								if(!empty($latestIt)){
										foreach ($latestIt as $it) {
											echo '<li>';
                                                echo $it['Name'];
												echo '<a href="items.php?do=Edit&itemId=' . $it['ID'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> Edit';
														if ($it['Aprove'] == 0) {
															echo "<a 
                                                            href='items.php?do=Activate&itemId=" . $it['ID'] . "' 
                                                            class='btn btn-info activate'>
                                                            <i class='fa fa-check'></i> Activate</a>";
														}
													echo '</span>';
												echo '</a>';
											echo '</li>';
										}}else{
											echo "<p class='emp'>No items to show</p>";
										}
									
								?>
								</ul>
                        </div>
                        </div></div>
                 </div>
				 
				 <!-- start of latest comments -->
				 <div class='row'>
                       <div class='col-sm-6'>
					   <div class="panel panel-default">
                       <div class="panel-heading">
								<i class="fa fa-comments"></i> 
								 latest <?php echo $comnum?> comments 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>                        
							<div class="panel-body">
							<?php
							$stmt=$con->prepare("SELECT comments.* ,users.Username FROM `comments` 
							INNER JOIN users ON comments.com_mem= users.UserID ORDER BY C_ID DESC LIMIT $comnum "  );
							$stmt->execute();
							$rows=$stmt->fetchAll();
							if(!empty($rows)){
                          foreach ($rows as $r) {
							echo "<div class='comment-box'>";
							 echo "<span class='member-n'>".$r['Username']."</span>";
							 echo "<p class='member-c'>".$r['comment']."</p>";
							 echo "<div class='opcom'>
							 <a style='color:#1d771d; font-weight:bold' href='comments.php?do=Edit&comId=".$r['C_ID']."' class='btn'><i class='far fa-edit'></i> Edit</a>
							 <a style='color:red; font-weight:bold;; '  href='comments.php?do=delete&comId=".$r['C_ID']."' class='btn del'><i class='fas fa-trash-alt'></i> Delete</a>
							 </div>";
							 
							 echo "</div>";
						  }
						}else{
							echo "<p class='emp'>No comments to show</p>";
						}

							?>
							</div>
                        </div></div>
                        
                        
                 </div>
				 </div></div>                 



<?php


   include $tpl.'footer.php';
}
else{
    header('location:index.php');
    exit();
}

?>