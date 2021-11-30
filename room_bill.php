<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// Required field names
	$required = array('type');

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
          	header('Location: room_bill.php' );
          	return;
	} 

      	$sql = "select * from roomBookings WHERE username = :username";
	if($_POST['type']!='all')
	{
		$sql .= " AND paymentStatus = '" . $_POST['type'] . "'";
	}
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
	':username' => $_SESSION['account']));
	
	echo"<h1>Your Bookings:</h1>";

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

	$totalamt = 0;
	foreach($rows as $var)
	{
		echo"<tr>";
		foreach($var as $key => $val)
		{
			echo"<td>{$val}</td>";
		}
		echo"</tr>";
		$totalamt += $var['amount'];
	}

	echo('<p><a href = "rooms.php">Go Back</a></p>');

	if($_POST['type']=='pending'){echo "Total bill amount for your bookings is : Rs.{$totalamt}.";}
	return;
}
?>

<html>
<head></head>
<body>
<h1>Check your bookings:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p> Choose payment status to see bookings of that status(choose all to see all bookings):
<select name="type">
    <option value="all">all</option>
    <option value="pending">Payment Pending</option>
    <option value="done">Payment Done</option>
</select>*
</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Proceed">
<a href= "rooms.php" > Go Back </a> </p>
</form>
</body>
</html>