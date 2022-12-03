
<?php 
include_once ("menu.php");
?>
<script>
$(document).ready(function()
{
    $("tr[contenteditable=true]").blur(function() {

		var str = $(this).attr("id");
		var arr = str.split("_");
		console.log("valore a=" + arr[0]);
		console.log("valore b=" + arr[1]);
		var id_squadra=arr[1];

		//var id_squadra = $(this).find('td:eq(0)').text();
		//var id_posizione= $(this).find('td:eq(1)').text();
		var squadra= $(this).find('td:eq(0)').text();
		var allenatore= $(this).find('td:eq(1)').text();
		var telefono=$(this).find('td:eq(2)').text(); // Task
		var email=$(this).find('td:eq(3)').text();  // Task
		var password=$(this).find('td:eq(4)').text();  // Task
		
		var query_str = "?&id_squadra=" + id_squadra +"&squadra=" + squadra + "&allenatore=" + allenatore + "&telefono=" +telefono + "&email=" + email + "&password=" + password;
// console.log(query_str);
		$.ajax({
			type: "POST",
			url: "query_update_squadre.php",
			data: query_str,
			cache: false,
			success: function(result){
				console.log(result);
			}

		});
		// setTimeout(function(){location.reload();	}, 1000);
 		
	});

});

</script>


<?php 
// $query="SELECT * FROM sq_fantacalcio";
// $result=$conn->query($query);
// $num=$result->num_rows; 
include_once ("../DB/fantacalcio.php");
$squadre = fantacalcio_getFantasquadre();
echo "<h2>Squadre</center></h2>";
?>
<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th>Squadra</th>
<th>Allenatore</th>
<th>Telefono</th>
<th>E-mail</th>
<th>password</th>
</tr>

<?php 
// $i=0;
// while ($i<12) {
	// $row=$result->fetch_assoc();
	

	// $id=$row["id"];
	// $squadra=$row["squadra"];
	// $allenatore=$row["allenatore"];
	// $telefono=$row["telefono"];
	// #$telefono=3*$i;
	// $email=$row["email"];
	// $passwor=$row["password"];



foreach($squadre as $squa)
	{
		// echo print_r($squa);
		echo "<tr height='50' id='squadra_". $squa["id"]."'  contenteditable='true' >" ;
		echo "<td >".$squa["squadra"]."</td>";
		echo "<td >".$squa["allenatore"]."</td>";
		echo "<td >".$squa["telefono"]."</td>";
		echo "<td >".$squa["email"]."</td>";
		echo "<td >".$squa["password"]."</td>";
		echo "</tr>";
}
?>

</table>;

<?php 
include_once ("../footer.php");
?>
