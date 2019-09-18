
<!-- <h2>Benvenuto sul sito web della SusyLeage</h2> -->

<?php
$querylastdate   = "SELECT fine
FROM `giornate` as g 
left join calendario as c on g.id_giornata =  c.id_giornata
where c.gol_casa is not null
order by fine
limit 1";
$result=$conn->query($querylastdate) or die($conn->error);
$lastdate = $result->fetch_object()->fine;
// print_r($value);

// $lastdate = "";

for ($girone = 1; $girone <= 10; $girone++) {
    $queryultimi="SELECT *
    FROM giornate as g 
    left join calendario as c on g.id_giornata =  c.id_giornata
    where c.gol_casa is not null
    and fine='" .$lastdate. "'
    and id_girone = ".$girone ;
    // echo $queryultimi;
    // echo '<br>';
    $result_ultimi=$conn->query($queryultimi);

    $num_ultimi=$result_ultimi->num_rows; 
    if($num_ultimi >0){
        // echo $num_ultimi;
        print_r($result_ultimi);
        echo '<br>';
    }
}
?>
<h2>Ultimi risultati</h2>

<?php
$querylastdate   = "SELECT fine
FROM `giornate` as g 
left join calendario as c on g.id_giornata =  c.id_giornata
where c.gol_casa is not null
order by fine
limit 1";
$result=$conn->query($querylastdate) or die($conn->error);
$lastdate = $result->fetch_object()->fine;

for ($girone = 1; $girone <= 10; $girone++) {

    $queryprox="SELECT *
    FROM giornate as g 
    left join calendario as c on g.id_giornata =  c.id_giornata
    where fine>'" .$lastdate. "'
    and id_girone = ".$girone ;
    // echo $queryprox;
    // echo '<br>';
    $result_prox=$conn->query($queryprox);

    $num_prox=$result_prox->num_rows; 
    if($num_prox >0){
        // echo $num_prox;
        print_r($result_prox);
        echo '<br>';
    }
}
?>
<h2>Prossimo turno</h2>
<h2>Sondaggi attivi</h2>

<h2>Annunci mercato</h2>

<h2>Il presidente ha qualcosa da dirvi</h2>



