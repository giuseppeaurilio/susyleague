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
	echo '<a href="/login.php" >Login</a>';
}
else { 
	echo 'Benvenuto ' . $allenatore . ',<a class="login" href="/logout.php" >Logout</a>';
}
?>
</div>