
<?php
ob_start() ; 
session_start() ; 
$pageTitle = "Comments" ;
if(isset($_SESSION["adminId"])){
    
    include "init.php" ; 
    
    $do = isset($_GET["do"]) ? $_GET["do"] : "Mange" ; 
    
    if($do == 'Mange'){
        
        $comment_count = 5 ; 
        $page = '';
        if(isset($_GET["page"])){
            $page = $_GET["page"] ; 
        } else{
            $page = 1; 
        }
        $start_from = ( $page - 1 ) * $comment_count ; 
        echo "<h2 class='text-center h1'style='margin: 60px 0px 25px;color: #675858;'>Mange Comments</h2>" ;

        $stmt = $con->prepare("SELECT 
                                    comments.*, item_name As item_name, userName As userName
                               FROM 
                                    comments 
                               INNER JOIN 
                                    users 
                               ON 
                                    comments.user_id = users.userId 
                               INNER JOIN 
                                    items 
                               ON 
                                    comments.item_id = items.item_id LIMIT $start_from, $comment_count");
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
                            <th scope="col">comment</th>
                            <th scope="col">Date</th>
                            <th scope="col">Item Name</th>
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
                            <td><?php echo $row["item_name"] ;  ?></td>
                            <td><?php echo $row["userName"] ; ?><td>
                            <td><a class="btn btn-warning btn-md"href="?do=Edit&comId=<?php echo $row["c_id"] ;  ?>"><i class="fa fa-edit fw"></i> Edit</a>
                            <a class="btn btn-danger btn-md confirm" href="?do=Delete&comId=<?php echo $row["c_id"] ;  ?>"><i class="fa fa-times fw confirm"></i> Delete</a>
                            <?php
                                if($row["c_status"] == 0 ){?>
                                    <a class="btn btn-info btn-md confirm" href="?do=Approve&comId=<?php echo $row["c_id"] ;  ?>&b=?do=Mange"><i class="fa fa-check fw conform"></i> Approve</a>
                                <?php }?>
                            </td>
                        </tr>
            <?php }?>
                    </tbody>
                </table>
            </div>
            <div class='container'>
                <div class='row'>
                    <div class="col-sm-12" >
                        <div class="float-left">
                            <nav aria-label="...">
                                <ul class="pagination pagination-sm">
                                    <?php
                                        $stmt = $con->prepare("SELECT 
                                                        comments.*, item_name As item_name, userName As userName
                                                FROM 
                                                        comments 
                                                INNER JOIN 
                                                        users 
                                                ON 
                                                        comments.user_id = users.userId 
                                                INNER JOIN 
                                                        items 
                                                ON 
                                                        comments.item_id = items.item_id");
                                        $stmt->execute() ;
                                        $count = $stmt->rowCount() ;
                                        $com_count = ceil($count/$comment_count);
                                        if($com_count>=1){
                                            echo '<li class="page-item '; if($_GET["page"] ==1 || !isset($_GET["page"]) ){ echo 'active' ; } echo '" aria-current="page"><a class="page-link" href="?page=1">1</a></li>';
                                        }
                                        for($i = 2; $i<=$com_count;$i++){
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


        <?php   }else{
            // there is no data into data base
            echo "<div class='container alert alert-danger text-center' style='margin-top:100px'><h2 class='h1'>There Is No data !!</h2></div>" ; 
        }  


    }elseif( $do == 'Edit' ){
        
        $comId = isset($_GET["comId"]) && is_numeric($_GET["comId"]) ? $_GET["comId"] : 0; 
        $stmt = $con -> prepare("SELECT * FROM comments WHERE c_id = ?") ;
        $stmt -> execute(array($comId)) ;
        $count = $stmt -> rowCount() ; 
        if($count){
            $com= $stmt->fetch() ;  ?>
            <h2 class="text-center h1">Edit Comments</h2>
            <div class="container">    
                <form class="editform" action="?do=Update" method="POST">
                    <input type="hidden" value="<?php echo $comId ; ?>" name="comId">
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Comment</strong></label>
                        <div class="col-sm-10">
                          <input type="text" 
                                 class="form-control col-sm-10 float-right" 
                                 id="inputUsername" 
                                 name="comment" 
                                 autocomplete="off" 
                                 required 
                                 placeholder="Enter Your Comment" 
                                 value="<?php echo $com["comment"]?>"/>
                        </div>
                    </div>                   
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item</strong></label>
                        <div class="col-sm-10">
                            <select name="item" class="form-control offset-sm-2 col-sm-10">
                            <?php

                               $stmt = $con->prepare("SELECT * FROM items") ;
                               $stmt -> execute() ; 
                               $rows = $stmt -> fetchAll() ;
                               foreach($rows as $row ){ 
                                   echo '<option value="'.$row["item_id"].'"' ; 
                                   if( $com["item_id"] == $row["item_id"] ){ echo "selected" ;  }
                                   echo '>' . $row["item_name"] . '</option>' ;
                               }


                            ?> 
                            </select>
                        </div>
                    </div>                 
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>User</strong></label>
                        <div class="col-sm-10">
                            <select name="user" class="form-control offset-sm-2 col-sm-10">
                            <?php

                               $stmt = $con->prepare("SELECT * FROM users") ;
                               $stmt -> execute() ; 
                               $rows = $stmt -> fetchAll() ;
                               foreach($rows as $row ){ 
                                   echo '<option value="'.$row["userId"].'"' ; 
                                   if( $com["user_id"] == $row["userId"] ){ echo "selected" ;  }
                                   echo '>' . $row["userName"] . '</option>' ;
                               }


                            ?> 
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="submit" class="btn btn-danger float-right btn-md" value="Update Comment"> 
                        </div>
                    </div>
                </form>
            </div> 
<?php 
        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">Sorry There Is No Coments Here</h2></div>' ; 
            $errTime = 3;
            $page ="Home" ; 
            $url = "index.php" ; 
            redirect($errMes, $errTime, $page, $url) ;
        }
        
    }elseif( $do == 'Update' ){
        
        echo '<h2 class="text-center h1">Update Comments</h2>' ;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $comId          = $_POST["comId"] ;
            $comment        = $_POST["comment"]  ;
            $item           = $_POST["item"]  ;
            $user           = $_POST["user"]  ;
 
            $errors = [] ; 
            if(empty($comment) || strlen($comment) < 3){
                $errors[] ="<div class='alert alert-danger'>You Should Enter Your Comment And Not Less Than 4 Character</div>" ; 
            }
            if(empty($errors)){
                $stmt = $con -> prepare("UPDATE comments SET comment=?, item_id=?, user_id=? WHERE c_id = ?") ; 
                $stmt -> execute(array($comment, $item, $user, $comId)) ; 

                echo '<h2 class="h1">'.$stmt->rowCount().'</h2>' ; 
            }else{
                echo "<div class='container' style='margin-top:50px'>" ; 
                foreach($errors as $error){
                    echo  $error ;
                }
                echo "</div>" ;
                echo '<div class="text-center" style="margin-top:50px"><a class="btn btn-danger btn-lg" 
                     style="" href="?do=Edit&item_id='.$comId.'"><i class="fa fa-angle-double-left"></i> Backc</a></div>' ;
            }

        }else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">You Cante Browise This Page Directly</h2></div>' ; 
            $errTime = 2;
            $back = '?do=Mange' ; 
            $page ='Items' ; 
            redirect($errMes, $errTime, $page, $back) ;
        }
        
    }elseif( $do == 'Delete' ){
        $comId = isset($_GET["comId"]) && is_numeric($_GET["comId"]) ? $_GET["comId"] : 0 ;
        if($comId){
            $check = checkItem('c_id', 'comments', $comId) ; 
            if($check > 0){
                $stmt = $con -> prepare("DELETE FROM comments WHERE c_id = ?") ;
                $stmt -> execute(array($comId)) ;
                echo '<div class="alert alert-success container text-center" style="margin-top:200px"><h2 class="h1">Comment Success Deleted</h2></div>' ; 
                header("refresh:1;url=comments.php?do=Mange") ; 
            }else{
                $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2 class="text-center h1" style="color: #675858;">There Is No Comment With This ID '.$comId.'</h2></div>' ; 
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

    }elseif( $do == 'Approve' ){
        $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? $_GET['comId'] : 0 ;
        $back = $_GET['b'] == '?do=Mange' ? '?do=Mange' : 'dashbord.php' ; 
        $stmt = $con->prepare("UPDATE comments SET c_status = 1 WHERE c_id = $comId") ; 
        $stmt -> execute()  ; 
        $count = $stmt -> rowCount() ; 
        if($count){
            $errMes =  '<div class="alert alert-success text-center" style="margin-top:150px"><h2 class="h1">Reqorid Successfully Updated :D</h2></div>' ;
            $errTime = 2 ; 
            $back = $back ; 
            $page ='Forward' ; 
            redirect($errMes, $errTime, $page, $back) ;
        } else{
            $errMes = '<div class="container alert alert-danger text-center" style="font-size:25px ; margin: 60px auto 20px"<h2       class="text-center h1" style="color: #675858;">Ther Is No Comment With This Id</h2></div>' ; 
            $errTime = 2;
            $back = '?do=Mange' ; 
            $page ='Comments' ; 
            redirect($errMes, $errTime, $page, $back) ;
        }
        
    }
    
    include $tmpls . 'footer.php' ; 

}else{
    header("location:index.php") ;
    exit() ; 
}
ob_end_flush() ; 
?>