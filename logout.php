<?php 

//logout.php

session_start();
session_unset() ; 
session_destroy() ; 

echo "<h2 class='h1 danger-message' style='    
    background-color: red;
    text-align: center;
    color: #2b2c2d;
    line-height: 30px;
    height: 30px;
    width: 800px;
    margin: 130px auto;
    border-radius: 5px;'
    >You Successfully LogOut</h2>" ; 

header("location:index.php ") ; 
exit() ; 

?>