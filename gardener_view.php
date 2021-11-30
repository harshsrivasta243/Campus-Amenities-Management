<?php
require_once "pdo.php";
 session_start();
 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }
?>
<html>
<head></head>
<body>
<h1>View Gardener Details</h1>
<?php
    if( isset( $_SESSION["success"] ) ){
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n"  );
        unset($_SESSION["success"] );
    }
    
        echo('<p><a href = "search_by_name.php" >Search Gardener(s) by Name </a></p> ');
        echo('<p><a href = "list_view.php" >View Whole List of Gardeners </a></p> ');
	 
?>
<p> <a href = "landscape.php" >Go Back </a> </p>
</body>
</html>