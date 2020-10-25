<?php 

	
	ob_start() ;
	session_start() ;
	
	$pageTitle = "My Profile" ; 
	
	include 'init.php' ; 
	
	if( isset($_SESSION["user"]) ){

		// Get User With This Session Name Data From DAtbase

		$stmt = $con->prepare("SELECT * FROM users WHERE userName = ?");
		$stmt -> execute(array($user)) ;   
		$info = $stmt -> fetch() ; 

?>

<h2 class="h1 text-center">My Profile</h2>
<div class="my-info block">
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				My Mainly Information
			</div>
			<div class="panel-body">
				<ul class="list-unstyled" style="margin-bottom: 0px">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>

						<?php echo $info['userName'] ?>
							
					</li>
					<li>
						<i class="fa fa-envelope fa-fw"></i>

						<?php echo $info['email'] ?>
						
					</li>
					<li>

						<i class="fa fa-unlock-alt fa-fw"></i>

						<?php if( strlen($info['fullname']) > 0 ){ echo $info['fullname'] ;  }else{ echo 'There Is No Fulname' ;} ?>
							
					</li>  
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<?php echo $info['date'] ?>
							
					</li>
				</ul>
				<span class="btn btn-warning btn-sm float-right">
					<i class="fa fa-edit"></i>
					<a href="#">Edit Profile</a>
				</span>
			</div>
		</div>
	</div>
</div>

<div class="my-ads block">
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				My Ads
			</div>
			<div class="panel-body">
				<div class="row">
					<?php 
				
						// Get User Items With His Id From DAtbase

						$stmt = $con->prepare("SELECT * FROM items WHERE member_id = ?");
						$stmt -> execute(array($info['userId'])) ;   
						$items = $stmt -> fetchAll() ; 

						// Check If There Is Any Items

						if(empty($items)){
							echo '<div>There Is No Ads Yet' . '<a class="float-right btn btn-success btn-sm" href="newad.php"><i class="fa fa-plus"></i> Add Item</a></div>'; 
						}else{

							// Show Data

							foreach ($items as $item) {
								 
								echo '<div class="col-sm-6 col-md-4">' ; 
									
									echo '<div class="card item-box">' ; 

										if($item["image"] !=''){
											echo '<img src="admin\upload\images\\' . $item["image"] . '" class="img-fluid">'  ;
										}else{
											echo '<img src="admin\upload\images\constad.jpg" class="img-fluid">'  ;
										}

										echo '<div class="caption">' ; 

											echo '<h5 class="card-title"><a href="items.php?id=' . $item['item_id'] . '">' . $item['item_name'] . '</a></h5>' ; 

											echo '<p class="card-text lead">' . $item['item_desc'] . '</p>' ;

											echo '<div class="card-date">' . $item['add_date'] . '</div>' ;
											
											echo '<span class="price">' . $item['price'] . '$</span>' ;

											if($item['apporove'] == 0){

												echo '<span class="un">Not approve</span>' ;

											} 

										echo '</div>' ; 
									
									echo '</div>' ; 
								
								echo '</div>' ;
							 
								
							}

						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="prov-items block">
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				My Comments
			</div>
			<div class="panel-body">
				<?php 
			
					// Get User Comments With His Id From Database

					$stmt = $con->prepare("SELECT * FROM comments WHERE user_id = ?");
					$stmt -> execute(array($info['userId'])) ;   
					$comments = $stmt -> fetchAll() ; 

					// Check If There Is Any Items

					if(empty($comments)){
						echo 'There Is No comments Yet' ;
					}else{

						// Show Data

						foreach ($comments as $com) {
							echo $com["comment"] . '<br />'; 
						}

					}
				?>
			</div>
		</div>
	</div>
</div>

<?php 
	
	include $tmpls .'footer.php' ;
	
	}else{
		echo '<div class="container">';
			echo '<div class="alert alert-danger text-center" style="margin-top:60px">You Are Not Allowed To Be Here</div>' ;
		echo '</div>'  ;
		header("refresh:5;url=index.php") ;  
	} 
	ob_end_flush()  ;
?>