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

			echo '<div class="row">' ;

			foreach ($items as $item) {
				
				echo '<div class="col-sm-6 col-md-4">' ; 
					
					echo '<div class="card item-box">' ; 

						echo '<img class="img-responsive card-img-top" src="admin\upload\images\\' . $item["image"] . '" alt="item">' ;
						//echo '<img src="admin\upload\images\\' . $item["image"] . '" class="img-fluid">'  ;


						echo '<div class="caption">' ; 

							echo '<h5 class="card-title"><a href="items.php?id=' . $item['item_id'] . '">' . $item['item_name'] . '</a></h5>' ; 

							echo '<p class="card-text lead">' . $item['item_desc'] . '</p>' ;

							echo '<span class="price">' . $item['price'] . '$</span>' ;
							echo '<div class="card-date">' . $item['add_date'] . '</div>' ; 

						echo '</div>' ; 
					
					echo '</div>' ; 
				
				echo '</div>' ;

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
?>