<div class="widget">
    <h2>Prossimo turno</h2>
    <?php
    // $querylastdate   = "SELECT fine
    // FROM `giornate` as g 
    // left join calendario as c on g.id_giornata =  c.id_giornata
    // where c.gol_casa is not null
    // order by fine
    // limit 1";
    // $result=$conn->query($querylastdate) or die($conn->error);
    // $res = $result->fetch_object();
    // // print_r("res".$res);
    // $lastdate = $res == "" ? "": $res->fine;

    $result_prox = 0;
    $num_prox = 0;
    $counter = 0;
    for ($girone = 1; $girone <= 10; $girone++) {

        
        $queryprox="SELECT g.id_giornata, sqf1.squadra as sq_casa, sqf2.squadra as sq_ospite
        FROM giornate as g 
        left join calendario as c on g.id_giornata =  c.id_giornata
        left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
        where fine > current_date()
        AND inizio < current_date()
        and id_girone = ".$girone ;
        // echo $queryprox;
        // echo '<br>';
        $result_prox=$conn->query($queryprox);

        // $num_prox=$result_prox->num_rows; 
        // if($num_prox >0){
        //     echo '<div>';
        //     $counter +=$num_prox;
        //     // echo $num_prox;
        //      print_r($result_prox);
        //     echo '<br>';
        //     echo '</div>';
        // }
        $partite = array();
        while($row = $result_prox->fetch_assoc()){
            array_push($partite, array(
                "id_giornata" =>$row["id_giornata"],
                "sq_casa"=>$row["sq_casa"],
                "sq_ospite"=>$row["sq_ospite"],
                )
            );
        }
        $result_prox->close();
        $conn->next_result();


        if(count($partite) >0){
            echo '<div>';
            $counter +=count($partite);

            $id= $partite[0]["id_giornata"];
            $descrizioneGiornata = "";
            if($id <= 22)
            { $descrizioneGiornata ="Campionato - Apertura. Giornata ". $id;}
            else if ($id>22 && $id<= 33)
            { $descrizioneGiornata ="Campionato - Chiusura. Giornata ". $id - 22;}
            else if ($id>33 && $id<= 48)
            { $descrizioneGiornata ="Coppa Italia - Girone Narpini. Giornata ".(ceil (($id-33) /3));}
            else if ($id>48 && $id<= 63)
            { $descrizioneGiornata ="Coppa Italia - Girone Gianluca. Giornata ".(ceil (($id-48) /3));}//(floor(($id-48)/3) + 1);}
            else if ($id == 64 )
            { $descrizioneGiornata ="Coppa Italia - Quarto 1 - Andata";}
            else if ($id == 65 )
            { $descrizioneGiornata ="Coppa Italia - Quarto 1 - Ritorno";}

            else if ($id == 66 )
            { $descrizioneGiornata ="Coppa Italia - Quarto 2 - Andata";}
            else if ($id == 67 )
            { $descrizioneGiornata ="Coppa Italia - Quarto 2 - Ritorno";}

            else if ($id == 68 )
            { $descrizioneGiornata ="Coppa Italia - Quarto 3 - Andata";}
            else if ($id == 69 )
            { $descrizioneGiornata ="Coppa Italia - Quarto 3 - Ritorno";}

            else if ($id == 70 )
            { $descrizioneGiornata ="Coppa Italia - Quarto 4 - Andata";}
            else if ($id == 71 )
            { $descrizioneGiornata ="Coppa Italia - Quarto 4 - Ritorno";}

            else if ($id == 72 )
            { $descrizioneGiornata ="Coppa Italia - Semifinale 1 - Andata";}
            else if ($id == 73 )
            { $descrizioneGiornata ="Coppa Italia - Semifinale 1 - Ritorno";}

            else if ($id == 74 )
            { $descrizioneGiornata ="Coppa Italia - Semifinale 2 - Andata";}
            else if ($id == 75 )
            { $descrizioneGiornata ="Coppa Italia - Semifinale 2 - Ritorno";}

            else if ($id == 76 )
            { $descrizioneGiornata ="Finale COPPA ITALIA";}
            else if ($id == 77 || $id == 78)
            { $descrizioneGiornata ="Coppa delle coppe - Giornata" . ($id-76);}

            else if ($id == 79)
            { $descrizioneGiornata ="Finale CAMPIONATO";}

            else if ($id == 79)
            { $descrizioneGiornata ="SUPERCOPPA";}

            else
            { $descrizioneGiornata ="mancante ".$id ;}
        
            // print_r($girone);
            // echo '<br>';
            echo '<h3>'.$descrizioneGiornata.'</h3>';
            
            // print_r($lastdate);
            // echo '<br>';
            $index=0;
            foreach($partite as $partita){
                // echo $num_ultimi;
                // print_r($risultato);
                // echo '<br>';
                $index++;
                if($index%2== 0)
                echo '<div class="result">';
                else
                echo '<div class="result alternate">';
                echo '<div><span style="float:left;">'. $partita["sq_casa"].'</span><span>-</span><span style="float:right;">'. $partita["sq_ospite"].'</span></div>';
                
                echo '</div>';
                }
            echo '</div>';
        } 
    }
    
    
    if($counter ==0)
    {
        echo "<div>Non ci sono partite in programma</div>";
     
    }
    echo '<div class="footer"><a href="/invio_formazione.php">Invia la formazione</a></div>';
    echo '<hr>';
    ?>

</div>