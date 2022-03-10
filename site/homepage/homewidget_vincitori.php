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
            echo "<div class='widgetcontent vincitori'>Non sono ancora stati assegnati premi!</div>";
            echo '<hr>';
        
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

                echo "<div >";
                if($index%2== 0)
                        echo "<div class='result'>";
                    else
                        echo '<div class="result alternate" >';
                    echo '
                        <div style="width:85%; display: inline-block;text-align: center;">'.$vincitore["Squadra"].' ('.$vincitore["Allenatore"].')</div>
                        <div style="width:14%; display: inline-block;text-align: center;">'.$vincitore["Posizione"].'</div>';
                    echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }
        
        $conn->next_result();
    ?>

    <hr>
</div>