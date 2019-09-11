<?php 
include("menu.php");

?>

<h2>Rose</h2>
<script>
    $(document).ready(function(){

        var time = 1000;
        var strurl = "/display_giocatori.php?autoscroll";
        var url_string = window.location.href;
        var url = new URL(url_string);
        var c = url.searchParams.get("autoscroll");
        console.log(c);
        // console.log($(document).height());
        time = $(document).height() *10;
        console.log(time);
    
        $('html, body').animate({ scrollTop: $(document).height() - $(window).height() }, time,"linear", function() {
            $(this).animate({ scrollTop: 0 }, time,"linear",  function(){window.location.href="/display_giocatori.php?autoscroll"});
        });
    });
</script>

<?php 

$query="SELECT * FROM sq_fantacalcio";
//echo $query;
$result = $con->query($query);

$query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";

// $result_generale=mysqli_query($con,$query_generale);
$result_generale = $con->query($query_generale);
$f=mysqli_fetch_assoc($result_generale);
//echo "generale=";
//print_r($f);
$fantamilioni=$f["valore"];

$i=0;
echo '<div class="maincontent">';
while ($i < $num) {


$squ=mysqli_fetch_assoc($result);
$id=$squ["id"];
$squadra=$squ["squadra"];
$allenatore=$squ["allenatore"];
$query2="SELECT a.costo,a.id_giocatore, b.nome, b.ruolo, c.squadra_breve  FROM rose as a inner join giocatori as b inner join squadre_serie_a as c where a.id_sq_fc='" . $id ."' and a.id_giocatore=b.id and b.id_squadra=c.id order by b.ruolo desc";
//echo $query2;
$result_giocatori=mysqli_query($con,$query2);
$num_giocatori=mysqli_num_rows($result_giocatori);

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
$spesi = $spesi+ $costo_giocatore;
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
</tr>

<?php 
++$j;

} 
echo "</table>";

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

++$i;
} 
echo '</div>';


// mysqli_close();
// $con->close();

?>


<?php 
include("footer.php");
?>
