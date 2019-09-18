<div class="widget">
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
    $result_ultimi = 0;
    $num_ultimi = 0;
    for ($girone = 1; $girone <= 10; $girone++) {
        $queryultimi="SELECT sqf1.squadra as sq_casa, sqf2.squadra as sq_ospite, 
        c.gol_casa, c.gol_ospiti as gol_ospite, c.punti_casa as voto_casa, c.punti_ospiti as voto_ospite
        FROM giornate as g 
        left join calendario as c on g.id_giornata =  c.id_giornata
        left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
        where c.gol_casa is not null
        and fine='" .$lastdate. "'
        and id_girone = ".$girone ;
        // echo $queryultimi;
        // echo '<br>';
        $result_ultimi=$conn->query($queryultimi);
        $risultati = array();
        while($row = $result->fetch_assoc()){
            array_push($risultati, array(
                "sq_casa"=>$row["sq_casa"],
                "sq_ospite"=>$row["sq_ospite"],
                "gol_casa"=>$row["gol_casa"],
                "gol_ospiti"=>$row["gol_ospiti"],
                "voto_casa"=>$row["voto_casa"],
                "voto_ospite"=>$row["voto_ospite"],
                )
            );
        }
        $result->close();
        $conn->next_result();
        // $num_ultimi=$result_ultimi->num_rows; 
        if($num_ultimi >0){
            print_r($girone);
            echo '<br>';
            print_r($lastdate);
            echo '<br>';
            // echo $num_ultimi;
            print_r($risultati);
            echo '<br>';
        }   
    }
    ?>
</div>