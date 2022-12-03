<?php 
include_once("menu.php");

?>
<script>

loadStatsDialog = function(id)
{
    var action ="stats";
    $.ajax({
        type:'POST',
            url:'display_riepilogoasta_controller.php',
            data: {
                "action": action,
                "id": id,
                "limit": 1,
            },
            success:function(data){
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                    if(resp.stats.length> 0){
                        //show data
                        var template = $('#tmplStats').html();
                        Mustache.parse(template);   // optional, speeds up future uses
                        var rendered = Mustache.render(template, resp);
                        $( "#dialog" ).prop('title', "Statistiche");        
                        $( "#dialog p" ).html(rendered);
                        $( "#dialog" ).dialog({modal:true, width:600});
                    }
                    else{
                        $( "#dialog" ).prop('title', "ERROR");                
                        $( "#dialog p" ).html("nessun dato presente");
                        $( "#dialog" ).dialog({modal:true});
                    }
                }
                else{
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
            }
    }); 
}
$(document).ready(function(){
    $(".rosegiocatoriseriea tr").unbind().bind("click", function(){
        loadStatsDialog($(this).data("id")); 
        } 
    );
})

</script>


<script id="tmplStats" type="x-tmpl-mustache">
    <h3>
        {{ stats.0.nome }} ({{ stats.0.squadra_breve }}) - {{ stats.0.ruolo }}
	</h3>
    <table border="0" cellspacing="2" cellpadding="2" style="text-align: center;">
        <tr><th>anno</th><th>pg</th><th>mv</th><th>mf</th><th>gf</th><th>gs</th><th>rp</th><th>rc</th><th>r+</th><th>r-</th><th>as</th><th>asf</th><th>am</th><th>es</th><th>au</th></tr>
        {{#stats}}
        <tr>
            <td>{{anno}}</td>
            <td>{{pg}}</td>
            <td>{{mv}}</td>
            <td>{{mf}}</td>
            <td>{{gf}}</td>
            <td>{{gs}}</td>
            <td>{{rp}}</td>
            <td>{{rc}}</td>
            <td>{{r+}}</td>
            <td>{{r-}}</td>
            <td>{{ass}}</td>
            <td>{{asf}}</td>
            <td>{{amm}}</td>
            <td>{{esp}}</td>
            <td>{{au}}</td>
        </tr>
        {{/stats}}
    </table >
</table>
</script>
<h2>Rose</h2>
<script>
    $(document).ready(function(){

        var time = 1000;
        var strurl = "/display_giocatori.php?autoscroll";
        var url_string = window.location.href;
        var url = new URL(url_string);
        var c = url.searchParams.get("autoscroll");
        // console.log(c);
        // console.log($(document).height());
        time = $(document).height() *10;
        console.log(time);
        if(c != null)
		{
            $('html, body').animate({ scrollTop: $(document).height() - $(window).height() }, time,"linear", function() {
                $(this).animate({ scrollTop: 0 }, time,"linear",  function(){window.location.href="/display_giocatori.php?autoscroll"});
            });
        }
    });
</script>

<?php 

// $query="SELECT * FROM sq_fantacalcio";
// //echo $query;
// $result = $conn->query($query);
include_once ("DB/fantacalcio.php");
$squadre = fantacalcio_getFantasquadre();

$query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";

// $result_generale=mysqli_query($con,$query_generale);
$result_generale = $conn->query($query_generale);
$f=mysqli_fetch_assoc($result_generale);
//echo "generale=";
//print_r($f);
$fantamilioni=$f["valore"];


echo '<div class="maincontent">';
foreach($squadre as $squ)
{

// $squ=mysqli_fetch_assoc($result);
$id=$squ["id"];
$squadra=$squ["squadra"];
$allenatore=$squ["allenatore"];
// $query2="SELECT a.costo,a.id_giocatore, b.nome, b.ruolo, c.squadra_breve  
// FROM rose as a inner join giocatori as b inner join squadre_serie_a as c 
// where a.id_sq_fc='" . $id ."' and a.id_giocatore=b.id and b.id_squadra=c.id order by b.ruolo desc";
$query2 = "SELECT r.costo,r.id_giocatore, g.nome, g.ruolo, sqa.squadra_breve, ra.ordine
FROM rose as r 
inner join giocatori as g on r.id_giocatore = g.id
inner join squadre_serie_a as sqa on sqa.id = g.id_squadra
inner join rose_asta as ra on r.id_giocatore = ra.id_giocatore
where r.id_sq_fc= '" . $id ."'
order by g.ruolo desc, ra.ordine";
//echo $query2;
$result_giocatori=mysqli_query($conn,$query2);
$num_giocatori=$result_giocatori->num_rows;

//echo "num giocatori=" . $num_giocatori;

?>


<div class="rosegiocatoriseriea">
<h2><?php echo "$squadra";?></h2>
<h3><?php echo "(" .$allenatore .")";?></h3>

<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th class="nome">Nome</th>
<th>Squadra</th>
<th>Ruolo</th>
<th>Costo</th>
</tr>
<?php 

$j=0;
$spesi=0;
while ($j < $num_giocatori) {
 $giocatore=mysqli_fetch_assoc($result_giocatori);
$id_giocatore=$giocatore["id_giocatore"];
$nome_giocatore=$giocatore["nome"];
//echo $nome_giocatore;
$squadra_giocatore=$giocatore["squadra_breve"];
$ruolo_giocatore=$giocatore["ruolo"];
$costo_giocatore=$giocatore["costo"];
// $spesi = $spesi+ $costo_giocatore;
?>


<tr style="cursor: pointer; background-color: <?php switch ($ruolo_giocatore) {
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
"
data-id="<?php  echo "$id_giocatore"; ?>"
> 


<td>
    <?php  
        echo "$nome_giocatore"; 
        echo  "&nbsp;<a style='float: right;font-size: small; color:black;' target='_blank' 
        href='https://www.fantacalcio.it/squadre/Giocatore/$nome_giocatore/$id_giocatore/5/2020-21'
        onclick='event.stopPropagation()'>
        <i class='fas fa-external-link-alt'></i>"
    ?>
</td>
<td><?php  echo "$squadra_giocatore"; ?></td>
<td><?php  echo "$ruolo_giocatore"; ?></td>
<td><?php  echo "$costo_giocatore"; ?></td>
</tr>

<?php 
++$j;

} 
echo "</table>";
$query3 = "select sum(ra.costo) as spesi
from rose_asta as ra
where ra.id_sq_fc = '". $id ."'";
$result3 = $conn->query($query3);
$f3=mysqli_fetch_assoc($result3);
//echo "generale=";
//print_r($f);
$spesi=$f3["spesi"];
?>
<table >
  <tr>
    <th>Fantamilioni spesi</th>
    <th><?php  echo $spesi; ?></th>
  </tr >
  <tr>
    <th>Fantamilioni restanti</th>
    <th><?php  echo $fantamilioni-$spesi; ?></th>
  </tr >
</table>
<!-- <form action="" class="a-form">
<label for="modulo"> Fantamilioni spesi= </label>
<label id="spesi" > <?php  echo $spesi; ?> </label><br>
<label for="restanti" >Fantamilioni restanti= </label>
<label id="restanti" >  <?php  echo $fantamilioni-$spesi; ?></label><br>
</form> -->
</div>
<?php 


} 
echo '</div>';


// mysqli_close();
// $con->close();

?>


<?php 
include_once("footer.php");
?>
