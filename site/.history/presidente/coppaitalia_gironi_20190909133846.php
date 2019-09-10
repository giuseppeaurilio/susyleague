<?php 
include("menu.php");

?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
    SalvaGirone = function(){
        // alert($(this).attr('id'));
        var girone = $(this).attr("id").slice(-1).toLowerCase()
        var dati = "";
        dati += "idg=" + girone;
        for (x = 1; x <= 6; x++) {
            var d = $("#sq_fcgir" + girone + x + " option:selected").val();
            var m = document.getElementById("cb" + girone + x + "").checked ? "1" : "0";
            if(d == null || d == 0 ){
                alert('selezionare tutte le squadre del girone')
                return false;
            }
            
            // if(data.lastIndexOf(d) != -1){
            //     alert('la squadra ' + $("#sq_fcgir" + girone + x + " option:selected").text() + " è presente più volte nel girone." )
            //     return false;
            // }

            dati += "&" + "sq" + x + "=" + d+ "&sq" + x + "m=" + m;
            // if(x == 1){
            //     dati +="sq" + x + "=" + d + "&sq" + x + "m=" + m;
            //     // $data += "#sq_fcgira" + $x + " option:selected"
            // }
            // else{
                // dati += "&" + "sq" + x + "=" + d+ "&sq" + x + "m=" + m;
                // $data += "&" + "#sq_fcgira" + $x + " option:selected"
            // }
        }
        // alert (dati);
        $.ajax({
                type:'POST',
                url:'coppaitalia_c_salvagiorne.php',
                data: dati,
                success:function(data){
                    // debugger;
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
    GeneraCalendario = function(){
        // alert("cal" + $(this).attr('id'));
        var girone = $(this).attr("id").slice(-1).toLowerCase();
        var idsquadre = [];
        for (x = 1; x <= 6; x++) {
            var d = $("#sq_fcgir" + girone + x + " option:selected").val();
            if(d == null || d == 0 ){
                alert('selezionare tutte le squadre del girone')
                return false;
            }
            idsquadre.push(d);
        }
        //var dati = JSON.stringify({"girone": girone, "idsquadre": idsquadre});
        // alert(JSON.stringify(idsquadre));
        $.ajax({
                type:'POST',
                url:'coppaitalia_c_generacalendario.php',
                data: {"girone": girone, "idsquadre": JSON.stringify(idsquadre)},
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
    showhideOption = function(){
        var value =$(this).val();
        var hf = $("#hf" +  $(this).attr("id").slice(-2).toLowerCase());
        // alert(value);
        if(value != null && value != ""){
            $("select option[value=" + $(this).val() + "]").hide();
            hf.val($(this).val());
        }    
        else{
            $("select option[value=" + hf.val() + "]").show();
            hf.val("");
        }
    };
    CaricaGirone = function(girone){
        $.ajax({
                type:'POST',
                url:'coppaitalia_c_getgirone.php',
                data: {"girone": girone},
                dataType:"json", 
                success:function(data){
                    // debugger;
                    // var resp=$.parseJSON(data)
                    if(data.result == "true"){
                        // alert(data.id_numbers);
                        for (i = 0; i < data.id_numbers.length; i++) { 
                            $("#sq_fcgir" + data.idg + (i+1)).val(data.id_numbers[i]["id_squadra"]).trigger('change');
                            $("#cb"+ data.idg + (i+1)).prop('checked', data.id_numbers[i]["squadra_materasso"] == "1");
                        }
                    }
                    else{
                        alert(data.error.msg);
                    }
                    
                    //$('#city').html('<option value="">Select state first</option>'); 
                }
                // ,error: function (xhr, ajaxOptions, thrownError) {
                //     alert(xhr.responseText);
                // }
            });
    }
    $(document).ready(function(){

        
        $("#salvagironeA").off("click").bind("click", SalvaGirone);
        $("#salvagironeB").off("click").bind("click", SalvaGirone);

        $("#generacalendariogironeA").off("click").bind("click", GeneraCalendario);
        $("#generacalendariogironeB").off("click").bind("click", GeneraCalendario);

        $( "select").change(showhideOption);

        CaricaGirone("a");
        CaricaGirone("b");
    })
</script>

<div style=" padding: 10px; display:inline-block;">
<h2>Girone A </h2>
<div >
<?php
$index =1;
while ($index <= 6){
    echo '<input type="hidden" id="hfa'.$index.'"/>';
    echo '<select id="sq_fcgira' .$index.'" name="squadra_fantacalcio">';
    echo '<option value="">--Seleziona squadra fantacalcio--</option>';
        

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
        echo '<option value=' . $id . '>'. $squadra . '</option>';
    ++$i;
    }

    echo '</select>';
    echo '<input type="checkbox" id="cba'.$index.'">materasso</input>';
    echo '<br/>';
    $index++;
}
?>

<input type="button" id="salvagironeA" value="Salva"/>
<input type="button" id="generacalendariogironeA" value="Genera Calendario"/>
</div>
</div>

<div style=" padding: 10px; display:inline-block;">
<h2>Girone B </h2>
<div >
<?php
$index =1;
while ($index <= 6){
    echo '<input type="hidden" id="hfb'.$index.'"/>';
    echo '<select id="sq_fcgirb' .$index.'" name="squadra_fantacalcio">';
    echo '<option value="">--Seleziona squadra fantacalcio--</option>';
        

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
        echo '<option value=' . $id . '>'. $squadra . '</option>';
    ++$i;
    }

    echo '</select>';
    echo '<input type="checkbox" id="cbb'.$index.'">materasso</input>';
    echo '<br/>';
    $index++;
}
?>
<input type="button" id="salvagironeB" value="Salva"/>
<input type="button" id="generacalendariogironeB" value="Genera Calendario"/>
</div>
</div>

<div class="mainaction">
    <a href="coppaitalia_calendario.php" >Calendario Incontri</a>
</div>
<?php 
include("../footer.php");
?>

