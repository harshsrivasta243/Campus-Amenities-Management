<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["grass_area_sqft" ] ) ){
      if( ($_POST["grass_area_sqft"] == '') || ($_POST["location_desc"] == '')  ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: add_campus_area.php' );
          return ;
      }

      $sql = "INSERT INTO campus_areas (location_id , grass_area_sqft , location_desc) VALUES (default , :grass_area_sqft , :location_desc )";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
	':grass_area_sqft' => $_POST['grass_area_sqft'],
	':location_desc' => $_POST['location_desc']
        ) );
      $_SESSION["success"] = "Campus Area Added Successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Add Campus Area</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Grass Area in Sq.Ft : <input type = "number" name = "grass_area_sqft" value = "" ></p>
<p>Location Description : <input type = "text" name = "location_desc" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "landscape.php" > Go Back </a> </p>
</form>
</body>
</html>