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
        $conn->next_result();
        // $num_ultimi=$annunci->num_rows; 
        if(count($sondaggi) >0){
            // echo $num_ultimi;
            // print_r($sondaggi);
            // echo '<br>';
        
        }  
        else
        {
            // echo "<h3> &nbsp;</h3>";
            echo "<div class='widgetcontent sondaggi'><div style='  text-align: center;
            padding: 125px 0;'>Non ci sono sondaggi al momento</div></div>";
            echo '<hr>';
        } 
        
        foreach($sondaggi as $sondaggio)
        {
            echo '<h3>'.$sondaggio["testo"].' Scadenza: '.date('d/m/Y', strtotime($sondaggio["scadenza"])).'</h3>';
            $resultsondaggio = array();
            $queryopzioni='CALL getRisposteSondaggio('.$sondaggio["id"].')';
            $resultOpzioni = $conn->query($queryopzioni) or die($conn->error);
            $opzioni = array();
            while($row = $resultOpzioni->fetch_assoc()){
                array_push($opzioni, array(
                    "id"=>$row["id"],
                    "opzione"=>$row["opzione"],
                    )
                );
            }
            $resultOpzioni->close();
            $conn->next_result();
            // if(count($opzioni) >0){
            //     // echo $num_ultimi;
            //     print_r($opzioni);
            //     echo '<br>';
            // } 
            $counter = 0;
            foreach($opzioni as $opzione)
            {
                
                $query='CALL getRisposteSquadreSondaggio('.$sondaggio["id"].', '.$opzione["id"].')';
                $resultvoti = $conn->query($query) or die($conn->error);
                // $voti = array();
                while($row = $resultvoti->fetch_assoc()){
                    array_push($resultsondaggio, array(
                        "id" => $opzione["id"],
                        "opzione" => str_replace('\'', '', $opzione["opzione"]),
                        "count"=>$row["num"],
                        )
                    );
                    $counter  +=$row["num"];
                }
                $resultvoti->close();
                $conn->next_result();
                
            }
            if(count($resultsondaggio) >0){
                // echo $num_ultimi;
                // print_r($resultsondaggio);
                // echo '<br>';
                
            
                // echo 'TOT:'. $counter;
                echo "<div class='widgetcontent2 '>";
                echo '<canvas id="myChart'.$sondaggio["id"].'" style="background-color: rgba(255,255,255,0.8)"></canvas>';
                echo "</div>";
                echo "<script>
                        var ctx = document.getElementById('myChart".$sondaggio["id"]."').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [";
                                foreach($resultsondaggio as $result)
                                echo "'".$result["opzione"]."',";
                                echo "],
                                datasets: [{
                                    label: '# di voti',
                                    data: [";
                                    foreach($resultsondaggio as $result)
                                    echo "'".$result["count"]."',";
                                    echo "],
                                    backgroundColor: [
                                        'rgba(255, 159, 64, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        
                                    ],
                                    borderColor: [
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                        </script>";
                echo '<div class="footer"><a href="/display_sondaggi.php"> Esprimi la tua opinione</a></div>';
                echo '<hr>';    
            } 
        }
        $conn->next_result();
    ?>
</div>