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
<h2>Statistiche e curiosità</h2>
<div class="record">
	<!-- SELECT c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti, c.md_casa, c.md_ospite, GREATEST(c.punti_casa, c.punti_ospiti) as md, c.id_giornata, g.id_girone, sqf.squadra as casa, sqf2.squadra as ospite
FROM `calendario` as c
left join sq_fantacalcio as sqf on c.id_sq_casa = sqf.id
left join sq_fantacalcio as sqf2 on c.id_sq_ospite = sqf2.id
left join giornate as g on g.id_giornata = c.id_giornata
order by  md desc -->
	<div class="statistica">
		<div class="titolo"> Punteggio più alto di squadra</div>
		<div class="descrizione">
			91 punti fatti da I NANI contro Atletico ero na volta alla giornata 18 della Apertura 18/19
			(I NANI - Atletico ero na volta 7-2)
		</div>
	</div>

	<!-- SELECT c.punti_casa, c.punti_ospiti, c.gol_casa, c.gol_ospiti, c.md_casa, c.md_ospite, GREATEST(-1*c.punti_casa, -1*c.punti_ospiti) as md, c.id_giornata, g.id_girone, sqf.squadra as casa, sqf2.squadra as ospite
FROM `calendario` as c
left join sq_fantacalcio as sqf on c.id_sq_casa = sqf.id
left join sq_fantacalcio as sqf2 on c.id_sq_ospite = sqf2.id
left join giornate as g on g.id_giornata = c.id_giornata
order by  md desc -->
<div class="statistica">
		<div class="titolo"> Punteggio più basso di squadra</div>
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
		<div class="titolo"> Partita con più gol</div>
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
			Ronni Merda ha applicato un modificatore difesa di +6 nella partita contro Panchester United nella giornata 3 della Chiusura 19/20
			(Panchester United - RonieMerda 0-1)
		</div>
		<div class="descrizione">
			Azienda PAAM ha applicato un modificatore difesa di +6 nella partita contro I NANI nella giornata 14 della Apertura 18/19
			(Azienda PAAM - I NANI 0-2)
		</div>
	</div>

	<div class="statistica">
		<div class="titolo"> Linea Maginot</div>
		<div class="descrizione">
			Ronni Merda ha applicato un modificatore difesa di -4 nella partita contro Azienda PAAM nella giornata 6 della Chiusura 18/19
			(Ronni Merda - Azienda PAAM 4-1)
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
			I NANI ha segnato 7 gol contro Atletico ero na volta alla giornata 18 della Apertura 18/19
			(I NANI - Atletico ero na volta 7-2)
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
			Il giocatore Zapata D. di Organizzazione Zero ha fatto registrare un fantapunteggio di 21 nella giornata 18 dell'Apertuna nel campionato 18/19
		</div>
		<!-- <div class="descrizione">
			Il giocatore Cristiano Ronaldo di Bono Coppi ha fatto registrare un fantapunteggio di 18.5 nella giornata 15 del 19/20
		</div>
		<div class="descrizione">
			Il giocatore Cristiano Ronaldo di Bono Coppi ha fatto registrare un fantapunteggio di 18.5 nella giornata 58 del 19/20
		</div>
		<div class="descrizione">
			Il giocatore Cornelius di Salsino è bello ha fatto registrare un fantapunteggio di 18.5 nella giornata 24 del 19/20
		</div> -->
	</div>
</div>


<?php 
include("footer.php");
?> 