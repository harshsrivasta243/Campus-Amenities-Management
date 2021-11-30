<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["gardener_id" ] ) ){
      if( ($_POST["gardener_id"] == '') || ($_POST["location_id"] == '') || ($_POST["duty_beg_date"] == '') || ($_POST["duty_end_date"] == '') || ($_POST["assignments"] == '') ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: assign_duty.php' );
          return ;
      }

      $sql = "INSERT INTO duty_roster (gardener_id , location_id , duty_beg_date , duty_end_date , assignments) VALUES (:gardener_id , :location_id , :duty_beg_date , :duty_end_date , :assignments)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
	':gardener_id' => $_POST['gardener_id'],
	':location_id' => $_POST['location_id'],
	':duty_beg_date' => $_POST['duty_beg_date'],
	':duty_end_date' => $_POST['duty_end_date'],
	':assignments' => $_POST['assignments']
        ) );
      $_SESSION["success"] = "Duty Assignment Successful.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Assign Duty to Gardener</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Enter Gardener ID: <input type = "number" name = "gardener_id" value = "" ></p>
<p>Enter Location ID : <input type = "number" name = "location_id" value = "" ></p>
<p>Enter Commence Date : <input type = "date" name = "duty_beg_date" value = "" ></p>
<p>Enter End Date : <input type = "date" name = "duty_end_date" value = "" ></p>
<p>Enter Details of Assignment : <input type = "text" name = "assignments" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "landscape.php" > Go Back </a> </p>
</form>
</body>
</html>