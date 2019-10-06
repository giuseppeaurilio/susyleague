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

    echo '<div id=riepilogo'.$squadra["id"].' class="riepilogo">';
    echo '<h2>'.$squadra["squadra"].'</h2>';
    echo '<h3>'.$squadra["allenatore"].'</h3>';
    echo '<table>';
    echo '<tr>
            <th>Ruolo</th>
            <th>In rosa</th>
            <th>Spesi</th>
        </tr>';
    foreach($riepilogo["giocatori"] as $row){
        switch($row["ruolo"])
        {
            case "P":
                echo '<tr><td>Portieri</td><td>'.$row["numero"]. '</td><td>'.$row["costo"].'</td>';
            break;
            case "D":
                echo '<tr><td>Difensori</td><td>'.$row["numero"]. '</td><td>'.$row["costo"].'</td>';
            break;
            case "C":
                echo '<tr><td>Centrocampisti</td><td>'.$row["numero"]. '</td><td>'.$row["costo"].'</td>';
            break;
            case "A":
                echo '<tr><td>Attaccanti</td><td>'.$row["numero"]. '</td><td>'.$row["costo"].'</td>';
            break;
        }
    }
    echo '</table>';
    echo '</div>';
    echo '<table>
            <tr>
                <th>Milioni spesi</th>
                <th>'.$riepilogo["spesi"].'</th>
               
            </tr>
        </table>';
    echo '<table>
        <tr>
            <th>Milioni rimanenti</th>
            <th>'.$rimanenti'</th>
           
        </tr>
    </table>';
    echo '<table>
        <tr>
            <th>Giocatori in rosa</th>
            <th>'.$riepilogo["numerototale"].'</th>
           
        </tr>
    </table>';

    // print_r($riepilogo["giocatori"]);
    // echo '<br> Spesi: ' . $riepilogo["spesi"];
    // echo '<br> Totale: ' . $riepilogo["numerototale"];
    // echo '<br> Rimanenti: ' . $rimanenti;
    // echo '<br> Offerta Massima: ' . $offertamassima;
    // echo '<br> Jolly: ' . $jollyScelto;
    $conn->next_result();
}
?>

<?php 
include("footer.php");
?>
