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

 let deferredPrompt;

 // Save data to sessionStorage

// Get saved data from sessionStorage

 window.addEventListener('beforeinstallprompt', (e) => {
   // Prevents the default mini-infobar or install dialog from appearing on mobile
   e.preventDefault();
   // Save the event because you'll need to trigger it later.
   deferredPrompt = e;
   // Show your customized install prompt for your PWA
   // Your own UI doesn't have to be a single element, you
   // can have buttons in different locations, or wait to prompt
   // as part of a critical journey.
   let notnow = sessionStorage.getItem("notnow");
//    console.log (notnow);
   if(notnow !== "true" )
        showInAppInstallPanel();
 });
 ///return true if the user is using an iPhone, iPad, or iPod. Otherwise, it will return false.
 function checkIOS(){
    
    console.log(navigator.userAgent);
    return [
        'iPad Simulator',
        'iPhone Simulator',
        'iPod Simulator',
        'iPad',
        'iPhone',
        'iPod'
      ].includes(navigator.platform)
      // iPad on iOS 13 detection
      || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
    };
// const checkIOS = () => {
//     debugger;
//     const ua = navigator.userAgent
//     if (/android/i.test(ua)) {
//       return "Android"
//     }
//     else if ((/iPad|iPhone|iPod/.test(ua))
//        || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1)){
//       return "iOS"
//     }
//     return "Other"
//   }

 function showInAppInstallPanel() {
    console.log(checkIOS());
    if(checkIOS()){
        $( "#installPWADialogIOS" ).dialog({
            autoOpen: true,
            show: {
                effect: "blind",
                duration: 1000
            },
            hide: {
                effect: "blind",
                duration: 1
            },
            position: 'top',
            resizable: false,
            height: "auto",
            width: "auto",
            modal: false,
        });
    }
    else{
        $( "#installPWADialog" ).dialog({
            autoOpen: true,
            show: {
                effect: "blind",
                duration: 1000
            },
            hide: {
                effect: "blind",
                duration: 1
            },
            position: 'top',
            resizable: false,
            height: "auto",
            width: "auto",
            modal: false,
            buttons: [
                {
                    text: "Installa",
                    click: async function() {
                        deferredPrompt.prompt();
                        // Find out whether the user confirmed the installation or not
                        const { outcome } = await deferredPrompt.userChoice;
                        // The deferredPrompt can only be used once.
                        deferredPrompt = null;
                        // Act on the user's choice
                        if (outcome === 'accepted') {
                            $( this ).dialog( "close" );
                        } 
                        else if (outcome === 'dismissed') {
                            console.log('User dismissed the install prompt');
                        }
                    }
                },
                {
                    text: "Magari dopo",
                    click: function() {
                        sessionStorage.setItem("notnow", "true");
                        $( this ).dialog( "close" );
                    }
                }
                ]
            
            });
    }
 }

  