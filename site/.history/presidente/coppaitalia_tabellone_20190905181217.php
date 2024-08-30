<?php
include("menu.php");

?>

<!DOCTYPE html>
<html>
<head>

<h1>Tabellone Coppa Italia</h2>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.min.css"/>
<script src="../js/jquery.datetimepicker.full.min.js"></script>
<script>
$(document).ready(function(){

    SalvaSquadrePartita = function(){
        
        var giornata = $(this).attr("name");

        console.log($(this).attr("name"));
        var id1 = $("#sq_a_" +  giornata + " option:selected").val();
        var id2 = $("#sq_b_" +  giornata + " option:selected").val();
        if(id1 == null || id1 == "")
        {
            alert('selezionare la squadra 1');
            return false;
        }
        if(id2 == null || id2 == "")
        {
            alert('selezionare la squadra 2');
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
                url:'match_c_salvasquadre.php',
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
    $(".btn_salvasquadre").off("click").bind("click", SalvaSquadrePartita);

    
    

    $.datetimepicker.setLocale('it');
    $('.datetime_class').datetimepicker();
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
$query="SELECT * FROM sq_fantacalcio order by squadra";

$result=$conn->query($query);
$squadre = array();
while($row = $result->fetch_assoc()){
    // $id=mysql_result($result,$i,"id");
    $id=$row["id"];
    $squadra=$row["squadra"];
    array_push($squadre, array(
        "id"=>$id,
        "squadra"=>$squadra
        )
    );
}

foreach($giornate as $giornata){
    print_r($giornata);
    // echo "<br><br><br>";

    $index = $giornata["id_giornata"];
    //match di andata e ritorno 
    //quarti 64/65 66/67 68/69 70/71
    //semifinali 72/73 74/75
    //finale secca 76
    switch($index){
        case 64:
        case 66:
        case 68:
        case 70:
        case 72:
        case 74:
        echo '<fieldset>';
        if($index == 64 ||$index == 66 ||$index == 68 ||$index == 70 )
        echo '<legend>Quarto '.(($index-62)/2).'</legend>';
        else
        echo '<legend>Semifinale '.(($index-70)/2).'</legend>';
        echo '<select id="sq_a_'.$index.'" name="squadra_fantacalcio_a_'.$index.'">';
        if($index == 72)
        echo '<option value="">--Vincente Quarto 1--</option>';
        else if($index == 74)
        echo '<option value="">--Vincente Quarto 3--</option>';
        else
        echo '<option value="">--Seleziona squadra fantacalcio--</option>';
        foreach($squadre as $squadra)
        {
            if($squadra["id"] ==$giornata["id_sq1"] ){
                echo '<option value=' . $squadra["id"] . ' selected>'. $squadra["squadra"] . '</option>';    
            }
            else{
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
        }
        echo '</select>';
        echo '<select id="sq_b_'.$index.'" name="squadra_fantacalcio_b_'.$index.'">';
        if($index == 72)
        echo '<option value="">--Vincente Quarto 2--</option>';
        else if($index == 74)
        echo '<option value="">--Vincente Quarto 4--</option>';
        else
        echo '<option value="">--Seleziona squadra fantacalcio--</option>';
        foreach($squadre as $squadra)
        {
            if($squadra["id"] ==$giornata["id_sq2"] ){
                echo '<option value=' . $squadra["id"] . ' selected>'. $squadra["squadra"] . '</option>';    
            }
            else{
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
        }
        echo '</select>';
        echo '<input type="button" class="btn_salvasquadre" id="salvasquadre'.$giornata["id_giornata"].'" value="Salva Squadre" name="'.$giornata["id_giornata"].'"/>';
        echo '<br>';
        echo '<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">';
       
        // $date_string_da = "";
        // if($giornata['inizio_a']["year"] != 0)
        // // print_r($giornata['inizio_a']);
        // $date_string_da =  date('Y-m-d H:i:s', mktime($giornata['inizio_a']['hour'], $giornata['inizio_a']['minute'], $giornata['inizio_a']['second'], $giornata['inizio_a']['month'], $giornata['inizio_a']['day'], $giornata['inizio_a']['year']));
        
        
        // $date_string_a = "";
        // if($giornata['fine_a']["year"] != 0)
        // // print_r($giornata['inizio_a']);
        // $date_string_a =  date('Y-m-d H:i:s', mktime($giornata['fine_a']['hour'], $giornata['fine_a']['minute'], $giornata['fine_a']['second'], $giornata['fine_a']['month'], $giornata['fine_a']['day'], $giornata['fine_a']['year']));

        // echo 'Andata <br>';
        // echo 'inizio: <input type="text" name="dataAndataDa" class="datetime_class" size="12" value="'. $date_string_da .'" id="txtDataAndataDa'.$giornata["id_giornata"].'">';
        // echo 'fine: <input type="text" name="dataAndataA" class="datetime_class" size="12" value="'. $date_string_a .'" id="txtDataAndataA'.$giornata["id_giornata"].'">';
        echo '<input type="hidden" name="giornata" value="'.$giornata["id_giornata"].'">';
        echo 'Inizio: <br>';
        echo 'Giorno:<input type="text" name="g_inizio" size="5" value="'. $giornata['inizio_a']['day'] .'" >';
        echo 'Mese:<input type="text" name="m_inizio" size="5" value="'. $giornata['inizio_a']['month'] .'" >';
        echo 'Anno:<input type="text" name="a_inizio" size="5" value="'. $giornata['inizio_a']['year'] .'">';
        echo 'Ore:<input type="text" name="h_inizio" size="5" value="'. $giornata['inizio_a']['hour'] .'">';
        echo 'Minuti:<input type="text" name="min_inizio" size="5" value="'. $giornata['inizio_a']['minute'] .'"><br>';
        echo 'Fine: <br>';
        echo 'Giorno:<input type="text" name="g_fine" size="5" value="'. $giornata['fine_a']['day'] .'" >';
        echo 'Mese:<input type="text" name="m_fine" size="5" value="'. $giornata['fine_a']['month'] .'" >';
        echo 'Anno:<input type="text" name="a_fine" size="5" value="'. $giornata['fine_a']['year'] .'">';
        echo 'Ore:<input type="text" name="h_fine" size="5" value="'. $giornata['fine_a']['hour'] .'">';
        echo 'Minuti:<input type="text" name="min_fine" size="5" value="'.  $giornata['fine_a']['minute'] .'"><br>';
        echo '<a href="calcola_giornata.php?&id_giornata='.$id_giornata .'&id_girone='.$idgirone.'">Calcola Giornata</a>';        
        echo '<br>';
        echo '<input type="submit" value="Salva date" name="dateandata'.$giornata["id_giornata"].'">';
        echo '</form>';
        //match di andata
        break;
        case 65:
        case 67:
        case 69:
        case 71:
        case 73:
        case 75:

        echo '<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">';

        $date_string_da = "";
        if($giornata['inizio_a']["year"] != 0)
        // print_r($giornata['inizio_a']);
        $date_string_da =  date('Y-m-d H:i:s', mktime($giornata['inizio_a']['hour'], $giornata['inizio_a']['minute'], $giornata['inizio_a']['second'], $giornata['inizio_a']['month'], $giornata['inizio_a']['day'], $giornata['inizio_a']['year']));
        
        
        $date_string_a = "";
        if($giornata['fine_a']["year"] != 0)
        // print_r($giornata['inizio_a']);
        $date_string_a =  date('Y-m-d H:i:s', mktime($giornata['fine_a']['hour'], $giornata['fine_a']['minute'], $giornata['fine_a']['second'], $giornata['fine_a']['month'], $giornata['fine_a']['day'], $giornata['fine_a']['year']));

        echo 'Ritorno <br>';
        echo 'inizio: <input type="text" name="dataRitornoDa" class="datetime_class" size="12" value="'. $date_string_da .'" id="txtDataRitornoDa'.$giornata["id_giornata"].'">';
        echo 'fine: <input type="text" name="dataRitornoA" class="datetime_class" size="12" value="'. $date_string_a .'" id="txtDataRitornoA'.$giornata["id_giornata"].'">';
        
        echo '<a href="calcola_giornata.php?&id_giornata='.$giornata["id_giornata"] .'&id_girone='.$idgirone.'">Calcola Giornata</a>';
        echo '<br>';
        echo '<input type="submit" value="Salva date" name="dateritorno'.$giornata["id_giornata"].'">';
        echo '</form>';
        echo '<br>';
        echo '</fieldset>';
        //match di ritorno
        break;
        case 76:
        //Finale

        echo '<fieldset>';
        echo '<legend>FINALE</legend>';
        echo '<select id="sq_a_'.$index.'" name="squadra_fantacalcio_a_'.$index.'">';
        echo '<option value="">--Vincente Semifinale 1--</option>';
        foreach($squadre as $squadra)
        {
            if($id ==$giornata["id_sq1"] ){
                echo '<option value=' . $squadra["id"] . ' selected>'. $squadra["squadra"] . '</option>';    
            }
            else{
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
        }
        echo '</select>';
        echo '<select id="sq_b_'.$index.'" name="squadra_fantacalcio_b_'.$index.'">';
        echo '<option value="">--Vincente Semifinale 2--</option>';
        foreach($squadre as $squadra)
        {
            if($id ==$giornata["id_sq2"] ){
                echo '<option value=' . $squadra["id"] . ' selected>'. $squadra["squadra"] . '</option>';    
            }
            else{
                echo '<option value=' . $squadra["id"] . '>'. $squadra["squadra"] . '</option>';
            }
        }
        echo '</select>';
        echo '<input type="button" class="btn_salvasquadre" id="salvasquadre'.$giornata["id_giornata"].'" value="Salva Squadre" name="'.$giornata["id_giornata"].'"/>';
        echo '<br>';
        echo '<form action="query_amministra_giornate.php" method="post" class="a-form" target="formSending">';

        $date_string_da = "";
        if($giornata['inizio_a']["year"] != 0)
        // print_r($giornata['inizio_a']);
        $date_string_da =  date('Y-m-d H:i:s', mktime($giornata['inizio_a']['hour'], $giornata['inizio_a']['minute'], $giornata['inizio_a']['second'], $giornata['inizio_a']['month'], $giornata['inizio_a']['day'], $giornata['inizio_a']['year']));
        
        
        $date_string_a = "";
        if($giornata['fine_a']["year"] != 0)
        // print_r($giornata['inizio_a']);
        $date_string_a =  date('Y-m-d H:i:s', mktime($giornata['fine_a']['hour'], $giornata['fine_a']['minute'], $giornata['fine_a']['second'], $giornata['fine_a']['month'], $giornata['fine_a']['day'], $giornata['fine_a']['year']));

        echo 'Ritorno <br>';
        echo 'inizio: <input type="text" name="dataRitornoDa" class="datetime_class" size="12" value="'. $date_string_da .'" id="txtDataRitornoDa'.$giornata["id_giornata"].'">';
        echo 'fine: <input type="text" name="dataRitornoA" class="datetime_class" size="12" value="'. $date_string_a .'" id="txtDataRitornoA'.$giornata["id_giornata"].'">';
        
        echo '<a href="calcola_giornata.php?&id_giornata='.$giornata["id_giornata"] .'&id_girone='.$idgirone.'">Calcola Giornata</a>';
        echo '<br>';
        echo '<input type="submit" value="Salva date" name="dateritorno'.$giornata["id_giornata"].'">';
        echo '</form>';
        echo '<br>';
        echo '</fieldset>';
        break;
    }
}

    
$conn->close();
?>
<?php 
include("footer.html");
?>
</body>
</html>