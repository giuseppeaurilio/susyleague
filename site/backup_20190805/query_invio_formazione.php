<?php 
include("dbinfo_susyleague.inc.php");
include("send_message_post.php");

$id_squadra=mysql_escape_String($_POST['id_squadra']);
$id_giornata=mysql_escape_String($_POST['id_giornata']);
$titolari=mysql_escape_String($_POST['titolari']);
$panchina=mysql_escape_String($_POST['panchina']);
$password_all=mysql_escape_String($_POST['password_all']);
    session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
	}
	
#echo "tutto ok!";
#echo $id_squadra;
#echo $id_giornata;
#echo $titolari;
#echo $password_all;


$link = mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


function readback($id_giornata,$id_squadra)
{
	$query="SELECT id_posizione, id_giocatore FROM formazioni where id_giornata=$id_giornata and id_squadra=$id_squadra order by id_posizione";
	$result=mysql_query($query);
	$num=mysql_numrows($result);
	$i=0;
	$a=array();
	while ($i < $num) 
	{
		array_push($a,mysql_result($result,$i,"id_giocatore"));
		++$i;
	}
	//$a[3]="5";
	//print_r($a);

	return $a;
}

date_default_timezone_set('Europe/Rome');

$adesso = date('Y-m-d H:i:s');
$nl="%0D%0";
$nl="\n";


$query="select fine from giornate where id_giornata=" . $id_giornata  . " and fine > '" . $adesso ."'";
#echo "<br>query_data=" . $query;
$result=mysql_query($query);
$num=mysql_numrows($result); 

#$query="SELECT password FROM sq_fantacalcio where id='" . $id_squadra . "'";
#echo $query;
#$result=mysql_query($query);
#$saved_password=mysql_result($result,0,"password");
#echo "id_squadra_logged" . $id_squadra_logged;
#echo "allenatore" . $allenatore;
#echo "id_squadra" . $id_squadra;
if ($num>0){
	if ($id_squadra==$id_squadra_logged){ 
		
		$query="SELECT * FROM sq_fantacalcio where id=$id_squadra";
		$result=mysql_query($query);

		$num=mysql_numrows($result); 
		$allenatore_nome = mysql_result($result,0,"allenatore");
		$squadrafc_nome = mysql_result($result,0,"squadra");
		#echo "pippo" .$id_squadra_logged .  $id_squadra . "fine";
		$titolari_array=explode("," , $titolari);
		$panchina_array=explode("," , $panchina);
		$num_titolari=count($titolari_array);
		$num_panchina=count($panchina_array);
		
		
		#echo "<br> num titolari= " .$num_titolari;
		#echo "<br> num panchina= " . $num_panchina;
		if (($num_titolari==11) and ($num_panchina==8)){
			$giocatori=array_merge ($titolari_array, $panchina_array);
			$prova_nr=0;
			do  
			{
				++$prova_nr;
				#print_r($giocatori);
				$i=1;
				$query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `id_giocatore`, `id_squadra_sa`) VALUES (" . $id_giornata .",". $id_squadra . "," ;
				$text="$squadrafc_nome ha appena inviato la formazione per la giornata $id_giornata \n\n". "TITOLARI \n\n";
				$ruolo_old="P";
				foreach ($giocatori as $value) 
				{
					$query_squadra="SELECT a.*, b.squadra_breve from giocatori as a inner join squadre_serie_a as b where a.id_squadra=b.id and a.id=" .$value ;
					#echo $query_nome;
					$result=mysql_query($query_squadra);
					$id_squadra_sa=mysql_result($result,0,"id_squadra");
					$nome=mysql_result($result,0,"nome");
					$ruolo=mysql_result($result,0,"ruolo");
					$squadra_breve=mysql_result($result,0,"squadra_breve");
	
					$query=$query_ini . $i . ",'" .$value . "','" . $id_squadra_sa . "')" ;
					$result=mysql_query($query);
					$text .= "$nome($squadra_breve) ";
					if ($i<11){
						$text .= "\n";
						}
	
					if ($i==11) {
	
						$text .= "\n\n" ."A DISPOSIZIONE \n\n";
					}
	
					$i=$i+1;
					#echo $query;
				}# end foreach
			//echo $text;
		} while ((readback($id_giornata,$id_squadra) <> $giocatori) and ($prova_nr<10)); // end prove immissione
		//echo "prova numero = $prova_nr";
		if ($prova_nr<10)
		{
			echo "Formazione inviata \n";
			echo "Messaggio telegram inviato \n";
			echo  $adesso ;
			//$text="ciao";
			$a=send_message_post($text);
		}
		else
		{
			echo "ATTENZIONE!!!!! \n\nSi e' verificato un problema con l'invio della formazione. Si prega di riprovare";
		}
		} #end if numero giocatori
		else echo "La formazione deve includere necessariamente 11 titolari e 8 riserve";
	}# end if password corretta
	else echo "Non si e' autenticati per iviare la formazione";
}# end if data corretta
else echo "E' troppo tardi per inviare la formazione";
?> 
