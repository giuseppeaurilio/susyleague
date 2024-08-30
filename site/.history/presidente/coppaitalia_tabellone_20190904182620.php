<?php
include("menu.php");

?>

<!DOCTYPE html>
<html>
<head>

<h1>Tabellone Coppa Italia</h2>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

    SalvaSquadrePartita = function(){
        var id1 = $("#sq_finalista1 option:selected").val();
        var id2 = $("#sq_finalista2 option:selected").val();
        var giornata = $("#hfgiornata").val();
        if(id1 == null || id1 == "")
        {
            alert('selezionare la squadra vincente Girone A');
            return false;
        }
        if(id2 == null || id2 == "")
        {
            alert('selezionare la squadra vincente Girone B');
            return false;
        }

        if(id1== id2 )
        {
            alert('le due squadre devono essere diverse');
            return false;
        }
        var idsquadre = [id1, id2];

        $.ajax({
                type:'POST',
                url:'finale_c_salvasquadre.php',
                data: {"idgiornata": giornata, "idsquadre": JSON.stringify(idsquadre)},
                success:function(data){
                   //debugger;
                    var resp=$.parseJSON(data)
                    if(resp.result == "true"){
                        alert(resp.message);
                    }
                    else{
                        alert(resp.error.msg);
                    }
                    
                    //$('#city').html('<option value="">Select state first</option>'); 
                }
                // ,error: function (xhr, ajaxOptions, thrownError) {
                //     alert(xhr.responseText);
                // }
            });
    };
    $("#salvasquadre").off("click").bind("click", SalvaSquadrePartita);

})
</script>

<?php
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$idgirone = 5; //5 tabellone coppaitalia 
include("../dbinfo_susyleague.inc.php");
$query= "SELECT giornate.*, 
        calendario.id_sq_casa, sq1.squadra as squadracasa,
        calendario.id_sq_ospite,  sq2.squadra as squadraospite 
        FROM `giornate` 
        left join `calendario` on `giornate`.`id_giornata` =  `calendario`.`id_giornata` 
        left join `sq_fantacalcio` sq1 on `calendario`.`id_sq_casa` =  `sq1`.`id`
        left join `sq_fantacalcio` sq2 on `calendario`.`id_sq_ospite` =  `sq2`.`id`
        WHERE id_girone = ".$idgirone." order by id_giornata ASC";
$result=$conn->query($query);
$giornate = array();
while ($row=$result->fetch_assoc()) {
    $id_giornata=$row["id_giornata"];
    $inizio=$row["inizio"];
    $fine=$row["fine"];
    $id_sq1=$row["id_sq_casa"];
    $sq1=$row["squadracasa"];
    $id_sq2=$row["id_sq_ospite"];
    $sq2=$row["squadraospite"];
    $inizio_a=date_parse($inizio);
    $fine_a=date_parse($fine);
    array_push($giornate, array(
        "id_giornata"=>$id_giornata,
        "inizio_a"=>$inizio_a,
        "fine_a"=>$fine_a,
        "id_sq1"=>$id_sq1,
        "sq1"=>$sq1,
        "id_sq2"=>$id_sq2,
        "sq2"=>$sq2,
        )
    );
}

foreach($giornate as $giornata){
    print_r($giornata);
    echo "<br><br><br>";

    //match di andata e ritorno
    //quarti
    //semifinali

    //finale secca
}

    
$conn->close();
?>
