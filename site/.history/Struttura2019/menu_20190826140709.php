<script>
  $(document).ready( function() {
    $("#menu").menu();
  } );
  </script>
  <style>
      .ui-menu { width: 150px; }
  </style>



<ul id="menu" class="navbar">
    <li><a href="/homepage/home.php">Home</a></li>
    <li><a href="/display_classifiche.php">Classifiche</a></li>
    <li><a href="#">Calendari</a>
        <ul>
            <li><a href="/display_calendario.php?&id_girone=1">Calendario Apertura</a></li>
            <li><a href="/display_calendario.php?&id_girone=2">Calendario Chiusura</a></li>
            <li><a href="/display_calendario.php?&id_girone=3">Calendario Finale</a></li>
        </ul>         
    </li>
    <li><a href="#">Rose</a>
        <ul>
            <li><a href="/display_rose.php" >Susy League</a></li>
            <li><a href="/display_giocatori.php">Serie A</a></li>
            <li><a href="/display_asta.php">Asta</a></li>
        </ul>         
    </li>
    <li><a href="/invio_formazione.php">Invio formazione</a></li>
    <li><a href="#">Social</a>
        <ul>
            <li><a href="/display_sondaggi.php">Sondaggi</a></li>
            <li><a href="/display_mercato.php">Mercato</a></li>

        </ul>         
    </li>
    <li><a href="/cambia_password.php" >Password</a></li>
    <li><a href="/homepage/regolamento.pdf" >Regolamento</a></li>
    <li><a href="/presidente/amministrazione.php" >Amministrazione</a></li>
</ul>
