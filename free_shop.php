<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["shopid"] ) ){
      $sql = "DELETE from owns  WHERE shopid= :shopid ";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':shopid' => $_POST['shopid']
        ) );
      $_SESSION["success"] = "Shop freed Successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Free Shop</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Shop id : <input type = "text" name = "shopid" value = "" ></p>
<p><input type = "submit" value = "Update" >
<a href= "update_shop_ownership.php" > Go Back </a> </p>
</form>
</body>
</html>