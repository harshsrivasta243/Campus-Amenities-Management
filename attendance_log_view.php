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
<h1>Attendance View</h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    
if($_SESSION['account']!='admin')
{
        echo('<p><a href = "attendance_user_cur_month.php" >View Your Attendance after a Specific Date </a></p> ');
        echo('<p><a href = "attendance_user_full.php" >View Your Complete Attendance Log </a></p> ');
}       
	
if($_SESSION['account']=='admin') 
{
	echo('<p><a href = "attendance_user_after_date.php" >View Specific Gardener Attendance after a Specific Date </a></p> ');
        echo('<p><a href = "attendance_user_full.php" >View Specific Gardener Complete Attendance Log </a></p> ');
	echo('<p><a href = "attendance_adm_after_date.php" >View Attendance after a Specific Date of all Gardeners </a></p> ');
	echo('<p><a href = "attendance_adm_full.php" >View Complete Attendance Log of all Gardeners  </a></p> ');
}
    
    
?>
<p> <a href = "landscape.php" >Go Back </a> </p>
</body>
</html>