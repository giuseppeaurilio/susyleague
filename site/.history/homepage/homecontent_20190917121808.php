
<!-- <h2>Benvenuto sul sito web della SusyLeage</h2> -->

<?php
$querylastdate   = "SELECT fine
FROM `giornate` as g 
left join calendario as c on g.id_giornata =  c.id_giornata
where c.gol_casa is not null
order by fine
limit 1";
$result=$conn->query($querylastdate) or die($conn->error);
$value = $result->fetch();
echo $value;    

$lastdate = "";
for ($girone = 1; $girone <= 10; $girone++) {
    $queryultimi="SELECT *
    FROM giornate as g 
    left join calendario as c on g.id_giornata =  c.id_giornata
    where c.gol_casa is not null
    and fine='" .$lastdate. "'
    and id_girone = ".$girone ;

    $result_ultimi=$conn->query($queryultimi);

    $num_ultimi=$result_ultimi->num_rows; 
}


if($num_ultimi >0){
echo '<h2>Ultimi risultati</h2>';

}

for ($girone = 1; $girone <= 10; $girone++) {

$queryprox="SELECT * FROM giornate where id_girone=". $girone . " order by id_giornata ASC";
$result_prox=$conn->query($queryprox);

}
$num_prox=$result_prox->num_rows; 
if($num_prox >0){
echo '<h2>Prossimo turno</h2>';
}

?>

