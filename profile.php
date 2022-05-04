<?php 
	ob_start() ;
	session_start() ;
	
	$pageTitle = "My Profile" ; 
	
	
	if(isset($_GET["publisher"]) && $_GET["publisher"] != ''){//comes from items
		$pageTitle=$_GET["publisher"]." Profile" ; 
	}
	
	include 'init.php' ; 
	
	$item_count = 3; 
	$page = '';
	if(isset($_GET["page"])){
		$page = $_GET["page"] ; 
	} else{
		$page = 1; 
	}
	$start_from = ( $page - 1 ) * $item_count ; 

	if( isset($_GET["guest"]) && $_GET["guest"]=="true" ){//no session
		$user = strtolower($_GET["publisher"] );
	}

	if( isset($_SESSION["user"]) || (isset($_GET["guest"]) && $_GET["guest"]=="true")){

		//i should do if it a guest and not session so $user = user publish the item
		if( (isset($_GET["publisher"]) && $_GET["publisher"]!="")){
			$user = strtolower($_GET["publisher"] ); 
		}

		// Get User With This Session Name Data From DAtbase
		

		$stmt = $con->prepare("SELECT * FROM users WHERE userName = ?");
		$stmt -> execute(array($user)) ;   
		$info = $stmt -> fetch() ; 
		

?>

<h2 class="h1 text-center">
	<?php 
		if(!isset($_GET["guest"]) && !isset($_GET["publisher"])){
			echo 'My Profile' ; 
		}else{
			echo  ucfirst($_GET["publisher"]) .' Profile' ; 
		}
	?>
</h2>
<div class="my-info block">
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php 
					if(!isset($_GET["guest"]) && !isset($_GET["publisher"])){
						echo 'My Information' ; 
					}else{
						echo  ucfirst($_GET["publisher"]) .' Information' ; 
					}
				?>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled" style="margin-bottom: 0px">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>

						<?php echo $info['userName'] ?>
							
					</li>
					<li>

						<?php 
							if(!isset($_GET["guest"]) && !isset($_GET["publisher"])){
								echo '<i class="fa fa-envelope fa-fw"></i>';
								echo $info['email'] ;
							}
						?>
						
					</li>
					<li>

						<i class="fa fa-unlock-alt fa-fw"></i>

						<?php if( strlen($info['fullname']) > 0 ){ echo $info['fullname'] ;  }else{ echo 'There Is No Fullname' ;} ?>
							
					</li>  
					<li>
						<?php 
							if(!isset($_GET["guest"]) && !isset($_GET["publisher"])){
								echo '<i class="fa fa-calendar fa-fw"></i>';
								echo $info['date'] ;
							}
						?>
							
					</li>
				</ul>
				<?php 
					if(!isset($_GET["guest"]) && !isset($_GET["publisher"])){
						echo '<div class="row justify-content-end"><span class="col-sm-1 btn btn-warning btn-sm">
							<a href="members.php?do=Edit&adminId='.$_SESSION["uid"].'"><i class="fa fa-edit"></i></a>
						</span></div>';
					}
				?>
			</div>
		</div>
	</div>
</div>

<div class="my-ads block">
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php 
					if(!isset($_GET["guest"]) && !isset($_GET["publisher"])){
						echo 'My Ads' ; 
					}else{
						echo  ucfirst($_GET["publisher"]) .' Ads' ; 
					}
				?>
			</div>
			<div class="panel-body">
				<div class="row">
					<?php 
				
						// Get User Items With His Id From DAtbase

						$stmt = $con->prepare("SELECT * FROM items WHERE member_id = ?");
						$stmt -> execute(array($info['userId'])) ;   
						$count = $stmt -> rowCount() ;  



						$stmt = $con->prepare("SELECT * FROM items WHERE member_id = ? LIMIT $start_from, $item_count");
						$stmt -> execute(array($info['userId'])) ;   
						$items = $stmt -> fetchAll() ; 
						
						

						// Check If There Is Any Items

						if(empty($items)){
							echo '<div class="col-sm-6">There Is No Ads Yet' ; 
							echo '</div>'; 
							echo '<div class="col-sm-6 text-end">' ; 
								echo '<a class="btn btn-success btn-sm" href="newad.php"> ' ;
									echo '<i class="fa fa-plus"></i>';
								echo '</a>';
							echo '</div>' ; 
						}else{

							// Show Data
							$i = 0 ; 
							foreach ($items as $item) {
								$i++ ; 
								echo '<div class="col-sm-6 col-md-3">' ; 
									
									echo '<div class="card item-box">' ; 
										echo '<div class="img-container">' ;
										
											$img_arr = explode('/',$item["image"]);
											if(!empty($img_arr)){
												if(isset($_GET["item_id"]) &&$_GET["item_id"] !='' && count($img_arr) > 1){
													//slider ere
													//print_r($img_arr) ; 
													echo "SLIDER" ; 
												}else{
													echo '<img src="admin\upload\images\\' . $img_arr[0] . '" class="img-fluid" alt="pro-photo">'  ;
													echo "<div><strong><code>multi photos don't supported</code></strong></div>";
												}
											}else{
												echo '<img src="admin\upload\images\constad.jpg" class="img-fluid" alt="const-pro">'  ;
											}
										echo '</div>';

										echo '<div class="caption">' ; 

											echo '<h5 class="card-title"><a href="items.php?item_id=' . $item['item_id'] . '">' . $item['item_name'] . '</a></h5>' ; 

											echo '<p class="card-text text-truncate lead">' . $item['item_desc'] . '</p>' ;

											echo '<div class="card-date">' . $item['add_date'] . '</div>' ;
											
											echo '<span class="price">' . $item['price'] . '$</span>' ;

											if($item['apporove'] == 0){

												echo '<span class="un">Not approve</span>' ;

											} 

										echo '</div>' ; 
							
									echo '</div>' ; 
						
								echo '</div>' ;
							 
								
								if($i%4==0){			
									echo '</div>' ;
									echo '<div class="row">' ;
								}
							}
							echo '</div>';
							if(!isset($_GET["guest"]) && !isset($_GET["publisher"])){
								echo '<div class="row justify-content-end">';
									echo '<div class="col-sm-2 text-end" >' ;
										echo '<a class="col-sm-12 btn btn-success btn-lg" href="items.php?do=Manage">' ;
											echo 'Manage';
										echo '</a>' ; 
									echo '</div>';
								echo '</div>';
							}

						}
					?>
				</div>
				<!-- fffffffffffffffffffff -->
				<div class='row'>
					<div class="col-sm-6 offset-3" >
						<div class="">
							<nav>
								<ul class="pagination pagination-sm justify-content-center">
									<?php
										$pages_count = ceil($count/$item_count);
										if($pages_count>=1){
											echo '<li class="page-item '; if($_GET["page"] ==1 || !isset($_GET["page"]) ){ echo 'active' ; } echo '" aria-current="page"><a class="page-link" href="?page=1">1</a></li>';
										}
										for($i = 2; $i<=$pages_count;$i++){
											echo '<li class="page-item '; if($_GET["page"] ==$i){ echo 'active' ; } echo '" aria-current="page">';
												echo '<a class="page-link" href="?page='.$i.'">'.$i.'</a>';
											echo '</li>';
										}
									?>
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<!--gfggggggggggggggggggg  -->
			</div>
		</div>
	</div>
</div>

<div class="prov-items block">
	<div class="container">
		<div class="col-sm-12">
			<div class="panel panel-default col-sm-12">
				<div class="panel-heading col-sm-12">
					<?php 
						if(!isset($_GET["guest"]) && !isset($_GET["publisher"])){
							echo 'My Comments' ; 
						}else{
							echo  ucfirst($_GET["publisher"]) .' Comments' ; 
						}
					?>
				</div>
				<div class="panel-body col-sm-12">
					<div class="row">	
						<div class="col-sm-12">
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
									echo '<ul class="list-unstyled">' ; 
									foreach ($comments as $com) {?>
										<li style="margin-bottom:2px" > 
											<div class="row justify-content-center">
													<div class="comm col-sm-12 d-inline-block <?php if(strlen($com["comment"]) >30){ echo 'text-truncate' ; }?>">
														<?php echo '<i class="fas fa-comments"></i> '.$com["comment"]  ;?>
													</div>
											</div>
										</li> 
										<?php }
									echo '</ul>' ;

								}
							?>
						</div>
					</div>
				</div>
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
