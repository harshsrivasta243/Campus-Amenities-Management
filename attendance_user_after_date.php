<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$sql = "select * from attendance_log where gardener_id = :gardener_id and attend_date >= :attend_date";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
	':gardener_id' => $_POST['gardener_id'],
	':attend_date' => $_POST['attend_date']
	 ));

	echo"<h1> Gardener Attendance PortFolio</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr><td>";
	echo "Gardener Id";
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

	echo('<p><a href = "attendance_log_view.php">Another Search</a></p>');
      	return;
}
?>

<html>
<head></head>
<body>
<h1>Gardener Attendance Details</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Enter Gardener ID: <input type = "number" name = "gardener_id" value = "" ></p>
<p>Enter Date after which Attendance is to be Fetched: <input type = "date" name = "attend_date" value = "" ></p>
<p><input type = "submit" value = "Proceed">
<a href= "attendance_log_view.php" > Go Back </a> </p>
</form>
</body>
</html>