<div class="stellarnav">
    <ul id="menu" class="navbar">
        <li><a href="/homepage/home.php">
        <i class="fas fa-home"></i> Home</a></li>
        <li><a href="/display_classifiche.php"><i class="fas fa-chart-line"></i> Classifiche</a></li>
        <li><a href="#"><i class="fas fa-calendar-alt"></i> Calendari</a>
            <ul>
                <li><a href="/display_calendario.php?&id_girone=1">
                    Calendario Apertura</a>
                </li>
                <li><a href="/display_calendario.php?&id_girone=2">Calendario Chiusura</a></li>
                <li><a href="/display_calendario.php?&id_girone=3">Calendario Finale</a></li>
            </ul>         
        </li>
        <li><a href="#"><i class="fas fa-users"></i> Rose</a>
            <ul>
                <li><a href="/display_rose.php" >Susy League</a></li>
                <li><a href="/display_giocatori.php">Serie A</a></li>
                <li><a href="/display_asta.php">Asta</a></li>
            </ul>         
        </li>
        <li><a href="/invio_formazione.php"><i class="fas fa-futbol"></i> Invio formazione</a></li>
        <li><a href="#"><i class="far fa-thumbs-up"></i> Social</a>
            <ul>
                <li><a href="/display_sondaggi.php">Sondaggi</a></li>
                <li><a href="/display_mercato.php">Mercato</a></li>

            </ul>         
        </li>
        <li><a href="/cambia_password.php" ><i class="fas fa-unlock-alt"></i> Password</a></li>
        <li><a href="/homepage/regolamento.pdf" ><i class="fas fa-pencil-alt"></i> Regolamento</a></li>
        <li><a href="/presidente/amministrazione.php" ><i class="fas fa-tools"></i> Amministrazione</a></li>
    </ul>
</div>
<script type="text/javascript" src="./plugin/menu/js/stellarnav.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="./plugin/menu/css/stellarnav.css">
<script type="text/javascript">
    $(document).ready(function($) {
        $('.stellarnav').stellarNav({
            theme: 'dark',
            breakpoint: 800,
            position: 'left'
            
        });
    });
</script>
