<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="<?php echo $img ?>logo.jpg">
        <title>
            <?php
            
                echo getTitle() ;
            ?>
        </title>
        <link rel="stylesheet" href="<?php echo $css ?>all.min.css">
        <link rel="stylesheet" href="<?php echo $css ?>fontawesome.min.css">
        <link rel="stylesheet" href="<?php echo $css ?>bootstrap5.min.css">
        <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $css ?>style.css">
    </head>
    <body <?php if(isset($ar)){
        echo "class='rtl'" ; 
    } ?> >