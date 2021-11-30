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
	$required = array('earDate', 'type', 'amount');

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
          	header('Location: add_earning.php' );
          	return;
	}

	$sql = "INSERT INTO earnings(earDate, description, type, amount) VALUES (:earDate, :description, :type, :amount)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':earDate' => $_POST['earDate'],
        ':description' => $_POST['description'],
        ':type' => $_POST['type'],
        ':amount' => $_POST['amount'],
        ) );
      	$_SESSION["success"] = "Earning Added successfully!";
      	header('Location: exp_ear_page.php' );
      	return ;
}
?>

<html>
<head></head>
<body>
<h1>Add a new earning:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>

<form method="post">

<p>Earning Date:<input type = "date" name = "earDate">*</p>

<p> Choose the Type of earning:
<select name="type">
    <option value="room">Room Booking earning</option>
    <option value="food">Food Booking earning</option>
    <option value="other">Other</option>
</select> *</p>

<p> Description: </p>
<textarea name="description" rows="3" cols="50">
</textarea>

<p>Amount(in Rupees):<input type="number" name="amount">*</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Proceed">

<a href= "exp_ear_page.php" > Go Back </a> </p>

</form>
</body>
</html>