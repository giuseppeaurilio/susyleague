<div class="widget">
    <h2>Fusti in preparazione</h2>
    <h3>Mastri birrai</h3>
    <?php
    $query='SELECT * FROM `contafusti` WHERE Stato = 0 order By DataUM desc';
    $result=$conn->query($query) or die($conn->error);
    $fustiinprep = array();
    while($row = $result->fetch_assoc()){
        array_push($fustiinprep, array(
            "Id"=>$row["Id"],
            "Presidente"=>$row["Presidente"],
            "Motivazione"=>$row["Motivazione"],
            "Stato"=>$row["Stato"],
            "DataUM"=>$row["DataUM"],
            )
        );
    }
    $result->close();
    // echo print_r($fustiinprep);
    ?>
    <div class="fusticoming widgetcontent">
        <div class="fusticomingcontent">
            <ul>
            <?php
                foreach($fustiinprep as $k => $v){
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
                <!-- <li class="alternate">Giuseppe Aurilio</li>
                <li class="">Daniele Rotondo</li>
                <li class="alternate">Giorgio "Coppi"</li> -->
            </ul>
        </div>
    </div>
    <hr>
</div>