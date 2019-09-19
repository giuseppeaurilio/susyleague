<div class="widget">
    <h2>Prossimo turno</h2>
    <?php
    // $querylastdate   = "SELECT fine
    // FROM `giornate` as g 
    // left join calendario as c on g.id_giornata =  c.id_giornata
    // where c.gol_casa is not null
    // order by fine
    // limit 1";
    // $result=$conn->query($querylastdate) or die($conn->error);
    // $res = $result->fetch_object();
    // // print_r("res".$res);
    // $lastdate = $res == "" ? "": $res->fine;

    $result_prox = 0;
    $num_prox = 0;
    $counter = 0;
    for ($girone = 1; $girone <= 10; $girone++) {

        $queryprox="SELECT *
        FROM giornate as g 
        left join calendario as c on g.id_giornata =  c.id_giornata
        left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
        where fine > current_date()
        AND inizio < current_date()
        and id_girone = ".$girone ;
        // echo $queryprox;
        // echo '<br>';
        $result_prox=$conn->query($queryprox);

        $num_prox=$result_prox->num_rows; 
        // if($num_prox >0){
        //     echo '<div>';
        //     $counter +=$num_prox;
        //     // echo $num_prox;
        //     print_r($result_prox);
        //     echo '<br>';
        //     echo '</div>';
        // }
        $partite = array();
        while($row = $result_prox->fetch_assoc()){
            array_push($partite, array(
                "id_giornata" =>$row["id_giornata"],
                "sq_casa"=>$row["sq_casa"],
                "sq_ospite"=>$row["sq_ospite"],
                "gol_casa"=>$row["gol_casa"],
                "gol_ospite"=>$row["gol_ospite"],
                "voto_casa"=>$row["voto_casa"],
                "voto_ospite"=>$row["voto_ospite"],
                )
            );
        }
        $result_prox->close();
    }
    
    $conn->next_result();
    if($counter ==0)
    {
        echo "<div>Non ci sono partite in programma</div>";
     
    }
    echo '<div class="footer"><a href="/invio_formazione.php">Invia la formazione</a></div>';
    echo '<hr>';
    ?>

</div>