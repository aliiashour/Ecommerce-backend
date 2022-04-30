
<?php

// members.php

/*
================================================
== Manage Members Pages
==You Can ADD | Edit | Delete | Members From Here
================================================

*/


session_start() ;

//$ar=''; 

$pageTitle = "Members" ;

if(isset($_SESSION["admin"])){
    
    include 'init.php' ;
    $newName='' ;
    $newEmail='';
    $newFullname='';
    $pass='';
    $do = isset($_GET["do"]) ? $_GET["do"] : 'Mange' ; 

    if($do =="Mange"){
        $member_count = 5 ; 
        $page = '';
        if(isset($_GET["page"])){
            $page = $_GET["page"] ; 
        } else{
            $page = 1; 
        }
        $start_from = ( $page - 1 ) * $member_count ; 
        
        echo "<h2 class='text-center h1'
            style='margin: 60px 0px 25px;
            color: #675858;'>
            ".lang('MANAGE')."
        </h2>" ;

        $stmt = $con->prepare("SELECT * FROM users WHERE groupId !=1 LIMIT $start_from, $member_count");
        $stmt->execute() ;
        $count = $stmt->rowCount() ;
        if($count){
//            echo $count ;  
            ?>

        <div class="container">

            <table class="table table-striped col-sm-12">
                <thead>
                    <tr>
                        <th scope="col">Avatar</th>
                        <th scope="col">Username</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Email</th>
                        <th scope="col">Registerd Date</th>
                        <th scope="col" colspan="3" class="text-center">Controle</th>
                    </tr>
                </thead>
            <tbody>

<?php

            $rows = $stmt->fetchall() ; 
            foreach($rows as $row){
                   
?>

        
                    <tr>
                        <td>
                            <?php 
                                $q = '' ; 
                                if(strtolower($_SESSION["admin"]) == strtolower($row["userName"])){
                                    $q = '' ; 
                                }else{
                                    $q = '?publisher='.$row["userName"] ;
                                }
                                
                                if($row["image"] !=''){
                                    echo '<a href="../profile.php'.$q.'"><img src="upload\images\\' . $row["image"] . '" class="avatar img-fluid img-thumbnail rounded-circle"></a>'  ;
                                }else{
                                    echo '<a href="../profile.php'.$q.'"><img src="upload\images\const.jpg" class="avatar img-fluid img-thumbnail rounded-circle"></a>'  ;
                                }


                            ?>
                                
                        </td>
                        <td><?php echo $row["userName"] ;  ?></td>
                        <td><?php echo $row["fullname"] ;  ?></td>
                        <td><?php echo $row["email"] ;  ?></td>
                        <td><?php echo $row["date"] ; ?><td>
                        <td><a class="btn btn-warning btn-md"href="?do=Edit&adminId=<?php echo $row["userId"] ;  ?>"><i class="fa fa-edit fw"></i></a>
                        <a class="btn btn-danger btn-md confirm" href="?do=Delete&adminId=<?php echo $row["userId"] ;  ?>"><i class="fa fa-times fw confirm"></i></a>
                        <?php
                            if(checkApporov($row["userId"])){?>
                                <a class="btn btn-info btn-md confirm" href="?do=Pending&mod=<?php echo $row["userId"] ;  ?>&b=Mange"><i class="fa fa-check fw conform"></i></a>
                            <?php }?>
                        </td>
                    </tr>
<?php }?>
                </tbody>
            </table>
        </div>
    

<?php   }else{
            // there is no data into data base
            echo "<div class='container alert alert-danger text-center' style='margin-top:100px'><h2 class='h1'>There Is No data !!</h2></div>" ; 
        }  ?>
            <!-- echo "<div class='container'><a class='btn btn-primary btn-lg float-right' style='margin-bottom:20px' href='?do=Add'><i class='fa fa-plus'></i> ".lang('ADDMEMBER')."</a></div> " ;  -->
            <div class='container'>
                <div class="row">
                    <div class='col-sm-12'>
                        <div class="float-right">
                            <a class='btn btn-primary btn-lg' style='margin-bottom:20px' href='?do=Add'>
                                <i class='fa fa-plus'></i> 
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
                                            $stmt = $con->prepare("SELECT * FROM users WHERE groupId !=1");
                                            $stmt->execute() ;
                                            $count = $stmt->rowCount() ;
                                            $mem_count = ceil($count/$member_count);
                                            if($mem_count>=1){
                                                echo '<li class="page-item '; if($_GET["page"] ==1 || !isset($_GET["page"]) ){ echo 'active' ; } echo '" aria-current="page"><a class="page-link" href="?page=1">1</a></li>';
                                            }
                                            for($i = 2; $i<=$mem_count;$i++){
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
    <?php }elseif($do=="Add"){?>
        
<!--        the form to set new member data-->
        
        <h2 class="text-center h1" 
                    style="margin: 60px 0px 25px;
                           color: #675858;">
                    <?php echo lang('ADDMEMBER')?></h2>
            <div class="container">    
                <form class="editform" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong><?php echo lang('USERNAME')?></strong></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control col-sm-10 float-right" id="inputUsername" name="username" autocomplete="off" required placeholder="Enter Your Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label"><strong><?php echo lang('PASSWORD')?></strong></label>
                        <div class="col-sm-10">
                          <input type="password" class="pass form-control col-sm-10 float-right" id="inputPassword" name="password" placeholder="Enter Your Password" autocomplete="new-password" required>
                            <i class="fa fa-eye show-pass"></i>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label"><strong><?php echo lang('EMAIL')?></strong></label>
                        <div class="col-sm-10">
                          <input required type="email" class="form-control col-sm-10 float-right" id="inputEmail" name="email" autocomplete="off"  placeholder="Enter Your Name Ex://ali12@gmail.com">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputFullname" class="col-sm-2 col-form-label"><strong><?php echo lang('FULLNAME')?></strong></label>
                        <div class="col-sm-10">
                          <input required type="text" class="form-control col-sm-10 float-right" id="inputFullname" name="fullname" autocomplete="off" placeholder="Enter Your Full Name EX://Ali Ashour">
                        </div>
                    </div>

                    <!-- START UPLOAD FILES AND image   -->
<!--                     
                    <div class="form-group row">
                        <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Avatar</strong></label>
                        <div class="col-sm-10">
                          <input required type="file" class="form-control col-sm-10 float-right" id="inputFullname" name="image" placeholder="">
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="submit" class="btn btn-success float-right btn-lg" value="<?php echo lang('ADDONLY')?>"> 
                        </div>
                    </div>
                </form>
            </div>
    <?php }elseif($do =="Insert"){
        
        // insert Page


        if($_SERVER['REQUEST_METHOD'] == 'POST'){



            // Get Uploded File Info

            // $imageName = $_FILES["image"]["name"] ;
            // $imageTmp  = $_FILES["image"]["tmp_name"] ;
            // $imageType = $_FILES["image"]["type"] ; 
            // $imageSize = $_FILES["image"]["size"] ;

            // Exetinstion Allowed To Upload

            // $allowedExetintion = array("jpeg", "jpg", "png", "gif") ;

            // $imageExtention = explode('.', $imageName) ;
            
            // $imageExtention = strtolower($imageExtention[1]) ; 
            

            $newName        = $_POST["username"]  ;
            $newEmail       = $_POST["email"]  ;
            $newFullname    = $_POST["fullname"]  ;
            $unhashpass     = $_POST["password"] ;  
            $pass           = sha1($_POST["password"]); 

            $AddErrors      = [];

            if(empty($newName) || strlen($newName) < 2){
                $AddErrors[] ="<div class='alert alert-danger'>You Should Enter Your Username And Not Less Than 1 Character</div>" ; 
            }
            if(empty($newEmail)){
                $AddErrors[] ="<div class='alert alert-danger'>You Should Enter Your Email</div>" ; 
            }
            if(empty($newFullname) || strlen($newFullname) < 6){
                $AddErrors[] ="<div class='alert alert-danger'>You Should Enter Your Full Name And It Should More Than 10 Characters</div>" ; 
            }
            if(empty($pass) || strlen($unhashpass) < 7){
                $AddErrors[] ="<div class='alert alert-danger'>You Should Enter Your Password And It Should More Than 7 Characters</div>" ; 
            }
            // if($imageName == ''){
            //     $AddErrors[] ="<div class='alert alert-danger'> Upload Your Image</div>" ;  
            
            // }if(!in_array($imageExtention, $allowedExetintion) && !empty($imageName)){
            //     $AddErrors[] ="<div class='alert alert-danger'>This Extention is Not <strong>Allowed</strong></div>" ;   
            // }if($imageSize > 4194304){
            //     $AddErrors[] ="<div class='alert alert-danger'>Image Size Can Not be More Than 4mb</div>" ; 
            // }

            
            if(empty($AddErrors)){

                // $image = rand(0, 1000000) . '_' . $imageName ; 
                // move_uploaded_file($imageTmp, "upload\images\\" . $image ); 



                $queryType = 'insert' ; 
                
                if(doQuery($queryType, $newName, $newEmail, $newFullname, $pass, '')){
                    echo "<h2 class='text-center h1' 
                              style='margin: 60px 0px 25px;
                                     color: #675858;'>"
                              .lang('SUCCESSADD').
                         "</h2>" ;
                        $Mes = '<div class="container alert alert-success text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">Member Suuccess Added To Your Databas</h2></div>' ; 
                        $errTime = 2;
                        $url='?do=Mange';
                        $page ='Mange' ; 
                        redirect($Mes, $errTime, $page, $url) ;
                }else{
                    $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">This Username is Not Allowed Chose Another Userame</h2></div>' ; 
                    $errTime = 2;
                    $url='?do=Add';
                    $page ='Add' ; 
                    redirect($errMes, $errTime, $page ,$url) ;
                }
                
            }else{
                echo "<div class='container' style='margin-top:150px'>" ; 
                foreach($AddErrors as $error){
                    echo  $error ; 
                }
                echo "</div>" ;
                echo '<div class="text-center" style="margin-top:50px"><a class="btn btn-danger btn-lg" 
                     style="" href="?do=Add"><i class="fa fa-angle-double-left"></i> '.lang("ERROR").'</a></div>' ;
            }

        }else{

            $errMes = '<h2 class="text-center h1" 
                    style="margin: 60px 0px 25px;
                    color: #675858;">
                    '.lang('CEUP').
                '</h2>' ; 
            $errTime = 3; 
            redirect($errMes, $errTime) ;
        }
    }elseif ($do == "Edit"){ // Edit page
        $userId = isset($_GET["adminId"]) && is_numeric($_GET["adminId"]) ? intval($_GET["adminId"]) : 0 ; 
        $queryType = 'edit' ;
        if(doQuery($queryType, $newName, $newEmail, $newFullname, $pass, $userId)){?>
            <h2 class="text-center h1" 
                    style="margin: 60px 0px 25px;
                           color: #675858;">
                    <?php echo lang('EDITMEMBERS')?></h2>
            <div class="container">    
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
   
<?php
        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">Sorry There Is No Users Here</h2></div>' ; 
            $errTime = 3; 
            redirect($errMes, $errTime) ;
        }
        
        
    }elseif ($do == "Update"){ // Update Page
        
        ?><h2 class="text-center h1" 
        style="margin: 60px 0px 25px;
        color: #675858;">
        <?php echo lang('UPDATEMEMBERS')?></h2>        
<?php
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
                             <a class="btn btn-primary btn-lg float-left"style="" href="?do=Mange">Mange Page</a></div>' ; ;
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
                    <?php echo lang('CANTUPDATE')?></h2>
    <?php 
                }
        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">'.lang("CEUP").'</h2></div>' ; 
            $errTime = 3; 
            redirect($errMes, $errTime) ;
        }
    }elseif ($do == "Delete"){
        if(isset($_GET["adminId"]) && is_numeric($_GET["adminId"]) ){
            $userId = intval($_GET["adminId"])  ;
            $queryType = 'delete' ; 
            if(doQuery($queryType, $newName, $newEmail, $newFullname, $pass, $userId)){
                echo "<div class='container text-center alert alert-success' style='margin-top:150px'><h2 class='h1'>Member Successfully Deleted</h2></div>" ; 
                header("refresh:0.5;url=members.php?do=Mange") ; 
            }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">There Is No Member With This ID '.$userId.'</h2></div>' ; 
                $errTime = 3; 
                redirect($errMes, $errTime) ;                
            }
    
        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">'.lang("CEUP").'</h2></div>' ; 
            $errTime = 3; 
            redirect($errMes, $errTime) ;
        }
        
    }elseif($do =="Pending"){
        
        $userId = isset($_GET["mod"]) && is_numeric($_GET["mod"]) ? intval($_GET["mod"]) : 0 ;
        if($userId){
            $queryType = 'aporove' ;
            if(doQuery($queryType, $newName, $newEmail, $newFullname, $pass, $userId)){
                if(isset($_GET["b"]) && $_GET["b"]=="Dash"){
                    $errMes = '<div class ="alert alert-success container" style="margin-top:100px"><h2 class="h1 text-center" style="font-size:25px">Member Apporoval Success Updated</h2></div>' ; 
                    $errTime = 1; 
                    $page="Dashboard" ; 
                    $url="dashbord.php" ; 
                    redirect($errMes, $errTime, $page, $url) ;
                }elseif(isset($_GET["b"])){
                    $errMes = '<div class ="alert alert-success container" style="margin-top:100px"><h2 class="h1 text-center" style="font-size:25px">Member Apporoval Success Updated</h2></div>' ; 
                    $errTime = 1; 
                    $page="Mange Member" ; 
                    $url="?do=Mange" ; 
                    redirect($errMes, $errTime, $page, $url) ;
                }else{
                    $errMes = '<div class ="alert alert-success container" style="margin-top:100px"><h2 class="h1 text-center" style="font-size:25px">Member Apporoval Success Updated</h2></div>' ; 
                    $errTime = 2; 
                    $page="Pending" ; 
                    $url="?do=Pending" ; 
                    redirect($errMes, $errTime, $page, $url) ;
                }

            }
        }else{
//            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">'.lang("CEUP").'</h2></div>' ; 
//            $errTime = 3; 
//            redirect($errMes, $errTime) ;
        }
        
        echo "<h2 class='text-center h1'
            style='margin: 60px 0px 25px;
            color: #675858;'>
            Pending Members
        </h2>" ;

        $stmt = $con->prepare("SELECT * FROM users WHERE groupId !=1 AND regStatus=0");
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
                        <th scope="col">Username</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Email</th>
                        <th scope="col">Registerd Date</th>
                        <th scope="col" colspan="3" class="text-center">Controle</th>
                    </tr>
                </thead>
            <tbody>

<?php

            $rows = $stmt->fetchall() ; 
            foreach($rows as $row){
                   
?>

        
                    <tr>
                        <th scope="row"><?php echo $row["userId"] ;  ?></th>
                        <td><?php echo $row["userName"] ;  ?></td>
                        <td><?php echo $row["fullname"] ;  ?></td>
                        <td><?php echo $row["email"] ;  ?></td>
                        <td><?php echo $row["date"] ; ?><td>
                        <td><a class="btn btn-warning btn-md"href="?do=Edit&adminId=<?php echo $row["userId"] ;  ?>"><i class="fa fa-edit fw"></i></a></td>
                        <td><a class="btn btn-danger btn-md confirm" href="?do=Delete&adminId=<?php echo $row["userId"] ;  ?>"><i class="fa fa-times fw confirm"></i></a></td>
                        <td><a class="btn btn-info btn-md confirm" href="?do=Pending&mod=<?php echo $row["userId"] ;  ?>"><i class="far fa-check fw conform"></i></a></td>
                    </tr>
<?php }?>
                </tbody>
            </table>
        </div>
    

<?php   }else{
            // there is no data into data base
            echo "<div class='container alert alert-danger text-center' style='margin-top:100px'><h2 class='h1'>There Is No data !!</h2></div>" ; 
        }  

    }
               
        
    include $tmpls.'footer.php' ;  
    
}else{ 
    header("location:index.php") ;
    exit() ; 
}


?>