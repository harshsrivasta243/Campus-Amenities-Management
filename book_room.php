<?php

require_once "pdo.php";

session_start();
 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
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
          	header('Location: book_room.php' );
          	return;
	} 

	$sql = "select * from rooms where roomNumber=:roomNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':roomNumber' => $_POST['roomNumber']
        ) );
      	
	if(!$stmt->rowCount())
	{
        	$_SESSION["error"] = "The room Number entered does not exist";
        	header('Location: book_room.php');
        	return ;
        }

	$sql2 = "select * from rooms where roomNumber=:roomNumber AND roomNumber not in (
select roomNumber from roomBookings where (fromDate<=:fromDate AND toDate>=:fromDate) OR (fromDate>=:fromDate AND fromDate<=:toDate))";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(array(
        ':roomNumber' => $_POST['roomNumber'],
        ':fromDate' => $_POST['fromDate'],
        ':toDate' => $_POST['toDate'],
        ) );
	
	if(!$stmt2->rowCount())
	{
        	$_SESSION["error"] = "The room Number entered was already taken for the given dates, sorry!";
        	header('Location: book_room.php');
        	return ;
        }

	$rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
	$chargePerDay = $rows[0]['chargePerDay'];

	/*$earlier = new DateTime("2010-07-06");
	$later = new DateTime("2010-07-09");
	$abs_diff = $later->diff($earlier)->format("%a"); */

	$fd = new DateTime($_POST['fromDate']);
	$td = new DateTime($_POST['toDate']);
	$abs_diff = $td->diff($fd)->format("%a");

	$sql = "INSERT INTO roomBookings(bookingId, roomNumber, fromDate, toDate, amount, username, paymentStatus) VALUES (default, :roomNumber, :fromDate, :toDate, :amount, :username, :paymentStatus)";
      	$stmt = $pdo->prepare($sql);
      	$stmt->execute(array(
        ':roomNumber' => $_POST['roomNumber'],
        ':fromDate' => $_POST['fromDate'],
        ':toDate' => $_POST['toDate'],
	':username' => $_SESSION['account'],
	':paymentStatus' => 'pending',
	':amount' => ($abs_diff+1)*($chargePerDay)
        ) );
      	$_SESSION["success"] = "Room Number {$_POST['roomNumber']} has been booked successfully for dates(Year-Month-Date) {$_POST['fromDate']} to {$_POST['toDate']} with charge per day being Rs.{$chargePerDay}.";
      	header('Location: rooms.php');
      	return;
}
?>

<html>
<head></head>
<body>
<h1>Book a room:</h1>

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

<p><input type = "submit" value = "Book Room">
<a href= "rooms.php" > Go Back </a> </p>
</form>
</body>
</html>