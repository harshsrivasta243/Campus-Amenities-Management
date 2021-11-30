<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }

if(isset($_POST["name" ] ) ){
      if( ($_POST["name"] == '') || ($_POST["fuel_type"] == '') || ($_POST["stock_quantity"] == '') || ($_POST["operating_cost_per_day"] == '') ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: add_equipment.php' );
          return ;
      }
/*
prepare() - returns a statement object or FALSE if an error occurred.
bind_param() - Returns TRUE on success or FALSE on failure.
execute() - Returns TRUE on success or FALSE on failure. 
*/
      $sql2 ='SELECT * FROM equipments WHERE name = :name';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute(array(
      ':name' => $_POST['name']));
      if($stmt2->rowCount()){
	 $sql = 'UPDATE equipments set stock_quantity = stock_quantity + :stock_quantity where name = :name';
	 $stmt = $pdo->prepare($sql);
	 $stmt->execute(array(
	 ':name' => $_POST['name'],
	 ':stock_quantity' => $_POST['stock_quantity']));

	 $sql3 = 'UPDATE equipments set available = available + :stock_quantity where name = :name';
	 $stmt = $pdo->prepare($sql3);
	 $stmt->execute(array(
	 ':name' => $_POST['name'],
	 ':stock_quantity' => $_POST['stock_quantity']));

	 $_SESSION["success"] = "Equipment was already in database, stock and availability updated.";
	 header('Location: landscape.php' );
	 return;
      }
      else 
      { 
	$sql = "INSERT INTO equipments(equipment_id, name, fuel_type, stock_quantity, ongoing_maintenance, available, operating_cost_per_day) VALUES (default, :name, :fuel_type, :stock_quantity, 0, :stock_quantity, :operating_cost_per_day)";
      	$stmt = $pdo->prepare($sql);
      	$stmt->execute(array(
        ':name' => $_POST['name'],
        ':fuel_type' => $_POST['fuel_type'],
        ':stock_quantity' => $_POST['stock_quantity'],
	':operating_cost_per_day' => $_POST['operating_cost_per_day']
        ) );
      $_SESSION["success"] = "New Equipment added successfully.";
      header('Location: landscape.php' );
      return ;
     }
}
?>
<html>
<body  >
<h1>Add Equipment</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p> Name of Equipment: <input type = "text" name = "name" value = "" ></p>
<p> Fuel Type of Equipment: 
<select type = "text" name = "fuel_type">
    <option value="Manual">Manual</option>
    <option value="Petrol">Petrol</option>
    <option value="Diesel">Diesel</option>
    <option value="Electricity">Electricity</option>
</select></p>
<p> Enter Number of Equipments: <input type = "number" name = "stock_quantity" value = "" ></p>
<p> Enter Per Day Operating Cost: <input type = "number" name = "operating_cost_per_day" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "landscape.php" > Go Back </a> </p>
</form>
</body>
</html>