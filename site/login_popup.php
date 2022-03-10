<script>
$(document).ready(function(){
    $("#btnLogin").off("click").bind("click", callLogin);
    $("#loginDialog .toggle-password").off("click").bind("click", togglePassword);
})

callLogin = function()
{
    $(" #loginDialog #result").hide();
    var uname = $("#ddlSquadra option:selected").val()
    var pword = $("#txtPassword").val()
    var action ="login";    
    // console.log(dati);
    $.ajax({
            type:'POST',
            url:'/login_popup_controller.php',
            data: {
                "squadra": uname,
                "password": pword,
                "action": action
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                if(resp.result == "true"){
                    // alert(resp.message);
                    setTimeout(function(){location.reload(true);},10);
                }
                else{
                    // alert(resp.error.msg);
                    $(" #loginDialog #result").show();
                    $(" #loginDialog #result .message").html(resp.error.msg)
                }
                
                
            }
    }); 
}
togglePassword = function() {
// alert("passa");
    // $(this).toggleClass("fa-eye fa-eye-slash");
    // var input = $($(this).attr("toggle"));
    var input = $("#txtPassword");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
}

</script>
<span>Squadra:	</span>
<?php
include_once ("dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM sq_fantacalcio";
#echo $sql;
$result=$conn->query($query);

$num=$result->num_rows; 
#print_r($result);
#echo "num=" . $num;
echo '<select id="ddlSquadra" name="squadra" style="width:101%">'; 
echo "<option value='0' size =30 >Presidente</option>";
while($row = $result->fetch_assoc()) 
{        
// print_r($row);
echo "<option value='".$row['id']."'>".$row['squadra']."</option>"; 
}
echo "</select>";


?>
<span>Password:</span> <input type="password" Name ='password' id="txtPassword" value="" style="width:98%">
<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
<!-- style="display:none" -->
<!-- <div id="result" class="result" style="display:none;"></div> -->
<div class="ui-widget" id="result" style="display:none;">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
        <p>
            <span class="ui-icon ui-icon-alert" 
                style="float: left; margin-right: .3em;"></span>
            <span class="message"> Sample ui-state-error style.</span>
        </p>
    </div>
</div>
<div class="button" ><a href="#" id="btnLogin" class="button">Login</a></div>