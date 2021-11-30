<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

	$sql = "select * from attendance_log";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array());

	echo"<h1>Attendance Log</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr><td>";
	echo "Gardener ID";
	echo"</td><td>";
	echo "Name";
	echo"</td><td>";
	echo "Date";  
	echo"</td></tr>\n";
	foreach($rows as $var)
	{
		echo"<tr><td>";
		echo($var['gardener_id']);
		echo"</td><td>";
		echo($var['name']);
		echo"</td><td>";
		echo($var['attend_date']);
		echo"</td></tr>\n";
	}

	echo('<p><a href = "attendance_log_view.php">Go Back</a></p>');
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