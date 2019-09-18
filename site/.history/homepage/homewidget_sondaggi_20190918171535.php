<div class="widget">
    <h2>Sondaggi attivi</h2>
    <?php 
        $query='CALL getSondaggiAttivi()';
        $result=$conn->query($query) or die($conn->error);
        $sondaggi = array();
        while($row = $result->fetch_assoc()){
            array_push($sondaggi, array(
                "id"=>$row["id"],
                "testo"=>$row["testo"],
                "squadra"=>$row["squadra"],
                "data"=>$row["data_annuncio"],
                )
            );
        }
        $result->close();
        // $num_ultimi=$annunci->num_rows; 
        if(count($sondaggi) >0){
            // echo $num_ultimi;
            print_r($sondaggi);
            echo '<br>';
        }   
        
        $conn->next_result();
    ?>
</div>