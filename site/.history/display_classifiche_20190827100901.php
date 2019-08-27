<?php
include "menu.php";

?>
<link href="style.css" rel="stylesheet" type="text/css">

<style>
body{
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
table{
	border-collapse: collapse;
	width: 100%;
}
table th, table td{
	border: 1px solid #ddd;
	padding: 8px;
	}
table tr:nth-child(even){
	background-color: #f2f2f2;
	}
table tr:hover {
	background-color: #ddd;
	}
table th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: left;
	background-color: #4CAF50;
	color: white;
}
</style>



<?php
include "dbinfo_susyleague.inc.php";
#echo $username;
// Create connection
$conn = new mysqli($localhost, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

$query = "SELECT * from gironi";

$result_girone = $conn->query($query);
$num_gironi = $result_girone->num_rows;
//echo $num_gironi;
$num_gironi = 2;
$j = 0;

while ($row = $result_girone->fetch_assoc() and $j < $num_gironi) {
    $id_girone = $row["id_girone"];
    $nome_girone = $row["nome"];

    ?>

	<h1>Classifiche Girone <?php echo $nome_girone ?> </h1>

	<h2>Classifica Punti</h2>
	<table >
	<tr>

	<th>Squadra</th>
	<th>Punti</th>
	<th>Voti</th>
	<th>V</th>
	<th>N</th>
	<th>P</th>
	<th>GF</th>
	<th>GS</th>

	</tr>


	<?php

    $query = "SELECT * from classifiche where id_girone=" . $id_girone . " order BY punti DESC,voti DESC, squadra ";
    $result = $conn->query($query);
    $num = $result->num_rows;
    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $id_squadra = $row["id_squadra"];
        $squadra = $row["squadra"];
        $punti = $row["punti"];
        $voto = $row["voti"];
        $gol_fatti = $row["gol_fatti"];
        $gol_subiti = $row["gol_subiti"];
        $vittorie = $row["vittorie"];
        $pareggi = $row["pareggi"];
        $sconfitte = $row["sconfitte"];

        ?>
		<td><?php echo "$squadra"; ?></td>
		<td><?php echo "$punti"; ?></td>
		<td><?php echo "$voto"; ?></td>
		<td><?php echo "$vittorie"; ?></td>
		<td><?php echo "$pareggi"; ?></td>
		<td><?php echo "$sconfitte"; ?></td>
		<td><?php echo "$gol_fatti"; ?></td>
		<td><?php echo "$gol_subiti"; ?></td>
		</tr>

		<?php

        ++$i;

    }
    ;

    ?>
</table>


<h2>Classifica Marcatori</h2>
<table>
<tr>

<th>Squadra</th>
<th>Voti</th>
<th>Punti</th>
<th>V</th>
<th>N</th>
<th>P</th>
<th>GF</th>
<th>GS</th>

</tr>


<?php

    $query = " SELECT * from classifiche where id_girone=" . $id_girone . " ORDER BY voti DESC,punti DESC,squadra";

    $result = $conn->query($query);

    $num = $result->num_rows;

    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $id_squadra = $row["id_squadra"];
        $squadra = $row["squadra"];
        $voto = $row["voti"];
        $punti = $row["punti"];
        $gol_fatti = $row["gol_fatti"];
        $gol_subiti = $row["gol_subiti"];
        $vittorie = $row["vittorie"];
        $pareggi = $row["pareggi"];
        $sconfitte = $row["sconfitte"];

        ?>
<td><?php echo "$squadra"; ?></td>
<td><?php echo "$voto"; ?></td>
<td><?php echo "$punti"; ?></td>

<td><?php echo "$vittorie"; ?></td>
<td><?php echo "$pareggi"; ?></td>
<td><?php echo "$sconfitte"; ?></td>
<td><?php echo "$gol_fatti"; ?></td>
<td><?php echo "$gol_subiti"; ?></td>
</tr>

<?php

        ++$i;

    }
    ;

    ?>
</table>

<?php
++$j;

}
;

?>

<!--   CLASSIFICA SOMMA  -->
<h1>Classifiche Aggregate </h1>
<table>
<tr>

<th>Squadra</th>
<th>Punti</th>
<th>Voti</th>

<th>V</th>
<th>N</th>
<th>P</th>
<th>GF</th>
<th>GS</th>

</tr>

<?php

$query = "SELECT id_squadra,squadra,sum(voti) as voti ,sum(punti) as punti, sum(gol_fatti) as gol_fatti, sum(gol_subiti) as gol_subiti, sum(vittorie) as vittorie, 
sum(pareggi) as pareggi, sum(sconfitte) as sconfitte 
from classifiche where (id_girone=1) or (id_girone=2) 
group by id_squadra 
ORDER BY punti DESC,voti DESC,squadra";

$result = $conn->query($query);

$num = $result->num_rows;
#echo $num;
$i = 0;

while ($row = $result->fetch_assoc()) {

    $id_squadra = $row["id_squadra"];
    $squadra = $row["squadra"];
    $voto = $row["voti"];
    $punti = $row["punti"];
    $gol_fatti = $row["gol_fatti"];
    $gol_subiti = $row["gol_subiti"];
    $vittorie = $row["vittorie"];
    $pareggi = $row["pareggi"];
    $sconfitte = $row["sconfitte"];

    ?>
<td><?php echo "$squadra"; ?></td>
<td><?php echo "$punti"; ?></td>
<td><?php echo "$voto"; ?></td>


<td><?php echo "$vittorie"; ?></td>
<td><?php echo "$pareggi"; ?></td>
<td><?php echo "$sconfitte"; ?></td>
<td><?php echo "$gol_fatti"; ?></td>
<td><?php echo "$gol_subiti"; ?></td>
</tr>

<?php

    ++$i;

}
;
$conn-close();
?>
</table>

</body>
</html>
