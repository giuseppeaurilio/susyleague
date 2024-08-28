<footer>
<!-- webmaster webmaster@susy-league.heliohost.org -->
<span style="float:left; display: block">
    powered by: susyleague plc.
    </span>
    <span style="float:right; display: block">V2.12.0</span>
   
</footer>
<button id="btnToTop" title="Torna su" class="back-to-top " style="display: none;">
  <svg
    xmlns="http://www.w3.org/2000/svg"
    class="back-to-top-icon"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
  >
    <path
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke-width="2"
      d="M7 11l5-5m0 0l5 5m-5-5v12"
    />
  </svg></button>



<div id="loginDialog" title="Login" style="display:none;">
<?php include_once "login_popup.php";?>

</div>

<div id="installPWADialog" title="Installa SusyLeague" style="display:none;">
<span> Vuoi installare l'app ufficiale della Serie A Centro Tim di Narpini NG sul tuo cellulare?</span>
</div>

<div id="installPWADialogIOS" title="Installa SusyLeague" style="display:none;">
<span>Installa questa applicazione sulla tua schermata iniziale per un accesso rapido, facile e offline quando sei in giro. Chiudi questa finestra modale, tocca l'icona "condividi", quindi tocca "Aggiungi alla schermata iniziale".</span>
</div>
<div id="cambioPasswordDialog" title="Cambio Password" style="display:none;">
<?php include_once "cambiopassword_popup.php";?>

</div>
<div id="dialog" title="Info" style="display:none;">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>

<div class="modal"><!-- Place at bottom of page --></div> 


<?php 
if(isset($conn))
{$conn->close();}
// if(isset($con))
// {$con->close();}

?>
<script>
 if (!navigator.serviceWorker.controller) {
     navigator.serviceWorker.register("/sw.js").then(function(reg) {
         console.log("Service worker has been registered for scope: " + reg.scope);
     });
 }
</script>
</body>
</html>