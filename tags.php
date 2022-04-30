
<?php

	// categoers.php
	session_start() ; 

	include "init.php" ;
		
	$item_count = 30 ; 
	$page = '';
	if(isset($_GET["page"])){
		$page = $_GET["page"] ; 
	} else{
		$page = 1; 
	}
	$start_from = ( $page - 1 ) * $item_count ; 

	if(isset($_GET["name"])){
		echo '<div class="container">' ;
		
		// Get Page Name From Link

		
		echo '<div class="text-center"><h2 class="h1">Tags</h2></div>' ; 
		

		// Get All Items Related With This Categorey Helping By $catId

		$items =  getTags($_GET["name"], $start_from, $item_count) ;
		$count =  getTagsCount($_GET["name"]) ;

		// Echo All Items Inner CAtegorey If Exist

		if(!empty($items)){ 
		echo '<div class="row justify-content-left">' ;

			// Show Data
			$i = 0 ; 
			foreach ($items as $item) {
				$i++ ; 
				echo '<div class="col-sm-6 col-md-3">' ; 
					
					echo '<div class="card item-box">' ; 
						echo '<div class="img-container">' ;
						
						$img_arr = explode('/',$item["image"]);
						if(!empty($img_arr)){
							if(isset($_GET["item_id"]) &&$_GET["item_id"] !=''){
								//slider ere
								//print_r($img_arr) ; 
								echo "SLIDER" ; 
							}else{
								echo '<img src="admin\upload\images\\' . $img_arr[0] . '" class="img-fluid" alt="pro-photo">'  ;
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
			echo '</div>';?>
			
			<div class='row'>
				<div class="col-sm-6 offset-3" >
					<div class="">
						<nav>
							<ul class="pagination pagination-sm justify-content-center">
								<?php
									$pages_count = ceil($count/$item_count);									if($pages_count>=1){
										echo '<li class="page-item '; if($_GET["page"] ==1 || !isset($_GET["page"]) ){ echo 'active' ; } echo '" aria-current="page"><a class="page-link" href="?name='.$_GET["name"].'&page=1">1</a></li>';
									}
									for($i = 2; $i<=$pages_count;$i++){
										echo '<li class="page-item '; if($_GET["page"] ==$i){ echo 'active' ; } echo '" aria-current="page">';
											echo '<a class="page-link" href="?name='.$_GET["name"].'&page='.$i.'">'.$i.'</a>';
										echo '</li>';
									}
								?>
							</ul>
						</nav>
					</div>
				</div>
			</div>
			
			<?php

		}else{
			
			// Echo No Date If Threre Is No Items With This Tags 

			echo '<div class="empty col-sm-12 col-md-12"><h2 class="h1">There Is No Items With This Tag</h2></div>' ;
		
		}

		echo '</div>';
	}else{
		echo '<div class="empty col-sm-12 col-md-12"><h2 class="h1">You Shouldent Be Here</h2></div>' ;
	}


	include $tmpls . 'footer.php' ; 