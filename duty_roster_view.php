<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

	$sql = "select * from duty_roster";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array());

	echo"<h1>Assigned Duties</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr><td>";
	echo "Gardener ID";
	echo"</td><td>";
	echo "Location ID";
	echo"</td><td>";
	echo "Duty Begin Date";
  	echo"</td><td>";
	echo "Duty End Date";
	echo"</td><td>";
	echo "Assignments";
	echo"</td></tr>\n";
	foreach($rows as $var)
	{
		echo"<tr><td>";
		echo($var['gardener_id']);
		echo"</td><td>";
		echo($var['location_id']);
		echo"</td><td>";
		echo($var['duty_beg_date']);
		echo"</td><td>";
		echo($var['duty_end_date']);
		echo"</td><td>";
		echo($var['assignments']);
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