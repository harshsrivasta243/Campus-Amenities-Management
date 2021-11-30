<?php
require_once "pdo.php";
session_start();
if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }
    
  if(isset($_POST["userid" ] ) ){
      if( ($_POST["userid"] == '') || ($_POST["location_id"] == '')   ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: req_grass_cut.php' );
          return ;
      }
      $sql2 ='SELECT * FROM requests WHERE userid = :userid and location_id = :location_id';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':userid' , $_POST['userid']  , PDO::PARAM_STR ) ;
      $stmt2->bindParam(':location_id' , $_POST['location_id'], PDO::PARAM_STR ) ;
      $stmt2->execute();
      $org_pw2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if($org_pw2 ){
        $_SESSION["error"] = "Request already registered.";
        header('Location: req_grass_cut.php' );
        return ;
      }

      $sql = "INSERT INTO requests (userid, location_id , req_date , status) VALUES (:userid, :location_id , curdate() , 'Pending')";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':userid' => $_POST['userid'],
        ':location_id' => $_POST['location_id']
        ) );
      $_SESSION["success"] = "Grass-cutting request registered successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Register Grass-Cutting Request</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>User ID : <input type = "text" name = "userid" value = "" ></p>
<p>Location ID : <input type = "number" name = "location_id" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "landscape.php" > Go Back </a> </p>
</form>
</body>
</html>