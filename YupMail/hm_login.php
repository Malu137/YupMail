<?php
   if (!defined('IN_WEBADMIN'))
      exit();

?>
   <br/>
   <br/>
   <form action="<?php echo $hmail_config['rooturl']; ?>index.php" method="post" onSubmit="return formCheck(this);" name="mainform">
   
      <?php
	     PrintHiddenCsrfToken();
           PrintHidden("page", "background_login");
      ?>

      <br/><br/>
      <div align="center">
        <!-- <img src="images/hm_logotype.jpg" border="0" align="middle" alt="">  -->
      </div>
      
      <table width="250" align="center">
         <tr>
            <td>

            	<br/><br/>
            	<?php
            	   $error = hmailGetVar("error");
            	   if ($error == "1")
            	   {
            	      EchoTranslation("Incorrect username or password.");
                     echo "<br/><br/>";  
            	   }
            	?>
               
            	<?php EchoTranslation("User Name")?>:<br/>
            	<input type="text" name="username" size="25" maxlength="256" />
				<?php echo("@yup.mail") ?>
				<br/>
		<br/>
            	<?php EchoTranslation("Password")?>:<br/>
            	<input type="password" name="password" size="25" maxlength="256" autocomplete="off" /><br/>
            	<br/>
            	<input type="submit" value="<?php EchoTranslation("OK")?>" />
            </td>
         </tr>
      </table>
   
   </form>
   <a href="http://localhost/YupMailSignUP/"> Register Page </a>
   
   <script type="text/javascript">
      document.mainform.username.focus();
   </script>
