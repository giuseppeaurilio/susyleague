<?php 
include("menu.php");

?>

<h2>Riepilogo ASTA</h2>
<div class="maincontent">

<?php 
//load squadre fantacalcio
$query="SELECT * FROM sq_fantacalcio order by squadra";

$result=$conn->query($query);
$squadre = array();
while($row = $result->fetch_assoc()){
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
include_once "DB/parametri.php";
foreach($squadre as $squadra)
{
    $rimanenti = getMilioniRimanenti($squadra["id"]);
    $offertamassima = getOffertaMassima($squadra["id"]);
    $jollyScelto = hasJolly($squadra["id"]);
    $riepilogo = getRiepilogoAsta($squadra["id"]);

    echo '<div id=riepilogo'.$squadra["id"].' class="riepilogo">';
    echo '<h2>'.$squadra["squadra"].'</h2>';
    echo '<h3>'.$squadra["allenatore"].'</h3>';
    echo '<h4>Offerta massima '.$offertamassima.'</h4>';
    echo '<table>';
    echo '<tr>
            <th>Ruolo</th>
            <th>Spesi</th>
            <th>In rosa</th>
        </tr>';
    foreach($riepilogo["giocatori"] as $row){
        switch($row["ruolo"])
        {
            case "P":
                echo '<tr style="background-color:#66CC33"><td>Portieri</td><td>'.$row["costo"].'</td><td>'.$row["numero"]. '</td></tr>';
            break;
            case "D":
                echo '<tr style="background-color:#33CCCC"><td>Difensori</td><td>'.$row["costo"].'</td><td>'.$row["numero"]. '</td></tr>';
            break;
            case "C":
                echo '<tr style="background-color:#FFEF00"><td>Centrocampisti</td><td>'.$row["costo"].'</td><td>'.$row["numero"]. '</td></tr>';
            break;
            case "A":
                echo '<tr style="background-color:#E80000"><td>Attaccanti</td><td>'.$row["costo"].'</td><td>'.$row["numero"]. '</td></tr>';
            break;
        }
    }
    echo '</table>';
    
    echo '<table>
        <tr>
            <th>Giocatori in rosa</th>
            <th>'.$riepilogo["numerototale"].'</th>
        
        </tr>
        <tr>
            <th>Jolly scelti</th>
            <th>'.$jollyScelto.'</th>
        
        </tr>
        <tr>
                <th>Milioni spesi</th>
                <th>'.$riepilogo["spesi"].'</th>
               
        </tr>
        <tr>
            <th>Milioni rimanenti</th>
            <th>'.$rimanenti.'</th>
           
        </tr>
    </table>';
    echo '</div>';

    // print_r($riepilogo["giocatori"]);
    // echo '<br> Spesi: ' . $riepilogo["spesi"];
    // echo '<br> Totale: ' . $riepilogo["numerototale"];
    // echo '<br> Rimanenti: ' . $rimanenti;
    // echo '<br> Offerta Massima: ' . $offertamassima;
    // echo '<br> Jolly: ' . $jollyScelto;
    $conn->next_result();
}
?>
</div>
<?php 
include("footer.php");
?>
