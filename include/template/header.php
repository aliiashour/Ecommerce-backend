
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="<?php echo $img ?>logo.jpg">
        <title>
            <?php
            
                echo getTitle() ;
            ?>
        </title>
        
        <link rel="stylesheet" href="<?php echo $css ?>all.min.css">
        <link rel="stylesheet" href="<?php echo $css ?>fontawesome.min.css">
        <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $css ?>style.css">
    </head>
    <body 
        <?php if(isset($ar)){
            echo "class='rtl'" ; 
        } ?> 
    >
<!--navbar.php-->
        <div class="upper-nav">
            <div class="container">
                <div class="row">
                    <div class="info col-sm-6 text-left">
                        <?php echo date('M / d / Y'); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php if(isset($_SESSION["user"])){ ?>
                                    <ul class="list-unstyled list float-left">
                                        <li class="list-item"><a href="newad.php">NewAdd</a></li>
                                        <li class="list-item"><a href="logout.php">Exit</a></li>
                                    </ul>
                                <?php } ?>

                            </div>   
                            <div class="col-sm-6 pan">
                                <?php 
                                    if(isset($_SESSION["user"])){
                                        $stmt = $con->prepare("SELECT * FROM users WHERE userName = ?") ;
                                        $stmt ->execute(array($_SESSION["user"])) ;
                                        $items = $stmt->fetchAll() ; 
                                        ?>
                                        <img src="admin\upload\images\<?php if($items[0]['image'] != ''){ echo $items[0]['image'] ; }else{ echo 'const.jpg' ;  }?>" class="rounded-circle mine img-fluid img-thumbnail" alt="pro-photo"><a href="profile.php"><span><?php echo $_SESSION["user"] ; ?></span></a> 
                                <?php
                                    }else{
                                        
                                        echo '<a href="log.php">Login/Signup</a>' ; 
                                    
                                    } 
                                    
                                    if(isset($_SESSION["admin"])){
                                        echo ' | <a href="admin">dashboard</a>'; 
                                    }
                                    

                                ?>
                            </div>
                        
  
                        </div>
                    </div>
                </div>
            </div>                
        </div>

        <nav style="color:#FFF" class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">HomePage</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse justify-content-end" id="app-nav">
                    <ul class="navbar-nav">                
                        <?php
                     
                            $cats = getCats() ; 
                            foreach ($cats as $cat) {
                               
                                echo '<li class="nav-item">' ;
                                if($cat["name"] == getTitle()){
                                    echo '<a class="nav-link activeLink" data-name="'.$cat["name"].'" href="categores.php?pageId=' . $cat['id'] . '&catName='.$cat["name"].' ">' . $cat["name"] . '</a>'  ; 
                                }else{
                                    echo '<a class="nav-link" data-name="'.$cat["name"].'" href="categores.php?pageId=' . $cat['id'] . '&catName='.$cat["name"].' ">' . $cat["name"] . '</a>'  ; 
                                }
                            
                                echo '</li>' ; 
                            }

                            // Chekc if There Is Sub Categores
                            if(!empty($cats)){

                                echo '<li class="nav-item">'; 
                                    echo '<div class="dropdown">' ;
                                        
                                        echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Sub Cactegores
                                                </button>' ;
                                        
                                        echo '  <ul style="max-length:200px;" class="dropdown-menu" aria-labelledby="dropdownMenuButton1">' ;
                                            
                                            foreach ($cats as $cat) {
                                                echo '<strong>'.$cat["name"]. ':</strong>'; 
                                                $subCats = getSubCatsOf($cat["id"]) ; 
                                                foreach ($subCats as $subCat) {
                                                    echo '<li><a class="dropdown-item" href="categores.php?pageId=' . $subCat['id'] . '&catName='.$subCat["name"].'"> ' . $subCat["name"] . ' </a></li>' ; 
                                                }
                                            }

                                        echo '</ul>' ;
                                    echo '</div>' ;
                                echo '</li>' ;
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>