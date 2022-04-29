<?php 	

	
	ob_start() ;
	session_start() ;

	$pageTitle = "Items" ; 
	
	include 'init.php' ; 
	// Check Items Id

    $item_id 	= isset($_GET["item_id"]) && is_numeric($_GET["item_id"]) ? intval($_GET["item_id"]) : 0 ;  
    $stmt 		= $con -> prepare(" SELECT 
										items.*, userName As publisher, userId As userId, categores.name AS category ,categores.id AS catId 
									FROM 
										items 
									INNER JOIN 
										users 
									ON 
										users.userID = items.member_id
									INNER JOIN 
										categores 
									ON 
										categores.id = items.cat_id
									WHERE item_id = ?
                                    AND apporove = 1") ;
    
    $stmt -> execute(array($item_id)) ;
    $count 		= $stmt -> rowCount() ; 
    if($count){
    
        $item = $stmt->fetch() ;
?>
    <h2 class="h1 text-center"> <?php echo $item["item_name"] ; ?> </h2>  
    <div class="container">
        <div class="row justify-content-left">
    		<div class="col-md-4">
                <div class="card item-box">

                    <?php 
                        $img_arr = explode('/',$item["image"]);
                        if(!empty($img_arr)){
                            if(isset($_GET["item_id"]) && $_GET["item_id"] !='' && count($img_arr) > 1){
                    ?>
                                <!--  -->
                                <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                                    <!-- Indicators -->
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        <?php
                                            $counter = 0 ; 
                                            foreach ($img_arr as $i){
                                                // echo $counter+1 ; 
                                                $output ='' ; 
                                                if($counter == 0){
                                                    $output .= '<div class="carousel-item active">' ; 
                                                    $output .=      '<div class="img-container">' ; 
                                                    $output .=          '<img src="admin\upload\images\\'.$i.'" class="d-block w-100 img-fluid" alt="pro-photo">' ; 
                                                    $output .=      '</div>' ; 
                                                    $output .= '</div>' ; 
                                                }else{
                                                    $output .= '<div class="carousel-item">' ; 
                                                    $output .=      '<div class="img-container">' ; 
                                                    $output .=          '<img src="admin\upload\images\\'.$i.'" class="d-block w-100 img-fluid" alt="pro-photo">' ; 
                                                    $output .=      '</div>' ; 
                                                    $output .= '</div>' ; 
                                                }
                                                echo $output ; 
                                                $counter++ ; 
                                            }
                                        ?>
                                    </div>

                                    <!-- Controls -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <div><strong><code>multi photos supported</code></strong></div>
                            <?php
                            }else{
                                echo '<img src="admin\upload\images\\' . $img_arr[0] . '" class="img-fluid" alt="pro-photo">';
                                echo "<div><strong><code>multi photos don't supported</code></strong></div>";
                            }

                        }else{
                            echo '<img src="admin\upload\images\constad.jpg" class="img-fluid" alt="const-pro">'  ;
                        }
                    ?>
                </div>
            </div>
    		<div class="col-md-8 pies">

    			<h3><?php echo $item["item_name"]?></h3>
    			
    			<ul class="list-unstyled">
	    			<li><span>Item Description</span>: <?php echo $item["item_desc"]?></li>
	    			<li><span>Item Price</span>: <?php echo $item["price"]?></li>
	    			<li><span>Item Country</span>: <?php echo $item["country"]?></li>
	    			<li><span>Item Rating </span>: <?php echo $item["rating"]?></li>
	    			<li><span>Item Status </span>: 
                        <?php 
                            if($item["status"] == 1){
                                echo 'New' ; 
                            }elseif($item["status"] == 2){
                                echo 'Like New' ; 
                            }elseif($item["status"] == 3){
                                echo 'Used' ; 
                            }elseif($item["status"] == 4){
                                echo 'Old' ; 
                            }elseif($item["status"] == 5){
                                    echo 'VeryfOld' ; 
                            }
                        ?>
                    </li>
                    <?php
                    if(isset($_SESSION["user"])&& strtolower($_SESSION["user"]) != strtolower($item["publisher"])){
                        // && $_SESSION["user"] == strtolower($item["publisher"])
                        // echo  $_SESSION["user"]) ; 
                        $qq = '?publisher='.$item["publisher"] .'' ; 
                        // $qq = '' ; 
                    }elseif(isset($_SESSION["user"])&& strtolower($_SESSION["user"]) == strtolower($item["publisher"])){
                        $qq='' ; 
                    }else if(!isset($_SESSION["user"])){
                        $qq = '?guest=true&publisher='.$item["publisher"] .'' ; 
                    }
                    ?>
	    			<li><span>Item Category</span>: <a href="categores.php?pageId=<?php echo $item['catId'] ; ?>"><?php echo $item["category"]?></a></li>
	    			<li><span>Item Publisher</span>: <a href="profile.php<?php echo $qq; ?>"><?php echo $item["publisher"]?></a></li>
                    <li><span>Tags</span>:
                        <?php 
                            $tags = explode(',', $item["item_tags"]);
                            foreach ($tags as $tag) {
                                $tag = str_replace(' ', '', $tag) ; 
                                echo '<span class="tag"><a href="tags.php?name=' . $tag . '">' . $tag . '</a></span>' ; 
                            }
                        ?>
                    </li>
    			</ul>
    		
    		</div>
    	</div>
    	<hr class="cutom-row">
        
        <!--    Make User Who HAs Session  TO Add Comment At The Current Item   -->
        <?php 

            if(isset($_SESSION['user'])){ ?>
            
                <form class="formcomment" action="<?php echo $_SERVER['PHP_SELF'] . '?item_id=' . $item['item_id'] ; ?>" method="POST">
                    
                    <div class="form-group">
                        <textarea name="comment" rows="6" cols="40" class="form-control" placeholder="Enter Your Comment . . . ." required></textarea>
                    </div>
                    
                    <div class="form-group bt">
                        <input class="btn btn-success btn-sm float-right" type="submit" name="submit" value="Comment" />
                    </div>

                </form>
        <?php 

                // Check If USer Add Comment 

                $errors = array() ; 

                if( $_SERVER['REQUEST_METHOD'] == 'POST'){
                    $comment = filter_var($_POST["comment"], FILTER_SANITIZE_STRING) ; 
                    if($comment == '' || strlen($comment) < 11){
                        $errors[] = '<div class="alert alert-danger text-center">Please, Fill The Textarea Before Send Comment or Comment Should Be More Than 10 Characters</div>' ; 
                    }
                    if(empty($errors)){

                        // Add Comment To Database
                        //get current user id
                        $stmt = $con->prepare("SELECT * FROM users WHERE userName = ?");
                        $stmt -> execute(array($user)) ;   
                        $info = $stmt -> fetch() ; 
                        //end getting
                        $stmt = $con->prepare("INSERT INTO comments(comment, item_id, user_id) VALUES(?, ?, ?)") ;
                        $stmt->execute(array($comment, $item_id, $info['userId'])) ;
                        echo '<div class="good text-center">Your Comment Successfully Add</div>'  ;
                    }else{
                        echo $errors[0] ; 
                    }
                }

            }else{
                echo '<p class="bad text-center">You Should Login To Comment At This Ada</p>' ;
            }
        ?>
        <hr class="cutom-row">
    	<div class="commenter">
    		<div class="row">
	    		
    			<?php 

    				// Get All User Name Who Make Comment at This Item
    				
                    $stmt = $con->prepare(" SELECT 
    											comments.*, userName As user 
											FROM 
												comments 
											INNER JOIN 
												users 
											ON 
												comments.user_id = users.userId 
											WHERE comments.item_id = ? AND comments.c_status = 1") ;
    				$stmt->execute(array($item_id)) ;  

    				$rows = $stmt->fetchAll() ;
    				
                    $count = $stmt->rowCount() ; 
    				
    				if( $count){

    					foreach ($rows as $row) {
    						echo '<div class="user col-md-3">' . $row['user'] . '</div>' ;
    						echo '<div class="comment col-md-9">' ;
                                echo $row['comment'] ;
                                

                                /*
                                ==============================================================
                                == Check If Admins Activate This Comment 
                                == if the comment Activate It Will Appear
                                == else it Will Hidden 
                                == if The Comment Not Activat It Will Appear If And Only If 
                                == You Are The Commenter And The Comment Not Activate
                                ==============================================================
                                

                                if($row["user"] == $user ){

                                   echo '<span>UnderModeration</span>' ;  
                                }
                                */

                            echo '</div>' ; 
    					}
    				}else{
    					echo '<div class="col-md-3">There is no Users Make Comments at This Item Yet !</div>' ;
    					echo '<div class="col-md-9">There is no Comments at This Item Yet !</div>' ;
    				}
    			?>
				
			</div>
		</div>
    </div>

<?php
    
    }else{
    	echo '<div class="container">
            <div class="empty col-sm-12 col-md-12">THER IS NO ITEMS With This Id [ ' . $item_id . ' ] Or This Item Not Approve
            </div>
        </div>'  ;

    }
	
	include $tmpls .'footer.php' ;
	
	
	ob_end_flush()  ;
?>