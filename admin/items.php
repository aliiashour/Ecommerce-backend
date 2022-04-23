<?php

    // page.php
    ob_start() ; 
    session_start() ; 
    $pageTitle='Items' ; 
    if(isset($_SESSION["adminId"])){
        
        include "init.php" ; 
        
        $do = isset($_GET["do"]) ? $_GET["do"] : 'Mange' ; 

        if($do =="Mange"){

            $item_count = 5 ; 
            $page = '';
            if(isset($_GET["page"])){
                $page = $_GET["page"] ; 
            } else{
                $page = 1; 
            }
            $start_from = ( $page - 1 ) * $item_count ; 

            
            echo '<h2 class="h1 text-center">Mange Items</h2>' ;  
            $stmt = $con->prepare("SELECT 
                                        items.* , users.userName As publisher, categores.name As category 
                                    FROM 
                                        items 
                                    INNER JOIN 
                                        categores 
                                    ON 
                                        categores.id = items.cat_id 
                                    INNER JOIN 
                                        users 
                                    ON 
                                        users.userId = items.member_id
                                    ORDER BY items.item_id DESC LIMIT $start_from, $item_count");
            $stmt->execute() ;
            $count = $stmt->rowCount() ;
            if($count){
    //            echo $count ;  
                ?>

            <div class="container">

                <table class="table table-striped col-sm-12">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Registerd Date</th>
                            <th scope="col">Country</th>
                            <th scope="col">Status</th>
                            <th scope="col">Publisher</th>
                            <th scope="col">Category</th>
                            <th scope="col" class="text-center">Controle</th>
                        </tr>
                    </thead>
                <tbody>

    <?php

                $rows = $stmt->fetchAll() ;
                foreach($rows as $row){
                     

    ?>


                        <tr>
                            <th scope="row"><?php echo $row["item_id"] ;  ?></th>
                            <td>
                                <?php 
                                    
                                    if($row["image"] !=''){
                                        echo '<img src="upload\images\\' . $row["image"] . '" class="avatar img-fluid img-thumbnail rounded-circle">'  ;
                                    }else{
                                        echo '<img src="upload\images\const.jpg" class="avatar img-fluid img-thumbnail rounded-circle">'  ;
                                    }


                                ?>
                                    
                            </td>
                            <td><?php echo $row["item_name"] ;  ?></td>
                            <td><?php echo $row["item_desc"] ;  ?></td>
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
                            <td><?php echo $row["publisher"] ; ?></td>
                            <td><?php echo $row["category"] ; ?></td>
                            <td><a class="btn btn-warning btn-md"href="?do=Edit&item_id=<?php echo $row["item_id"] ;  ?>"><i class="fa fa-edit fw"></i> Edit</a>
                            <a class="btn btn-danger btn-md confirm" href="?do=Delete&item_id=<?php echo $row["item_id"] ;  ?>"><i class="fa fa-times fw confirm"></i> Delete</a>
                                <?php if( $row["apporove"] == 0 ){ echo '<a class="btn btn-info btn-md confirm" href="?do=Approve&item_id='.$row["item_id"].'"><i class="fa fa-check fw"></i> Activate</a>'; } ?>
                            </td>
                        </tr>
    <?php   } ?>
                    </tbody>
                </table>
                
            </div>

    <?php   }else{
                // there is no data into data base
                echo "<div class='container alert alert-danger text-center' style='margin-top:100px'><h2 class='h1'>There Is No data !!</h2></div>" ; 
            }  ?>

            <div class='container'>
                <div class="row">
                    <div class='col-sm-12'>
                        <div class="float-right">
                            <a class='btn btn-primary btn-lg' style='margin-bottom:20px' href='?do=Add'>
                                <i class='fa fa-plus'></i> 
                                Add Item
                            </a>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-sm-12" >
                        <div class="float-left">
                            <nav aria-label="...">
                                <ul class="pagination pagination-sm">
                                    <?php
                                            $stmt = $con->prepare("SELECT 
                                            items.* , users.userName As publisher, categores.name As category 
                                            FROM 
                                                items 
                                            INNER JOIN 
                                                categores 
                                            ON 
                                                categores.id = items.cat_id 
                                            INNER JOIN 
                                                users 
                                            ON 
                                                users.userId = items.member_id
                                            ORDER BY items.item_id DESC");
                                            $stmt->execute() ;
                                            $count = $stmt->rowCount() ;
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
            </div>
            
<?php
        }elseif ($do == "Add"){?>
            <h2 class="text-center h1">Add New Item</h2>
            <div class="container">    
                <form class="editform" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Name</strong></label>
                        <div class="col-sm-10">
                          <input type="text" 
                                 class="form-control col-sm-10 float-right" 
                                 id="inputUsername" 
                                 name="name" 
                                 autocomplete="off" 
                                 required 
                                 placeholder="Enter Item Name" />
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
                                 placeholder="Enter Item Description" />
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
                                 placeholder="Enter Item Price" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Avatar</strong></label>
                        <div class="col-sm-10">
                          <input required type="file" class="form-control col-sm-10 float-right" id="inputFullname" name="image" placeholder="">
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
                                 placeholder="Enter Item Country Made" />
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Status</strong></label>
                        <div class="col-sm-10">
                            <select name="status" class="form-control offset-sm-2 col-sm-10">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                                <option value="5">Very Old</option>
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
                                 placeholder="Enter Item Tags EX:// tag," />
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Category</strong></label>
                        <div class="col-sm-10">
                            <select name="category" class="form-control offset-sm-2 col-sm-10">
                                <option value="0">...</option>
                            <?php
                                
                               $stmt = $con->prepare("SELECT * FROM categores") ;
                               $stmt -> execute() ; 
                               $rows = $stmt -> fetchAll() ;
                               foreach($rows as $row ){
                                   echo '<option value="'.$row["id"].'">'.$row["name"].'</option>' ; 
                               }
                                   
                               
                            ?> 
                            </select>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Member</strong></label>
                        <div class="col-sm-10">
                            <select name="member" class="form-control offset-sm-2 col-sm-10">
                                <option value="0">...</option>
                            <?php
                                
                               $stmt = $con->prepare("SELECT * FROM users") ;
                               $stmt -> execute() ; 
                               $rows = $stmt -> fetchAll() ;
                               foreach($rows as $row ){
                                   echo '<option value="'.$row["userId"].'">'.$row["userName"].'</option>' ; 
                               }
                                   
                               
                            ?> 
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="submit" class="btn btn-success float-right btn-md" value="Add Item"> 
                        </div>
                    </div>
                </form>
            </div>
   <?php }elseif ($do == "Insert"){
            echo '<h2 class="text-center h1">Insert Item</h2>' ; 
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                if($_POST["name"] !=''){


                    // Get Uploded File Info

                    $imageName = $_FILES["image"]["name"] ;
                    $imageTmp  = $_FILES["image"]["tmp_name"] ;
                    $imageType = $_FILES["image"]["type"] ; 
                    $imageSize = $_FILES["image"]["size"] ;

                    // Exetinstion Allowed To Upload

                    $allowedExetintion = array("jpeg", "jpg", "png", "gif") ;

                    $imageExtention = explode('.', $imageName) ;
                    
                    $imageExtention = strtolower($imageExtention[1]) ; 

                    $name           = $_POST["name"]  ;
                    $description    = $_POST["description"]  ;
                    $price          = $_POST["price"] ; 
                    $country        = $_POST["country"] ; 
                    $status         = $_POST["status"] ; 
                    $category       = $_POST["category"] ; 
                    $member         = $_POST["member"] ;
                    $tags           = $_POST["tags"] ;
                    $errors = [] ; 
                    if(empty($name) || strlen($name) < 3){
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
                    if( $status == 0){
                        $errors[] ="<div class='alert alert-danger'>You Should Enter The Item Status</div>" ; 
                    }
                    if( $category == 0){
                        $errors[] ="<div class='alert alert-danger'>You Should Enter The Item Category</div>" ; 
                    }
                    if( $member == 0){
                        $errors[] ="<div class='alert alert-danger'>You Should Enter The Item Member</div>" ; 
                    }if($imageName == ''){
                        $errors[] ="<div class='alert alert-danger'> Upload Your Image</div>" ;  
                    
                    }if(!in_array($imageExtention, $allowedExetintion) && !empty($imageName)){
                        $errors[] ="<div class='alert alert-danger'>This Extention is Not <strong>Allowed</strong></div>" ;   
                    }if($imageSize > 4194304){
                        $errors[] ="<div class='alert alert-danger'>Image Size Can Not be More Than 4mb</div>" ; 
                    }
            
                    if(empty($errors)){


                        $image = rand(0, 1000000) . '_' . $imageName ; 
                        move_uploaded_file($imageTmp, "upload\images\\" . $image ); 


                        $stmt = $con->prepare("INSERT INTO 
                                                        items(item_name, item_desc, price, country, status, add_date, cat_id, member_id, item_tags, image) 
                                               VALUES(:zx, :zxx, :zxxx, :zxxxx, :zxxxxx, now(), :zxxxxxx, :zxxxxxxx, :zxxxxxxxx, :zxxxxxxxxx)") ; 
                        $stmt->execute(array(
                            'zx'        => $name,
                            'zxx'       => $description,
                            'zxxx'      => $price,
                            'zxxxx'     => $country,
                            'zxxxxx'    => $status,
                            'zxxxxxx'   => $category,
                            'zxxxxxxx'  => $member,
                            'zxxxxxxxx' => $tags,
                            'zxxxxxxxxx'=> $image
                        ));

                        $errMes = '<div class="container alert alert-success text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;"> Item Success Add </h2></div>' ; 
                        $errTime = 1;
                        $url='?do=Add';
                        $page ='Add' ; 
                        redirect($errMes, $errTime, $page ,$url) ;

                    }else{
                        
                        echo "<div class='container' style='margin-top:50px'>" ; 
                        foreach($errors as $error){
                            echo  $error ; 
                        }
                        echo "</div>" ;
                        echo '<div class="text-center" style="margin-top:50px"><a class="btn btn-danger btn-lg" 
                             style="" href="?do=Add"><i class="fa fa-angle-double-left"></i> '.lang("ERROR").'</a></div>' ;
                    }
                }else{
                    $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;"> Please Fill The Item Name Field </h2></div>' ; 
                    $errTime = 4;
                    $url='?do=Add';
                    $page ='Add' ; 
                    redirect($errMes, $errTime, $page ,$url) ;
                }
            }else{

                $errMes = '<h2 class="text-center h1" 
                        style="margin: 60px 0px 25px;
                        color: #675858;">
                        '.lang('CEUP').
                    '</h2>' ; 
                    $errTime = 3;
                    $url='categores.php';
                    $page ='Mange' ; 
                    redirect($errMes, $errTime, $page ,$url) ;
            }

        }elseif ($do == "Edit"){
            $item_id = isset($_GET["item_id"]) && is_numeric($_GET["item_id"]) ? intval($_GET["item_id"]) : 0 ;  
            $stmt = $con -> prepare("SELECT * FROM items WHERE item_id = ?") ;
            $stmt -> execute(array($item_id)) ;
            $count = $stmt -> rowCount() ; 
            if($count){
                $item= $stmt->fetch() ; 

?>
                <h2 class="text-center h1">Edit Item</h2>
                <div class="container">   
                    <div class="row">
                        <div class="col-sm-4 float-left">
                            <?php 
                                echo '<img src="upload\images\\' . $item["image"] . '" class="img-fluid">'  ;
                            ?>
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
                                    <input required type="file" class="form-control col-sm-10 float-right" id="inputUsername" name="image" value="sdfghj">
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
                                            value="<?php echo $item["country"]?>"/>
                                    </div>
                                </div>                    
                                <div class="form-group row">
                                    <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Status</strong></label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-control offset-sm-2 col-sm-10">
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
                                        <select name="category" class="form-control offset-sm-2 col-sm-10">
                                        <?php

                                        $stmt = $con->prepare("SELECT * FROM categores") ;
                                        $stmt -> execute() ; 
                                        $rows = $stmt -> fetchAll() ;
                                        foreach($rows as $row ){
                                            echo '<option value="'.$row["id"].'"'; 
                                            if( $item["cat_id"] == $row["id"] ){ echo "selected" ; } 
                                            echo '>' . $row["name"] . '</option>' ; 
                                        }


                                        ?> 
                                        </select>
                                    </div>
                                </div>                    
                                <div class="form-group row">
                                    <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Member</strong></label>
                                    <div class="col-sm-10">
                                        <select name="member" class="form-control offset-sm-2 col-sm-10">
                                        <?php

                                        $stmt = $con->prepare("SELECT * FROM users") ;
                                        $stmt -> execute() ; 
                                        $rows = $stmt -> fetchAll() ;
                                        foreach($rows as $row ){ 
                                            echo '<option value="'.$row["userId"].'"' ; 
                                            if( $item["member_id"] == $row["userId"] ){ echo "selected" ;  }
                                            echo '>' . $row["userName"] . '</option>' ;
                                        }


                                        ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <input type="submit" class="btn btn-danger float-right btn-md" value="Update Item"> 
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="editItemComments">
                        <h2 class='text-center h1'style='margin: 30px 0px 25px;color: #675858;'>Mange [ <?php echo $item['item_name'] ?> ] Comments</h2> ;
                        <?php 

                        $stmt = $con->prepare("SELECT 
                                                    comments.*, userName As userName
                                            FROM 
                                                    comments 
                                            INNER JOIN 
                                                    users 
                                            ON 
                                                    comments.user_id = users.userId 
                                            INNER JOIN 
                                                    items 
                                            ON 
                                                    comments.item_id = items.item_id WHERE items.item_id = $item_id");
                        $stmt->execute() ;
                        $count = $stmt->rowCount() ;
                        if($count){
                            //            echo $count ;  
                                ?>

                            
                                <table class="table table-striped col-sm-12">
                                    <thead>
                                        <tr>
                                            <th scope="col">#ID</th>
                                            <th scope="col">comment</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col" colspan="3" class="text-center">Controle</th>
                                        </tr>
                                    </thead>
                                <tbody>

                            <?php

                                $rows = $stmt->fetchall() ; 
                                foreach($rows as $row){

                            ?>


                                        <tr>
                                            <th scope="row"><?php echo $row["c_id"] ;  ?></th>
                                            <td><?php echo $row["comment"] ;  ?></td>
                                            <td><?php echo $row["c_date"] ;  ?></td>
                                            <td><?php echo $row["userName"] ; ?><td>
                                            <td><a class="btn btn-warning btn-md"href="comments.php?do=Edit&comId=<?php echo $row["c_id"] ;  ?>"><i class="fa fa-edit fw"></i> Edit</a>
                                            <a class="btn btn-danger btn-md confirm" href="comments.php?do=Delete&comId=<?php echo $row["c_id"] ;  ?>"><i class="fa fa-times fw confirm"></i> Delete</a>
                                            <?php
                                                if($row["c_status"] == 0 ){?>
                                                    <a class="btn btn-info btn-md confirm" href="comments.php?do=Approve&comId=<?php echo $row["c_id"] ;  ?>&b=?do=Mange"><i class="fa fa-check fw conform"></i> Approve</a>
                                                <?php }?>
                                            </td>
                                        </tr>
                            <?php }?>
                                    </tbody>
                                </table>

                            


                        <?php   }else{
                            // there is no data into data base
                            echo "<div class='container alert alert-danger text-center' style='margin-top:100px'><h2 class='h1'>There Is No data !!</h2></div>" ; 
                        }  ?>
                    </div>
                </div> 
<?php
            }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">Sorry There Is No Items Here</h2></div>' ; 
                $errTime = 3;
                $page ="Home" ; 
                $url = "index.php" ; 
                redirect($errMes, $errTime, $page, $url) ;
            }
        }elseif ($do == "Update"){
            echo '<h2 class="text-center h1">Update Items</h2>' ;
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $itemId = $_POST["itemId"] ;
                $itemName       = $_POST["name"]  ;
                $description    = $_POST["description"]  ;
                $price          = $_POST["price"]  ;
                $country        = $_POST["country"] ; 
                $status         = $_POST["status"] ; 
                $category       = $_POST["category"] ;
                $member         = $_POST["member"] ;
                $tags           = $_POST["tags"] ; 


                $imageName = $_FILES["image"]["name"] ;
                $imageTmp  = $_FILES["image"]["tmp_name"] ;
                $imageType = $_FILES["image"]["type"] ; 
                $imageSize = $_FILES["image"]["size"] ;
                

                $allowedExetintion = array("jpeg", "jpg", "png", "gif") ;

                $imageExtention = explode('.', $imageName) ;
                
                $imageExtention = strtolower($imageExtention[1]) ; 
        

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
                if(!in_array($imageExtention, $allowedExetintion) && !empty($imageName)){
                    $errors[] ="<div class='alert alert-danger'>This Extention is Not <strong>Allowed</strong></div>" ;   
                }if($imageSize > 4194304){
                    $errors[] ="<div class='alert alert-danger'>Image Size Can Not be More Than 4mb</div>" ; 
                }

                if(empty($errors)){
                    $image = rand(0, 1000000) . '_' . $imageName ; 
                    move_uploaded_file($imageTmp, "upload\images\\" . $image ); 

                    $stmt = $con -> prepare("UPDATE items SET item_name=?, image=?, item_desc=?, price=?, country=?, status=?, cat_id=?, member_id=?, item_tags=? WHERE item_id = ?") ; 
                    $stmt -> execute(array($itemName, $image, $description, $price, $country, $status, $category, $member, $tags, $itemId)) ; 

                    echo '<h2 class="h1">'.$stmt->rowCount().'</h2>' ; 
                }else{
                    echo "<div class='container' style='margin-top:50px'>" ; 
                    foreach($errors as $error){
                        echo  $error ;
                    }
                    echo "</div>" ;
                    echo '<div class="text-center" style="margin-top:50px"><a class="btn btn-danger btn-lg" 
                         style="" href="?do=Edit&item_id='.$itemId.'"><i class="fa fa-angle-double-left"></i> Backc</a></div>' ;
                }

            }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">You Cante Browise This Page Directly</h2></div>' ; 
                $errTime = 2;
                $back = '?do=Mange' ; 
                $page ='Items' ; 
                redirect($errMes, $errTime, $page, $back) ;
            }
        }elseif ($do == "Delete"){

            $item_id = isset($_GET["item_id"]) && is_numeric($_GET["item_id"]) ? $_GET["item_id"] : 0 ;
            if($item_id){
                $check = checkItem('item_id', 'items', $item_id) ; 
                if($check > 0){
                    $stmt = $con -> prepare("DELETE FROM items WHERE item_id = ?") ;
                    $stmt -> execute(array($item_id)) ;
                    echo '<div class="alert alert-success container text-center" style="margin-top:200px"><h2 class="h1">Items Success Deleted</h2></div>' ; 
                    header("refresh:1;url=items.php?do=Mange") ; 
                }else{
                    $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">There Is No Item With This ID '.$item_id.'</h2></div>' ; 
                    $errTime = 3; 
                    redirect($errMes, $errTime) ;                
                }
            }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">You Cant Enter This Page</h2></div>' ; 
                $errTime = 3; 
                $page = "Items" ; 
                $url = '?do=Manage' ; 
                redirect($errMes, $errTime, $page, $url) ;
            }
  
        }elseif ($do == "Approve"){
            
            $backTo = isset($_GET["dashbord"]) ? 'dashbord.php' : "?do=Mange" ; 
            
            $item_id = isset($_GET["item_id"]) && is_numeric($_GET["item_id"]) ? $_GET["item_id"] : 0 ; 
            
            $stmt = $con -> prepare("SELECT * FROM items WHERE item_id = $item_id") ;
            $count = $stmt -> execute() ; 
            $count = $stmt -> rowCount() ;
            
            if($count > 0 ){
                $stmt = $con -> prepare("UPDATE items SET apporove = 1 WHERE item_id = $item_id") ; 
                if($stmt ->execute()){
                    $errmes = '<div class="alert alert-success text-center mt-5"><h2 class="h1">Items Updated Successfully :D</h2></div>' ; 
                    $errTime = 2 ; 
                    $page = 'Forward' ; 
                    $url  = $backTo ; 
                    redirect($errmes, $errTime, $page, $url) ;
                }
                
            }else{
                $errmes = '<div class="alert alert-danger text-center mt-5"><h2 class="h1">Sorry, There Is No Item With This Id '.$item_id.'</h2></div>' ; 
                $errTime = 2 ; 
                $page ="Mange" ; 
                $url  = "?do=Mange" ; 
                redirect($errmes, $errTime, $page, $url) ; 
            }
        }
        
        include "$tmpls"."footer.php" ; 
        
        
    }else{
        header("location:index.php") ; 
        exit() ; 
    }
    ob_end_flush() ; 
?>