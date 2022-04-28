<?php
// index.php
ob_start() ; 
session_start();

$pageTitle='Shop' ; 
//include "init.php" ;
include "init.php" ;

$items = getAllItems() ;

// Echo All Items Inner CAtegorey If Exist

if(!empty($items)){ 
	$i = 0 ; 
	echo '<div class="container all-items">' ;
		echo '<div class="row justify-content-center">' ;

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
					echo '</div>' ; 

						echo '<div class="caption">' ; 

							echo '<h5 class="card-title"><a href="items.php?item_id=' . $item['item_id'] . '">' . $item['item_name'] . '</a></h5>' ; 

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
	echo '</div>';
}else{
	
	// Echo No Date If Categorey Have No Data

	echo '<div class="container"><div class="empty"><h2 class="h1">There Is No Data</h2></div></div>' ;

}

include $tmpls . 'footer.php' ; 
ob_end_flush() ; 
?>
