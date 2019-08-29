<?php
include "menu.php";

?>
<link href="style.css" rel="stylesheet" type="text/css">

<style>
body{
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
table{
	border-collapse: collapse;
	width: 100%;
}
table th, table td{
	border: 1px solid #ddd;
	padding: 8px;
	}
table tr:nth-child(even){
	background-color: #f2f2f2;
	}
table tr:hover {
	background-color: #ddd;
	}
table th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: left;
	background-color: #4CAF50;
	color: white;
}
</style>
<?php
    class Rigaclassifica{
        public $idSquadra;
        public $squadra;
        public $punti;
        public $marcatori;
        public $vittorie;
        public $pareggi;
        public $sconfitte;
        public $golfatti;
        public $golsubiti;
        public $marcatoricasa;
        public $vittoriecasa;
        public $pareggicasa;
        public $sconfittecasa;
        public $golfatticasa;
        public $golsubiticasa;
        public $marcatoritrasf;
        public $vittorietrasf;
        public $pareggitrasf;
        public $sconfittetrasf;
        public $golfattitrasf;
        public $golsubititrasf;
    }
?>


<?php
include "dbinfo_susyleague.inc.php";
#echo $username;
// Create connection
$conn = new mysqli($localhost, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$idgirone=2;
// echo "Connected successfully";
$query='
CREATE TEMPORARY TABLE classificacasa
SELECT c.id_sq_casa as idsquadrac, 
SUM(case 
	when gol_casa> gol_ospiti then 3 
    when gol_casa = gol_ospiti then 1
    when gol_casa< gol_ospiti then 0 
end) as puntic,
SUM(punti_casa) as marcatoric, 
SUM(case 
	when gol_casa> gol_ospiti then 1 
    ELSE 0
end) as vittoriec,
SUM(case 
	when gol_casa = gol_ospiti then 1 
    ELSE 0
end) as pareggic,
SUM(case 
	when gol_casa < gol_ospiti then 1 
    ELSE 0
end) as sconfittec,
SUM(gol_casa) as golfattic,
SUM(gol_ospiti) as golsubitic
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone = '.$idgirone.'
group by id_sq_casa
order by puntic desc;


CREATE TEMPORARY TABLE classificatrasferta
SELECT c.id_sq_ospite as idsquadrat, 
SUM(case 
	when gol_ospiti > gol_casa then 3 
    when gol_ospiti = gol_casa then 1
    when gol_ospiti < gol_casa then 0 
end) as puntit,
SUM(punti_ospiti) as marcatorit, 
SUM(case 
	when gol_ospiti > gol_casa then 1 
    ELSE 0
end) as vittoriet,
SUM(case 
	when gol_ospiti = gol_casa then 1 
    ELSE 0
end) as pareggit,
SUM(case 
	when gol_ospiti < gol_casa then 1 
    ELSE 0
end) as sconfittet,
SUM(gol_casa) as golsubitit,
SUM(gol_ospiti) as golfattit
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone = '.$idgirone.'
group by id_sq_ospite
order by puntit desc;

select cc.idsquadrac as idsquadra,sf.squadra, 
cc.puntic + ct.puntit as punti,
cc.marcatoric + ct.marcatorit as marcatori,
cc.vittoriec + ct.vittoriet as vittoriet,
cc.pareggic + ct.pareggit as pareggi,
cc.sconfittec + ct.sconfittet as sconfitte,
cc.golfattic + ct.golfattit as golfatti,
cc.golsubitic + ct.golsubitit as golsubiti,
cc.marcatoric,  cc.vittoriec, cc.pareggic, cc.sconfittec, cc.golfattic, cc.golsubitic,
ct.marcatorit, ct.vittoriet, ct.pareggit, ct.sconfittet, ct.golfattit, ct.golsubitit
from classificacasa as cc
inner join classificatrasferta as ct on cc.idsquadrac = ct.idsquadrat
left  join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc;


DROP TEMPORARY TABLE classificacasa;
DROP TEMPORARY TABLE classificatrasferta;';

$result_girone = $conn->query($query);
