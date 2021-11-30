<?php
require_once "pdo.php";
 session_start();
 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }
?>
<html>
<head></head>
<body>
<h1>Market Related Services  </h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    if($_SESSION["account"] == "admin" ){
        echo('<p><a href = "register_shop.php" >Register a Shop </a></p> ');
        echo('<p><a href = "register_shopkeeper.php" >Register a Shopkeeper </a></p> ');
        echo('<p><a href = "update_shop_ownership.php" >Update Shop Ownership </a></p> ');
    
        echo('<p><a href = "shop_info.php" >View shop information </a></p> ');
        echo('<p><a href = "shopkeeper_info.php" >View shopkeeper information </a></p> ');
        echo('<p><a href = "due_payment.php" > Payment information </a></p> ');
        echo('<p><a href = "add_drop_payment.php"> Add/Clear Dues </a></p> ' );
        echo('<p><a href = "licence_renewal_reminder.php" >Licence renewal Reminder </a></p> ');
    }
    else{
        echo('<a href="shop_feedback.php" > Enter shop feedback </a>' );
    }
    
?>
<p> <a href = "app.php" >Go Back </a> </p>
</body>
</html>