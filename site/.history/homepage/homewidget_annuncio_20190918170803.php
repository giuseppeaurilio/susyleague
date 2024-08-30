<div class="widget">
        <h2>Il presidente ha qualcosa da dirvi</h2>
        <?php 
            $queryannunci='CALL getAnnunciAttivi()';
            $result=$conn->query($queryannunci) or die($conn->error);
            $annunci = array();
            while($row = $resultannunci->fetch_assoc()){
                array_push($annunci, array(
                    "id"=>$row["id"],
                    "titolo"=>$row["titolo"],
                    "testo"=>$row["testo"],
                    )
                );
            }
            $num_ultimi=$annunci->num_rows; 
            if($num_ultimi >0){
                // echo $num_ultimi;
                print_r($annunci);
                echo '<br>';
            }   
            $result->close();
            $conn->next_result();
        ?> 
</div>