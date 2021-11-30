<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }

if(isset($_POST["equipment_id" ] ) ){
      if( ($_POST["equipment_id"] == '') || ($_POST["maintenance_rate"] == '') || ($_POST["no_of_equipments"] == '') || ($_POST["maintenance_date"] == '') ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: drop_for_maintenance.php' );
          return ;
      }
/*
prepare() - returns a statement object or FALSE if an error occurred.
bind_param() - Returns TRUE on success or FALSE on failure.
execute() - Returns TRUE on success or FALSE on failure. 
*/
      $sql2 ='SELECT * FROM equipments WHERE equipment_id = :equipment_id';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute(array(
      ':equipment_id' => $_POST['equipment_id']));

      $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      $available = $rows[0]['available'];

      if($available < $_POST['no_of_equipments']){
	$_SESSION["error"] = 'Available Equipments Less Than Those Desired for Maintenance, Please Check Equipment Availability First';
	header('Location: landscape.php' );
	return ;
      }
      else
      {
	 $sql = 'UPDATE equipments set available = available - :no_of_equipments WHERE equipment_id = :equipment_id';
	 $stmt = $pdo->prepare($sql);
	 $stmt->execute(array(
	 ':no_of_equipments' => $_POST['no_of_equipments'],
	 ':equipment_id' => $_POST['equipment_id']));

	 $sql3 = 'UPDATE equipments set ongoing_maintenance = :no_of_equipments WHERE equipment_id = :equipment_id';
	 $stmt3 = $pdo->prepare($sql3);
	 $stmt3->execute(array(
	 ':no_of_equipments' => $_POST['no_of_equipments'],
	 ':equipment_id' => $_POST['equipment_id']));

	 $sql4 = "INSERT INTO maintenance_log (equipment_id, maintenance_rate, no_of_equipments, net_expenditure, maintenance_date, status) VALUES (:equipment_id, :maintenance_rate, :no_of_equipments, (:maintenance_rate)*(:no_of_equipments), :maintenance_date, 'Pending')";
	 $stmt4 = $pdo->prepare($sql4);
	 $stmt4->execute(array(
	 ':equipment_id' => $_POST['equipment_id'],
	 ':maintenance_rate' => $_POST['maintenance_rate'],
	 ':no_of_equipments' => $_POST['no_of_equipments'],
	 ':maintenance_date' => $_POST['maintenance_date']));

	 $_SESSION["success"] = "Equipment Added for Maintenance, Availability Updated.";
	 header('Location: landscape.php' );
	 return;
	}
}
?>
<html>
<body  >
<h1>Drop Equipment For Maintenance</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p> Enter Equipment ID: <input type = "number" name = "equipment_id" value = "" ></p>
<p> Enter Rate of Maintenance: <input type = "number" name = "maintenance_rate" value = "" ></p>
<p> Enter Number of Equipments: <input type = "number" name = "no_of_equipments" value = "" ></p>
<p> Enter Date of Maintenance Drop: <input type = "date" name = "maintenance_date" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "landscape.php" > Go Back </a> </p>
</form>
</body>
</html>