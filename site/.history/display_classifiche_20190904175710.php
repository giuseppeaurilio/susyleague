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
<script>
// $(document).ready(function(){
//     $( "#tabs" ).tabs();
// });
</script>

<div id="tabs">
<ul>
    <li><a href="#tabs-1">Apertura </a></li>
    <li><a href="#tabs-2">Chiusura </a></li>
    <li><a href="#tabs-3">Aggregate </a></li>
    <li><a href="#tabs-4">FINALE</a></li>
    <li><a href="#tabs-5">Coppa Italia - Gironi</a></li>
    <li><a href="#tabs-6">Coppa Italia - Tabellone</a></li>
    <li><a href="#tabs-7">Coppa delle coppe</a></li>
    <!-- <li><a href="#tabs-8">Supercoppa</a></li> -->

</ul>
<?php
include "display_classifica_apertura.php";
include "display_classifica_chiusura.php";
include "display_classifica_aggregate.php";
include "display_classifica_finale.php";
include "display_classifica_coppaitalia_gironi.php";
include "display_classifica_coppaitalia_tabellone.php";
include "display_classifica_coppacoppe.php";
// include "display_classifica_supercoppa.php";
?>
</div>