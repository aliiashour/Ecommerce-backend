<?php

    // page.php
    ob_start() ; 
    session_start() ; 
//    $pageTitle='' ; 
    if(isset($_SESSION["adminId"])){
        
        include "init.php" ; 
        
        $do = isset($_GET["do"]) ? $_GET["do"] : 'Mange' ; 

        if($do =="Mange"){
            
            
        }elseif ($do == "Add"){
            
            
        }elseif ($do == "Delete"){
            
            
        }elseif ($do == "Insert"){
            
            
        }
        
        include "$tmpls"."footer.php" ; 
        
        
    }else{
        header("location:index.php") ; 
        exit() ; 
    }
    ob_end_flush() ; 
?>