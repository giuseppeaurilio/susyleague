<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
    $allenatore="";
}
else { 
    $allenatore= $_SESSION['allenatore'];
}
?>
<div>
<?php
if (!(isset($allenatore) && $allenatore != '')) {
    echo '<a href="#" >Login</a>';
    echo '<div id="pnlLogin">';

    echo '</div>';
}
else { 
    echo 'Benvenuto ' . $allenatore . ',<a class="login" href="/logout.php" >Logout</a>';
    // <li><a href="/cambia_password.php" ><i class="fas fa-unlock-alt"></i> Password</a></li>
}
?>
</div>