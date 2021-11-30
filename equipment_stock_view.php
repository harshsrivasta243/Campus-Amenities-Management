<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

	$sql = "select * from equipments";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array());

	echo"<h1>Equipments Details</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr><td>";
	echo "Equipment ID";
	echo"</td><td>";
	echo "Name of Equipment";
	echo"</td><td>";
	echo "Fuel Type";
	echo"</td><td>";
	echo "Net Stock";
	echo"</td><td>";
	echo "Equipments under Maintenance Currently";
	echo"</td><td>";
	echo "Equipments Available";
	echo"</td><td>";
	echo "Per Day Operating Cost";  
	echo"</td></tr>\n";
	foreach($rows as $var)
	{
		echo"<tr><td>";
		echo($var['equipment_id']);
		echo"</td><td>";
		echo($var['name']);
		echo"</td><td>";
		echo($var['fuel_type']);
		echo"</td><td>";
		echo($var['stock_quantity']);
		echo"</td><td>";
		echo($var['ongoing_maintenance']);
		echo"</td><td>";
		echo($var['available']);
		echo"</td><td>";
		echo "Rs.{$var['operating_cost_per_day']}";
		echo"</td></tr>\n";
	}

	echo('<p><a href = "landscape.php">Go Back</a></p>');
      	return;
?>

<html>
<head></head>
<body>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
</body>
</html>