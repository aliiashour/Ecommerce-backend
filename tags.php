
<?php

	// categoers.php
	session_start() ; 

	include "init.php" ;
	if(isset($_GET["name"])){
		echo '<div class="container">' ;
		
		// Get Page Name From Link

		
		echo '<div class="text-center"><h2 class="h1">Tags</h2></div>' ; 
		

		// Get All Items Related With This Categorey Helping By $catId

		$items =  getTags($_GET["name"]) ;

		// Echo All Items Inner CAtegorey If Exist

		if(!empty($items)){ 
			echo '<div class="row">';

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

							echo '<p class="card-text lead">' . $item['item_desc'] . '</p>' ;

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

		}else{
			
			// Echo No Date If Threre Is No Items With This Tags 

			echo '<div class="empty col-sm-12 col-md-12"><h2 class="h1">There Is No Items With This Tag</h2></div>' ;
		
		}

		echo '</div>';
	}else{
		echo '<div class="empty col-sm-12 col-md-12"><h2 class="h1">You Shouldent Be Here</h2></div>' ;
	}


	include $tmpls . 'footer.php' ; 