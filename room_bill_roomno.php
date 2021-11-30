<?php

require_once "pdo.php";

session_start();
if($_SESSION["account"] != "admin" ){
header('Location: app.php' );
return;
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// Required field names
	$required = array('roomNumber', 'fromDate', 'toDate');

	// Loop over field names, make sure each one exists and is not empty
	$error = '';
	foreach($required as $field)
	{
  		if(empty($_POST[$field]))
		{
    			$error = "Sorry, you didn't fill the required field for {$field}";
			break;
  		}
	}

	if (!empty($error))
	{
  		$_SESSION["error"] = $error;
          	header('Location: room_bill_roomno.php' );
          	return;
	} 

      	$sql = "select * from roomBookings WHERE roomNumber=:roomNumber AND fromDate=:fromDate AND toDate=:toDate";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
	':roomNumber' => $_POST['roomNumber'],
	':fromDate' => $_POST['fromDate'],
	':toDate' => $_POST['toDate']
	));
	
	echo"<h1>the corresponding Booking for your query is:</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr>";
	echo"<td>Booking Id</td>";
	echo"<td>Room Number</td>";
	echo"<td>From Date</td>";
	echo"<td>To Date</td>";
	echo"<td>Amount</td>";
	echo"<td>Booked By</td>";
	echo"<td>Payment Status</td>";
	echo"</tr>\n";
	foreach($rows as $var)
	{
		echo"<tr>";
		foreach($var as $key => $val)
		{
			echo"<td>{$val}</td>";
		}
		echo"</tr>";
	}

	echo('<p><a href = "rooms.php">Go Back</a></p>');
      	return;
}
?>

<html>
<head></head>
<body>
<h1>Check your booking:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Starting date of stay:<input type = "date" name = "fromDate">*</p>
<p>Ending date:<input type = "date" name = "toDate">*</p>
<p> Room Number: <input type = "text" name = "roomNumber" value = "" >*</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Proceed">
<a href= "rooms.php" > Go Back </a> </p>
</form>
</body>
</html>