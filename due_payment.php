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
<h1>Due Payments  </h1>
<table border = "1" >
<?php
$stmt = $pdo->query("SELECT shopid, slipid, amount , type, deadline   FROM charges NATURAL JOIN dues " );

echo("<tr> <td>SHOP ID </td>  <td>SLIP ID </td> <td>AMOUNT </td> <td>TYPE </td> <td>DEADLINE</td>  </tr> " );
while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    echo "<tr><td>" ;
    echo($row['shopid']);
    echo("</td><td>");
    echo($row['slipid']);
    echo("</td><td>");
    echo($row['amount']);
    echo("</td><td>");
    echo($row['type']);
    echo("</td><td>");
    echo($row['deadline']);
    echo("</td></tr>\n");
}
?>
</table>
<p> <a href = "market.php" >Go Back </a> </p>
</body>
</html>