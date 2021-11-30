<?php
require_once "pdo.php";
 session_start();
?>
<html>
<head></head>
<body>
<h1>IIT Patna  </h1>
<?php
    if( isset( $_SESSION["success"] ) ){## displaying a Login conformation flash message
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
     }
  if(! isset($_SESSION["account"] ) ){     ?>
     <p><a href="login_user.php"> Login as user  </a> </p>
     <p><a href="login_admin.php"> Login as administrator </a> </p>
  <?php }
  else{
    echo('<h2>User Name: '.$_SESSION["account"].' </h2>' );
    echo('<p><a href="guest_house.php"> Guest House Related Services  </a> </p>' );
    echo('<p><a href="landscape.php"> Landscaping Related Services  </a> </p>');
    echo('<p><a href="market.php"> Market Related Services  </a> </p>');
    if($_SESSION["account"] == "admin" ){
        echo('<p><a href="register_user.php"> Register a new user  </a> </p>' );
    }
    echo('<p><a href="logout.php">LogOut </a></p>');
  }
    ?>
</body>
</html>