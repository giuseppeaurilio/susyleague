
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
    if(count($annunci) >0){
        echo '<div class="widget">';
        echo '<h2>Il presidente ha qualcosa da dirvi</h2>';
        foreach($annunci as $annuncio){
            // echo $num_ultimi;
            // print_r($annunci);
            // echo '<br>';
            echo '<h3>'.$annuncio["titolo"].'</h3>';
            
            echo '<div>'.$annuncio["testo"].'</div>';
            echo '<hr>';
        }
        echo '</div>   ';
    }
    $conn->next_result();
?> 
