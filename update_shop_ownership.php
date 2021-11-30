<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
?>
<html>
<body  >
<h1>Update Shop Ownership</h1>
<p><a href = "update_owner_shop.php" >Update Shop Owner </a></p>
<p><a href = "update_licence.php" >Update Shop Licence </a></p>
<p><a href = "free_shop.php" >Free a shop </a></p>
<a href= "market.php" > Go Back </a> </p>
</body>
</html>