<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["shopid"] ) ){
      if( ($_POST["shopid"] == '') || ($_POST["licence"] == '')    ){
          $_SESSION["error"] = 'Cannot leave and field empty';
          header('Location: update_licence.php' );
          return ;
      }
      $sql = "UPDATE owns SET licence_val= :licence WHERE shopid= :shopid ";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':shopid' => $_POST['shopid'],
        ':licence' => $_POST['licence'],
        ) );
      $_SESSION["success"] = "Updated Successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Update Licence</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>Shop id : <input type = "text" name = "shopid" value = "" ></p>
<p>Licence Validity <input type = "text" name = "licence" value = "" > </p>
<p><input type = "submit" value = "Update" >
<a href= "update_shop_ownership.php" > Go Back </a> </p>
</form>
</body>
</html>