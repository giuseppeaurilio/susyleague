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
    echo '<a href="#" id="aLogin">Login</a>';
    echo '<div id="pnlLogin"> &nbsp;';

    echo '</div>';
}
else { 
    echo 'Benvenuto ' . $allenatore . ',<a class="login" href="/logout.php" >Logout</a>';
    // <li><a href="/cambia_password.php" ><i class="fas fa-unlock-alt"></i> Password</a></li>
}
?>
</div>
<script>
    $(document).ready(function(){
        $("#aLogin").off("click").bind("click", function(){$("#pnlLogin").toggle();});
    });
</script>