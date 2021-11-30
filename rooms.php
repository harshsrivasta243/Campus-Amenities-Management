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
<h1>Rooms Related Services</h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    if($_SESSION["account"] == "admin" ){
        echo('<p><a href = "add_room.php" >Add a Room </a></p> ');
	echo('<p><a href = "room_bill_roomno.php" >Generate bill of a room Booking by room number, starting and ending dates of stay. </a></p> ');
	echo('<p><a href = "see_room_bookings.php" >See the room bookings </a></p> ');
    }
        echo('<p><a href = "register_complaint.php">Register complaint!</a></p>');
        echo('<p><a href = "book_room.php" >Book a Room </a></p> ');
        echo('<p><a href = "avai_room.php" >Check availability of Rooms </a></p> ');
        echo('<p><a href = "room_bill.php" >Generate bill of your room bookings</a></p> ');
?>
<p> <a href = "guest_house.php" >Go Back </a> </p>
</body>
</html>