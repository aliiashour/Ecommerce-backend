<?php 
ob_start("ob_gzhandler") ; 
session_start() ;
// $ar=''  ;
if(isset($_SESSION["adminId"])){
    $pageTitle = "Dashboard" ;
    include "init.php" ; 
    $Lastusers = 5 ; 
    $data = getLatest('userName, userId', 'users', 'userId', $Lastusers) ; 
    $data2 = getLatest('item_name, item_id, apporove', 'items', 'item_id', $Lastusers) ; 
  ?>

<div class="home-stats">
    <div class="container text-center">
        <h2 class="h1"><?php echo lang('DASHBOARD')?></h2>
        <div class="row">
            <div class="col-md-3">
                
                <div class="stat members">
                    <i class="fas fa-users fw fa-3x mb-2"></i>
                    <div>
                    <?php echo lang('TOTALMEMBERS')?>
                        <span><a href="members.php?do=Mange"><?php echo getCount("userId", "users")?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat pending">
                    <i class="fas fa-users-slash fw fa-3x mb-2"></i>
                    <div>
                    <?php echo lang('PENDINGMEMBERS')?>
                        <span><a href="members.php?do=Pending"><?php echo getPendingCount("users")?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat items">
                    <i class="fas fa-sitemap fw fa-3x mb-2"></i>
                    <div>
                        <?php echo lang('TOTALITEMS')?>  
                        <span><a href="items.php?do=Mange"><?php echo getCount("item_id", "items") ; ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat comments">
                    <i class="fas fa-comments fw fa-3x mb-2"></i>
                    <div>
                        <?php echo lang('TOTALCOMMENTS')?>  
                        <span><a href="comments.php?do=Mange"><?php echo getCount("c_id", "comments") ; ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="latest">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest <?php echo $Lastusers?> Registerd Members
                        <i class="fas fa-sort-up toogle-body fw fa-2x"></i>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php
                                if( !empty($data)){
                                    foreach($data as $row){?>

                                        <li><?php echo $row["userName"] ?>
                                        <a class="btn btn-warning btn-md float-right" href="members.php?do=Edit&adminId=<?php echo $row["userId"]?>"><i class="fa fa-edit"></i></a>
                                        <?php  if(checkApporov($row["userId"])){?>

                                                    <a class="btn btn-info btn-md float-right" href="members.php?do=Pending&mod=<?php echo $row["userId"]?>&b=Dash"><i class="fa fa-check"></i> Activate</a>
                                                       
                                    <?php }
                                        echo '</li>' ; 
                                    } 
                                }else{
                                    echo "there Is No Users To Show" ; 
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest <?php echo $Lastusers?> Items
                        <i class="fas fa-sort-up toogle-body fw fa-2x"></i>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php
                                if( !empty($data2)){
                                    foreach($data2 as $row){?>

                                        <li><?php echo $row["item_name"] ?>
                                        <a class="btn btn-warning btn-md float-right" href="items.php?do=Edit&item_id=<?php echo $row["item_id"]?>"><i class="fa fa-edit"></i></a>
                                        <?php  if($row["apporove"] == 0){ ?>

                                                    <a class="btn btn-info btn-md float-right confirm" href="items.php?do=Approve&item_id=<?php echo $row["item_id"]?>&dashbord=yes"><i class="fa fa-check"></i></a>

                                    <?php } 
                                        echo '</li>' ; 

                                    } 
                                }else{
                                    echo "there Is No Items To Show" ; 
                                } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest <?php echo $Lastusers?> Comments
                        <i class="fas fa-sort-up toogle-body fw fa-2x"></i>
                    </div>
                    <div class="panel-body">
                        
                        <ul class="list-unstyled">
                            <?php
                                $data3 = $con->prepare("SELECT userName, comments.* FROM comments INNER JOIN users ON users.userId = comments.user_id ORDER BY c_id DESC LIMIT $Lastusers") ; 
                                $data3->execute() ;
                                if( !empty($data3) ){
                                    
                                    foreach($data3 as $com){ 
                            ?>

                                        <li style="border-bottom:2px solid black;"><?php echo '<span class="d-inline-block">'.$com["userName"].'</span> :' ; ?><span class="comment <?php if(strlen($com["comment"]) > 30){ echo 'text-truncate' ;} ?> "><?php  echo $com["comment"] ; ?></span>
                                        <a class="btn btn-warning btn-md float-right" href="comments.php?do=Edit&comId=<?php echo $com["c_id"]?>"><i class="fa fa-edit"></i></a>
                                        <?php  if($com["c_status"] == 0){ ?>

                                                    <a class="btn btn-info btn-md float-right confirm" href="comments.php?do=Approve&comId=<?php echo $com["c_id"]?>&b=dashbord.php"><i class="fa fa-check"></i></a>

                                        <?php } 
                                        echo '</li>' ;  
                                    }
                                } else {
                                    echo "there Is No Comments To Show" ; 
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php      
    include $tmpls . "footer.php" ; 
}else{
    header("location:index.php");
    exit() ; 
}




ob_end_flush() ; 
?>