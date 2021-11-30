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
	$required = array('staffId', 'day', 'durationInHours');

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
          	header('Location: add_duty.php' );
          	return;
	} 
	
	$sql2 ='SELECT staffId FROM staff WHERE staffId = :staffId';
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(array(
        ':staffId' => $_POST['staffId']));
        if(!$stmt2->rowCount())
	{
        	$_SESSION["error"] = "Sorry, The entered staff Id does not exist!";
        	header('Location: add_duty.php');
        	return ;
        }

	$sql3 ='SELECT * FROM duties WHERE staffId = :staffId AND day = :day';
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute(array(
        ':staffId' => $_POST['staffId'],
	':day' => $_POST['day']
	));
        if($stmt3->rowCount())
	{
        	$_SESSION["error"] = "Sorry, The duty for the corresponding staff and the day is already assigned.";
        	header('Location: add_duty.php');
        	return ;
        }

	$sql = "INSERT INTO duties(staffId, day, durationInHours) VALUES (:staffId, :day, :durationInHours)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':staffId' => $_POST['staffId'],
        ':day' => $_POST['day'],
        ':durationInHours' => $_POST['durationInHours']
        ) );
      	$_SESSION["success"] = "Duty Added successfully!";
      	header('Location: guest_house_staff.php' );
      	return ;
}
?>

<html>
<head></head>
<body>
<h1>Add a new duty schedule:</h1>

<?php
if(isset($_SESSION["error"])){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>

<form method="post">

<p>Staff Id:<input type = "text" name = "staffId">*</p>

<p> Choose the day of the week:
<select name="day">
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
    <option value="Sunday">Sunday</option>
</select> *</p>

<p>Duration(in hours):<input type="number" name="durationInHours">*</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Add Duty">

<a href= "guest_house_staff.php" > Go Back </a> </p>

</form>
</body>
</html>