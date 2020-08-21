<div class="widget">
    <h2>Il Fustometro</h2>
    <h3>Fusti assegnati</h3>
    <?php 
        $query='SELECT * FROM `contafusti` WHERE Stato = 1 order By DataUM desc';
        $result=$conn->query($query) or die($conn->error);
        $fustiassegnati = array();
        while($row = $result->fetch_assoc()){
            array_push($fustiassegnati, array(
                "Id"=>$row["Id"],
                "Presidente"=>$row["Presidente"],
                "Motivazione"=>$row["Motivazione"],
                "Stato"=>$row["Stato"],
                "DataUM"=>$row["DataUM"],
                )
            );
        }
        $result->close();
        // echo print_r($fustiassegnati);

        ?>
    <div class="fustiassegnati widgetcontent">
        <div class="fustiassegnaticontent">
            <div id="count-example">
            <?php echo count($fustiassegnati) ?>
            </div>
        </div>    
        <div class="lista">
            <ul>
            <?php
                foreach($fustiassegnati as $k => $v){
                    if ($k % 2 == 0) {
                        echo '<li class="alternate">';
                    }
                    else
                    {
                        echo '<li class="">';
                    }
                    echo $v["Presidente"];
                    if($v["Motivazione"] != "")
                    {
                        echo ': ' .$v["Motivazione"] ;
                    }
                    // echo '('.date('d/m/Y', strtotime($v["DataUM"])).')';
                    echo'</li>';
                }
            ?>
                <!-- <li class="alternate">Andrea Rotondo</li>
                <li class="">Filippo Pagliarella</li>
                <li class="alternate">Andrea Rotondo</li>
                <li class="">Andrea Rotondo</li>
                <li class="alternate">Daniele Rotondo</li> -->
            </ul>
        </div>
    </div>
   
    <hr>
</div>