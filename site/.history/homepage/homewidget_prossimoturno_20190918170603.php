<div class="widget">
    <h2>Prossimo turno</h2>
    <?php
    $querylastdate   = "SELECT fine
    FROM `giornate` as g 
    left join calendario as c on g.id_giornata =  c.id_giornata
    where c.gol_casa is not null
    order by fine
    limit 1";
    $result=$conn->query($querylastdate) or die($conn->error);
    $lastdate = $result->fetch_object()->fine;

    $result_prox = 0;
    $num_prox = 0;
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
        $result_prox->close();
    }
    
    $conn->next_result();
    ?>
</div>