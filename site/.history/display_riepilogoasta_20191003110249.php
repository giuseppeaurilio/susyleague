<?php 
include("menu.php");

?>

<h2>Riepilogo ASTA</h2>


<?php 
//load squadre fantacalcio
$query="SELECT * FROM sq_fantacalcio order by squadra";

$result=$conn->query($query);
$squadre = array();
while($row = $result->fetch_assoc()){
    // $id=mysql_result($result,$i,"id");
    $id=$row["id"];
    $squadra=$row["squadra"];
    array_push($squadre, array(
        "id"=>$id,
        "squadra"=>$squadra
        )
    );
}
?>
<?php
 foreach($squadre as $squadra)
 {
    $queryriepilogo='CALL getRiepilogoRosa('.$squadra["id"].')';
    $resultriepilogo = $conn->query($queryriepilogo) or die($conn->error);
    $arrayriepilogo = array();
    while ($row = $resultriepilogo->fetch_assoc()) {
    }
    echo $squadra["squadra"];
    echo '<br>';
    print_r($resultriepilogo);
    echo '<br>';
    $conn->next_result();
 }
?>

<?php 
include("footer.php");
?>
