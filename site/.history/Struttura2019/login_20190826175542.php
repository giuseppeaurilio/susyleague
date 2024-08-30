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
    include("configuration.php");
    // Create connection
    $conn = new mysqli($localhost, $username, $password,$database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "SELECT * FROM sq_fantacalcio";
    #echo $sql;
    $result=$conn->query($query);

    echo '<a href="#" id="aLogin">Login</a>';
    echo '<div id="pnlLogin" style="display: none;">';
        echo '<div >';
            echo '<span>Squadra</span><select name="squadra">'; 
            echo "<option value='0' size =30 >Presidente</option>";
            while($row = $result->fetch_assoc()) 
            {        
            // print_r($row);
            echo "<option value='".$row['id']."'>".$row['squadra']."</option>"; 
            }
            echo "</select>";
        echo '</div >';
        echo '<div >';
            echo'<span>Password: </span><input type="password" Name ="password"  value="">';
        echo '</div >';
        echo '<div >';
            echo'<input type="button" Name = "btnLogin"  value="Login">';
        echo '</div >';
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