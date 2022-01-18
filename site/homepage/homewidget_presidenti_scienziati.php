<div class="widget">
    <h2>Presidenti scienziati</h2>
    <?php 
        $query='SELECT `id_sq_casa`, sqf1.squadra as sqcasa,  `numero_giocanti_casa`, `id_sq_ospite`, sqf2.squadra as sqtrasferta, `numero_giocanti_ospite` 
        FROM `calendario` as c 
        left join sq_fantacalcio as sqf1 on c.id_sq_casa = sqf1.id 
        left join sq_fantacalcio as sqf2 on c.id_sq_ospite = sqf2.id   
        WHERE (`numero_giocanti_casa` < 11 or `numero_giocanti_ospite` < 11) and gol_casa is not null';
        $result=$conn->query($query) or die($conn->error);
        $formazioni = array();
        while($row = $result->fetch_assoc()){
            array_push($formazioni, array(
                "idcasa"=>$row["id_sq_casa"],
                "sqcasa"=>$row["sqcasa"],
                "numcasa"=>$row["numero_giocanti_casa"],
                "idtrasferta"=>$row["id_sq_ospite"],
                "sqtrasferta"=>$row["sqtrasferta"],
                "numtrasferta"=>$row["numero_giocanti_ospite"],
                )
            );
        }
        $result->close();
        $conn->next_result();
        $presidenti = array();
        for ($ids = 1; $ids <= 12; $ids++) {
            $squadra = "";
            $indieci = 0;
            $innove = 0;
            $meno = 0;
            foreach($formazioni as $formazione)
            {
                if($formazione["idcasa"] == $ids)
                {
                   $squadra = $formazione["sqcasa"];
                   if($formazione["numcasa"] == 10)
                   {
                        $indieci++;
                   }
                   if($formazione["numcasa"] == 9) 
                   {
                        $innove++;
                   }
                   if($formazione["numcasa"] < 9) 
                   {
                        $meno++;
                   }
                }
                else  if($formazione["idtrasferta"] == $ids)
                {
                   $squadra = $formazione["sqtrasferta"];
                   if($formazione["numtrasferta"] == 10)
                   {
                        $indieci++;
                   }
                   if($formazione["numtrasferta"] == 9) 
                   {
                        $innove++;
                   }
                   if($formazione["numtrasferta"] < 9) 
                   {
                        $meno++;
                   }
                }
            }
            if($indieci <> 0 || $innove <> 0 || $meno <> 0)
            array_push($presidenti, array(
                "idsquadra" => $ids,
                "squadra" => $squadra,
                "indieci" => $indieci,
                "innove" => $innove,
                "meno" => $meno,
                )
            );
        }
        if(count($presidenti) == 0){
            echo "<h3> &nbsp;</h3>";
            echo "<div class='widgetcontent scienziati'>I nostri presidenti studiano!</div>";
            echo '<hr>';
        
        }  
        else
        {
            echo "<div class='widgetcontent scienziati'>";
            echo '<h3>
                    <div style="display: inline-block;width: 40%;">Squadra</div>
                    <div style="text-align: center;display: inline-block;width: 20%;">in 10</div>
                    <div style="text-align: center;display: inline-block;width: 20%;">in 9</div>
                    <div style="text-align: center;display: inline-block;width: 15%;">meno</div>
                </h3>';
            $index=0;
            foreach($presidenti as $presidente)
            {
                $index++;
                if($index%2== 0)
                    echo "<div class='result'>";
                else
                    echo '<div class="result alternate" >';
                echo '<div style="display: inline-block;width: 40%;">'.$presidente["squadra"].'</div>
                    <div style="text-align: center;display: inline-block;width: 20%;">'.$presidente["indieci"].'</div>
                    <div style="text-align: center;display: inline-block;width: 20%;">'.$presidente["innove"].'</div>
                    <div style="text-align: center;display: inline-block;width: 15%;">'.$presidente["meno"].'</div>';
                echo "</div>";
               
            }
            echo "</div>";
        }
        $conn->next_result();
    ?>
</div>