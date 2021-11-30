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
	$required = array('fromDate');

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
          	header('Location: see_food_bookings.php' );
          	return;
	} 

      	$sql = "select * from foodBookings where orderDate>=:fromDate";
	if($_POST['paymentStatus']!='any')
	{
		$sql .= " AND paymentStatus = '" . $_POST['paymentStatus']. "'";
	}
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
	':fromDate' => $_POST['fromDate'] ));
	
	echo"<h1>Following are the food bookings:</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr>";
	echo"<td>Order Id</td>";
	echo"<td>Item Number</td>";
	echo"<td>Meal</td>";
	echo"<td>Order Date</td>";
	echo"<td>Quantity</td>";
	echo"<td>Amount</td>";
	echo"<td>Payment Status</td>";
	echo"<td>Booked by</td>";
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

	echo('<p><a href = "guest_house_restaurant.php">Go Back</a></p>');
	return;
}
?>

<html>
<head></head>
<body>
<h1>See the food bookings:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Choose date to see food orders on and after the chosen date:<input type = "date" name = "fromDate">*</p>
<p> Choose the payment status of bookings to view records (choose any to see all types):
<select name="paymentStatus">
    <option value="any">any</option>
    <option value="pending">Payment Pending</option>
    <option value="done">Payment Done</option>
</select> *</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Proceed">
<a href= "guest_house_restaurant.php" > Go Back </a> </p>
</form>
</body>
</html>