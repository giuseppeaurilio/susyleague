<div class="widget">
    
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
    echo '<h2>Partite in corso</h2>';
    for ($girone = 1; $girone <= 10; $girone++) {

        
        $query="SELECT g.id_giornata, sqf1.squadra as sq_casa, sqf2.squadra as sq_ospite, 
        c.gol_casa, c.gol_ospiti as gol_ospite, c.punti_casa as voto_casa, c.punti_ospiti as voto_ospite
        FROM giornate as g 
        left join calendario as c on g.id_giornata =  c.id_giornata
        left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
		where fine < DATE_ADD(NOW(), INTERVAL 2 HOUR)
		and gol_casa is null
        and id_girone = ".$girone ;
        // echo $queryprox;
        // echo '<br>';
        $result=$conn->query($query);

        // $num_prox=$result_prox->num_rows; 
        // if($num_prox >0){
        //     echo '<div>';
        //     $counter +=$num_prox;
        //     // echo $num_prox;
        //      print_r($result_prox);
        //     echo '<br>';
        //     echo '</div>';
        // }
        $partite = array();
        while($row = $result->fetch_assoc()){
            array_push($partite, array(
                "id_giornata" =>$row["id_giornata"],
                "sq_casa"=>$row["sq_casa"],
                "sq_ospite"=>$row["sq_ospite"],
                )
            );
        }
        $result->close();
        $conn->next_result();


        if(count($partite) >0){
        //    echo $girone .'<br>';
        //     print_r($partite);
        //     echo $girone .'<hr>';
            echo '<div>';
            $counter +=count($partite);

            $id= $partite[0]["id_giornata"];
            include_once "../DB/calendario.php";
            $descrizioneGiornata = getDescrizioneGiornata($id);
        
            // print_r($girone);
            // echo '<br>';
            echo '<h3>'.$descrizioneGiornata.'</h3>';
            
            // print_r($lastdate);
            // echo '<br>';
            $index=0;
            foreach($partite as $partita){
                // echo $num_ultimi;
                // print_r($risultato);
                // echo '<br>';
                $index++;
                if($index%2== 0)
                echo '<div class="result">';
                else
                echo '<div class="result alternate" >';
                echo '<div style="text-align:center;"><div style="width:40%; display:inline-block;">'. $partita["sq_casa"].'</div>
                <div style="width:10%; display:inline-block;">-</div>
                <div style="width:40%; display:inline-block;">'. $partita["sq_ospite"].'</div>
                </div>';
                
                echo '</div>';
                }
            echo '<h4><a style="text-decoration: none;color: white;" href="/display_giornata.php?&id_giornata='.$id.'">Formazioni <i class="fas fa-list-ol" aria-hidden="true"></i></a></h4>';
            echo '</div>';
        } 
        
    }
    echo '<hr>';
    ?>
</div>