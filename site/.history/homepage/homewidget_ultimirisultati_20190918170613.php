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
        $result_ultimi->close();
    }
    
    $conn->next_result();
    ?>
</div>