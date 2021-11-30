<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["shopid" ] ) ){
      if( ($_POST["shopid"] == '') || ($_POST["plotid"] == '')   ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: register_shop.php' );
          return ;
      }
      $sql2 ='SELECT shopid FROM shop  WHERE shopid = :shopid';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':shopid' , $_POST['shopid']  , PDO::PARAM_STR ) ;
      $stmt2->execute();
      $org_pw2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if($org_pw2 ){
        $_SESSION["error"] = "Shop-id taken.";
        header('Location: register_shop.php' );
        return ;
      }

      $sql2 ='SELECT plotid FROM shop  WHERE plotid = :plotid';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':plotid' , $_POST['plotid']  , PDO::PARAM_STR ) ;
      $stmt2->execute();
      $org_pw2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if($org_pw2 ){
        $_SESSION["error"] = "Plot not free.";
        header('Location: register_shop.php' );
        return ;
      }

      $sql = "INSERT INTO shop (shopid, plotid , rating , reviews) VALUES (:shopid, :plotid , 0 , 0)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':shopid' => $_POST['shopid'],
        ':plotid' => $_POST['plotid']
        ) );
      $_SESSION["success"] = "User Registered successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Register a new Shop</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Shop id : <input type = "text" name = "shopid" value = "" ></p>
<p>Plot id : <input type = "text" name = "plotid" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "market.php" > Go Back </a> </p>
</form>
</body>
</html>