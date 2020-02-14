
<script>
$(document).ready(function(){
    
    $(".toggle-password").off("click").bind("click", togglePassowrd);
    $("#btnSalvaPassword").off("click").bind("click", callSalvaPassword);
})

callSalvaPassword = function()
{
    var uname = '<?php 
                    if (!(isset($_SESSION['allenatore']) && $_SESSION['allenatore'] != '')) { 
                        echo $_SESSION['allenatore'];
                    }
                    ?>';
    var pwordold = $("#txtPasswordOld").val()
    var pwordnew = $("#txtPasswordNew").val()
    var pwordnewconfirm = $("#txtPasswordNewConfirm").val()
    var action ="cambiopassword";    
    var control = "";
    if(pwordnew != pwordnewconfirm)
    {
        control = "La password di conferma non corrisponde alla nuova password."
    }

    if(control != "")
    {
         // $( "#dialog" ).dialog('destroy');
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(control);
        $( "#dialog" ).dialog({modal:true});
    }
    else
    {
        // console.log(dati);
        
        $.ajax({
                type:'POST',
                url:'/cambiopassword_popup_controller.php',
                data: {
                    "squadra": uname,
                    "passwordvecchia": pwordold,
                    "passwordnuova": pwordnew,
                    "action": action
                },
                success:function(data){
                    $( "#cambioPasswordDialog" ).dialog("destroy");
                    var resp=$.parseJSON(data)
                    if(resp.result == "true"){
                    var  buttons= [
                                    {
                                    text: "Ok",
                                    // icon: "ui-icon-heart",
                                    click: function() {
                                            window.location.reload();
                                        }
                                    }
                                ]
                        // $( "#dialog" ).dialog('destroy');
                        $( "#dialog" ).prop('title', "Info");
                        $( "#dialog p" ).html("Operazione eseguita.");
                        $( "#dialog" ).dialog({modal:true, buttons: buttons});
                        // resp.result => "Login eseguito",
                    }
                    else{
                        // $( "#dialog" ).dialog('destroy');
                        $( "#dialog" ).prop('title', "ERROR");                
                        $( "#dialog p" ).html(resp.error.msg);
                        $( "#dialog" ).dialog({modal:true});
                    } 
                }
        }); 
    }
}
togglePassowrd = function() {
// alert("passa");
    // $(this).toggleClass("fa-eye fa-eye-slash");
    // var input = $($(this).attr("toggle"));
    var input = $(".password");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
}

</script>

<span>Vecchia Password:</span> <input type="password" Name ='password' id="txtPasswordOld" class="password" value="" style="width:99%">
<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
<span>Nuova Password:</span> <input type="password" Name ='password' id="txtPasswordNew" class="password" value="" style="width:99%">
<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
<span>Conferma nuova Password:</span> <input type="password" Name ='password' id="txtPasswordNewConfirm" class="password" value="" style="width:99%">
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
<div class="button" ><a href="#" id="btnSalvaPassword" class="button">Salva</a></div>