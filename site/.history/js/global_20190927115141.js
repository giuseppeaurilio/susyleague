var body = $("body")
$(document).on({
    ajaxStart: function() { alert("pippo"); body.addClass("loading");    setTimeout(function(){ }, 3000)},
    ajaxStop: function() {body.removeClass("loading"); }    
});