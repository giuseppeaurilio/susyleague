var body = $("body")
$(document).on({
    ajaxStart: function() { 
        // $loading.show();
        $("body").addClass("loading");
    },
    ajaxStop: function() {
        // body.removeClass("loading"); 
    }    
});