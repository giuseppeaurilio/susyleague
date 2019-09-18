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
                "scadenza"=>$row["scadenza"],
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
        
        foreach($sondaggi as $sondaggio)
        {
            $query='CALL getRisposteSondaggio('.$sondaggio["id"].')';
            $resultOpzioni = $conn->query($query) or die($conn->error);
            $opzioni = array();
            while($row = $resultOpzioni->fetch_assoc()){
                array_push($opzioni, array(
                    "id"=>$row["id"],
                    "opzione"=>$row["opzione"],
                    )
                );
            }
            if(count($opzioni) >0){
                // echo $num_ultimi;
                print_r($opzioni);
                echo '<br>';
            } 

            foreach($opzioni as $opzione)
            {
                $query='CALL getRisposteSquadreSondaggio('.$sondaggio["id"].', '.$opzione["id"].')';
                $resultvoti = $conn->query($query) or die($conn->error);
                $voti = array();
                while($row = $resultOpzioni->fetch_assoc()){
                    array_push($opzioni, array(
                        "id"=>$row["id"],
                        "opzione"=>$row["opzione"],
                        )
                    );
                }
                if(count($voti) >0){
                    // echo $num_ultimi;
                    print_r($voti);
                    echo '<br>';
                } 
            }
            
        }
        $conn->next_result();
    ?>
</div>