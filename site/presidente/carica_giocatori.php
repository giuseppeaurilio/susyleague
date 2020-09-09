<?php 
include("menu.php");
?>
<h2>Carica Giocatori</h2>
<div class="">
    <span>
        In questa pagina è possibile caricare e aggiornare le rose delle squadre di serie A.
        <br>
        Il file deve essere un formato .csv ovvero un file di testo i cui dati sono separati da virgole.<br>
        Nel file ci devono essere 4 colonne:Id,R,Nome,Squadra
        <ol>
            <li>Id=numero intero univoco assegnato al giocatore da Fantagazzetta</li>
            <li>R=ruolo. Puo' assumere i valori P,D,C,A per indicare Portiere,Difensore,Centrocampista e Attaccante rispettivamente</li>
            <li>Nome=Nome del giocatore</li>
            <li>Squadra=Nome della squadra di serie A di appartenenza del Giocatore. Si verifichi che non ci siano errori nella digitazione del nome delle squadre e ce ogni squadra compaia sempre con la stessa denominazione</li>
        </ol>
        Ad esempio:<br>
        <span >
        Id,R,Nome,Squadra<br>
        408,A,HIGUAIN,Juventu0<br>
        441,A,BELOTTI,Torino<br></span>
        Un esempio funzionante di file corretto puo' essere scaricato <a href="giocatori_esempio.csv">qui</a><br>
        <hr> 
        Spuntando la casella <strong>"Primo caricamento"</strong>, vengono importate tutte le squadre e i giocatori presenti nel file. Squadre o giocatori gia nel sistema vengono <strong>CANCELLATI</strong><br>
        Se invece si effettua un import del file senza aver selezionato "Primo Caricamento", viene fatto un update di giocatori: i gicoatori che hanno cambiato squadra sono aggiornati; i giocatori non presenti vengono importati.
</span>
</div>
<hr>
<form action="upload_giocatori.php" method="post" enctype="multipart/form-data">
    <span>Primo caricamento</span><input type="checkbox" name="cbCancella" value="si"></input>
    <br>
    Selziona File da inserire:
    <input type="file" name="fileToUpload" >

    <input type="submit" value="Carica File" name="submit">
</form>
<hr>
<!-- <a href="spiegazione_creazione_file_csv.pdf">File di Spiegazione</a>     -->
<?php 
include("../footer.php");
?>