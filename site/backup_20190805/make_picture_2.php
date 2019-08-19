<?php
//include ("./imagettftextboxopt.php");

$id_giornata=$_GET['id_giornata'];
$id_incontro= $_GET['id_incontro'];
$rotation= $_GET['rotation'];


$filename="soccer_field.jpg";
$my_img = imagecreatefromjpeg ($filename);
$white = imagecolorallocate($my_img, 255, 255, 255);
$black = imagecolorallocate($my_img, 0, 0, 0);
$my_img=imagerotate($my_img,90,$white);
$font = './bold.ttf';
$font_size=16;
$src = imagecreatefrompng('player.png');
$src_scaled=imagescale($src,40,40);



include("./dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query2="SELECT a.id_sq_casa as id_casa, a.id_sq_ospite as id_ospite, b.squadra as sq_casa, c.squadra as sq_ospite, a.gol_casa, a.gol_ospiti, a.punti_casa, a.punti_ospiti FROM calendario as a inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=".$id_giornata ." and a.id_partita=" . $id_incontro ;

$result_giornata=mysql_query($query2);
$num_giornata=mysql_numrows($result_giornata);
$j=0;
while ($j < $num_giornata) {
	$id_casa=mysql_result($result_giornata,$j,"id_casa");
	$id_ospite=mysql_result($result_giornata,$j,"id_ospite");
	$punti_casa=mysql_result($result_giornata,$j,"punti_casa");
	$gol_casa=mysql_result($result_giornata,$j,"gol_casa");
	$sq_casa=mysql_result($result_giornata,$j,"sq_casa");
	$sq_ospite=mysql_result($result_giornata,$j,"sq_ospite");
	$gol_ospite=mysql_result($result_giornata,$j,"gol_ospiti");
	$punti_ospite=mysql_result($result_giornata,$j,"punti_ospiti");
	

	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve FROM formazioni as a inner join giocatori as b inner join squadre_serie_a as c where a.id_giornata='" . $id_giornata . "' and a.id_squadra= '". $id_casa ."' and a.id_giocatore=b.id and a.id_squadra_sa=c.id ";

	$result_formazione=mysql_query($query_formazione);
	$num_giocatori=mysql_numrows($result_formazione);
	$i=0;
	while (($i < $num_giocatori) && ($i < 11) )
	{
		$ruolo=mysql_result($result_formazione,$i,"ruolo");
		$nome=mysql_result($result_formazione,$i,"nome");
		$squadra_breve=mysql_result($result_formazione,$i,"squadra_breve");
		$voto=mysql_result($result_formazione,$i,"voto"); 
		$voto_md=mysql_result($result_formazione,$i,"voto_md");
		$text="$nome($squadra_breve)-$voto $voto_md";
		//echo " $i $j </br> text=$text";
		$bbox = imagettfbbox($font_size, 0, $font, '$text');
		imagecopy($my_img, $src_scaled, imagesx($my_img)*0.5-20, imagesy($my_img)*($i+1)*0.1-20, 0, 0, 40, 40);
		imagettftext($my_img, $font_size, 0,imagesx($my_img)*0.5-$bbox[4]/2, imagesy($my_img)*($i+1)*0.1, $black, $font, $text);

		++$i;

	}
	
$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve FROM formazioni as a inner join giocatori as b inner join squadre_serie_a as c where a.id_giornata='" . $id_giornata . "' and a.id_squadra= '". $id_ospite ."' and a.id_giocatore=b.id and a.id_squadra_sa=c.id ";
++$j;
}







imagesetthickness ( $my_img, 5 );

header( "Content-type: image/png" );
imagepng( $my_img );


imagedestroy( $my_img );
?>
