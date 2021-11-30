<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

	$sql = "select * from campus_areas";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array());

	echo"<h1>Campus Areas</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr><td>";
	echo "Location Id";
	echo"</td><td>";
	echo "Grass Area(in sq.ft)";
	echo"</td><td>";
	echo "Description";  
	echo"</td></tr>\n";
	foreach($rows as $var)
	{
		echo"<tr><td>";
		echo($var['location_id']);
		echo"</td><td>";
		echo($var['grass_area_sqft']);
		echo"</td><td>";
		echo($var['location_desc']);
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