
<?php

	// categoers.php
	session_start() ; 

	$pageTitle = "categores" ; 

	
	if(isset($_GET["catName"]) && $_GET["catName"] != ''){
		$pageTitle=$_GET["catName"] ; 
	}
	include "init.php" ;
	
	echo '<div class="container">' ;
	
	// Get Page Name From Link
	
	
	
	echo '<div class="text-center"><h2 class="h1">Categores</h2></div>' ; 
	
	// Get Category Id From Link

	$catId = intval($_GET["pageId"]) ;
	// Get All Items Related With This Categorey Helping By $catId

	$items = getItems($catId) ;

	// Echo All Items Inner CAtegorey If Exist
	// echo '<div class="text-center"><h2 class="h1">Categorey [ '.$item["name"].' ] </h2></div>' ; 

	if(!empty($items)){ 
		$i = 0 ; 
		echo '<div class="row justify-content-center">' ;

		foreach ($items as $item) {
			$i++ ; 
			echo '<div class="col-sm-6 col-md-3">' ; 
				
				echo '<div class="card item-box">' ; 
				echo '<div class="img-container">' ;
					
					if($item["image"] !=''){
						echo '<img src="admin\upload\images\\' . $item["image"] . '" class="img-fluid" alt="pro-phot">'  ;
					}else{
						echo '<img src="admin\upload\images\constad.jpg" class="img-fluid" alt="pro-const-phot">'  ;
					}
				echo '</div>';

					echo '<div class="caption">' ; 

						echo '<h5 class="card-title"><a href="items.php?id=' . $item['item_id'] . '">' . $item['item_name'] . '</a></h5>' ; 

						echo '<p class="card-text lead">' . $item['item_desc'] . '</p>' ;

						echo '<span class="price">' . $item['price'] . '$</span>' ;
						echo '<div class="card-date">' . $item['add_date'] . '</div>' ; 

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
		
		// Echo No Date If Categorey Have No Data

		echo '<div class="empty col-sm-12 col-md-12"><h2 class="h1">There Is No Data</h2></div>' ;
	
	}

	echo '</div>';

	include $tmpls . 'footer.php' ; 