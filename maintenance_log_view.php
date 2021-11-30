<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$sql = "select * from maintenance_log where maintenance_date >= :maintenance_date";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
	':maintenance_date' => $_POST['maintenance_date'] ));

	echo"<h1> Maintenance Log and Expenditure Details</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr><td>";
	echo "Equipment Id";
	echo"</td><td>";
	echo "Maintenance Rate";
	echo"</td><td>";
	echo "Number of Equipments";  
	echo"</td><td>";
	echo "Net Expenditure";
	echo"</td><td>";
	echo "Date Dropped for Maintenance";
	echo"</td><td>";
	echo "Status";
	echo"</td></tr>\n";
	foreach($rows as $var)
	{
		echo"<tr><td>";
		echo($var['equipment_id']);
		echo"</td><td>";
		echo($var['maintenance_rate']);
		echo"</td><td>";
		echo($var['no_of_equipments']);
		echo"</td><td>";
		echo($var['net_expenditure']);
		echo"</td><td>";
		echo($var['maintenance_date']);
		echo"</td><td>";
		echo($var['status']);
		echo"</td></tr>\n";
	}

	echo('<p><a href = "landscape.php">Another Search</a></p>');
      	return;
}
?>

<html>
<head></head>
<body>
<h1>Maintenance Log and Expenditure Details</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Enter Date after which Attendance of Gardeners is to be Fetched: <input type = "date" name = "maintenance_date" value = "" ></p>
<p><input type = "submit" value = "Proceed">
<a href= "landscape.php" > Go Back </a> </p>
</form>
</body>
</html>