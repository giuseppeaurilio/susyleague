<div class="widget">
    <h2>Vincitori</h2>
    <?php 
        $query='SELECT v.`id` as id, v.`competizione_id` as idc, v.`desc_competizione` as descc, 
        v.`posizione` as pos, v.`sq_id` as ids, sqf.squadra, sqf.allenatore 
        FROM `vincitori` as v
        left join sq_fantacalcio as sqf on sqf.id = v.sq_id
        order by competizione_id, desc_competizione, posizione';
        $result=$conn->query($query) or die($conn->error);
        $vincitori = array();
        while($row = $result->fetch_assoc()){
            array_push($vincitori, array(
                "Competizione"=>$row["descc"],
                "Squadra"=>$row["squadra"],
                "Allenatore"=>$row["allenatore"],
                "Posizione"=>$row["pos"],
                )
            );
        }
        $result->close();
        $conn->next_result();
        
        if(count($vincitori) == 0){
            echo "<h3> &nbsp;</h3>";
            echo "<div style='text-align: center;padding: 125px 0;' class=' vincitori'>Non sono ancora stati assegnati premi!</div>";
            // echo '<hr>';
        
        }  
        else
        {
            echo "<div class='widgetcontent vincitori'>";
            $competizionecurrent = "";
            $index=0;
            foreach($vincitori as $vincitore)
            {
                $index++;
               
                if($competizionecurrent == "" OR $competizionecurrent != $vincitore["Competizione"])
                {
                    $competizionecurrent = $vincitore["Competizione"];
                    $index=0;
                    echo '<h3>
                            <div >'.$vincitore["Competizione"].'</div>
                        </h3>';
                }

                // echo '<div class="vincitori">';
                $posizione = "primo";
                if($vincitore["Posizione"]=="1")
                {
                    $posizione = "primo";
                }
                else if($vincitore["Posizione"]=="2")
                {
                    $posizione = "secondo";
                }
                else if($vincitore["Posizione"]=="3")
                {
                    $posizione = "terzo";
                }

                $award = '<i class="fas fa-award"></i>';
               
                // {
                   
                // }
                if(($vincitore["Posizione"]=="1") && ($competizionecurrent=="Apertura Cannonieri"
                || $competizionecurrent=="Chiusura Cannonieri"
                || $competizionecurrent=="Aggregate Cannonieri"))
                {
                    $award = '<i class="far fa-futbol"></i>';
                }
                else if(($vincitore["Posizione"]=="1") && ($competizionecurrent=="Coppa Italia"
                || $competizionecurrent=="Supercoppa"
                || $competizionecurrent=="Coppa delle Coppe"))
                {
                    $award = '<i class="fas fa-trophy"></i>';
                }
                else if(($vincitore["Posizione"]=="1") && ($competizionecurrent=="Finale Campionato"))
                {
                    $award = '<i class="fas fa-shield-alt"></i>';
                }
                else
                // if($competizionecurrent=="Apertura Campionato"
                // || $competizionecurrent=="Chiusura Campionato"
                // || $competizionecurrent=="Aggregate Campionato")
                {
                    $award = '<i class="fas fa-award"></i>';
                }
                if($index%2== 0)
                        echo '<div class="result '.$posizione.'" >';
                    else
                        echo '<div class="result alternate '.$posizione.'" >';
                    // echo '
                    //     <div style="width:85%; display: inline-block;text-align: center;">'.$vincitore["Squadra"].' ('.$vincitore["Allenatore"].')</div>
                    //     <div style="width:14%; display: inline-block;text-align: center;">'.$vincitore["Posizione"].$award.'</div>';
                    echo '
                        <div class="squadra">'.$vincitore["Squadra"].' ('.$vincitore["Allenatore"].')</div>
                        <div class="premio">'.$award.'</div>';
                    echo "</div>";
                // echo "</div>";
            }
            echo "</div>";
        }
        
        $conn->next_result();
    ?>

    <hr>
</div>