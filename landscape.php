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
<h1>Landscape Related Services</h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    
        echo('<p><a href = "req_grass_cut.php" >Request Grass Cutting </a></p> ');
        echo('<p><a href = "gardener_view.php" >View Gardener Details </a></p> ');
	echo('<p><a href = "campus_areas_view.php" >View Campus Area Details </a></p> ');
	echo('<p><a href = "duty_roster_view.php" >View Duty Roster </a></p> ');
	echo('<p><a href = "equipment_stock_view.php" >View Equipments Stock and Availability </a></p> ');
	echo('<p><a href = "mark_attendance.php" >Mark Gardener Attendance </a></p> ');
        
	
if($_SESSION['account']=='admin') 
{
	echo('<p><a href = "add_gardener.php" >Add Gardener </a></p> ');
	echo('<p><a href = "add_campus_area.php" >Add Campus Area</a></p> ');
	echo('<p><a href = "assign_duty.php" >Assign Duty to Gardener</a></p> ');
	echo('<p><a href = "add_equipment.php" >Add Equipment</a></p> ');
	echo('<p><a href = "maintenance_log_view.php" >View Maintenance Log and Expenditure Details</a></p> ');
	echo('<p><a href = "drop_for_maintenance.php" >Drop Equipment(s) for Maintenance</a></p> ');
	echo('<p><a href = "attendance_log_view.php" >View Attendance Details</a></p> ');
	echo('<p><a href = "requests_view.php" >View Grass Cutting Requests</a></p> ');
	
	
}
    
    
?>
<p> <a href = "app.php" >Go Back </a> </p>
</body>
</html>