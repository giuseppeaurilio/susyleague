<?php 
session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	$id_squadra_logged="";
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
}
include("menu.php");

?>
<h2>SusyLeague - Statistiche e curiosità</h2>
<div class="record">
	<!-- SELECT c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti, c.md_casa, c.md_ospite, GREATEST(c.punti_casa, c.punti_ospiti) as md, c.id_giornata, g.id_girone, sqf.squadra as casa, sqf2.squadra as ospite
FROM `calendario` as c
left join sq_fantacalcio as sqf on c.id_sq_casa = sqf.id
left join sq_fantacalcio as sqf2 on c.id_sq_ospite = sqf2.id
left join giornate as g on g.id_giornata = c.id_giornata
order by  md desc -->
	<div class="statistica">
		<div class="titolo"> punteggio più alto di squadra</div>
		<div class="descrizione">
			90 punti fatti da Bar Fabio dal 1936 contro Bono Coppi alla giornata 77 della Coppa Coppe 19/20
			(Bono Coppi - Bar Fabio dal 1936 6-0)
		</div>
	</div>

	<!-- SELECT c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti, c.md_casa, c.md_ospite, GREATEST(-1*c.punti_casa, -1*c.punti_ospiti) as md, c.id_giornata, g.id_girone, sqf.squadra as casa, sqf2.squadra as ospite
FROM `calendario` as c
left join sq_fantacalcio as sqf on c.id_sq_casa = sqf.id
left join sq_fantacalcio as sqf2 on c.id_sq_ospite = sqf2.id
left join giornate as g on g.id_giornata = c.id_giornata
order by  md desc -->
<div class="statistica">
		<div class="titolo"> punteggio più basso di squadra</div>
		<div class="descrizione">
			50 punti fatti da Rodrigo Becao contro Bar Fabio dal 1936 alla giornata 12 della Apertura 19/20
			(Bono Coppi - Bar Fabio dal 1936 6-0)
		</div>
	</div>

	<!-- SELECT c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti, c.md_casa, c.md_ospite, c.gol_casa +c.gol_ospiti as md, c.id_giornata, g.id_girone, sqf.squadra as casa, sqf2.squadra as ospite
FROM `calendario` as c
left join sq_fantacalcio as sqf on c.id_sq_casa = sqf.id
left join sq_fantacalcio as sqf2 on c.id_sq_ospite = sqf2.id
left join giornate as g on g.id_giornata = c.id_giornata
order by  md desc -->
	<div class="statistica">
		<div class="titolo"> partita con più gol</div>
		<div class="descrizione">
			5 a 5 Bono Coppi contro I NANI dal 1936 alla giornata 5 della Chiusura 19/20
			(Bono Coppi - I NANI 5-5)
		</div>
	</div>

	<!-- SELECT c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti, c.md_casa, c.md_ospite, GREATEST(c.md_casa, c.md_ospite) as md, c.id_giornata, g.id_girone, sqf.squadra as casa, sqf2.squadra as ospite
	FROM `calendario` as c
	left join sq_fantacalcio as sqf on c.id_sq_casa = sqf.id
	left join sq_fantacalcio as sqf2 on c.id_sq_ospite = sqf2.id
	left join giornate as g on g.id_giornata = c.id_giornata
	order by  md desc -->
	<div class="statistica">
		<div class="titolo"> Colabrodo</div>
		<div class="descrizione">
			Ronei Merda ha applicato un modificatore difesa di +6 nella partita contro Panchester United nellagiornata 3 della Chiusura 19/20
			(Panchester United - RonieMerda 0-1)
		</div>
	</div>
	<!-- SELECT c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti, c.md_casa, c.md_ospite,GREATEST(c.gol_casa, c.gol_ospiti) as md, c.id_giornata, g.id_girone, sqf.squadra as casa, sqf2.squadra as ospite
FROM `calendario` as c
left join sq_fantacalcio as sqf on c.id_sq_casa = sqf.id
left join sq_fantacalcio as sqf2 on c.id_sq_ospite = sqf2.id
left join giornate as g on g.id_giornata = c.id_giornata
order by  md desc -->
	<div class="statistica">
		<div class="titolo">Maggior numero di gol segnati</div>
		<div class="descrizione">
			Bar Fabio dal 1936 ha segnato 6 gol contro Bono Coppi nella gioranta 77 del 19/20
			(Bono Coppi - Bar Fabio dal 1936 0-6)
		</div>
	</div>

	<!-- SELECT f.*, sqf.squadra, g.nome
FROM `formazioni` as f
left join rose as r on r.id_giocatore = f.id_giocatore
left join sq_fantacalcio as sqf on sqf.id = r.id_sq_fc
left join giocatori as g on g.id = f.id_giocatore
order by voto desc -->
	<div class="statistica">
		<div class="titolo">Fuoriclasse</div>
		<div class="descrizione">
			Il giocatore Cristiano Ronaldo di Bono Coppi ha fatto registrare un fantapunteggio di 18.5 nella giornata 15 del 19/20
		</div>
		<div class="descrizione">
			Il giocatore Cristiano Ronaldo di Bono Coppi ha fatto registrare un fantapunteggio di 18.5 nella giornata 58 del 19/20
		</div>
		<div class="descrizione">
			Il giocatore Cornelius di Salsino è bello ha fatto registrare un fantapunteggio di 18.5 nella giornata 24 del 19/20
		</div>
	</div>
</div>


<?php 
include("footer.php");
?> 