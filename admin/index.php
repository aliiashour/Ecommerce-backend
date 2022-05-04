<?php
// index.php
session_start() ; 
$nonav = '' ;
$pageTitle = "Login" ;
//$ar='yes' ;
if(isset($_SESSION["admin"])){
    header("location:dashbord.php") ;
}
include "init.php" ;

if($_SERVER["REQUEST_METHOD"] == "POST" && strlen($_POST["user"]) > 0 && strlen($_POST["password"]) >= 8 )
{
    $name = $_POST["user"];
    $pass = $_POST["password"];
    $hashedpass = sha1($pass) ;
    $stmt = $con->prepare("SELECT 
                                userId, userName, password 
                           FROM 
                                users 
                           WHERE 
                                userName = ? 
                           AND 
                                password = ? 
                           AND 
                                groupId = 1 
                           LIMIT 1") ;
    $stmt->execute(array($name, $hashedpass)) ;
    $row = $stmt->fetch() ; 
    $res = $stmt->rowCount()  ;
    if($res)
    {
    	$_SESSION["admin"] = $name ;
    	$_SESSION["adminId"] = $row['userId'];
    	header("location:dashbord.php") ; 
    }
}
?>



<form class="login-form" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
    <h2 class="h1 text-center"><?php echo lang('LOGINFORM') ?></h2>
    <div class="form-group">
        <label><?php echo lang('USER') ?></label>
        <input class="form-control" type="text" name="user" placeholder="<?php echo lang('ENTERNAME') ?>" autocomplete="on">
        <small><?php echo lang('CONNAME') ?></small>
    </div>
    
    <div class="form-group">
        <label><?php echo lang('PASS') ?></label>
        <input class="form-control" type="password" name="password" placeholder="<?php echo lang('ENTERPASS') ?>" autocomplete="on">
        <small><?php echo lang('CONPASS') ?></small>
    </div>
    
    <button class="btn btn-primary float-right"><?php echo lang('LOGIN') ?></button>
    <button class="btn btn-primary float-left"><a href="../" style="color:#FFF;text-decoration:#FFF" ><?php echo lang('BACK') ?></a></button>
    <p class="lead" id="response"></p>
</form>

<?php include $tmpls.'footer.php' ; ?>