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

<!-- query per export da DB  vecchi -->
<!-- SELECT pf.id_girone, pf.id_giornata, pf.voto_casa, 
pf.voto_ospite, pf.mv_casa, pf.mv_ospite, pf.tot_casa, 
pf.tot_ospite, pf.gol_casa, pf.gol_ospite, 
sq1.squadra as sq_casa, sq2.squadra as sq_ospite
FROM `punteggio_finale` as pf
left join sq_fantacalcio as sq1 on pf.id_casa = sq1.id
left join sq_fantacalcio as sq2 on pf.id_ospite = sq2.id-->

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
			45 punti fatti da Jimmy Grimnble contro Bar Limpido alla giornata 1 dei PlayOff-PlayOut 17/18
			(Bar Limpido - Jimmy Grimble 2-0)
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
		<div class="descrizione">
			Prosut ha applicato un modificatore difesa di +6 nella partita contro Ronie Merda nella giornata 15 della Apertura 17/18
			(Prosut! - Ronie Merda 0-2)
		</div>
	</div>

	<div class="statistica">
		<div class="titolo"> Linea Maginot</div>
		<div class="descrizione">
			SS SCrotone  ha applicato un modificatore difesa di -5 nella partita contro AS Fidanken nella giornata 1 della Chiusura 17/18
			(SS Scrotone - AS Fidanken 3-0)
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
		<div class="titolo">BOMBER</div>
		<div class="descrizione">
			Il giocatore ZAPATA D. di Organizzazione Zero ha fatto registrare un fantapunteggio di 21 nella giornata 18 dell'Apertuna 18/19
		</div>
		<div class="descrizione">
			Il giocatore ICARDI di AS Valle S. Andrea ha fatto registrare un fantapunteggio di 21 nella giornata 4 e 5  della Chiusura 17/18
		</div>
		<div class="descrizione">
			Il giocatore IMMOBILE di Prosut! ha fatto registrare un fantapunteggio di 21 nella giornata 17  della Apertura 17/18
		</div>
	</div>
<!-- SELECT  g.nome, sqf.squadra, f.voto, f.id_giornata 
FROM `formazioni` as f
left join giocatori as g on f.id_giocatore = g.id
left join sq_fantacalcio as sqf on sqf.id = f.id_squadra
where g.ruolo = 'P'
order by voto desc -->
	<div class="statistica">
		<div class="titolo">Miglior Portiere</div>
		<div class="descrizione">
			Il giocatore DONNARUMMA G. di I  NANI ha fatto registrare un fantapunteggio di 11 nella giornata 2 dei PlayOffPlayOut 18/19
		</div>
		<div class="descrizione">
			Il giocatore DRAGOWSKI di BAR Fabio dal 1936 ha fatto registrare un fantapunteggio di 11 nella giornata 18 della Apertura 19/20
		</div>
	</div>
	<!-- SELECT  g.nome, sqf.squadra, f.voto, f.id_giornata 
FROM `formazioni` as f
left join giocatori as g on f.id_giocatore = g.id
left join sq_fantacalcio as sqf on sqf.id = f.id_squadra
where g.ruolo = 'D'
order by voto desc -->
	<div class="statistica">
		<div class="titolo">Miglior Difensore</div>
		<div class="descrizione">
			Il giocatore FELIPE D. di Atletico ero na volta ha fatto registrare un fantapunteggio di 14 nella giornata 11 della  Chiusura 18/19
		</div>
	</div>
		<!-- SELECT  g.nome, sqf.squadra, f.voto, f.id_giornata 
FROM `formazioni` as f
left join giocatori as g on f.id_giocatore = g.id
left join sq_fantacalcio as sqf on sqf.id = f.id_squadra
where g.ruolo = 'C'
order by voto desc -->
<div class="statistica">
		<div class="titolo">Miglior Centrocampista</div>
		<div class="descrizione">
			Il giocatore KHEDIRA di Atletico ero na volta ha fatto registrare un fantapunteggio di 17.5 nella giornata 6 dell'Apertura 17/18
		</div>
		<div class="descrizione">
			Il giocatore ILICIC di Ronie Merda ha fatto registrare un fantapunteggio di 17.5 nelle giornate 4 e 5 dell'Chiusura 17/18
		</div>
	</div>
</div>


<?php 
include("footer.php");
?> 