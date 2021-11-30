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
<h1>Shopkeeper Information  </h1>
<table border = "1" >
<?php
$stmt = $pdo->query("SELECT shopkeeperid , name, passvalidity    FROM shopkeeper " );
echo("<tr> <td>SHOPKEEPER ID </td>  <td>NAME </td>  <td>Shops Owned</td> <td> Due Payment(over all shops) </td> <td>PASS Valid upto </td>  </tr> " );
while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    echo "<tr><td>" ;
    echo($row['shopkeeperid']);

    echo("</td><td>");
    echo($row['name']);

    echo("</td><td>");
    $stmt2 = $pdo->query("SELECT shopid from owns where shopkeeperid = '".$row['shopkeeperid']."'" );
    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ){
        echo($row2['shopid']);echo(', ');
    }

    echo("</td><td>");
    $amt = 0;
    $stmt3 = $pdo->query("SELECT amount from charges natural join dues natural join owns where shopkeeperid = '".$row['shopkeeperid']."'" );
    while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC) ){
        $amt+= $row3['amount'];
    }
    echo($amt);
    
    echo("</td><td>");
    echo($row['passvalidity'] );

    echo("</td></tr>");
}
?>
</table>
<p> <a href = "market.php" >Go Back </a> </p>
</body>
</html>