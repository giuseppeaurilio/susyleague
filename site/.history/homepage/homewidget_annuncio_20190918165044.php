<div class="widget">
        <h2>Il presidente ha qualcosa da dirvi</h2>
        <?php 
            $query='CALL getAnnunciAttivi()';
            $result = $conn->query($query) or die($conn->error);
            $annunci = array();
            while($row = $result->fetch_assoc()){
                array_push($annunci, array(
                    "id"=>$row["id"],
                    "titolo"=>$row["titolo"],
                    "testo"=>$row["testo"],
                    )
                );
            }
            print_r($annunci);
            echo '<br>';
        ?>
</div>