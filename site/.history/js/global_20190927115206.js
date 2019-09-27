var body = $("body")
$(document).on({
    ajaxStart: function() { body.addClass("loading"); alert("pippo"); },
    ajaxStop: function() {body.removeClass("loading"); }    
});