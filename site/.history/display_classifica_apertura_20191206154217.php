<?php
$idgirone=1;
// echo "Connected successfully";
$queryclassifica='CALL getClassifica('.$idgirone.')';
// print_r($queryclassifica);
$result_girone = $conn->query($queryclassifica) or die($conn->error);
// print_r($result_girone);
$arraysquadre = array();
    //recupero i dati dal DB e li trasferisco nell'array di oggetti
while ($row = $result_girone->fetch_assoc()) {
    $temp = new RigaClassifica();
    // print_r($row );
    $temp->idSquadra = $row["idsquadra"];
    $temp->squadra = $row["squadra"];
    $temp->punti = $row["punti"];
    $temp->marcatori = $row["marcatori"];
    $temp->vittorie = $row["vittorie"];
    $temp->pareggi = $row["pareggi"];
    $temp->sconfitte = $row["sconfitte"];
    $temp->golfatti = $row["golfatti"];
    $temp->golsubiti = $row["golsubiti"];
    $temp->marcatoricasa = $row["marcatoric"];
    $temp->vittoriecasa = $row["vittoriec"];
    $temp->pareggicasa = $row["pareggic"];
    $temp->sconfittecasa = $row["sconfittec"];
    $temp->golfatticasa = $row["golfattic"];
    $temp->golsubiticasa = $row["golsubitic"];
    
    $temp->marcatoritrasf = $row["marcatorit"];
    $temp->vittorietrasf = $row["vittoriet"];
    $temp->pareggitrasf = $row["pareggit"];
    $temp->sconfittetrasf = $row["sconfittet"];
    $temp->golfattitrasf = $row["golfattit"];
    $temp->golsubititrasf = $row["golsubitit"];
    array_push($arraysquadre,$temp);
}
// $conn->close();
$result_girone->close();
$conn->next_result();
// print("<pre>".print_r($arraysquadre,true)."</pre>").'<br>';
?>


<div id="tabs-1">
<h2>Torneo Apertura</h2>
<h3>Classifica Punti</h3>
<div class="scrollmenu">
<table class="classifica">
<thead>
<tr>
<th >
&nbsp;
</th>
<th colspan="7">
TOTALI
</th>
<th colspan="6">
CASA
</th>
<th colspan="6">
TRASFERTA
</th>
</tr>
</thead>
<tr>

<th >Squadra</th>
<th>Punti</th>
<th>Voti</th>
<th>V</th>
<th>N</th>
<th>P</th>
<th>GF</th>
<th>GS</th>
<th>Voti</th>
<th>V</th>
<th>N</th>
<th>P</th>
<th>GF</th>
<th>GS</th>
<th>Voti</th>
<th>V</th>
<th>N</th>
<th>P</th>
<th>GF</th>
<th>GS</th>

</tr>
<?php 
foreach($arraysquadre as $squadra){
    echo '<tr>';
        echo '<td>'.$squadra->squadra.'</td>';
        echo '<td>'.$squadra->punti.'</td>';
        echo '<td>'.$squadra->marcatori.'</td>';
        echo '<td>'.$squadra->vittorie.'</td>';
        echo '<td>'.$squadra->pareggi.'</td>';
        echo '<td>'.$squadra->sconfitte.'</td>';
        echo '<td>'.$squadra->golfatti.'</td>';
        echo '<td>'.$squadra->golsubiti.'</td>';
        echo '<td>'.$squadra->marcatoricasa.'</td>';
        echo '<td>'.$squadra->vittoriecasa.'</td>';
        echo '<td>'.$squadra->pareggicasa.'</td>';
        echo '<td>'.$squadra->sconfittecasa.'</td>';
        echo '<td>'.$squadra->golfatticasa.'</td>';
        echo '<td>'.$squadra->golsubiticasa.'</td>';
        echo '<td>'.$squadra->marcatoritrasf.'</td>';
        echo '<td>'.$squadra->vittorietrasf.'</td>';
        echo '<td>'.$squadra->pareggitrasf.'</td>';
        echo '<td>'.$squadra->sconfittetrasf.'</td>';
        echo '<td>'.$squadra->golfattitrasf.'</td>';
        echo '<td>'.$squadra->golsubititrasf.'</td>';
    echo '</tr>';
}
?>
</table>
</div>
<?php 


usort($arraysquadre, "cmp");
?>

<h3>Classifica marcatori</h3>
<table class="classifica">
<tr>
<th>Squadra</th>
<th>Punti</th>
</tr>

<?php 
foreach($arraysquadre as $squadra){
    echo '<tr>';
        echo '<td>'.$squadra->squadra.'</td>';
        echo '<td>'.$squadra->marcatori.'</td>';
       
    echo '</tr>';
}
?>
</table>

<?php
$querystatistichemd='CALL statistiche_mediadifesa('.$idgirone.');';
$resultstats=$conn->query($querystatistichemd);
$stats = array();
while ($row=$resultstats->fetch_assoc()) {
    array_push($stats, array(
        "id"=>$row["id_sq_casa"],
        "squadra"=>$row["squadra"],
        "md_f_c"=>$row["md_f_c"],
        "md_f_t"=>$row["md_f_t"],
        "md_f"=>$row["md_f"],
        "md_c_c"=>$row["md_c_c"],
        "md_c_t"=>$row["md_c_t"],
        "md_c"=>$row["md_c"],
        "md"=>$row["md"],
        )
    );
}
$resultstats->close();
$conn->next_result();
// echo print_r($stats);
?>
<h3>Statistiche Media Difesa</h3>
    <div class="scrollmenu">
    <table class="classifica">
    <thead>
    <tr>
        <th >
        &nbsp;
        </th>
        <th colspan="3">
        Media difesa applicata
        </th>
        <th colspan="3">
        Media difesa subita
        </th>
        <th rowspan="2">FATTORE <br>CULO</th>
    </tr>
    </thead>
    <tr>
        <th >Squadra</th>
        <th>Casa</th>
        <th>Traf</th>
        <th>TOT</th>
        <th>Casa</th>
        <th>Traf</th>
        <th>TOT</th>
        <th>&nbsp;</th>
    </tr>
    <?php 
    foreach($stats as $squadra){
        echo '<tr>';
            echo '<td>'.$squadra["squadra"].'</td>';
            echo '<td>'.$squadra["md_f_c"].'</td>';
            echo '<td>'.$squadra["md_f_t"].'</td>';
            echo '<td>'.$squadra["md_f"].'</td>';
            echo '<td>'.$squadra["md_c_c"].'</td>';
            echo '<td>'.$squadra["md_c_t"].'</td>';
            echo '<td>'.$squadra["md_c"].'</td>';
            echo '<td>'.$squadra["md"].'</td>';
        echo '</tr>';
    }
    ?>
    </table>
    </div>
</div>