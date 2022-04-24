<?php
    ob_start();

    session_start() ; 

    $pageTitle="Categores" ; 

    if(isset($_SESSION["adminId"])){
        
        include "init.php" ; 
        $do = isset($_GET["do"]) ? $_GET["do"] : 'Mange' ; 
        
        if($do == "Mange"){
            $category_count = 2 ; 
            $page = '';
            if(isset($_GET["page"])){
                $page = $_GET["page"] ; 
            } else{
                $page = 1; 
            }
            $start_from = ( $page - 1 ) * $category_count ; 

            
            $sortArr = array("ASC", "DESC");
            $order = isset($_GET["sort"]) && in_array($_GET["sort"], $sortArr) ? $_GET["sort"] : "ASC"   ;
            $stmt = $con->prepare("SELECT * FROM categores WHERE parent = 0 ORDER BY ordering $order LIMIT $start_from, $category_count"); 
            $stmt -> execute() ;
            $cats = $stmt->fetchAll() ; ?>
            
            <div class="latest">
                <div class="container categores">
                    <h2 class="h1 text-center">Mange Categoers</h2>
                    <div class="row">
                        <div class="col-md-12 panel panel-default">
                            <div class="panel-heading">
                                    <i class="fas fa-puzzle-piece"></i> Categoers Name
                                <div class="ordering float-right">
                                    Ordering By : 
                                    <a href="?sort=ASC" class="<?php if($order=='ASC'){ echo "active" ;}?>">ASC</a> | 
                                    <a href="?sort=DESC" class="<?php if($order=='DESC'){ echo "active"; }?>">DESC</a>

                                </div>
                            </div>
                            <div class="panel-body">
                                <?php 
                                    echo '<div class="container">' ; 
                                    foreach($cats as $cat){
                                        echo '<div class="row">'; 
                                            echo '<div class="cat col-sm-12">';
                                                echo '<div class="hidden-buttons">' ;
                                                    echo '<a class="btn btn-warning btn-md" href="?do=Edit&catId='.$cat['id'].'"><i class="fa fa-edit"></i> Edit</a>' ;
                                                    echo '<a class="btn btn-danger btn-md confirm" href="?do=Delete&catId='.$cat['id'].'"><i class="fa fa-times"></i> Delete</a>' ; 
                                                echo '</div>'  ; 

                                                echo '<h4>'.$cat["name"].'</h4>' ;
                                                echo '<div class="toggleView">' ; 
                                                    echo '<p>' ; if(empty($cat["description"])){ echo 'This Category Has No description' ;  }else{ echo $cat["description"]; } echo '</p>' ;
                                                    if($cat["visibilty"] == 1){echo '<a class="btn btn-warning btn-md" href="#"><i class="fa fa-edit"></i> Visible It</a>' ;}
                                                    if($cat["allowComment"] == 1){echo '<a class="btn btn-info btn-md" href="#"><i class="fas fa-pencil-alt"></i> Make Comment</a>' ;}
                                                    if($cat["allowAds"] == 1){echo '<a class="btn btn-success btn-md" href="#"><i class="fas fa-eye"></i> Show Ads</a>' ;}
                                                echo '</div>' ; 
                                            echo '</div>' ;
                                        echo '</div>'; 
                                        
                                        // Make Nested Forloap To Show All This Main Category SubCategory If It Founded
                                        
                                        $stmt = $con->prepare("SELECT * FROM categores WHERE parent = ?"); 
                                        $stmt -> execute( array($cat['id']) ) ;
                                        $subcats = $stmt->fetchAll() ;
                                        if( !empty($subcats) ){
                                            foreach ($subcats as $subcat) {
                                                echo '<div class="row">';
                                                    echo '<div class="cat subcat col-sm-10 offset-sm-2">';
                                                    echo '<div class="hidden-buttons">' ;
                                                        echo '<a class="btn btn-warning btn-md" href="?do=Edit&catId='.$subcat['id'].'"><i class="fa fa-edit"></i> Edit</a>' ;
                                                        echo '<a class="btn btn-danger btn-md confirm" href="?do=Delete&catId='.$subcat['id'].'"><i class="fa fa-times"></i> Delete</a>' ; 
                                                    echo '</div>'  ; 

                                                    echo '<h4>'.$subcat["name"].'</h4>' ;
                                                    echo '<div class="toggleView">' ; 
                                                        echo '<p>' ; if(empty($subcat["description"])){ echo 'This Category Has No description' ;  }else{ echo $subcat["description"]; } echo '</p>' ;
                                                        if($subcat["visibilty"] == 1){echo '<a class="btn btn-warning btn-md" href="#"><i class="fa fa-edit"></i> Visible It</a>' ;}
                                                        if($subcat["allowComment"] == 1){echo '<a class="btn btn-info btn-md" href="#"><i class="fas fa-pencil-alt"></i> Make Comment</a>' ;}
                                                        if($subcat["allowAds"] == 1){echo '<a class="btn btn-success btn-md" href="#"><i class="fas fa-eye"></i> Show Ads</a>' ;}
                                                    echo '</div>' ; 
                                                    echo '</div>' ;
                                                echo '</div>';
                                                echo '<hr>' ;   
                                            }
                                        }else{
                                            echo '<div class="empty">There Is No Subcategorey at <strong>' . $cat["name"] . '</strong> Category</div>' ; 
                                        }


                                    }
                                    echo '</div>' ; 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            

            <div class='container'>
                <div class="row">
                    <div class='col-sm-12'>
                        <div class="float-right">
                            <a class='btn btn-primary btn-lg' style='margin-bottom:20px' href='?do=Add'>
                                <i class='fa fa-plus'></i> 
                                Add category
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
                                            $stmt = $con->prepare("SELECT * FROM categores WHERE parent = 0 ORDER BY ordering $order"); 
                                            $stmt->execute() ;
                                            $count = $stmt->rowCount() ;
                                            $cat_count = ceil($count/$category_count);
                                            if($cat_count>=1){
                                                echo '<li class="page-item '; if($_GET["page"] ==1 || !isset($_GET["page"]) ){ echo 'active' ; } echo '" aria-current="page"><a class="page-link" href="?page=1">1</a></li>';
                                            }
                                            for($i = 2; $i<=$cat_count;$i++){
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
<?php        }elseif ($do == "Add"){?>
        
<!--        the form to set new member data-->
        
            <h2 class="text-center h1">Add New Category</h2>
            <div class="container">    
                <form class="editform" action="?do=Insert" method="POST">
                    
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Name</strong></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control col-sm-10 float-right" id="inputUsername" name="name" autocomplete="off" required placeholder="Enter Category Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label"><strong>Description</strong></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control col-sm-10 float-right" id="inputPassword" name="description" placeholder="Enter Category Description" autocomplete="on" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label"><strong>Odering</strong></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control col-sm-10 float-right" id="inputEmail" name="ordering" autocomplete="off"  placeholder="Enter YNumber To Odering Categores">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Parent</strong></label>
                        <div class="col-sm-10">
                            <select name="parent" class="form-control offset-sm-2 col-sm-10">
                                <option value="0">None</option>
                            <?php
                                
                               $stmt = $con->prepare("SELECT * FROM categores WHERE parent = 0") ;
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
                        <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Visibilety</strong></label>
                        <div class="col-sm-10">
                            <div class="offset-md-2">
                                <input id="visyes" type="radio" name="visibilty" value="0" checked>
                                <label for="visyes">Yes</label>
                            </div>
                            <div class="offset-md-2">
                                <input id="visno" type="radio" name="visibilty" value="1">
                                <label for="visno">No</label>
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Allow Commenting</strong></label>
                        <div class="col-sm-10">
                            <div class="offset-md-2">
                                <input id="comyes" type="radio" name="comment" value="0" checked>
                                <label for="comyes">Yes</label>
                            </div>
                            <div class="offset-md-2">
                                <input id="comno" type="radio" name="comment" value="1">
                                <label for="comno">No</label>
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Allow Ads</strong></label>
                        <div class="col-sm-10">
                            <div class="offset-md-2">
                                <input id="addyes" type="radio" name="ads" value="0" checked>
                                <label for="addyes">Yes</label>
                            </div>
                            <div class="offset-md-2">
                                <input id="addno" type="radio" name="ads" value="1">
                                <label for="addno">No</label>
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="submit" class="btn btn-success float-right btn-lg" value="Add Category"> 
                        </div>
                    </div>
                </form>
            </div>
<?php
        }elseif ($do == "Insert"){
        
        // insert Page
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($_POST["name"] !=''){
                    $categoryName   = $_POST["name"]  ;
                    $description    = $_POST["description"]  ;
                    $ordering       = $_POST["ordering"] ; 
                    $visibilty      = $_POST["visibilty"] ; 
                    $comment        = $_POST["comment"] ; 
                    $ads            = $_POST["ads"] ; 
                    $parent         = $_POST["parent"] ; 

                    $check = checkItem('name', 'categores', $categoryName) ; 
                    if($check == 1){
                        $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">Sorry, This Category Name is Not Allowed Chose Another Name</h2></div>' ; 
                        $errTime = 2;
                        $url='?do=Add';
                        $page ='Add' ; 
                        redirect($errMes, $errTime, $page ,$url) ;
                    }else{

                        $stmt = $con->prepare("INSERT INTO categores(name, description, ordering, visibilty, allowComment, allowAds, parent) VALUES(:zx, :zxx, :zxxx, :zxxxx, :zxxxxx, :zxxxxxx, :zxxxxxxx)") ; 
                        $stmt->execute(array(
                            'zx'        => $categoryName,
                            'zxx'       => $description,
                            'zxxx'      => $ordering,
                            'zxxxx'     => $visibilty,
                            'zxxxxx'    => $comment,
                            'zxxxxxx'   => $ads,
                            'zxxxxxxx'   => $parent  
                        ));

                        $errMes = '<div class="container alert alert-success text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;"> Category Success Add </h2></div>' ; 
                        $errTime = 1;
                        $url='?do=Add';
                        $page ='Add' ; 
                        redirect($errMes, $errTime, $page ,$url) ;
                    }
                }else{
                    $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;"> Please Fill The Category Name Field </h2></div>' ; 
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

            $catId = isset($_GET["catId"]) && is_numeric($_GET["catId"]) ? intval($_GET["catId"]) : 0 ;
            // Select All Data From Database Depend On CatId
            $stmt = $con->prepare("SELECT * FROM categores WHERE id = ?") ;
            $stmt -> execute(array($catId)) ; 
            $cat = $stmt -> fetch() ; 
            $count = $stmt -> rowCount() ;
            if($count > 0){?>
                <h2 class="text-center h1">Edit Category</h2>
                <div class="container">    
                    <form class="editform" action="?do=Update" method="POST">
                        <input type="hidden" name="catId" value="<?php echo $cat["id"] ; ?>">
                        <div class="form-group row">
                            <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Name</strong></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control col-sm-10 float-right" id="inputUsername" name="name" autocomplete="off" required placeholder="Enter Category Name" value="<?php echo $cat["name"] ; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label"><strong>Description</strong></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control col-sm-10 float-right" id="inputPassword" name="description" placeholder="Enter Category Description" autocomplete="on" value="<?php echo $cat["description"] ; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label"><strong>Odering</strong></label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control col-sm-10 float-right" id="inputEmail" name="ordering" autocomplete="off"  placeholder="Enter Number To Odering Categores" value="<?php echo $cat["ordering"] ; ?>">
                            </div>
                        </div>
                       
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Parent</strong></label>
                                <div class="col-sm-10">
                                    <select name="parent" class="form-control offset-sm-2 col-sm-10">
                                    
                                    <?php

                                        // Check Category is Main Or Sub One
                                    
                                        
                                            // This Cat Is Sub  
                                            $stmt = $con->prepare("SELECT * FROM categores WHERE parent = 0 AND id !=?  ") ;
                                            $stmt -> execute(array($catId)) ; 
                                            $parents = $stmt -> fetchAll() ;
                                            echo '<option value="0">None</option>';
                                            foreach($parents as $parent ){
                                               echo '<option value="'.$parent["id"].'"'; 
                                               if( $cat["parent"] == $parent["id"] ){ echo "selected" ; } 
                                               echo '>' . $parent["name"] . '</option>' ; 
                                            }
                                            
                                        

                                    ?> 
                                    
                                    </select>
                                </div>
                            </div>
 
                        
                        <div class="form-group row">
                            <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Visibilety</strong></label>
                            <div class="col-sm-10">
                                <div class="offset-md-2">
                                    <input id="visyes" type="radio" name="visibilty" value="0" <?php if($cat["visibilty"] == 0){ echo "checked" ;  }?>>
                                    <label for="visyes">Yes</label>
                                </div>
                                <div class="offset-md-2">
                                    <input id="visno" type="radio" name="visibilty" value="1" <?php if($cat["visibilty"] == 1){ echo "checked" ;  }?>>
                                    <label for="visno">No</label>
                                </div>                            
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Allow Commenting</strong></label>
                            <div class="col-sm-10">
                                <div class="offset-md-2">
                                    <input id="comyes" type="radio" name="comment" value="0" <?php if($cat["allowComment"] == 0){ echo "checked" ;  }?>>
                                    <label for="comyes">Yes</label>
                                </div>
                                <div class="offset-md-2">
                                    <input id="comno" type="radio" name="comment" value="1" <?php if($cat["allowComment"] == 1){ echo "checked" ;  }?>>
                                    <label for="comno">No</label>
                                </div>                            
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Allow Ads</strong></label>
                            <div class="col-sm-10">
                                <div class="offset-md-2">
                                    <input id="addyes" type="radio" name="ads" value="0" <?php if($cat["allowAds"] == 0){ echo "checked" ;  }?>>
                                    <label for="addyes">Yes</label>
                                </div>
                                <div class="offset-md-2">
                                    <input id="addno" type="radio" name="ads" value="1" <?php if($cat["allowAds"] == 1){ echo "checked" ;  }?>>
                                    <label for="addno">No</label>
                                </div>                            
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                              <input type="submit" class="btn btn-danger float-right btn-lg" value="Update Category"> 
                            </div>
                        </div>
                    </form>
                </div>
            <?php }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">Sorry There Is No Category With This ID</h2></div>' ; 
                $errTime = 2;
                $page="Categores" ; 
                $url ="?do=Mange" ; 
                redirect($errMes, $errTime, $page, $url) ;
            }
        }elseif ($do == "Update"){
            echo '<h2 class="text-center h1">Update Category</h2>' ;
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $catId          = $_POST["catId"] ;
                if($_POST["name"] !=""){
                    $catName        = $_POST["name"]  ;
                    $description    = $_POST["description"]  ;
                    $ordering       = $_POST["ordering"]  ;
                    $visibilty      = $_POST["visibilty"] ; 
                    $comment        = $_POST["comment"] ; 
                    $ads            = $_POST["ads"] ;
                    if(isset($_POST["parent"])){
                    
                        $parents        = $_POST["parent"] ;  

                        $stmt = $con -> prepare("UPDATE categores SET name=?, description=?, ordering=?, visibilty=?, allowComment=?, allowAds=?, parent=? WHERE id = ?") ; 
                        $stmt -> execute(array($catName, $description, $ordering, $visibilty, $comment, $ads, $parents, $catId)) ; 
                        
                    
                    }else{

                        $stmt = $con -> prepare("UPDATE categores SET name=?, description=?, ordering=?, visibilty=?, allowComment=?, allowAds=? WHERE id = ?") ; 
                        $stmt -> execute(array($catName, $description, $ordering, $visibilty, $comment, $ads, $catId)) ; 
                    
                    }
                    echo '<h2 class="h1 text-center">numbers of fileds Updated: '.$stmt->rowCount().'</h2>' ; 
                    
                }else{
                        $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">You Should Enter Category Field Name</h2></div>' ; 
                        $errTime = 2;
                        $url = "categores.php?do=Edit&catId=$catId" ; 
                        $page ='Edit' ; 
                        redirect($errMes, $errTime, $page, $url) ;
                    }
            }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">You Cante Browise This Page Directly</h2></div>' ; 
                $errTime = 2;
                $back = '?do=Mange' ; 
                $page ='Categores' ; 
                redirect($errMes, $errTime, $page, $back) ;
                }
        }elseif ($do == "Delete"){

            $catId = isset($_GET["catId"]) && is_numeric($_GET["catId"]) ? $_GET["catId"] : 0 ;
            if($catId){
                $check = checkItem('id', 'categores', $catId) ; 
                if($check > 0){

                    // I Add The OR statement To Delete All Sub Category With Main Category When I Deleted The Main One
                    
                    $stmt = $con -> prepare("DELETE FROM categores WHERE id = ? OR parent = ?") ;
                    $stmt -> execute(array($catId, $catId)) ;
                    echo '<div class="alert alert-success container text-center" style="margin-top:200px"><h2 class="h1">Categores Success Deleted</h2></div>' ; 
                    header("refresh:1;url=categores.php?do=Mange") ; 
                }else{
                    $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">There Is No Categores With This ID '.$userId.'</h2></div>' ; 
                    $errTime = 3; 
                    redirect($errMes, $errTime) ;                
                }
            }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">You Cant Enter This Page</h2></div>' ; 
                $errTime = 3; 
                $page = "Categores" ; 
                $url = '?do=Manage' ; 
                redirect($errMes, $errTime, $page, $url) ;
            }

        }

        include $tmpls."footer.php" ;   
    }else{
        header("location:index.php") ; 
        exit() ; 
    }
    ob_end_flush();
?>
<!--
                    if($stmt->rowCount()){
                        $errMes = '<div class="container alert alert-Success text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">Category Success Updated</h2></div>' ; 
                        $errTime = 2;
                        $back = '?do=Mange' ; 
                        $page ='Categores' ; 
                        redirect($errMes, $errTime, $page, $back) ;      
                    }else{
                        $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">This Name Can Not Be Chosen Please Chose Another Name</h2></div>' ; 
                        $errTime = 4;
                        $back = '?do=Update&catId='.$catId ; 
                        $page ='Update' ; 
                        redirect($errMes, $errTime, $page, $back) ;                 
                    } -->
