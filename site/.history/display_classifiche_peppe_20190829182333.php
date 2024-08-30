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
    class RigaClassifica{
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
    function cmp($a, $b)
    {
        return $a->marcatori < $b->marcatori;
    }
?>
<?php
include "display_classifica_apertura.php";
include "display_classifica_chiusura.php";
?>