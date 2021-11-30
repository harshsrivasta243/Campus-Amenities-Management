<?php

require_once "pdo.php";

session_start();
 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// Required field names
	$required = array('roomNumber', 'description');

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
          	header('Location: register_complaint.php' );
          	return;
	} 
	
	$sql2 ='SELECT roomNumber FROM rooms WHERE roomNumber = :roomNumber';
        $stmt2 = $pdo->prepare($sql2);
       	$stmt2->execute(array(
       	':roomNumber' => $_POST['roomNumber']));
       	if(!$stmt2->rowCount())
	{
        	$_SESSION["error"] = "Sorry, The entered room number does not exist!";
        	header('Location: register_complaint.php');
        	return;
        }

	$sql = "INSERT INTO complaints(complaintId, roomNumber, description, status, username) VALUES (default, :roomNumber, :description, :status, :username)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':roomNumber' => $_POST['roomNumber'],
        ':description' => $_POST['description'],
        ':status' => '1',
	':username' => $_SESSION['account']
        ) );
      	$_SESSION["success"] = "Complaint Registered successfully!";
      	header('Location: rooms.php' );
      	return ;
}
?>

<html>
<head></head>
<body>
<h1>Register a complaint:</h1>

<?php
if(isset($_SESSION["error"])){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>

<form method="post">

<p>Room Number:<input type = "text" name = "roomNumber">*</p>

<p> Description: </p>
<textarea name="description" rows="3" cols="50">
</textarea>*

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Register Complaint">

<a href= "rooms.php" > Go Back </a> </p>

</form>
</body>
</html>