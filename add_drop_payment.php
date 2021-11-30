<?php
require_once "pdo.php";
session_start();
    if($_SESSION["account"] != "admin" ){
        header('Location: app.php' );
        return ;
    }
  if(isset($_POST["slipid"] ) ){
      if( ($_POST["slipid"] == '')    ){
          $_SESSION["error"] = 'Cannot leave slip id empty';
          header('Location: add_drop_payment.php' );
          return ;
      }
      if($_POST["shopid"] == '' ){
        $sql = "DELETE FROM charges where slipid = :slipid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
          ':slipid' => $_POST['slipid']
          ) );
        $_SESSION["success"] = "Updated Successfully.";
        header('Location: app.php' );
        return ;
      }

      $sql = "INSERT INTO dues (slipid, type , amount ,deadline ) VALUES (:slipid, :type , :amount , :deadline)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':slipid' => $_POST['slipid'],
        ':type' => $_POST['type'],
        ':amount' => $_POST['amount'],
        ':deadline' => $_POST['deadline']
        ) );

        $sql = "INSERT INTO charges (slipid, shopid ) VALUES (:slipid, :shopid )";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':slipid' => $_POST['slipid'],
        ':shopid' => $_POST['shopid'],
        ) );
        
      $_SESSION["success"] = "Updated Successfully.";

      header('Location: app.php' );
      return ;
  }
?>
<html>
<body  >
<h1>ADD/DROP Bills</h1>
<h1>To Drop a bill, Fill slip id and leave other fields empty</h1>
<?php
if(isset($_SESSION["error"] ) ){
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>
<form method = "post">
<p> Slip id : <input type = "text" name = "slipid" value = "" ></p>
<p>Shop id : <input type = "text" name = "shopid" value = "" ></p>
<p>Type : <select name  = "type" >
            <option value = "fine"> Fine  </option>
            <option value = "electric"> Electricity  </option>
            <option value = "rent"> Rent  </option>
           </select>
</p>
<p>Amount <input type = "text" name = "amount" value = "" > </p>
<p>Deadline <input type = "text" name = "deadline" value = "" > </p>
<p><input type = "submit" value = "Add" >
<a href= "market.php" > Go Back </a> </p>
</form>
</body>
</html>