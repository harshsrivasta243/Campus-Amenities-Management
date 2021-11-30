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
<h1>Guest House Related Services</h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    
        echo('<p><a href = "rooms.php" >Rooms Related </a></p> ');
        echo('<p><a href = "guest_house_restaurant.php" >Food Related </a></p> ');
        
	
if($_SESSION['account']=='admin') 
{
	echo('<p><a href = "guest_house_staff.php" >Guest House Staff Related </a></p> ');
	echo('<p><a href = "exp_ear_page.php" >Expenditure/Earnings Related</a></p> ');
}
    
    
?>
<p> <a href = "app.php" >Go Back </a> </p>
</body>
</html>