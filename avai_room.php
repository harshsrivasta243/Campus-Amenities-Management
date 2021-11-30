<?php

require_once "pdo.php";

session_start();
 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// Required field names
	$required = array('fromDate', 'toDate', 'capacity', 'ac', 'bed', 'chargePerDay');

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
          	header('Location: avai_room.php' );
          	return;
	} 

//mysql> select * from rooms where capacity>=2 AND ac=1 AND bed=1 AND chargePerDay<=1000 AND roomNumber not in (
//    -> select roomNumber from roomBookings where (fromDate<='2021-11-13' AND toDate>='2021-11-13') OR (fromDate>='2021-11-13' AND fromDate<='2021-11-15'));
//Empty set (0.00 sec)

	$sql = "select * from rooms where capacity>=:capacity AND ac>=:ac AND bed>=:bed AND chargePerDay<=:chargePerDay AND roomNumber not in (
select roomNumber from roomBookings where (fromDate<=:fromDate AND toDate>=:fromDate) OR (fromDate>=:fromDate AND fromDate<=:toDate))";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':capacity' => $_POST['capacity'],
        ':bed' => $_POST['bed'],
        ':ac' => $_POST['ac'],
        ':chargePerDay' => $_POST['chargePerDay'],
        ':fromDate' => $_POST['fromDate'],
        ':toDate' => $_POST['toDate']
        ) );
      	
	/*while($stmt)
	{
		print_r($stmt);
	}*/

	/*echo"<pre>/n";
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	while($row)
	{
		print_r($row);
	}
	echo"</pre\n>";*/
	
	echo"<h1> The available rooms for your query are:</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	/*echo"<pre>";
        print_r($rows);
	echo"</pre>";*/
	
	/*echo"<table border=1>";
	while($rows)
	{
		echo"<tr><td>";
		echo($rows['roomNumber']);
		echo"</td><td>";
		echo($rows['capacity']);
		echo"</td><td>";
		echo($rows['ac']);
		echo"</td><td>";
		echo($rows['bed']);
		echo"</td><td>";
		echo($rows['chargePerDay']);
		echo"</td></tr>\n";
	}*/

	/*echo "<pre>";
	echo "Product ID\tAmount";
	foreach ( $array as $var ) {
    		echo "\n", $var['product_id'], "\t\t", $var['amount'];
	}*/

	echo"<table border=1>";
	echo"<tr><td>";
	echo"Room Number";
	echo"</td><td>";
	echo "Capacity of the room";
	echo"</td><td>";
	echo "AC Type of the room";
	echo"</td><td>";
	echo "Bed type of the room";
	echo"</td><td>";
	echo "Charge Per Day of the room";
	echo"</td></tr>\n";
	foreach($rows as $var)
	{
		echo"<tr><td>";
		echo($var['roomNumber']);
		echo"</td><td>";
		echo($var['capacity']);
		echo"</td><td>";
		echo($var['ac'] == 1 ? "Non-AC" : "AC");
		echo"</td><td>";
		echo($var['bed'] == 1 ? "Single" : "Double");
		echo"</td><td>";
		echo "Rs.{$var['chargePerDay']}";
		echo"</td></tr>\n";
	}

	echo('<p><a href = "book_room.php">Book your room now!</a></p>');
      	return;
}
?>

<html>
<head></head>
<body>
<h1>Check the rooms availability:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Starting date to check room availability:<input type = "date" name = "fromDate">*</p>
<p>Ending date:<input type = "date" name = "toDate">*</p>
<p> Choose the minimum capacity required for the room:
<select name="capacity">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
</select>
*
</p>
<p> Choose the desired AC/Non-AC Type of the room:
<select name="ac">
    <option value="1">Non-AC</option>
    <option value="2">AC</option>
</select>
*
</p>
<p> Choose the desired Bed Type of the room:
<select name="bed">
    <option value="1">Single</option>
    <option value="2">Double</option>
</select>
*
</p>
<p>Choose the maximum Charge Per Day (in Rupees) possible: <input type="number" name="chargePerDay">*</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Proceed">
<a href= "rooms.php" > Go Back </a> </p>
</form>
</body>
</html>