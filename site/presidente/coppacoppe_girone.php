<?php 
include("menu.php");

?>
<script>
    // SalvaGirone = function(){
    //     // alert($(this).attr('id'));
    //     var idsquadre = [];
        
    //     for (x = 1; x <= 10; x++) {
    //         var d = $("#sq_fc"  + x + " option:selected").val();
    //         if(d == null || d == 0 ){
    //             alert('selezionare tutte le squadre del girone')
    //             return false;
    //         }
    //         idsquadre.push(d);
    //     }
    //     alert (dati);
        
    //     $.ajax({
    //             type:'POST',
    //             url:'coppacoppe_c_salvagiorone.php',
    //             data: {"idsquadre": JSON.stringify(idsquadre)},
    //             success:function(data){
    //                 // debugger;
    //                 var resp=$.parseJSON(data)
    //                 if(resp.result == "true"){
    //                     alert(resp.message);
    //                 }
    //                 else{
    //                     alert(resp.error.msg);
    //                 }
                    
    //                 //$('#city').html('<option value="">Select state first</option>'); 
    //             }
    //             // ,error: function (xhr, ajaxOptions, thrownError) {
    //             //     alert(xhr.responseText);
    //             // }
    //     }); 
    // }
    GeneraCalendario = function(){
        var idsquadre = [];
        // for (x = 1; x <= 10; x++) {
        //     var d = $("#sq_fc"  + x + " option:selected").val();
        //     if(d == null || d == 0 ){
        //         alert('selezionare tutte le squadre del girone')
        //         return false;
        //     }
        //     idsquadre.push(d);
        // }
        $('.coppacoppasquadra').each(function( index ) {
            if($(this).is(":checked"))
                idsquadre.push($(this).val());
            });
        //var dati = JSON.stringify({"girone": girone, "idsquadre": idsquadre});
        // alert(JSON.stringify(idsquadre));
        $.ajax({
                type:'POST',
                url:'coppacoppe_c_generacalendario.php',
                data: {"idsquadre": JSON.stringify(idsquadre)},
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
    }
    // showhideOption = function(){
    //     var value =$(this).val();
    //     var hf = $("#hf" +  $(this).attr("id").slice(-1).toLowerCase());
    //     // alert(value);
    //     if(value != null && value != ""){
    //         $("select option[value=" + $(this).val() + "]").hide();
    //         hf.val($(this).val());
    //     }    
    //     else{
    //         $("select option[value=" + hf.val() + "]").show();
    //         hf.val("");
    //     }
    // };
    // CaricaGirone = function(){
    //     $.ajax({
    //             type:'POST',
    //             url:'coppacoppe_c_getgirone.php',
    //             data: {"girone": "unico"},
    //             dataType:"json", 
    //             success:function(data){
    //                 // debugger;
    //                 // var resp=$.parseJSON(data)
    //                 if(data.result == "true"){
    //                     // alert(data.id_numbers);
    //                     for (i = 0; i < data.id_numbers.length; i++) { 
    //                         $("#sq_fc" + (i+1)).val(data.id_numbers[i]["id_squadra"]).trigger('change');
    //                         $("#cb"+ (i+1)).prop('checked', data.id_numbers[i]["squadra_materasso"] == "1");
    //                     }
    //                 }
    //                 else{
    //                     alert(data.error.msg);
    //                 }
    //                 //$('#city').html('<option value="">Select state first</option>'); 
    //             }
    //             // ,error: function (xhr, ajaxOptions, thrownError) {
    //             //     alert(xhr.responseText);
    //             // }
    //         });
    // }
    $(document).ready(function(){

        
        // $("#salvagirone").off("click").bind("click", SalvaGirone);

        $("#generacalendariogirone").off("click").bind("click", GeneraCalendario);

        // $( "select").change(showhideOption);

        // CaricaGirone();
    })
</script>


<h2>Girone Coppa delle Coppe </h2>
<div >
<?php
// $index =1;
// while ($index <= 10){
//     echo '<input type="hidden" id="hf'.$index.'"/>';
//     echo '<select id="sq_fc' .$index.'" name="squadra_fantacalcio">';
//     echo '<option value="">--Seleziona squadra fantacalcio--</option>';
        

    $query="SELECT * FROM sq_fantacalcio order by squadra";
    // $result=mysql_query($query);
    // $num=mysql_numrows($result); 
    $result=$conn->query($query);
    $num=$result->num_rows; 
    $i=0;
    while($row = $result->fetch_assoc()){
        // $id=mysql_result($result,$i,"id");
        $id=$row["id"];
        $squadra=$row["squadra"];
        echo '<input id="cbSquadra'.$id.'" class="coppacoppasquadra" type="checkbox" checked  value="'.$id.'">'. $squadra . '</input><br>';
    // ++$i;
    }

//     echo '</select>';
//     echo '<br/>';
//     $index++;
// }
?>

<!-- <input type="button" id="salvagirone" value="Salva"/> -->
<input type="button" id="generacalendariogirone" value="Genera Calendario"/>
</div>

<div class="mainaction">
    <a href="coppacoppe_calendario.php" >Calendario Incontri</a>
</div>
    
<?php 
include("../footer.php");
?>
