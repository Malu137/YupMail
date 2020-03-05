<?php
   if (!defined('IN_WEBADMIN'))
      exit();

?>

<form method= 'POST' action ="<?php echo $hmail_config['rooturl']; ?>index.php" onSubmit="return formCheck(this);" name= "mainform">
<?php
		PrintHiddenCsrfToken();
      	PrintHidden("page", "background_compose");

   	?>
<table width="450px">
<tr>
 <td valign="top">
  <label for="SenderEmaill">From :</label>
 </td>
 <td valign="top">
 <?php echo $_SESSION['session_username']; ?>
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="recieverEmaill">To :</label>
 </td>
 <td valign="top">
  <input  type="text" name="recieverEmail" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="subjectl">Sub : </label>
 </td>
 <td valign="top">
  <input  type="text" name="subject" maxlength="80" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="bodyl">Body :</label>
 </td>
 <td valign="top">
  <textarea  name="body" maxlength="1000" cols="25" rows="6"></textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" value="Send">   
 </td>
</tr>
</table>
</form>