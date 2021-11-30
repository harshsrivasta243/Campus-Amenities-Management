<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }

if(isset($_POST["roomNumber" ] ) ){
      if( ($_POST["roomNumber"] == '') || ($_POST["capacity"] == '') || ($_POST["ac"] == '') || ($_POST["bed"] == '') || ($_POST["chargePerDay"] == '') ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: add_room.php' );
          return ;
      }
/*
prepare() - returns a statement object or FALSE if an error occurred.
bind_param() - Returns TRUE on success or FALSE on failure.
execute() - Returns TRUE on success or FALSE on failure. 
*/
      $sql2 ='SELECT roomNumber FROM rooms  WHERE roomNumber = :roomNumber';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute(array(
      ':roomNumber' => $_POST['roomNumber']));
      if($stmt2->rowCount()){
        $_SESSION["error"] = "The asked Room number is already added";
        header('Location: add_room.php' );
        return ;
      }
      

      $sql = "INSERT INTO rooms(roomNumber, capacity, ac, bed, chargePerDay) VALUES (:roomNumber, :capacity, :ac, :bed, :chargePerDay)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':roomNumber' => $_POST['roomNumber'],
        ':capacity' => $_POST['capacity'],
        ':ac' => $_POST['ac'],
        ':bed' => $_POST['bed'],
        ':chargePerDay' => $_POST['chargePerDay']
        ) );
      $_SESSION["success"] = "Room Added successfully!";
      header('Location: rooms.php' );
      return ;
}
?>
<html>
<body  >
<h1>Add a new room.</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p> Room Number: <input type = "text" name = "roomNumber" value = "" >*</p>
<p> Choose the capacity of the room:
<select name="capacity">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
</select> *</p>
<p> Choose the AC Type of the room:
<select name="ac">
    <option value="1">Non-AC</option>
    <option value="2">AC</option>
</select> *</p>
<p> Choose the Bed Type of the room:
<select name="bed">
    <option value="1">Single</option>
    <option value="2">Double</option>
</select> *</p>
<p>ChargePerDay(in Rupees) : <input type="number" name="chargePerDay">*</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Add Room">
<a href= "rooms.php" > Go Back </a> </p>
</form>
</body>
</html>