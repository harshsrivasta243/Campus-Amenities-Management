<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["name" ] ) ){
      if( ($_POST["name"] == '') || ($_POST["mobile_no"] == '') || ($_POST["email"] == '') || ($_POST["dob"] == '') || ($_POST["wage_per_day"] == '') ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: add_gardener.php' );
          return ;
      }

      $sql = "INSERT INTO gardeners (gardener_id , name , mobile_no , email , dob , wage_per_day) VALUES (default , :name , :mobile_no , :email , :dob , :wage_per_day)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
	':name' => $_POST['name'],
	':mobile_no' => $_POST['mobile_no'],
	':email' => $_POST['email'],
	':dob' => $_POST['dob'],
	':wage_per_day' => $_POST['wage_per_day']
        ) );
      $_SESSION["success"] = "Gardener Added Successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Add Gardener</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Enter Name of Gardener : <input type = "text" name = "name" value = "" ></p>
<p>Enter Mobile Number : <input type = "number" name = "mobile_no" value = "" ></p>
<p>Enter Email : <input type = "text" name = "email" value = "" ></p>
<p>Enter Date of Birth : <input type = "date" name = "dob" value = "" ></p>
<p>Enter Daily Wage : <input type = "number" name = "wage_per_day" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "landscape.php" > Go Back </a> </p>
</form>
</body>
</html>