<?php 
include("menu.php");

?>

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}


.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}

.floatbox {
    float:left; /*force into block level for dimensions*/
    //width:400px;
    height:900px;
    //background:blue;
    color:#000;
    margin:20px 20px 0 0;
}
</style>




<h2>Rose</h2>


<?php 
include("dbinfo_susyleague.inc.php");
//echo $username;
$con=mysqli_connect($host,$username,$password,$database) or die( "Unable to select database");


$query="SELECT * FROM sq_fantacalcio";
//echo $query;
$result=mysqli_query($con,$query);
$num=mysqli_num_rows($result);

//echo "<br>" . "num= " . $num;




#echo "<b><left>Squadre</center></b><br><br>";

$query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";
//echo $query_generale;
$result_generale=mysqli_query($con,$query_generale);
$f=mysqli_fetch_assoc($result_generale);
//echo "generale=";
//print_r($f);
$fantamilioni=$f["valore"];

$i=0;

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
<div class="floatbox">
<h2><?php echo "$squadra";?></h2>
<h3><?php echo "(" .$allenatore .")";?></h3>

<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th><font face="Arial, Helvetica, sans-serif">Nome</font></th>
<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
<th><font face="Arial, Helvetica, sans-serif">Ruolo</font></th>
<th><font face="Arial, Helvetica, sans-serif">Costo</font></th>
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


<tr bgcolor= <?php switch ($ruolo_giocatore) {
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
> 

<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$nome_giocatore"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$squadra_giocatore"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$ruolo_giocatore"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$costo_giocatore"; ?></font></td>
</tr>

<?php 
++$j;

} 
echo "</table>";

?>
<form action="" class="a-form">
<label for="modulo"> Fantamilioni spesi= </label>
<label id="spesi" > <?php  echo $spesi; ?> </label><br>
<label for="restanti" >Fantamilioni restanti= </label>
<label id="restanti" >  <?php  echo $fantamilioni-$spesi; ?></label><br>
</form>
</div>
<?php 

++$i;
} 



mysqli_close();

?>



<?php 
include("footer.html");

?>

</body>
</html>
