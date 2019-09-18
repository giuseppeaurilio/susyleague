<div class="widget">
    <h2>Annunci mercato</h2>
    <?php 
        $queryannunci='CALL getAnnunciMercato()';
        $result=$conn->query($queryannunci) or die($conn->error);
        $annunci = array();
        while($row = $result->fetch_assoc()){
            array_push($annunci, array(
                "id"=>$row["id"],
                "testo"=>$row["testo"],
                "squadra"=>$row["squadra"],
                "data"=>$row["data"],
                )
            );
        }
        $result->close();
        // $num_ultimi=$annunci->num_rows; 
        if(count($annunci) >0){
            // echo $num_ultimi;
            print_r($annunci);
            echo '<br>';
        }   
        
        $conn->next_result();
    ?> 
</div>