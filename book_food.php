<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// Required field names
	$required = array('itemNumber', 'meal', 'orderDate', 'quantity');

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
          	header('Location: book_food.php' );
          	return;
	} 

	$sql = "select * from foodMenu where itemNumber=:itemNumber AND meal=:meal";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':itemNumber' => $_POST['itemNumber'],
	':meal' => $_POST['meal']
        ) );
      	
	if(!$stmt->rowCount())
	{
        	$_SESSION["error"] = "The item Number and meal combination entered does not exist.";
        	header('Location: book_food.php');
        	return ;
        }

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$price = $rows[0]['price'];
	$foodname = $rows[0]['name'];

	date_default_timezone_set("Asia/Calcutta");
	if($_POST['meal']=='Breakfast')
	{
		if(date("Y-m-d")==$_POST['orderDate'] && date("H") >= 7)
		{
			$error = "Sorry, it's too late to book for breakfast for the given date.";
		}
	}

	if($_POST['meal']=='Lunch')
	{
		if(date("Y-m-d")==$_POST['orderDate'] && date("H") >= 13)
		{
			$error = "Sorry, it's too late to book for lunch for the given date.";
		}
	}
	
	if($_POST['meal']=='Dinner')
	{
		if(date("Y-m-d")==$_POST['orderDate'] && date("H") >= 19)
		{
			$error = "Sorry, it's too late to book for dinner for the given date.";
		}
	}

	if (!empty($error))
	{
  		$_SESSION["error"] = $error;
          	header('Location: book_food.php' );
          	return;
	}

	$sql2 = "INSERT INTO foodBookings(orderId, itemNumber, meal, orderDate, quantity, amount, paymentStatus, username) VALUES (default, :itemNumber, :meal, :orderDate, :quantity, :amount, :paymentStatus, :username)";
      	$stmt2 = $pdo->prepare($sql2);
      	$stmt2->execute(array(
        ':itemNumber' => $_POST['itemNumber'],
        ':meal' => $_POST['meal'],
        ':orderDate' => $_POST['orderDate'],
	':quantity' => $_POST['quantity'],
	':amount' => ($_POST['quantity'])*($price),
	':paymentStatus' => 'pending',
	':username' => $_SESSION['account']
        ) );
      	$_SESSION["success"] = "Food Item {$foodname} (Price: Rs.{$price} per plate) has been booked successfully for {$_POST['meal']} for {$_POST['orderDate']} (Year-Month-Date).";
      	header('Location: guest_house_restaurant.php');
      	return;
}
?>

<html>
<head></head>
<body>
<h1>Book Food:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p> Item Number: <input type = "text" name = "itemNumber" value = "" >*</p>
<p> Choose the Meal time:
<select name="meal">
    <option value="Breakfast">Breakfast</option>
    <option value="Lunch">Lunch</option>
    <option value="Dinner">Dinner</option>
</select> *</p>
<p>Date for booking:<input type = "date" name = "orderDate">*</p>
<p>Number of plates: <input type="number" name="quantity">*</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Book Food">

<a href= "guest_house_restaurant.php" > Go Back </a> </p>
</form>
</body>
</html>