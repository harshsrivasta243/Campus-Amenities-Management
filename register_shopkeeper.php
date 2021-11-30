<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["shopkeeperid" ] ) ){
      if( ($_POST["shopkeeperid"] == '') || ($_POST["name"] == '') || ($_POST["passvalidity"] == '')    ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: register_shopkeeper.php' );
          return ;
      }
      $sql2 ='SELECT shopkeeperid FROM shopkeeper  WHERE shopkeeperid = :shopkeeperid';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':shopkeeperid' , $_POST['shopkeeperid']  , PDO::PARAM_STR ) ;
      $stmt2->execute();
      $org_pw2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if($org_pw2 ){
        $_SESSION["error"] = "Shopkeeper already registered.";
        header('Location: register_shopkeeper.php' );
        return ;
      }
      $sql = "INSERT INTO shopkeeper (shopkeeperid, name , passvalidity) VALUES (:shopkeeperid, :name , :passvalidity)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':shopkeeperid' => $_POST['shopkeeperid'],
        ':name' => $_POST['name'],
        ':passvalidity' => $_POST['passvalidity']
        ) );
      $_SESSION["success"] = "User Registered successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Register a new Shopkeeper</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Shopkeeper id : <input type = "text" name = "shopkeeperid" value = "" ></p>
<p>Name : <input type = "text" name = "name" value = "" ></p>
<p>Pass-Validity : <input type = "text" name = "passvalidity" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "market.php" > Go Back </a> </p>
</form>
</body>
</html>