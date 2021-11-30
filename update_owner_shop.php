<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["shopkeeperid"] ) ){
      if( ($_POST["shopid"] == '') || ($_POST["shopkeeperid"] == '') || ($_POST["licence"] == '')    ){
          $_SESSION["error"] = 'Cannot leave and field empty';
          header('Location: update_owner_shop.php' );
          return ;
      }
      $sql2 ='SELECT shopid FROM owns  WHERE shopid = :shopid';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':shopid' , $_POST['shopid']  , PDO::PARAM_STR ) ;
      $stmt2->execute();
      $org_pw2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if($org_pw2 ){
        $_SESSION["error"] = "Shop assigned to a shopkeeper.";
        header('Location: update_owner_shop.php' );
        return ;
      }

      $sql2 ='SELECT shopid FROM shop  WHERE shopid = :shopid';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':shopid' , $_POST['shopid']  , PDO::PARAM_STR ) ;
      $stmt2->execute();
      $org_pw2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if(!$org_pw2 ){
        $_SESSION["error"] = "Shop doesn't exists.";
        header('Location: update_owner_shop.php' );
        return ;
      }

      $sql = "INSERT INTO owns (shopkeeperid, shopid , licence_val ) VALUES (:shopkeeperid, :shopid , :licence_val)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':shopkeeperid' => $_POST['shopkeeperid'],
        ':shopid' => $_POST['shopid'],
        ':licence_val' => $_POST['licence'],
        ) );
      $_SESSION["success"] = "Updated Successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Update Owner</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Shop id : <input type = "text" name = "shopid" value = "" ></p>
<p>Shopkeeper id : <input type = "text" name = "shopkeeperid" value = "" ></p>
<p>Licence Validity <input type = "text" name = "licence" value = "" > </p>
<p><input type = "submit" value = "Update" >
<a href= "update_shop_ownership.php" > Go Back </a> </p>
</form>
</body>
</html>