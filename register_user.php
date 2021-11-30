<?php
require_once "pdo.php";
  session_start();
  if(isset($_POST["account" ] ) ){
      if( ($_POST["account"] == '') || ($_POST["pw"] == '')   ){
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: register_user.php' );
          return ;
      }
      if($_POST["account"] == "admin" ){
        $_SESSION["error"] = 'User cannot be assigned username admin';
        header('Location: register_user.php' );
        return ;
      }
      $sql2 ='SELECT passwd FROM user  WHERE userid = :account';
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':account' , $_POST['account']  , PDO::PARAM_STR ) ;
      $stmt2->execute();
      $org_pw2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if($org_pw2 ){
        $_SESSION["error"] = "User already Registered.";
        header('Location: register_user.php' );
        return ;
      }
      $sql = "INSERT INTO user (userid, passwd) VALUES (:userid, :passwd)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':userid' => $_POST['account'],
        ':passwd' => $_POST['pw']
        ) );
      $_SESSION["success"] = "User Registered successfully.";
      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>Register a new user</h1>
<h2>Enter the credentials</h2>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p>User id : <input type = "text" name = "account" value = "" ></p>
<p>Password: <input type = "password" name = "pw" value = "" ></p>
<p><input type = "submit" value = "Register" >
<a href= "app.php" > Go Back </a> </p>
</form>
</body>
</html>