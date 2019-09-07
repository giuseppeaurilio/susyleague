<?php 
include("menu.php");
?>
<h1>Carica Giocatori</h1>


<form action="upload_giocatori.php" method="post" enctype="multipart/form-data">
    Selziona File da inserire:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Carica File" name="submit">
</form>
<h2><a href="spiegazione_creazione_file_csv.pdf">File di Spiegazione</a></h2>
<p>Un esempio funzionante di file corretto puo' essere scaricato <a href="giocatori_esempio.csv">qui</a>
<p>Il file deve essere un formato .csv ovvero un file di testo i cui dati sono separati da virgole.</p>
<p>Questo file puo' essere creato da una tabella excel, salvando il file come .csv</p>
<p>Nel file ci devono essere 4 colonne:Id,R,Nome,Squadra</p>
<p>Id=numero intero univoco assegnato al giocatore da Fantagazzetta</p>
<p>R=ruolo. Puo' assumere i valori P,D,C,A per indicare Portiere,Difensore,Centrocampista e Attaccante rispettivamente.</p>
<p>Nome=Nome del giocatore.</p>
<p>Squadra=Nome della squadra di serie A di appartenenza del Giocatore. Si verifichi che non ci siano errori nella digitazione del nome delle squadre e ce ogni squadra compaia sempre con la stessa denominazione.</p>
<p>Esempio di formato valido del file e':"</p>

<p>Id,R,Nome,Squadra</p>
<p>408,A,HIGUAIN,Juventus</p>
<p>441,A,BELOTTI,Torino</p>
<p>277,A,ICARDI,Inter</p>
<p>410,A,MERTENS,Napoli</p>
<p>647,A,DZEKO,Roma</p>
<p>409,A,INSIGNE,Napoli</p>
<p>785,A,IMMOBILE,Lazio</p>
<p>309,A,DYBALA,Juventus</p>

<p>Un esempio funzionante di file corretto puo' essere scaricato <a href="giocatori_esempio.csv">qui</a>

</p>
<br>
    
<?php 
include("../footer.php");
?>