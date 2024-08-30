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
        "id"=>$id,
        "squadra"=>$squadra
        )
    );
}
?>
<?php
include_once ("DB/asta.php");
foreach($squadre as $squadra)
{
    $queryriepilogo='CALL getRiepilogoRosa('.$squadra["id"].')';
    $resultriepilogo = $conn->query($queryriepilogo) or die($conn->error);

    $arrayriepilogo = array();
    $spesi =0;
    $numerototale = 0;
    $rimanenti = 0;
    $offertamassima = 0;
    $jollyScelto = false;
    
    while ($row = $resultriepilogo->fetch_assoc()) {
            array_push($arrayriepilogo, array(
                "numero"=>$row["numero"],
                "costo"=>$row["costo"],
                "ruolo"=>$row["ruolo"]
            )            
        );
        $spesi +=$row["costo"];
        $numerototale += $row["numero"];
    }
    $rimanenti = getMilioniRimanenti($squadra["id"]);
    // $offertamassima = getOffertaMassima($squadra["id"]);
    // $jollyScelto = hasJolly($squadra["id"]);
    echo 'Squadra: '.$squadra["squadra"];
    echo '<br> Riepilogo';
    print_r($arrayriepilogo);
    // echo '<br> Spesi: ' + $spesi;
    // echo '<br> Totale: ' + $numerototale;
    // echo '<br> Rimanenti: ' + $rimanenti;
    // echo '<br> Offerta Massima: ' + $offertamassima;
    // echo '<br> Jolly: ' + $jollyScelto;
    $conn->next_result();
}
?>

<?php 
include("footer.php");
?>
