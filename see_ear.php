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
	$required = array('earDate');

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
          	header('Location: see_ear.php' );
          	return;
	} 

      	$sql = "select * from earnings where earDate>=:earDate";
	if($_POST['type']!='all')
	{
		$sql .= ' AND type = ' . $_POST['type'];
	}
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
	':earDate' => $_POST['earDate'] ));
	
	echo"<h1>Following are the earnings:</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr>";
	echo"<td>Earning Date</td>";
	echo"<td>Description</td>";
	echo"<td>Amount</td>";
	echo"<td>Type</td>";
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

	echo('<p><a href = "exp_ear_page.php">Go Back</a></p>');
      	return;
}
?>

<html>
<head></head>
<body>
<h1>Check the earnings record:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Choose date to see earnings on and after the chosen date:<input type = "date" name = "earDate">*</p>
<p> Choose the type of earnings to view records (choose all to see all types):
<select name="type">
    <option value="all">all</option>
    <option value="room">room maintaenance related</option>
    <option value="food">food related</option>
    <option value="other">other than room and food earnings</option>
</select> *</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Proceed">
<a href= "exp_ear_page.php" > Go Back </a> </p>
</form>
</body>
</html>