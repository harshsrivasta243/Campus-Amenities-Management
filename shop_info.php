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
<h1>Shop Information  </h1>
<table border = "1" >
<?php
$stmt = $pdo->query("SELECT shopid , plotid, rating , reviews    FROM shop " );
echo("<tr> <td>SHOP ID </td>  <td>PLOT ID </td> <td>SHOPKEEPER ID </td> <td>Performance ( 0- 10) </td>  <td> Due Payment </td>  <td>LICENCE Vatlid upto </td>  </tr> " );
while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    echo "<tr><td>" ;
    echo($row['shopid']);

    echo("</td><td>");
    echo($row['plotid']);

    echo("</td><td>");
    $stmt2 = $pdo->query("SELECT shopkeeperid , licence_val from owns where shopid = '".$row['shopid']."'" );
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    if($row2){
        echo($row2['shopkeeperid' ] );
    }
    else{
        echo("shop not assigned");
    }

    echo("</td><td>");
    if($row['reviews'] == 0 ){
        echo(0);
    }
    else{
        echo( $row['rating']/$row['reviews'] );
    }

    echo("</td><td>");
    $amt = 0;
    $stmt3 = $pdo->query("SELECT amount from charges natural join dues where shopid = '".$row['shopid']."'" );
    while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC) ){
        $amt+= $row3['amount'];
    }
    echo($amt);
    echo("</td><td>");

    if($row2){
        echo($row2['licence_val' ] );
    }
    else{
        echo("NA");
    }
    echo("</td></tr>");
}
?>
</table>
<p> <a href = "market.php" >Go Back </a> </p>
</body>
</html>