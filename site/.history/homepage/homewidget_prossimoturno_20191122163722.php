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

        
        // $queryprox="SELECT g.id_giornata, sqf1.squadra as sq_casa, sqf2.squadra as sq_ospite
        // FROM giornate as g 
        // left join calendario as c on g.id_giornata =  c.id_giornata
        // left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        // LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
        // where fine > DATE_ADD(NOW(), INTERVAL 2 HOUR)
        // AND inizio < DATE_ADD(NOW(), INTERVAL 2 HOUR)
        // and id_girone = ".$girone ;
        $queryprox="
        CREATE TEMPORARY TABLE formazioni_inviate
        select count(*) as lineup,  id_giornata ,id_squadra  from formazioni 
        group by id_giornata, id_squadra;

        
        SELECT g.id_giornata, sqf1.squadra as sq_casa, sqf2.squadra as sq_ospite,
        if(f1.lineup = 19, true, false) as luc, 
        if(f2.lineup = 19, true, false) as luo
    
        FROM giornate as g 
        left join calendario as c on g.id_giornata =  c.id_giornata
        left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
		left join formazioni_inviate as f1 on f1.id_giornata = c.id_giornata and  f1.id_squadra=c.id_sq_casa 
		left join formazioni_inviate as f2 on f2.id_giornata = c.id_giornata and  f2.id_squadra=c.id_sq_ospite
        where fine > DATE_ADD(NOW(), INTERVAL 2 HOUR)
        AND inizio < DATE_ADD(NOW(), INTERVAL 2 HOUR)
		
        and id_girone = ".$girone ."
        order by id_partita;
        ";

        // echo $queryprox;
        // echo '<br>';
        // $result_prox=$conn->multi_query($queryprox);
        if ($conn->multi_query($queryprox)) {
            do {
                /* store first result set */
                if ($result = $conn->store_result()) {
                    while ($row = $result->fetch_row()) {
                        // printf("%s\n", $row[0]);
                        // print_r($row);
                        array_push($partite, array(
                            "id_giornata" =>$row["id_giornata"],
                            "sq_casa"=>$row["sq_casa"],
                            // "luc"=>$row["luc"],
                            "sq_ospite"=>$row["sq_ospite"],
                            // "luo"=>$row["luo"]
                            )
                        );
                    }
                    $result->free();
                }
                // /* print divider */
                // if ($conn->more_results()) {
                //     printf("-----------------\n");
                // }
            } while ($conn->next_result());
        }
        // $num_prox=$result_prox->num_rows; 
        // if($num_prox >0){
        //     echo '<div>';
        //     $counter +=$num_prox;
        //     // echo $num_prox;
        //      print_r($result_prox);
        //     echo '<br>';
        //     echo '</div>';
        // }

        // print_r($result_prox);
        $partite = array();
        // while($row = $result_prox->fetch_assoc()){
        //     array_push($partite, array(
        //         "id_giornata" =>$row["id_giornata"],
        //         "sq_casa"=>$row["sq_casa"],
        //         // "luc"=>$row["luc"],
        //         "sq_ospite"=>$row["sq_ospite"],
        //         // "luo"=>$row["luo"]
        //         )
        //     );
        // }
        // do {
        //     /* store first result set */
        //     if ($result = $result_prox->store_result()) {
        //         while ($row = $result->fetch_row()) {
        //             printf("%s\n", $row[0]);
        //         }
        //         $result->free();
        //     }
        //     /* print divider */
        //     if ($result_prox->more_results()) {
        //         printf("-----------------\n");
        //     }
        // } while ($mysqli->next_result());

        // $result_prox->close();
        // $conn->next_result();

        // print_r ($partite);
        if(count($partite) >0){
            echo '<div>';
            $counter +=count($partite);

            $index=0;
            $prev = "";
            foreach($partite as $partita){
                $id= $partita["id_giornata"];
                include_once "../DB/calendario.php";
                $descrizioneGiornata = getDescrizioneGiornata($id);
                if($prev != $descrizioneGiornata)
                {
                    echo '<h3>'.$descrizioneGiornata.'</h3>';
                    $prev = $descrizioneGiornata;
                }
                $index++;
                if($index%2== 0)
                echo '<div class="result">';
                else
                echo '<div class="result alternate" >';
                echo '<div style="text-align:center;">
                <div style="width:40%; display:inline-block;" class="'. $partita["luc"] = 0 ? "missing" :"sent".'">'. $partita["sq_casa"].'</div>
                <div style="width:10%; display:inline-block;">-</div>
                <div style="width:40%; display:inline-block;" class="'. $partita["luo"] = 0 ? "missing" :"sent".'">'. $partita["sq_ospite"].'</div>
                </div>';
                
                echo '</div>';
                }
            echo '</div>';
        } 
    }
    
    
    if($counter ==0)
    {
        echo "<div>Non ci sono partite in programma</div>";
     
    }
    echo '<div class="footer"><a href="/invio_formazione.php">Invia la formazione</a></div>';
    echo '<hr>';
    ?>

</div>