<footer>
<!-- webmaster webmaster@susy-league.heliohost.org -->
<span style="float:left; display: block">
    powered by: susyleague plc.
    </span>
    <span style="float:right; display: block">V2.8.1</span>
   
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

</body>
</html>