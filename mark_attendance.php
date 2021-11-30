<?php
require_once "pdo.php";
session_start();
    
  if(isset($_POST["gardener_id" ] ) ){
      if( ($_POST["gardener_id"] == '') || ($_POST["name"] == '')  ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: mark_attendance.php' );
          return ;
      }
      
      $sql2 ='SELECT gardener_id,name FROM attendance_log WHERE gardener_id = :gardener_id AND attend_date = curdate()';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute(array(
      ':gardener_id' => $_POST['gardener_id']));
      if($stmt2->rowCount()){
        $_SESSION["error"] = "Attendance Already Marked for Today.";
        header('Location: mark_attendance.php' );
        return ;
      }

      $sql = "INSERT INTO attendance_log (gardener_id , name , attend_date) VALUES (:gardener_id , :name , curdate() )";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
	':gardener_id' => $_POST['gardener_id'],
	':name' => $_POST['name']
        ) );
      $_SESSION["success"] = "Attendance Marked Successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Mark Attendance</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Enter Gardener ID : <input type = "number" name = "gardener_id" value = "" ></p>
<p>Enter Name : <input type = "text" name = "name" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "landscape.php" > Go Back </a> </p>
<p>Submitting will mark attendance for today only.</p>
</form>
</body>
</html>