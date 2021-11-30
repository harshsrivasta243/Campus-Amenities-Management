<?php
require_once "pdo.php";
 session_start();
 if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
?>
<html>
<head></head>
<body>
<h1>Expenditure/Earnings Portal</h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    if($_SESSION["account"] == "admin" ){
	echo('<p><a href = "add_expenditure.php" >Add some expenditure</a></p> ');
	echo('<p><a href = "add_earning.php" >Add some earning</a></p> ');
	echo('<p><a href = "see_exp.php" >View Expenditures Record</a></p> ');
	echo('<p><a href = "see_ear.php" >View Earnings Record</a></p> ');
    }
    
?>
<p> <a href = "guest_house.php" >Go Back </a> </p>
</body>
</html>