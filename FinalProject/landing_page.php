<?php
session_start();
include('config.php');

?>
<html>
    <style>
    body {
        background-color: #e3bff2;
    }
    .center-image {
          display: block; /* Or display: inline-block for inline centering */
          margin-left: auto;
          margin-right: auto;
        }
</style>
    <body>
        <img src="petunia1.jpg" alt="Petunia" class="center-image">
        
        
        
        <?php include('header.php'); ?>
        
        <h2 style="text-align: center;">Welcome to our Store!</h2>
        
        <p style = "text-align: center; font-size: 18px; color: #333">
            Discover our blooming selection of petunia-themed products, from seeds to cozy apparel!
            
            
            
        </p>
        
        <p style = "text-align: center; font-size: 18px; color: #333">
            <a href="aboutPetunia.php">Learn all about us!</a>
            <a href="display_pictures.php">Check out our products!</a>
        </p>
    </body>
</html>
