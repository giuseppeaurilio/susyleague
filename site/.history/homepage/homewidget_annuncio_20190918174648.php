<div class="widget">
    <h2>Il presidente ha qualcosa da dirvi</h2>
    <?php 
        $queryannunci='CALL getAnnunciAttivi()';
        $result=$conn->query($queryannunci) or die($conn->error);
        $annunci = array();
        while($row = $result->fetch_assoc()){
            array_push($annunci, array(
                "id"=>$row["id"],
                "titolo"=>$row["titolo"],
                "testo"=>$row["testo"],
                )
            );
        }
        $result->close();
        // $num_ultimi=$annunci->num_rows; 
        // if(count($annunci) >0){
        foreach($annunci as $annuncio){
            // echo $num_ultimi;
            // print_r($annunci);
            // echo '<br>';
            echo '<h4>'.$annuncio["titolo"].'</h4>'
            echo '<hr>';
            echo '<div>'.$annuncio["testo"].'</div>';
        }   
        
        $conn->next_result();
    ?> 
</div>