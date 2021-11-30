<?php
require_once "pdo.php";
 session_start();
 if(! isset($_SESSION["account"] ) ){    
    header('Location: app.php');
 }
 if(isset($_POST["shopid"] ) && isset($_POST["rating" ] ) ){
    $sql ='UPDATE shop set reviews = reviews +1   where shopid = :shopid ';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':shopid' , $_POST['shopid']  , PDO::PARAM_STR ) ; ##array(':account' => $_POST['account'] ) ;
    $stmt->execute();

    $sql ='UPDATE shop set rating = rating + :rating    where shopid = :shopid ';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':shopid' , $_POST['shopid']  , PDO::PARAM_STR ) ; ##array(':account' => $_POST['account'] ) ;
    $stmt->bindParam(':rating' , $_POST['rating']  , PDO::PARAM_STR ) ;
    $stmt->execute();

    $_SESSION["success" ] = "Feedback Submitted";
    header('Location: app.php' );
    return;
 }
?>
<html>
<head></head>
<body>
<form method = "post" >
<p>Shop id : <input type = "text" name = "shopid" value = "" ></p>
<p>
Rating :
<select name = "rating"  >
<option value = "0" >0 </option>
<option value = "1" >1 </option>
<option value = "2" >2 </option>
<option value = "3" >3 </option>
<option value = "4" >4 </option>
<option value = "5" >5 </option>
<option value = "6" >6 </option>
<option value = "7" >7 </option>
<option value = "8" >8 </option>
<option value = "9" >9 </option>
<option value = "10" >10 </option>
</select>
</p>
<p><input type = "submit" value = "Submit" >
</form>
<p> <a href = "market.php" >Go Back </a> </p>
</body>
</html>