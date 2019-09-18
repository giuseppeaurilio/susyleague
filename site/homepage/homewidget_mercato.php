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
                "data"=>$row["data_annuncio"],
                )
            );
        }
        $result->close();
        // $num_ultimi=$annunci->num_rows; 
        if(count($annunci) >0){
            foreach($annunci as $annuncio)
            {
                echo '<div>'.$annuncio["squadra"].':'.$annuncio["testo"].'.('.date('d/m/Y', strtotime($annuncio["data"])).')</div>';
                echo '<hr>'; 
            }
            
            // echo '<div>'.$annuncio["testo"].'</div>';
            // echo $num_ultimi;
            // print_r($annunci);
            // echo '<br>';
        //     echo '<table >';
        //     echo '<tr> ';

        //     echo '<th>Data</th>';
        //     echo '<th>Squadra</th>';
        //     echo '<th>Annuncio</th>';
        //     echo '</tr>';
        //     foreach($annunci as $annuncio)
        //     {
        //         echo '<tr> ';
        //             echo '<td>'. date('d/m/Y', strtotime($annuncio["data"])).'</td>';
        //             echo '<td>'.$annuncio["squadra"].'</td>';
        //             echo '<td>'.$annuncio["testo"].'</td>';
        //         echo '</tr>';
        //     }
        //     echo "</table>";
        //     echo '<hr>';    
        }   
        else
        {
            echo "<div>Non ci annunci di mercato</div>";
            echo '<hr>';
        }
        
        $conn->next_result();
    ?> 
</div>