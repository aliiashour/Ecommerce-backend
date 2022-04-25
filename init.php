<?php
// init.php
// database Files

ini_set('display_errors', 'On') ;
error_reporting(E_ALL) ; 

include 'admin/connect.php'  ; 

$user = '' ; 

if(isset($_SESSION["user"])) {

	$user = $_SESSION["user"];

    if(!isset($_SESSION["admin"])){

        if(isset($_SESSION["LAST_ACTIVE_TIME"])){
            if(time()-$_SESSION["LAST_ACTIVE_TIME"] >900){
                header("location:logout.php") ;
            }
        }
        
        $_SESSION["LAST_ACTIVE_TIME"] = time() ; 
    }
    
    //include 'user_auth_session.php'  ; 

}

$tmpls      = "include/template/" ;     // template files 
$img        = "layout/images/";         // images files
$language   = "include/language/";      // langusgae files
$fun        = "include/function/" ;     // function files
$css        = "layout/css/" ;           // css files
$js         = "layout/js/" ;            // js files



include $fun . 'functions.php'; 

// Important files 
if(isset($ar)){
    include $language.'ar.php'  ; 
}else{
    include $language.'en.php'  ; 
}

include $tmpls . 'header.php'  ;


?>