<footer>
<!-- webmaster webmaster@susy-league.heliohost.org -->
<span style="float:left; display: block">
    powered by: susyleague plc.
    </span>
    <span style="float:right; display: block"> web site V1.3</span>
</footer>




<div id="loginDialog" title="Login" style="display:none;">
<?php include_once "login_popup.php";?>

</div>
<div id="dialog" title="Info" style="display:none;">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>

<div class="modal"><!-- Place at bottom of page --></div> 


<?php 
if(isset($conn))
{$conn->close();}
if(isset($con))
{$con->close();}

?>

</body>
</html>