<?php 
include_once ("menu.php");
?>
<h2>Carica Giocatori</h2>
<div class="">
    <span>
        In questa pagina è possibile caricare e aggiornare le rose delle squadre di serie A.
        <br>
        Il file deve essere un formato .csv ovvero un file di testo i cui dati sono separati da punto-e-virgola.<br>
        Nel file ci devono essere 4 colonne:Id;R;Nome;Squadra
        <ol>
            <li>Id=numero intero univoco assegnato al giocatore da Fantagazzetta</li>
            <li>R=ruolo. Puo' assumere i valori P,D,C,A per indicare Portiere,Difensore,Centrocampista e Attaccante rispettivamente</li>
            <li>Nome=Nome del giocatore</li>
            <li>Squadra=Nome della squadra di serie A di appartenenza del Giocatore. Si verifichi che non ci siano errori nella digitazione del nome delle squadre e ce ogni squadra compaia sempre con la stessa denominazione</li>
        </ol>
        Ad esempio:<br>
        <span >
        Id;R;Nome;Squadra;Quotazioen<br>
        408;A;HIGUAIN;Juventus; 10<br>
        441;A;BELOTTI;Torino; 9<br></span>
        Un esempio funzionante di file corretto puo' essere scaricato <a href="giocatori_esempio.csv">qui</a><br>
        <hr> 
        </span>
</div>
<hr>
<h2>Data base giocatori</h2>
<h3>Giocatori Serie A</h3>
<form action="upload_giocatori.php" method="post" enctype="multipart/form-data">
    <i>Attenzione, Selezionando questo check box, il database verra creato da zero. Se invece non è selezionato, verranno inseriti i nuovi giocatori, e modificata la squadra di Serie A di quelli esistenti.<i>
    <br>
    <span>Primo caricamento</span><input type="checkbox" name="cbCancella" value="si"></input>
    
    Selziona File da inserire:
    <input type="file" name="fileToUpload" >

    <input type="submit" value="Carica File" name="submit">
</form>
<h3>Giocatori Svincolati</h3>
<form action="upload_giocatori_svincolati.php" method="post" enctype="multipart/form-data">
    <i>Attenzione, i giocatori definiti nel file verranno inseriti nella squadra ZVincolati<i><br>
    Selziona File da inserire:
    <input type="file" name="fileToUpload" >

    <input type="submit" value="Carica File" name="submit">
</form>
<hr>
<!-- <h2>Statistiche giocatori</h2>
<form action="upload_statistiche.php" method="post" enctype="multipart/form-data">
    <select name="AnnoStats" id="AnnoStats">
        <option value="">--anno--</option>	
        <option value="22/23">22/23</option>
        <option value="21/22">21/22</option>
        <option value="20/21">20/21</option>
        <option value="19/20">19/20</option>
        <option value="18/19">18/19</option>
        <option value="17/18">17/18</option>
        <option value="16/17">16/17</option>
        <option value="15/16">15/16</option>
    </select>
    <br>
    Selziona File da inserire:
    <input type="file" name="fileToUploadStats" >
    <input type="submit" value="Carica File" name="submitStats">
</form>
<hr> -->
<h2>PINFO</h2>
<form action="upload_pinfo.php" method="post" enctype="multipart/form-data">
    Selziona File da inserire:
    <input type="file" name="fileToUploadPInfo" >
    <input type="submit" value="Carica File" name="submitPInfo">
</form>
<!-- <a href="spiegazione_creazione_file_csv.pdf">File di Spiegazione</a>     -->
<?php 
include_once ("../footer.php");
?>