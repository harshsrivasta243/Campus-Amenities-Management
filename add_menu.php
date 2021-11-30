<?php

require_once "pdo.php";

session_start();

if($_SESSION["account"] != "admin" )
{
	header('Location: app.php' );
	return;
}

if( isset($_POST["itemNumber"]) )
{
      if( ($_POST["itemNumber"]=='') || ($_POST["name"]=='') || ($_POST["price"]=='') )
      {
          $_SESSION["error"] = 'Cannot leave any field empty';
          header('Location: add_menu.php' );
          return ;
      }

      $sql2 ="SELECT * FROM foodMenu  WHERE itemNumber = :itemNumber and meal = :meal";
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute(array(
      ':itemNumber' => $_POST['itemNumber'],
      ':meal' => $_POST['meal']
      ));
      if($stmt2->rowCount()){
        $_SESSION["error"] = "The asked item in the given meal time is already added";
        header('Location: add_menu.php' );
        return ;
      }

      $sql = "INSERT INTO foodMenu (itemNumber, name, meal, price) VALUES (:itemNumber, :name, :meal, :price)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':itemNumber' => $_POST['itemNumber'],
        ':name' => $_POST['name'],
        ':meal' => $_POST['meal'],
        ':price' => $_POST['price'],
        ) );
      $_SESSION["success"] = "Item added in the menu successfully.";
      header('Location: guest_house_restaurant.php' );
      return ;
}
?>

<html>
<body  >
<h1>Add a new delicious item to the menu, yum!</h1>

<?php
if(isset($_SESSION["error"]))
{
  echo('<p style="color:red"> '.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"] );
}
?>

<form method = "post">
<p>Item Number : <input type = "text" name = "itemNumber" value = "" >*</p>
<p>Name : <input type = "text" name = "name" value = "" >*</p>
<p> Choose the Meal time for the item:
<select name="meal">
    <option value="Breakfast">Breakfast</option>
    <option value="Lunch">Lunch</option>
    <option value="Dinner">Dinner</option>
</select> *</p>
<p>Price(in Rupees) : <input type="number" name="price">*</p>

<p> * - all the fields marked with '*' are mandatory.

<p><input type = "submit" value = "Add item">
<a href= "guest_house_restaurant.php" > Go Back </a> </p>
</form>
</body>
</html>