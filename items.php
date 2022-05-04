<?php 	

	
	ob_start() ;
	session_start() ;

	$pageTitle = "Items" ; 
	
	include 'init.php' ; 
	// Check Items Id
    $do = (isset($_GET["do"]))? $_GET["do"]:"Main" ;
    if($do == "Main"){
            
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
        <h2 class="h1 text-center"> <?php echo $item["item_name"].' Product' ; ?> </h2>  
        <div class="container">
            <div class="row">
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
                        <li>
                            <div class="row">
                                <div class="col-sm-4 d-inline-block">
                                    Item Description
                                    <span>
                                        :
                                    </span>
                                </div>
                                <div class="col-sm-8 d-inline-block <?php if(strlen($item["item_desc"]) > 64){ echo 'text-truncate' ;} ?> desc">
                                    <?php echo $item["item_desc"]?>
                                </div>
                            </div>
                        </li>



                        <li>
                            <div class="row">
                                <div class="col-sm-4 d-inline-block">
                                    Item Price
                                    <span>
                                        :
                                    </span>
                                </div>

                                <div class="col-sm-8 d-inline-block">
                                    <?php echo $item["price"]?>  
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-sm-4 d-inline-block">
                                    Item Country
                                    <span>
                                        :
                                    </span>
                                </div>

                                <div class="col-sm-8 d-inline-block">
                                    <?php echo $item["country"]?>  
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-sm-4 d-inline-block">
                                    Item Rating
                                    <span>
                                        :
                                    </span>
                                </div>

                                <div class="col-sm-8 d-inline-block">
                                    <?php echo $item["rating"]?>  
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-sm-4 d-inline-block">
                                    Item Status
                                    <span>
                                        :
                                    </span>
                                </div>

                                <div class="col-sm-8 d-inline-block">
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
                                                echo 'VeryOld' ; 
                                        }
                                    ?>
                                </div>
                            </div>
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
                        <li>
                            <div class="row">
                                <div class="col-sm-4 d-inline-block">
                                    Item Category
                                    <span>
                                        :
                                    </span>
                                </div>

                                <div class="col-sm-8 d-inline-block">
                                    <a href="categores.php?pageId=<?php echo $item['catId'] ; ?>"><?php echo $item["category"]?></a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-sm-4 d-inline-block">
                                    Item Publisher
                                    <span>
                                        :
                                    </span>
                                </div>

                                <div class="col-sm-8 d-inline-block">
                                    <a href="profile.php<?php echo $qq; ?>"><?php echo $item["publisher"]?></a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-sm-4 d-inline-block">
                                    Tags
                                    <span>
                                        :
                                    </span>
                                </div>

                                <div class="col-sm-8 d-inline-block">
                                    <?php 
                                        $tags = explode(',', $item["item_tags"]);
                                        foreach ($tags as $tag) {
                                            $tag = str_replace(' ', '', $tag) ; 
                                            echo '<span class="tag"><a href="tags.php?name=' . $tag . '">' . $tag . '</a></span>' ; 
                                        }
                                    ?>
                                </div>
                            </div>
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
                        <div class="mb-3">
                            <label for="forRate" class="form-label">Rate</label>
                            <input type="text" class="form-control" id="forRate" name="rate" placeholder="Your Rate Regarding This Item is.." >
                        </div>
                                            
                        <div class="form-group bt">
                            <input class="btn btn-success btn-sm float-right" type="submit" name="submit" value="submit" />
                        </div>

                    </form>
            <?php 

                    // Check If USer Add Comment 

                    $errors = array() ; 

                    if( $_SERVER['REQUEST_METHOD'] == 'POST'){
                        $rate = 0 ; 
                        $comment = filter_var($_POST["comment"], FILTER_SANITIZE_STRING) ; 
                        $rate = filter_var($_POST["rate"], FILTER_SANITIZE_NUMBER_FLOAT) ; 
                        if($comment == '' || strlen($comment) < 11){
                            $errors[] = '<div class="alert alert-danger text-center">Please, Fill The Textarea Before Send Comment or Comment Should Be More Than 10 Characters</div>' ; 
                        }if($rate < 0){
                            $errors[] = '<div class="alert alert-danger text-center">Please, Enter an integer Value greater >= 0 </div>' ; 
                        }
                        if(empty($errors)){

                            // Add Comment To Database
                            //get current user id
                            $stmt = $con->prepare("SELECT * FROM users WHERE userName = ?");
                            $stmt -> execute(array($user)) ;   
                            $info = $stmt -> fetch() ; 

                            $stmt = $con->prepare("SELECT rating FROM items WHERE item_id = ?");
                            $stmt -> execute(array($item_id )) ;   
                            $item_info = $stmt -> fetch() ; 
                            //end getting
                            $stmt = $con->prepare("INSERT INTO comments(comment, item_id, user_id) VALUES(?, ?, ?)") ;
                            $stmt->execute(array($comment, $item_id, $info['userId'])) ;

                            $new_val = ($item_info["rating"] + $rate) / 2; 
                            $stmt = $con->prepare("UPDATE items SET rating = '".$new_val."' WHERE item_id = ".$item_id."") ;
                            $stmt->execute() ;
                            echo '<div class="good text-center">Your responce Successfully Add</div>'  ;
                        }else{

                            foreach ($errors as $error) {
                                echo $error ; 
                            }
                        }
                    }

                }else{
                    echo '<p class="bad text-center">You Should Login To Comment At This Ada</p>' ;
                }
            ?>
            <hr class="cutom-row">
            <div class="row">
                <div class="commenter">
                        
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
                                echo '<ul class="list-unstyled">' ; 
                                foreach ($rows as $row) {?>
                                    <li>
                                        <div class="row">
                                            <div class="user col-sm-3 d-inline-block">
                                                <?php echo $row["user"] ; ?>
                                            </div>
                                            <div class="comment col-sm-9 d-inline-block">
                                                <div class="<?php if(strlen($row["comment"]) > 30){ echo 'text-truncate' ;} ?> ">
                                                    <?php echo $row['comment'] ; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li><hr><?php

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
                                }
                                echo '</ul>' ; 
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

    }elseif($do =="Manage"){
        //Manage my ads only
        if(isset($_SESSION["user"])){
            $userSessionedId = $_SESSION["uid"] ; 
            $item_count = 10 ; 
            $page = '';
            if(isset($_GET["page"])){
                $page = $_GET["page"] ; 
            } else{
                $page = 1; 
            }
            $start_from = ( $page - 1 ) * $item_count ; 
    
            
            echo '<h2 class="h1 text-center">Mange My Items</h2>' ;  
            $stmt = $con->prepare("SELECT 
                                        items.*, categores.name As category 
                                    FROM 
                                        items 
                                    INNER JOIN 
                                        categores 
                                    ON 
                                        categores.id = items.cat_id 
                                    WHERE items.member_id = $userSessionedId
                                    ORDER BY items.item_id DESC LIMIT $start_from, $item_count");
            $stmt->execute() ;
            $count = $stmt->rowCount() ;
            if($count){  ?>
                <div class="container">
        
                    <table class="table table-striped col-sm-12">
                        <thead>
                            <tr>
                                <th scope="col">Photo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Registerd Date</th>
                                <th scope="col">Country</th>
                                <th scope="col">Status</th>
                                <th scope="col">Category</th>
                                <th scope="col" class="text-center">Controle</th>
                            </tr>
                        </thead>
                    <tbody> <?php
                    $rows = $stmt->fetchAll() ;
                    foreach($rows as $row){ ?>
                        <tr>
                            <td>
                                <?php 
                                    $img_arr = explode('/',$row["image"]);
                                    if(!empty($img_arr)){
                                        if(isset($_GET["item_id"]) &&$_GET["item_id"] !='' && count($img_arr) > 1){
                                            //slider ere
                                            //print_r($img_arr) ; 
                                            echo "SLIDER" ; 
                                        }else{
                                            echo '<a href="items.php?item_id='.$row["item_id"].'"><img src="admin\upload\images\\' . $img_arr[0] . '" class="avatar img-fluid img-thumbnail rounded-circle" alt="pro-photo"></a>'  ;
                                        }
                                    }else{
                                        echo '<a href="items.php?item_id='.$row["item_id"].'"><img src="admin\upload\images\constad.jpg" class="avatar img-fluid img-thumbnail rounded-circle" alt="const-pro"></a>'  ;
                                    }
    
    
                                ?>
                                    
                            </td>
                            <td><?php echo $row["item_name"] ;  ?></td>
                            <td><?php echo $row["price"] ;  ?></td>
                            <td><?php echo $row["add_date"] ; ?></td>
                            <td><?php echo $row["country"] ; ?></td>
                            <td>
                                <?php 
                                    if($row["status"] == 1){
                                        echo 'New' ; 
                                    }elseif($row["status"] == 2){
                                        echo 'Like New' ; 
                                    }elseif($row["status"] == 3){
                                        echo 'Used' ; 
                                    }elseif($row["status"] == 4){
                                        echo 'Old' ; 
                                    }elseif($row["status"] == 5){
                                        echo 'VeryfOld' ; 
                                    }
                                ?>
                            </td>
                            <td>
                                <a href="categores.php?pageId=<?php echo $row["cat_id"] ; ?>&catName=<?php echo $row["category"] ; ?>"><?php echo $row["category"] ; ?></a>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-md"href="?do=Edit&item_id=<?php echo $row["item_id"] ;  ?>"><i class="fa fa-edit fw"></i></a>
                                <a class="btn btn-danger btn-md confirm" href="?do=Delete&item_id=<?php echo $row["item_id"] ;  ?>"><i class="fa fa-times"></i></a>
                                <?php 
                                    if( $row["apporove"] == 0 ){ 
                                        echo '<a class="btn btn-info btn-md confirm" href="?do=Approve&item_id='.$row["item_id"].'"> '; 
                                            echo '<i class="fa fa-check"></i>' ;
                                        echo '</a>'; 
                                    } 
                                ?>
                            </td>
                        </tr><?php 
                    } ?>
                        </tbody>
                    </table>
                </div><?php   
            }else{
                echo "<div class='container alert alert-danger text-center' style='margin-top:100px'><h2 class='h1'>There Is No data !!</h2></div>" ; 
            } ?>
    
            <div class='container'>
                <div class='row justify-content-end'>
                    <div class="col-sm-10">
                        <div class="">
                            <nav>
                                <ul class="pagination pagination-sm">
                                    <?php
                                        $stmt = $con->prepare("SELECT 
                                        items.*, categores.name As category 
                                        FROM 
                                            items 
                                        INNER JOIN 
                                            categores 
                                        ON 
                                            categores.id = items.cat_id 
                                        WHERE items.member_id = $userSessionedId 
                                        ORDER BY items.item_id DESC");
                                        $stmt->execute() ;
                                        $count = $stmt->rowCount() ;
                                        $pages_count = ceil($count/$item_count);
                                        if($pages_count>=1){
                                            echo '<li class="page-item '; if($_GET["page"] ==1 || !isset($_GET["page"]) ){ echo 'active' ; } echo '" aria-current="page">';
                                                echo '<a class="page-link" href="?do=Manage&page=1">1</a>';
                                            echo '</li>';
                                        }
                                        for($i = 2; $i<=$pages_count;$i++){
                                            echo '<li class="page-item '; if($_GET["page"] ==$i){ echo 'active' ; } echo '" aria-current="page">';
                                                echo '<a class="page-link" href="?do=Manage&page='.$i.'">'.$i.'</a>';
                                            echo '</li>';
                                        }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
  <?php }else{
            echo "YOU ARE NOT ALLAWED TO BE HERE" ; 
        }
    }elseif($do == "Edit"){
        $item_id = isset($_GET["item_id"]) && is_numeric($_GET["item_id"]) ? intval($_GET["item_id"]) : 0 ;  
        $stmt = $con -> prepare("SELECT * FROM items WHERE item_id = ?") ;
        $stmt -> execute(array($item_id)) ;
        $count = $stmt -> rowCount() ; 
        if($count){
            $item= $stmt->fetch() ; ?>
            <h2 class="text-center h1">Edit Item</h2>
            <div class="container">   
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card item-box">
                            <?php 
                                $img_arr = explode('/',$item["image"]);
                                if(!empty($img_arr)){
                                    if(isset($_GET["item_id"]) &&$_GET["item_id"] !='' && count($img_arr) > 1){ ?> 
                                        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
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
                                    <?php }else{
                                        echo '<img src="admin\upload\images\\' . $img_arr[0] . '" class="img-fluid" alt="pro-photo">'  ;
                                        echo "<div><strong><code>multi photos don't supported</code></strong></div>";
                                    }
                                }else{
                                    echo '<img src="admin\upload\images\constad.jpg" class="avatar img-fluid img-thumbnail rounded-circle" alt="const-pro">'  ;
                                }
                                //echo '<img src="upload\images\\' . $item["image"] . '" class="img-fluid">'  ;
                            ?>
                        </div> 
                    </div> 
                    <div class="col-sm-8 float-right">
                        <form class="editform" action="?do=Update" method="POST" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $item_id ; ?>" name="itemId">
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Name</strong></label>
                                <div class="col-sm-10">
                                <input type="text" 
                                        class="form-control col-sm-10 float-right" 
                                        id="inputUsername" 
                                        name="name" 
                                        autocomplete="off" 
                                        required 
                                        placeholder="Enter Item Name" 
                                        value="<?php echo $item["item_name"]?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Avatar</strong></label>
                                <div class="col-sm-10">
                                <input required type="file" class="form-control col-sm-10 float-right" id="inputUsername" name="image[]" value="" multiple>
                                </div>
                            </div>                    

                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Desc</strong></label>
                                <div class="col-sm-10">
                                <input type="text" 
                                        class="form-control col-sm-10 float-right" 
                                        id="inputUsername" 
                                        name="description" 
                                        autocomplete="off"
                                        required
                                        placeholder="Enter Item Description" 
                                        value="<?php echo $item["item_desc"]?>"/>
                                </div>
                            </div>                    
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Price</strong></label>
                                <div class="col-sm-10">
                                <input type="text" 
                                        class="form-control col-sm-10 float-right" 
                                        id="inputUsername" 
                                        name="price" 
                                        autocomplete="off"
                                        required
                                        placeholder="Enter Item Price" 
                                        value="<?php echo $item["price"]?>"/>
                                </div>
                            </div>                    
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Country</strong></label>
                                <div class="col-sm-10">
                                <input type="text" 
                                        class="form-control col-sm-10 float-right" 
                                        id="inputUsername" 
                                        name="country" 
                                        autocomplete="on"
                                        required
                                        placeholder="Enter Item Country Made" 
                                        value="<?php echo $item["country"]?>" />
                                </div>
                            </div>                    
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Status</strong></label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-control col-sm-10">
                                        <option value="1" <?php if($item["status"] == 1 ){ echo "selected" ; } ?>>New</option>
                                        <option value="2" <?php if($item["status"] == 2 ){ echo "selected" ; } ?>>Like New</option>
                                        <option value="3" <?php if($item["status"] == 3 ){ echo "selected" ; } ?>>Used</option>
                                        <option value="4" <?php if($item["status"] == 4 ){ echo "selected" ; } ?>>Old</option>
                                        <option value="5" <?php if($item["status"] == 5 ){ echo "selected" ; } ?>>Very Old</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Tags</strong></label>
                                <div class="col-sm-10">
                                <input type="text" 
                                        class="form-control col-sm-10 float-right" 
                                        id="inputUsername" 
                                        name="tags" 
                                        autocomplete="off"
                                        placeholder="Enter Item Tags EX:// tag," 
                                        value="<?php echo $item["item_tags"]?>" />
                                </div>
                            </div>               
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Category</strong></label>
                                <div class="col-sm-10">
                                    <select name="category" class="form-control col-sm-10">
										<?php
											
										$stmt = $con->prepare("SELECT * FROM categores Where visibilty=0 AND parent=0") ;
										$stmt -> execute() ; 
										$cats = $stmt -> fetchAll() ;
										foreach($cats as $cat ){
											echo '<optgroup label="'.$cat["name"].'">' ; 
											$subCats = getSubCatsOf($cat["id"]) ; 
											foreach ($subCats as $subCat) {
                                                    if( $item["cat_id"] == $subCat["id"] ){
                                                        echo '<option value="'.$subCat["id"].'" selected>'.$subCat["name"].'</option>' ; 
                                                    }else{
                                                        echo '<option value="'.$subCat["id"].'">'.$subCat["name"].'</option>' ; 
                                                    }
												}
										}
											
										
										?> 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-10">
                                    <input type="submit" class="col-sm-2 btn btn-danger float-end btn-md" value="Update"> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <?php
        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">Sorry There Is No Items Here</h2></div>' ; 
            $errTime = 3;
            $page ="Home" ; 
            $url = "index.php" ; 
            redirect($errMes, $errTime, $page, $url) ;
        }

    }elseif($do=="Update"){
        
        $allowedExetintion = array("jpeg", "jpg", "png", "gif") ;
        $errors = array() ; 
        echo '<h2 class="text-center h1">Update Items</h2>' ;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $itemId =       $_POST["itemId"] ;
            $itemName       = $_POST["name"]  ;
            $description    = $_POST["description"]  ;
            $price          = $_POST["price"]  ;
            $country        = $_POST["country"] ; 
            $status         = $_POST["status"] ; 
            $category       = $_POST["category"] ;
            $tags           = $_POST["tags"] ; 

            $errors = [] ; 
            if(empty($itemName) || strlen($itemName) < 3){
                $errors[] ="<div class='alert alert-danger'>You Should Enter Your Username And Not Less Than 4 Character</div>" ; 
            }
            if(empty($description) || strlen($description) < 10){
                $errors[] ="<div class='alert alert-danger'>You Should Enter Item Description Or Description Characters Should Be More Than 10 </div>" ; 
            }
            if(empty($price)){
                $errors[] ="<div class='alert alert-danger'>You Should Enter Item Price</div>" ; 
            }
            if(empty($country) || strlen($country) < 4){
                $errors[] ="<div class='alert alert-danger'>You Should Enter Your Country And It Should More Than 4 Characters</div>" ; 
            }
            $image='' ; 
            $allImage='' ; 
            foreach($_FILES["image"]["tmp_name"] as $key => $value){
                $imageName = $_FILES["image"]["name"][$key] ;
                $imageTmp  = $_FILES["image"]["tmp_name"][$key] ;
                $imageType = $_FILES["image"]["type"][$key] ; 
                $imageSize = $_FILES["image"]["size"][$key] ;
                
        
                $imageExtention = explode('.', $imageName) ;
                
                $imageExtention = strtolower($imageExtention[1]) ; 
                if($imageName == ''){
                    $errors[] ="<div class='alert alert-danger'> Upload Your Image</div>" ;  
                
                }if(!in_array($imageExtention, $allowedExetintion) && !empty($imageName)){
                    $errors[] ="<div class='alert alert-danger'>This Extention is Not <strong>Allowed</strong></div>" ;   
                }if($imageSize > 4194304){
                    $errors[] ="<div class='alert alert-danger'>Image Size Can Not be More Than 4mb</div>" ; 
                }
                if(empty($errors)){
                    $image = rand(0, 1000000) . '_' . $imageName ; 
                    move_uploaded_file($imageTmp, "admin\upload\images\\" . $image );
                    $allImage .= $image.'/';
                }
            }
            $allImage = $image;


            if(empty($errors)){
               // tags work
                $t ='' ; 
                if($status == 1){
                    $t .=  'New' ;
                }elseif($status == 2){
                    $t .=  'LikeNew' ;
                }elseif($status == 3){
                    $t .=  'Used' ;  
                }elseif($status == 4){
                    $t .=  'Old' ;  
                }elseif($status == 5){
                    $t .=  'VeryOld' ;
                }
                $arr = array("New", "LikeNew", "Old", "veryOld", "Used");
                $tags_arr = explode(', ', $tags);//all new tags value
                $ii = 0 ; 
                foreach($tags_arr as $i){
                    if(in_array($i, $arr)){
                        $tags_arr[$ii] = $t ;
                    }
                    $ii++ ; 
                }
                $tags = join(', ',$tags_arr) ; 

                $stmt = $con -> prepare("UPDATE items SET item_name=?, image=?, item_desc=?, price=?, country=?, status=?, cat_id=?, item_tags=? WHERE item_id = ?") ; 
                $stmt -> execute(array($itemName, $allImage, $description, $price, $country, $status, $category, $tags, $itemId)) ; 

                echo '<h2 class="h1">'.$stmt->rowCount().'</h2>' ; 
            }else{
                echo "<div class='container' style='margin-top:50px'>" ; 
                foreach($errors as $error){
                    echo  $error ;
                }
                echo "</div>" ;
                echo '<div class="text-center" style="margin-top:50px"><a class="btn btn-danger btn-lg" 
                     style="" href="?do=Edit&item_id='.$itemId.'"><i class="fa fa-angle-double-left"></i></a></div>' ;
            }

        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">You Cante Browise This Page Directly</h2></div>' ; 
            $errTime = 2;
            $back = '?do=Mange' ; 
            $page ='Items' ; 
            redirect($errMes, $errTime, $page, $back) ;
        }
    }elseif($do=="Delete"){

        $item_id = isset($_GET["item_id"]) && is_numeric($_GET["item_id"]) ? $_GET["item_id"] : 0 ;
        if($item_id){
            $check = checkItem('item_id', 'items', $item_id) ; 
            if($check > 0){
                $stmt = $con -> prepare("DELETE FROM items WHERE item_id = ?") ;
                $stmt -> execute(array($item_id)) ;
                echo '<div class="alert alert-success container text-center" style="margin-top:200px"><h2 class="h1">Items Success Deleted</h2></div>' ; 
                header("refresh:1;url=items.php?do=Manage") ; 
            }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">There Is No Item With This ID '.$item_id.'</h2></div>' ; 
                $errTime = 1; 
                redirect($errMes, $errTime) ;                
            }
        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">You Cant Enter This Page</h2></div>' ; 
            $errTime = 3; 
            $page = "Items" ; 
            $url = '?do=Main' ; 
            redirect($errMes, $errTime, $page, $url) ;
        }
    }else{
        echo "HERE IS NOT A PAGE LIKE " . $do ; 
    }
    
	include $tmpls .'footer.php' ;
	
	
	ob_end_flush()  ;
?>