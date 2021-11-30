<?php
require_once "pdo.php";
 session_start();
 if($_SESSION["account"]!='admin'){    
    header('Location: app.php');
 }
?>
<html>
<head></head>
<body>
<h1>Guest House Staff Related Services</h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    if($_SESSION["account"] == "admin" ){
        echo('<p><a href = "add_staff.php" >Add a new staff member</a></p> ');
	echo('<p><a href = "add_duty.php" >Add a new Duty Schedule</a></p> ');
	echo('<p><a href = "view_staff.php" >View the guest house staff details</a></p> ');
	echo('<p><a href = "view_duties.php" >View the assigned staff duties</a></p> ');
    }
    
?>
<p> <a href = "guest_house.php" >Go Back </a> </p>
</body>
</html>