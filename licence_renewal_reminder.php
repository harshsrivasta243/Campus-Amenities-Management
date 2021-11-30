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
$stmt = $pdo->query("SELECT shopkeeperid, shopid, licence_val    FROM owns " );
echo("<tr> <td>SHOPKEEPER ID </td>  <td>SHOP ID </td> <td>LICENCE VALID TILL </td> <td>Remarks </td>   </tr> " );
while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    echo "<tr><td>" ;
    echo($row['shopkeeperid']);
    echo("</td><td>");
    echo($row['shopid']);
    echo("</td><td>");
    echo($row['licence_val']);
    echo("</td><td>");

    $d1 = strtotime( $row['licence_val'] );
    $d2 = strtotime(date("Y-m-d") );
    $d_diff =  ($d1 - $d2)/(24*3600);
    if($d_diff <= 0 ){
        echo("Expired");
    }
    else if( $d_diff < 90 ){
        echo("Renew Soon" );
    }
    else if($d_diff >= 90 && $d_diff <= 180 ){
        echo("More than 3 months to expiry" );
    }
    else{
        echo("More than 6 months to expiry" );
    }
    echo("</td></tr>");
}
?>
</table>
<p> <a href = "market.php" >Go Back </a> </p>
</body>
</html>