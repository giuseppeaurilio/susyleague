<?php 
include("menu.php");

?>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
<script>

function load_data(id_sq, ruolo) {
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'sq_sa='+id_sq+"&"+"ruolo="+ruolo,
                success:function(html){
                    $('#giocatore').html(html);
                    //$('#city').html('<option value="">Select state first</option>'); 
                }
            }); 
}


$(document).ready(function(){
    $('#sq_sa').on('change',function(){
        var sq_sa_ID = $('#sq_sa').val();
        var ruolo = $('#ruolo').val();
        var a=load_data(sq_sa_ID ,ruolo);
        if(sq_sa_ID && ruolo){
			load_data(sq_sa_ID , ruolo)
        }else{
            $('#giocatore').html('<option value="">--Seleziona giocatore--</option>');
            //$('#city').html('<option value="">Select state first</option>'); 
        }
    });
    
    $('#ruolo').on('change',function(){
        var sq_sa_ID = $('#sq_sa').val();
        var ruolo = $('#ruolo').val();
        var a=load_data(sq_sa_ID ,ruolo);
        if(sq_sa_ID && ruolo){
			load_data(sq_sa_ID , ruolo)
        }else{
            $('#giocatore').html('<option value="">--Seleziona giocatore--</option>');
            //$('#city').html('<option value="">Select state first</option>'); 
        }
    });

   $('#giocatore').on('change',function(){
        var sq_sa_ID = $('#sq_sa').val();
        var ruolo = $('#ruolo').val();
        var giocatore_ID=$('#giocatore').val();
        var sq_fc = $('#sq_fc').val();
        var costo=$('#costo').val();
        var disabled=!(sq_sa_ID  && giocatore_ID && sq_fc && $.isNumeric(costo))
		$("#submit").prop('disabled', disabled);
        $("#sommario").val(giocatore_ID + "_" + sq_fc)
        
    });
    
    $('#sq_fc').on('change',function(){
        var sq_sa_ID = $('#sq_sa').val();
        var ruolo = $('#ruolo').val();
        var giocatore_ID=$('#giocatore').val();
        var sq_fc = $('#sq_fc').val();
        var costo=$('#costo').val();
        var disabled=!(sq_sa_ID  && giocatore_ID && sq_fc && $.isNumeric(costo))
		$("#submit").prop('disabled', disabled);
        $("#sommario").val( giocatore_ID + "_" + sq_fc)
        
    });   

    $('#costo').on('keyup',function(){
        var sq_sa_ID = $('#sq_sa').val();
        var ruolo = $('#ruolo').val();
        var giocatore_ID=$('#giocatore').val();
        var sq_fc = $('#sq_fc').val();
        var costo=$('#costo').val();
        var disabled=!(sq_sa_ID  && giocatore_ID && sq_fc && $.isNumeric(costo))
		$("#submit").prop('disabled', disabled);
        $("#sommario").val( giocatore_ID + "_" + sq_fc)
        
    });  
    
    
});
</script>
	
<h2>Aggiungi Giocatore</h2>
<div class="aggiungi">
<form action="aggiungi_a_rosa.php" method="get">
<select name="Ruolo" id="ruolo">
  <option value="">--Seleziona ruolo--</option>	
  <option value="P">Portiere</option>
  <option value="D">Difensore</option>
  <option value="C">Centrocampista</option>
  <option value="A">Attaccante</option>
</select>


<select name="squadra_serie_a" id="sq_sa">
<option value="">--Seleziona squadra--</option>	
<?php
$query_sa="SELECT * FROM squadre_serie_a order by squadra";
$result_sa=$conn->query($query_sa);

$num_sa=$result_sa->num_rows; 
$i=0;
while ($row=$result_sa->fetch_assoc()) {
	
	$id=$row["id"];
    $squadra=$row["squadra_breve"];
	  echo '<option value=' . $id . '>'. $squadra . '</option>';
++$i;
}
?>
</select>


<select name="giocatore" id="giocatore">
		<option value="">--Seleziona giocatore--</option>	
</select>

&#8658;


<select id="sq_fc" name="squadra_fantacalcio ">
	<option value="">--Seleziona squadra fantacalcio--</option>	
	  
<?php
$query="SELECT * FROM sq_fantacalcio order by squadra   ";
$result=$conn->query($query);

$num=$result->num_rows; 
$i=0;
while ($row=$result->fetch_assoc()) {
	$id=$row["id"];
    $squadra=$row["squadra"];
	  echo '<option value=' . $id . '>'. $squadra . '</option>';
++$i;
}
?>
</select>

Costo:<input type="text" id="costo" name="costo" size="4">


<input  type="hidden" id="sommario" name="sommario" value="">
 
 
<input type="submit" id="submit" value="Aggiungi" disabled>
</form> 

</div>



<h2>Rose</h2>


<?php 




#echo "<b><left>Squadre</center></b><br><br>";

$query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";
#echo $query2;
$result_generale=$conn->query($query_generale);
while ($row=$result_generale->fetch_assoc()) {

$fantamilioni=$row["valore"];
}
$i=0;

$query="SELECT * FROM sq_fantacalcio order by squadra";
$result=$conn->query($query);

$num=$result->num_rows; 


while ($row=$result->fetch_assoc()) {



$id=$row["id"];
$squadra=$row["squadra"];
$allenatore=$row["allenatore"];
$query2="SELECT a.costo,a.id_giocatore, b.nome, b.ruolo, c.squadra_breve  FROM rose as a inner join giocatori as b inner join squadre_serie_a as c where a.id_sq_fc='" . $id ."' and a.id_giocatore=b.id and b.id_squadra=c.id order by b.ruolo desc";
#echo $query2;
$result_giocatori=$conn->query($query2);
$num_giocatori=$result_giocatori->num_rows;

#echo $i;

?>
<div class="rosegiocatoriseriea">
<h2><?php echo "$squadra";?></h2>
<h3><?php echo "(" .$allenatore .")";?></h3>

<table class="table_rose" border="0" cellspacing="2" cellpadding="2">
<tr> 

<th>Nome</th>
<th>Squadra</th>
<th>Ruolo</th>
<th>Costo</th>
<th>Azione</th>
</tr>
<?php 

$j=0;
$spesi=0;
$portieri=0;
$difensori=0;
$centrocampisti=0;
$attaccanti=0;
while ($row=$result_giocatori->fetch_assoc()) {
	$id_giocatore=$row["id_giocatore"];
	$nome_giocatore=$row["nome"];
	$squadra_giocatore=$row["squadra_breve"];
	$ruolo_giocatore=$row["ruolo"];
	$costo_giocatore=$row["costo"];
$spesi = $spesi+ $costo_giocatore;
$portieri=$portieri + ($ruolo_giocatore=="P");
$difensori=$difensori + ($ruolo_giocatore=="D");
$centrocampisti=$centrocampisti + ($ruolo_giocatore=="C");
$attaccanti=$attaccanti + ($ruolo_giocatore=="A");
?>


<tr style="background-color: <?php switch ($ruolo_giocatore) {
    case "P":
        echo "#66CC33";
        break;
    case "D":
        echo "#33CCCC";
        break;
    case "C":
        echo "#FFEF00";
        break;
     case "A":
        echo "#E80000 ";
        break;
    default:
        echo "#FFFFFF";
}
?>
"> 

<td><?php  echo "$nome_giocatore"; ?></td>
<td><?php  echo "$squadra_giocatore"; ?></td>
<td><?php  echo "$ruolo_giocatore"; ?></td>
<td><?php  echo "$costo_giocatore"; ?></td>
<td><a href=<?php  echo "cancella_giocatore_da_rosa.php?id_giocatore=" . $id_giocatore; ?> >Cancella</a></td>
</tr>

<?php 
++$j;

} 
echo "</table>";

?>
<br>

<table >
  <tr>
    <th>giocatori</th>
    <th><?php  echo $num_giocatori; ?></th>
  </tr >
  <tr>
    <th>portieri</th>
    <th><?php  echo $portieri; ?></th>
  </tr>
   <tr>
    <th>difensori</th>
    <th><?php  echo $difensori; ?></th>
  </tr>
  <tr>
    <th>centrocampisti</th>
    <th><?php  echo $centrocampisti; ?></th>
  </tr>
  <tr>
    <th>attaccanti</th>
    <th><?php  echo $attaccanti; ?></th>
  </tr>
  <tr >
    <th>Fantamilioni spesi</th>
    <th><?php  echo $spesi; ?></th>
  </tr>
   <tr >
    <th>Fantamilioni restanti</th>
    <th><?php  echo $fantamilioni-$spesi; ?></th>
  </tr>
  
</table>


</div>
<?php 

++$i;
} 
?>
<?php 
include("../footer.php");
?>
