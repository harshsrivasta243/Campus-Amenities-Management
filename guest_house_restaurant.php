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
<h1>Food Related Services</h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    if($_SESSION["account"] == "admin" ){
        echo('<p><a href = "add_menu.php" >Add an item to the food menu</a></p> ');
        echo('<p><a href = "see_food_bookings.php" >See the food bookings</a></p> ');
    }
        echo('<p><a href = "book_food.php" >Book Food.</a></p> ');
        echo('<p><a href = "view_menu.php" >See the menu.</a></p> ');
        echo('<p><a href = "food_bill.php" >Check/pay your food bill.</a></p> ');
?>
<p> <a href = "guest_house.php" >Go Back </a> </p>
</body>
</html>