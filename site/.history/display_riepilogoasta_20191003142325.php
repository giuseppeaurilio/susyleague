<?php 
include("menu.php");

?>

<h2>Riepilogo ASTA</h2>


<?php 
//load squadre fantacalcio
$query="SELECT * FROM sq_fantacalcio order by squadra";

$result=$conn->query($query);
$squadre = array();
while($row = $result->fetch_assoc()){
    // $id=mysql_result($result,$i,"id");
    $id=$row["id"];
    $squadra=$row["squadra"];
    array_push($squadre, array(
        "id"=>$row["id"],
        "squadra"=>$row["squadra"],
        "allenatore"=>$row["allenatore"]
        )
    );
}
?>
<?php
include_once ("DB/asta.php");
foreach($squadre as $squadra)
{
    $rimanenti = getMilioniRimanenti($squadra["id"]);
    $offertamassima = getOffertaMassima($squadra["id"]);
    $jollyScelto = hasJolly($squadra["id"]);
    $riepilogo = getRiepilogoAsta($squadra["id"]);

    
    echo '<h2>'.$squadra["squadra"].'</h2>';
    echo '<h3>'.$squadra["allenatore"].'</h3>';
    <h3><?php echo "(" .$allenatore .")";?></h3>

    print_r($riepilogo["giocatori"]);
    echo '<br> Spesi: ' . $riepilogo["spesi"];
    echo '<br> Totale: ' . $riepilogo["numerototale"];
    echo '<br> Rimanenti: ' . $rimanenti;
    echo '<br> Offerta Massima: ' . $offertamassima;
    echo '<br> Jolly: ' . $jollyScelto;
    $conn->next_result();
}
?>

<?php 
include("footer.php");
?>
