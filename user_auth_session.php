<?php
    ob_start() ; 
    
    if(isset($_POST['type']) && $_POST['type']=='ajax'){
    
        if(time() - $_SESSION["LAST_ACTIVE_TIME"] > 10){        
            echo 'logout';
        }

    }else{
        if(!isset($_SESSION["admin"])){

           if(isset($_SESSION["LAST_ACTIVE_TIME"])){
              if(time()-$_SESSION["LAST_ACTIVE_TIME"] >10){
                   header("location:logout.php") ;
                }
            }

            $_SESSION["LAST_ACTIVE_TIME"] = time() ; 
        }
    }
    ob_end_flush() ; 

?>
