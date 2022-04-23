<?php
// init.php
// database Files

include 'connect.php'  ; 


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

include $tmpls.'header.php'  ;

if(!isset($nonav)){         // check the ability to add navbar file
    include $tmpls.'navbar.php'  ;
}


?>