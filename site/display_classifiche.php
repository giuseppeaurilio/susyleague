<?php
include_once("menu.php");

?>

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
$(document).ready(function(){
    $( "#tabs" ).tabs(

        {
            // collapsible: true
        }
    );
});
</script>

<div id="tabs">
<ul >
    <li><a href="#tabs-1">Apertura </a></li>
    <li><a href="#tabs-2">Chiusura </a></li>
    <li><a href="#tabs-3">Aggregate </a></li>
    <!-- <li><a href="#tabs-4">FINALE</a></li> -->
    <li><a href="#tabs-5">Coppa Italia - Gironi</a></li>
    <!-- <li><a href="#tabs-6">Coppa Italia - Tabellone</a></li> -->
    <li><a href="#tabs-7">Coppa delle coppe</a></li>
    <!-- <li><a href="#tabs-8">Supercoppa</a></li> -->

</ul>
<?php
include_once( "display_classifica_apertura.php");
include_once( "display_classifica_chiusura.php");
include_once( "display_classifica_aggregate.php");
// include_once( "display_classifica_finale.php");
include_once( "display_classifica_coppaitalia_gironi.php");
// include_once( "display_classifica_coppaitalia_tabellone.php");
include_once( "display_classifica_coppacoppe.php");
// include_once( "display_classifica_supercoppa.php");
?>
</div>

<?php 
include_once ("footer.php");
?>
