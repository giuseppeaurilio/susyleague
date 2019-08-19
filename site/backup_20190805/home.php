<?php
/* Dies wird einen Fehler provozieren. Beachten Sie die vorangehende Ausgabe,
 * die vor dem Aufruf von header() erzeugt wird */
header('Location: homepage/home.php');
exit;
?>