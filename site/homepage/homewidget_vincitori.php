<div class="widget">
    <h2>Vincitori</h2>
    <?php 
        $query='SELECT g.nome as "Competizione", sqf.squadra as "Squadra", sqf.allenatore as "Allenatore"
        FROM `vincitori` as v 
        left join gironi as g on v.id_girone = g.id_girone 
        left join sq_fantacalcio as sqf on sqf.id = v.id_vincitore 
        order by g.id_girone desc';
        $result=$conn->query($query) or die($conn->error);
        $vincitori = array();
        while($row = $result->fetch_assoc()){
            array_push($vincitori, array(
                "Competizione"=>$row["Competizione"],
                "Squadra"=>$row["Squadra"],
                "Allenatore"=>$row["Allenatore"],
                )
            );
        }
        $result->close();
        $conn->next_result();
        
        if(count($vincitori) == 0){
            echo "<div>Non sono ancora stati assegnati premi!</div>";
            echo '<hr>';
        
        }  
        else
        {
            echo "<div>";
            echo '<h3>
                    <div style="width:49%; display: inline-block; text-align: center;">Competizione</div>
                    <div style="width:49%; display: inline-block;text-align: center;">Squadra</div>
                </h3>';
            $index=0;
            foreach($vincitori as $vincitore)
            {
                $index++;
                if($index%2== 0)
                    echo "<div class='result'>";
                else
                    echo '<div class="result alternate" >';
                echo '
                    <div style="width:49%; display: inline-block; text-align: center;">'.$vincitore["Competizione"].'</div>
                    <div style="width:49%; display: inline-block;text-align: center;">'.$vincitore["Squadra"].'</div>';
                echo "</div>";
               
            }
            echo "</div>";
        }
        $conn->next_result();
    ?>
</div>