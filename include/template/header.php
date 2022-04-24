
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
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
                                        <li class="list-item"><a href="profile.php">My Profile</a></li>
                                        <li class="list-item"><a href="newad.php">NewAdd</a></li>
                                        <li class="list-item"><a href="logout.php">Exit</a></li>
                                    </ul>
                                <?php } ?>

                            </div>  
                            <div class="col-sm-6 pan">
                                <?php 

                                    if(isset($_SESSION["user"])){

                                        echo '<img src="layout/images/b.jpg" alt="me" class="mine rounded-circle imr-fluid img-thumbnail">' . '<span>'. $_SESSION["user"] . '</span>' ; 
                                        
                                    
                                    }else{
                                        
                                        echo '<a href="log.php">Login/Signup</a>' ; 
                                    
                                    }

                                    

                                ?>
                                | <a href="admin">dashboard</a>
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
                                    echo '<a class="nav-link" href="categores.php?pageId=' . $cat['id'] . '">' . $cat["name"] . '</a>'  ; 
                                echo '</li>' ; 
                            }

                            // Chekc if There Is Sub Categores
                            $subcats = getSubCats() ; 
                            
                            if(!empty($subcats)){

                                echo '<li class="nav-item">'; 
                                    echo '<div class="dropdown">' ;
                                        
                                        echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="supcat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Sub Categores
                                                </button>' ;
                                        
                                        echo '<div class="dropdown-menu" aria-labelledby="supcat">' ;
                                            
                                            foreach ($subcats as $subcat) {

                                                echo '<a class="dropdown-item" href="categores.php?pageId=' . $subcat['id'] . '"> ' . $subcat["name"] . ' </a>' ;

                                            }

                                        echo '</div>' ;

                                    echo '</div>' ;
                                echo '</li>' ;

                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>