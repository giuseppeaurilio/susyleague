<div class="widget">
<script>
    $(document).ready(function(){
        $('.perlecontent').slick({
            arrows:false,
            autoplay:true,
            autoplaySpeed: 5000,
            dots:true,
            centerMode:true,
            respondTo:'window'
            }
        );

   
})
</script>
    <h2>Le perle di Iori</h2>
    <!-- <h3>Fusti assegnati</h3> -->
    <?php 
       $query= "SELECT `Id`, `Data`, `Testo`FROM `perlediiori` order by 'Data' Desc";
        $result=$conn->query($query) or die($conn->error);
        $perle = array();
        while($row = $result->fetch_assoc()){
            array_push($perle, array(
                "Id"=>$row["Id"],
                "Data"=>($row["Data"]),
                "Testo"=>($row["Testo"])
                )
            );
        }
        $result->close();
        // echo print_r($fustiassegnati);

        ?>
    <div class="perle widgetcontent">
        
        <div class="perlecontent">
            <?php
                foreach($perle as $perla){
                    echo '<div class="perla" ><span>'.$perla["Testo"].'</span></div>';
                }
            ?>  
        
        </div>
    </div>
   
    <hr>
</div>