<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

	$sql = "select * from requests";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array());

	echo"<h1>Grass Cutting Requests</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr><td>";
	echo "Requester User ID";
	echo"</td><td>";
	echo "Location ID";
	echo"</td><td>";
	echo "Request Date";
	echo"</td><td>";
	echo "Status";  
	echo"</td></tr>\n";
	foreach($rows as $var)
	{
		echo"<tr><td>";
		echo($var['userid']);
		echo"</td><td>";
		echo($var['location_id']);
		echo"</td><td>";
		echo($var['req_date']);
		echo"</td><td>";
		echo($var['status']);
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