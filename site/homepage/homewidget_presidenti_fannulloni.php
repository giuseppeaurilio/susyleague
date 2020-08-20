<div class="widget">
    <h2>Presidenti fannulloni</h2>
    <?php 
        $query='SELECT Allenatore, ammcontrollata, ammcontrollata_anno FROM `sq_fantacalcio` where  ammcontrollata_anno > 0 order by ammcontrollata desc, ammcontrollata_anno desc, allenatore';
        $result=$conn->query($query) or die($conn->error);
        $presidenti = array();
        while($row = $result->fetch_assoc()){
            array_push($presidenti, array(
                "Allenatore"=>$row["Allenatore"],
                "ammcontrollata"=>$row["ammcontrollata"],
                "ammcontrollata_anno"=>$row["ammcontrollata_anno"],
                )
            );
        }
        $result->close();
        $conn->next_result();
        
        if(count($presidenti) == 0){
            echo "<div>Abbiamo solo bravi presidenti!</div>";
            echo '<hr>';
        
        }  
        else
        {
            echo "<div>";
            echo '<h3>
                    <div style="width:55%; display: inline-block;">Presidente</div>
                    <div style="width:20%; display: inline-block;text-align: center;">#G</div>
                    <div style="width:20%; display: inline-block;text-align: center;">#G TOT</div>
                </h3>';
            $index=0;
            foreach($presidenti as $presidente)
            {
                $index++;
                if($index%2== 0)
                    echo "<div class='result'>";
                else
                    echo '<div class="result alternate" >';
                echo '<div style="width:55%; display: inline-block;">'.$presidente["Allenatore"].'</div>
                    <div style="width:20%; display: inline-block;text-align: center;">'.$presidente["ammcontrollata"].'</div>
                    <div style="width:20%; display: inline-block;text-align: center;">'.$presidente["ammcontrollata_anno"].'</div>';
                echo "</div>";
               
            }
            echo "</div>";
        }
        $conn->next_result();
    ?>
</div>