<div class="widget">
    <h2>Ultimi risultati</h2>

    <?php

    //tantativo di query per ultimi risultati
//     SELECT g.id_giornata, sqf1.squadra as sq_casa, sqf2.squadra as sq_ospite, 
//     c.gol_casa, c.gol_ospiti as gol_ospite, c.punti_casa as voto_casa, c.punti_ospiti as voto_ospite
//     FROM giornate as g 
//     left join calendario as c on g.id_giornata =  c.id_giornata
//     left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
//     LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
//     where c.gol_casa is not null
//     and fine =(
//     SELECT fine
// FROM `giornate` as g 
// left join calendario as c on g.id_giornata =  c.id_giornata
// where g.fine < CURRENT_DATE
// order by fine desc
//     Limit 1)
//     order by fine desc
    $querylastdate   = "SELECT fine
    FROM `giornate` as g 
    left join calendario as c on g.id_giornata =  c.id_giornata
    where c.gol_casa is not null
    order by fine
    limit 1";
    $result=$conn->query($querylastdate) or die($conn->error);
    $res = $result->fetch_object();
    // print_r("res".$res);
    $lastdate = $res == "" ? "": $res->fine;
    $result_ultimi = 0;
    $num_ultimi = 0;
    $counter = 0;
    for ($girone = 1; $girone <= 10; $girone++) {
        $queryultimi="SELECT g.id_giornata, sqf1.squadra as sq_casa, sqf2.squadra as sq_ospite, 
        c.gol_casa, c.gol_ospiti as gol_ospite, c.punti_casa as voto_casa, c.punti_ospiti as voto_ospite
        FROM giornate as g 
        left join calendario as c on g.id_giornata =  c.id_giornata
        left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
        where c.gol_casa is not null
        and fine='" .$lastdate. "'
        and id_girone = ".$girone ;
        // echo $queryultimi;
        // echo '<br>';
        $result_ultimi=$conn->query($queryultimi);
        $risultati = array();
        while($row = $result_ultimi->fetch_assoc()){
            array_push($risultati, array(
                "id_giornata" =>$row["id_giornata"],
                "sq_casa"=>$row["sq_casa"],
                "sq_ospite"=>$row["sq_ospite"],
                "gol_casa"=>$row["gol_casa"],
                "gol_ospite"=>$row["gol_ospite"],
                "voto_casa"=>$row["voto_casa"],
                "voto_ospite"=>$row["voto_ospite"],
                )
            );
        }
        $result_ultimi->close();
        $conn->next_result();
        // $num_ultimi=$result_ultimi->num_rows; 
        if(count($risultati) >0){
            echo '<div>';
            $counter +=count($risultati);

            $id= $risultati[0]["id_giornata"];
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
            foreach($risultati as $risultato){
                // echo $num_ultimi;
                // print_r($risultato);
                // echo '<br>';
                $index++;
                if($index%2== 0)
                echo '<div class="result">';
                else
                echo '<div class="result alternate">';
                echo '<a style="text-decoration: none;color: black;" href="/display_giornata.php?&id_giornata='.$id.'">';  
                echo '<div>'. $risultato["sq_casa"].' <span class="punti">('.$risultato["voto_casa"].')</span><span class="gol" >'.$risultato["gol_casa"].'</span></div>';
                echo '<div>'. $risultato["sq_ospite"].' <span class="punti">('.$risultato["voto_ospite"].')</span><span class="gol">'.$risultato["gol_ospite"].'</span></div>';
                echo '</a>';  
                echo '</div>';
                }
            echo '</div>';
            echo '<div class="footer">';
            // switch ($girone)
            // {
            //     case 1:
            //     case 2:
            //     case 6:
            //         echo '<a href="/display_calendario.php?id_girone='.$girone.'">Consulta il calendario.</a>';    
            //     break;
            //     case 4:
            //         echo '<a href="/display_calendario_coppaitalia_gironi.php">Consulta il calendario.</a>';    
            //     break;
            //     case 5:
            //         echo '<a href="/display_calendario_coppaitalia_tabellone.php">Consulta il calendario.</a>';    
            //     break;
            //     case 7:
            //     case 8:
            //         echo '<a href="/display_calendario_finali.php">Consulta il calendario.</a>';    
            //     break;
            // }
            echo '<a href="/display_classifiche.php">Classifiche</a>';  
            echo '</div>';
            
        }   
       
       
    }
    if($counter ==0)
    {
        echo "<div>Non sono state giocate partite recentemente.</div>";
        // echo '<div class="footer"><a href="/display_calendario.php?id_girone=1">Consulta il calendario.</a></div>';    
    }
    
    echo '<hr>';
    ?>
</div>