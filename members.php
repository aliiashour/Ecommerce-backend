
<?php

// members.php

/*
================================================
== Manage Members Pages
==You Can Edit 
================================================

*/


session_start() ;

//$ar=''; 

$pageTitle = "Members" ;

if(isset($_SESSION["user"])){
    
    include 'init.php' ;
    $newName='' ;
    $newEmail='';
    $newFullname='';
    $pass='';
    $do = isset($_GET["do"]) ? $_GET["do"] : 'Edit' ; 

    if($do == "Edit"){ // Edit page
        $userId = isset($_GET["adminId"]) && is_numeric($_GET["adminId"]) ? intval($_GET["adminId"]) : 0 ; 
        $queryType = 'edit' ;
        if(doQuery($queryType, $newName, $newEmail, $newFullname, $pass, $userId)){?>
            <h2 class="text-center h1" 
                    style="margin: 60px 0px 25px;
                           color: #675858;">
                    <?php echo lang('EDITMEMBERS')?></h2>
            <div class="container">   
                <div class="row">
                    <div class="col-sm-8">
                        <form class="editform" action="?do=Update" method="POST">
                            <input type="text" name="userid" class="d-none" value="<?php echo $row["userId"]?>">
                            <div class="form-group row">
                                <label for="inputUsername" class="col-sm-2 col-form-label"><strong><?php echo lang('USERNAME')?></strong></label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control col-sm-10 float-right" id="inputUsername" name="username" autocomplete="off" required value="<?php echo $row['userName']?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label"><strong><?php echo lang('PASSWORD')?></strong></label>
                                <div class="col-sm-10">
                                <input type="password" class="form-control col-sm-10 float-right" id="inputPassword" name="password" placeholder="Leave It If You Want To Keep Your Old Pass" autocomplete="new-password">
                                <input type="password" name="oldpassword" value="<?php echo $row['password']?>" hidden>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label"><strong><?php echo lang('EMAIL')?></strong></label>
                                <div class="col-sm-10">
                                <input required type="email" class="form-control col-sm-10 float-right" id="inputEmail" name="email" autocomplete="off" value="<?php echo $row['email']?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputFullname" class="col-sm-2 col-form-label"><strong><?php echo lang('FULLNAME')?></strong></label>
                                <div class="col-sm-10">
                                <input required type="text" class="form-control col-sm-10 float-right" id="inputFullname" name="fullname" autocomplete="off" value="<?php echo $row['fullname']?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                        <input type="submit" class="btn btn-primary float-right btn-lg" value="<?php echo lang('SAVE')?>"> 
                                    </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="img-container">
                                <img src="admin\upload\images\\<?php if($row['image'] != ''){echo $row['image'] ; }else{ echo 'const.jpg' ;  }?>" class="img-fluid" alt="pro-photo">
                            </div>
                        </div>
                    </div>
                </div> 
            </div><?php
        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">Sorry There Is No Users Here</h2></div>' ; 
            $errTime = 3; 
            redirect($errMes, $errTime) ;
        }
    }elseif ($do == "Update"){ // Update Page
        
        ?><h2 class="text-center h1" 
        style="margin: 60px 0px 25px;
        color: #675858;">
        <?php echo lang('UPDATEMEMBERS')?></h2><?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($_POST["username"] !="" && $_POST["email"] !="" && $_POST["fullname"] !="" && strlen($_POST["oldpassword"]) > 7){
                $newName = $_POST["username"]  ;
                $newEmail = $_POST["email"]  ;
                $newFullname = $_POST["fullname"]  ;
                $userid = $_POST["userid"] ; 
                $pass = empty($_POST["password"]) ? $_POST["oldpassword"] : sha1($_POST["password"]) ;
                $queryType = "update" ; 
                if(doQuery($queryType, $newName, $newEmail, $newFullname, $pass, $userid)){
                    ?><h2 class='text-center h1' 
                        style='margin: 60px 0px 25px;
                                color: #675858;'><?php echo lang('SUCCESSUPDATE')?></h2> <?php 
                            echo '<div class="container" style="margin-top:100px; width:315px">
                            <a class="btn btn-primary btn-lg float-right"style="" href="?do=Edit&adminId='.$userid.'">'.lang("CHECK").'</a>
                            </div>' ; 
                }else{
                    echo doQuery($queryType, $newName, $newEmail, $newFullname, $pass, $userid) ; 
                    $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">This Username is Not Allowed Chose Another Userame</h2></div>' ; 
                    $errTime = 2;
                    $back = '?do=Edit&adminId='.$userid ; 
                    $page ='Edit' ; 
                    redirect($errMes, $errTime, $page, $back) ;
                }
            }else{
                ?><h2 class="text-center h1" 
                style="margin: 60px 0px 25px;
                color: #675858;">
                <?php echo lang('CANTUPDATE')?></h2><?php 
            }
        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">'.lang("CEUP").'</h2></div>' ; 
            $errTime = 3; 
            redirect($errMes, $errTime) ;
        }
    }else{ 
        header("location:index.php") ;
        exit() ;
    }
    
    include $tmpls . "footer.php" ;
}else{ 
    header("location:index.php") ;
    exit() ; 
}
?>