<?php

require_once "pdo.php";

session_start();

 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$sql = "select * from gardeners where name = :name";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
	':name' => $_POST['name'] ));

	echo"<h1> The details of gardeners with the given name are:</h1>";

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo"<table border=1>";
	echo"<tr><td>";
	echo "Gardener Id";
	echo"</td><td>";
	echo "Name";
	echo"</td><td>";
	echo "Mobile No";
	echo"</td><td>";
	echo "Email";
	echo"</td><td>";
	echo "DoB";
	echo"</td><td>";
	echo "Wage Per Day";  
	echo"</td></tr>\n";
	foreach($rows as $var)
	{
		echo"<tr><td>";
		echo($var['gardener_id']);
		echo"</td><td>";
		echo($var['name']);
		echo"</td><td>";
		echo($var['mobile_no']);
		echo"</td><td>";
		echo($var['email']);
		echo"</td><td>";
		echo($var['dob']);
		echo"</td><td>";
		echo "Rs.{$var['wage_per_day']}";
		echo"</td></tr>\n";
	}

	echo('<p><a href = "gardener_view.php">Another Search</a></p>');
      	return;
}
?>

<html>
<head></head>
<body>
<h1>Search Gardener(s) by name:</h1>

<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Enter name: <input type = "text" name = "name" value = "" ></p>

<p><input type = "submit" value = "Proceed">
<a href= "gardener_view.php" > Go Back </a> </p>
</form>
</body>
</html>