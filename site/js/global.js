$(document).on({
    ajaxStart: function() { 
        $("body").addClass("loading");
    },
    ajaxStop: function() {
        $("body").removeClass("loading"); 
    }    
});

modalPopupResult = function(data){
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