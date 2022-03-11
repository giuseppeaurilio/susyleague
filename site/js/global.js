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
modalPopupResultHide = function(data){
    var resp=$.parseJSON(data)
    if(resp.result == "true"){
        //do nothing
    }
    else{
        // $( "#dialog" ).dialog('destroy');
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(resp.error.msg);
        $( "#dialog" ).dialog({modal:true});
    }
}

// $(document).ready(function(){
//     $("#btnToTop").off("click").bind("click", callLogin);
//     // mybutton = document.getElementById("btnToTop");

//     // When the user scrolls down 20px from the top of the document, show the button
//     window.onscroll = function() {scrollFunction()};
    
// })
$(document).ready(function(){
    $("#btnToTop").off("click").bind("click", toTop);
    $(window).scroll(function() {
        if ($(this).scrollTop()) {
            $('#btnToTop').fadeIn("slow");
        } else {
            $('#btnToTop').fadeOut("slow");
        }
    });
    window.onscroll = function() {scrollFunction()};
})


function scrollFunction() {
  if (document.body.scrollTop > 140 || document.documentElement.scrollTop > 140) {
      $(".menu").css("position", "fixed");
      $(".menu").css("top", "0");
      $(".menu").css("width", "100%");
  } else {
        $(".menu").css("position", "");
        $(".menu").css("top", "");
        $(".menu").css("width", "");
  }
}

toTop = function(){
    // debugger;
    //1 second of animation time
    //html works for FFX but not Chrome
    //body works for Chrome but not FFX
    //This strange selector seems to work universally
    $("html, body").animate({scrollTop: 0}, 1000);
 };