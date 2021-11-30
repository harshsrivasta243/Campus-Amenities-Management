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
	$required = array('staffId', 'name', 'age', 'gender', 'mobileNumber');

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
          	header('Location: add_staff.php' );
          	return;
	} 
	
	$sql2 ='SELECT staffId FROM staff WHERE staffId = :staffId';
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(array(
        ':staffId' => $_POST['staffId']));
        if($stmt2->rowCount())
	{
        	$_SESSION["error"] = "The asked Staff member Id is already added";
        	header('Location: add_staff.php');
        	return ;
        }

	$sql = "INSERT INTO staff(staffId, name, age, gender, mobileNumber) VALUES (:staffId, :name, :age, :gender, :mobileNumber)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':staffId' => $_POST['staffId'],
        ':name' => $_POST['name'],
        ':age' => $_POST['age'],
        ':gender' => $_POST['gender'],
        ':mobileNumber' => $_POST['mobileNumber']
        ) );
      	$_SESSION["success"] = "Staff Added successfully!";
      	header('Location: guest_house_staff.php' );
      	return ;
}
?>

<html>
<head></head>
<body>
<h1>Add a new staff member:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>

<form method="post">

<p>Staff Id:<input type = "text" name = "staffId">*</p>

<p>Name:<input type = "text" name = "name">*</p>

<p>Age(in years):<input type="number" name="age">*</p>

<p> Choose the Meal time:
<select name="gender">
    <option value="M">Male</option>
    <option value="F">Female</option>
</select> *</p>

<p>Mobile Number:<input type="number" name="mobileNumber">*</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Add Staff">

<a href= "guest_house_staff.php" > Go Back </a> </p>

</form>
</body>
</html>