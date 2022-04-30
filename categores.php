
<?php

	// categoers.php
	session_start() ; 

	$pageTitle = "categores" ; 

	
	if(isset($_GET["catName"]) && $_GET["catName"] != ''){
		$pageTitle=$_GET["catName"] ; 
	}
	include "init.php" ;
		
	$item_count = 30 ; 
	$page = '';
	if(isset($_GET["page"])){
		$page = $_GET["page"] ; 
	} else{
		$page = 1; 
	}
	$start_from = ( $page - 1 ) * $item_count ; 



	echo '<div class="container">' ;
	
	// Get Page Name From Link
	
	
	
	echo '<div class="text-center"><h2 class="h1">Categores</h2></div>' ; 
	
	// Get Category Id From Link

	$catId = intval($_GET["pageId"]) ;
	// Get All Items Related With This Categorey Helping By $catId

	$items = getItems($catId, $start_from, $item_count) ;
	$count = getItemsConut($catId); 

	// Echo All Items Inner CAtegorey If Exist
	// echo '<div class="text-center"><h2 class="h1">Categorey [ '.$item["name"].' ] </h2></div>' ; 

	if(!empty($items)){ 
		$i = 0 ; 
			// get all cat subcategory
			$subCats = getSubCatsOf($catId) ;
			if(!empty($subCats)){?>
				<div class="row">
					<ul class="list-unstyled">
						<li>
							<div class="row">
								<div class="col-sm-3 d-inline-block">
									SubCategories
									<span>
										:
									</span>
								</div>

								<div class="col-sm-8 d-inline-block">
									<?php 
										foreach ($subCats as $subCat) {
											echo '<span class="tag subcat"><a href="categores.php?pageId=' . $subCat["id"] . '&catName=' . $subCat["name"] . '">' . $subCat["name"] . '</a></span>' ; 
										}
									?>
								</div>
							</div>
						</li> 
					</ull>
				
				</div><?php 
			}
		echo '<div class="row justify-content-left">' ;

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
		echo '</div>';?>
		
		<!-- Start Pagination -->
		<div class='row'>
			<div class="col-sm-6 offset-3" >
				<div>
					<nav>
						<ul class="pagination pagination-sm justify-content-center">
							<?php
								$pages_count = ceil($count/$item_count);
								if($pages_count>=1){
									echo '<li class="page-item '; if($_GET["page"] ==1 || !isset($_GET["page"]) ){ echo 'active' ; } echo '" aria-current="page"><a class="page-link" href="?pageId='.$catId.'&catName='.$pageTitle.'&page=1">1</a></li>';
								}
								for($i = 2; $i<=$pages_count;$i++){
									echo '<li class="page-item '; if($_GET["page"] ==$i){ echo 'active' ; } echo '" aria-current="page">';
										echo '<a class="page-link" href="?pageId='.$catId.'&catName='.$pageTitle.'&page='.$i.'">'.$i.'</a>';
									echo '</li>';
								}
							?>
						</ul>
					</nav>
				</div>
			</div>
		</div>



		<!-- End Pagination -->
		
		<?php

	}else{
		
		// Echo No Date If Categorey Have No Data

		echo '<div class="empty col-sm-12 col-md-12"><h2 class="h1">There Is No Data</h2></div>' ;
	
	}

	echo '</div>';

	include $tmpls . 'footer.php' ; 