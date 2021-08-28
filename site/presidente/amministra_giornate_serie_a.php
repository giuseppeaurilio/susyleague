
<?php 
include("menu.php");
?>
<script>
salvaDate = function(){
    // console.log($(this).attr("data-idgiornata"));
    var idgiornata =  $(this).attr("data-idgiornata");
    var inizio = $("#txtinizio" + idgiornata).val();
    var fine = $("#txtfine" + idgiornata).val();
    // console.log ("inizio: " + inizio);
    // console.log ("fine: " +fine);
    var message = ""
    if(idgiornata == null)
            message = 'giornata selezionata non valida';
    if(message == "" && (inizio == ""))
        message = 'data inizion non valida';
    if(message == "" && fine == "" )
        message = 'data fine non valida';
    if(message == "" && fine < inizio )
        message = 'data fine deve essere successiva a data inizio';
    
    
    if (message != "")
    {
        // alert (message);
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(message);
        $( "#dialog" ).dialog({modal:true});
        return false;
    }

    var action ="salvaseriea";
    $.ajax({
            type:'POST',
            url:'amministra_giornate_controller.php',
            data: {
                "action": action,
                "idgiornata": idgiornata,
                "inizio": inizio,
                "fine": fine,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}
cancellaDate = function (){
    // console.log($(this).attr("data-idgiornata"));
    var idgiornata =  $(this).attr("data-idgiornata");
    // console.log ("inizio: " + inizio);
    // console.log ("fine: " +fine);
    var message = ""
    if(idgiornata == null)
            message = 'giornata selezionata non valida';
    
    if (message != "")
    {
        // alert (message);
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(message);
        $( "#dialog" ).dialog({modal:true});
        return false;
    }

    var action ="cancellaseriea";
    $.ajax({
            type:'POST',
            url:'amministra_giornate_controller.php',
            data: {
                "action": action,
                "idgiornata": idgiornata,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}
$(document).ready(function(){
    $(".datetimeselector").flatpickr({enableTime: true,})
    $(".btnsalvadata").off("click").bind("click", salvaDate);
    $(".btncancelladata").off("click").bind("click", cancellaDate);
})

</script>

<table border="0" cellspacing="2" cellpadding="2">
    <tbody>
        <tr> 
            <th>Id</th>
            <th>Descrizione</th>
            <th>Inizio</th>
            <th>Fine</th>
            <th>&nbsp;</th>
        </tr>
<?php 
include_once("../DB/serie_a.php");
$giornatesa = seriea_getGiornate();
//load giornate
// $query="SELECT id, descrizione, inizio, fine FROM `giornate_serie_a` order by id asc";

// $result=$conn->query($query);
// $giornate = array();
// while($row = $result->fetch_assoc()){    
//     array_push($giornate, array(
//         "id"=>$row["id"],
//         "descrizione"=>$row["descrizione"],
//         "inizio"=>$row["inizio"],
//         "fine"=>$row["fine"],
//         )
//     );
// }
// print_r($giornate);
foreach($giornatesa as $giornata)
{
    echo "<tr>
        <td>".$giornata["id"]."</td>
        <td>".$giornata["descrizione"]."</td>
        <td> <input class=\"datetimeselector\" type=\"textbox\" id=\"txtinizio".$giornata["id"]."\" value=\"" .$giornata["inizio"]."\"/></td>
        <td> <input class=\"datetimeselector\" type=\"textbox\" id=\"txtfine".$giornata["id"]."\" value=\"" .$giornata["fine"]."\"/></td>
        <td> 
            <input class=\"btnsalvadata\" type=\"button\" id=\"btndate".$giornata["id"]."\" value=\"salva\" data-idgiornata=".$giornata["id"].">
            <input class=\"btncancelladata\" type=\"button\" id=\"btndatedel".$giornata["id"]."\" value=\"cancella\" data-idgiornata=".$giornata["id"].">
            
            <a href=\"amministra_voti.php?giornata_serie_a_id=".$giornata["id"]."\" >Voti</a>
        </td>
    </tr>";
}
?>
</tbody>
</table>
<?php 
include("../footer.php");
?>
