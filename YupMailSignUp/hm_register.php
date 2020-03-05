<?php
   if (!defined('IN_WEBADMIN'))
      exit();

?>
   <br/>
   <br/>
   <form action="<?php echo $hmail_config['rooturl']; ?>index.php" method="post" onSubmit="return formCheck(this);" name="mainform">
   
      <?php
	     PrintHiddenCsrfToken();
           PrintHidden("page", "background_register");
      ?>

      <br/><br/>
      <div align="center">
         <img src="images/hm_logotype.jpg" border="0" align="middle" alt="">  
      </div>
      
      <table width="250" align="center">
         <tr>
            <td>

            	<br/><br/>
            	<?php
            	   $error = hmailGetVar("status");
				   
				   //echo  hmailGetVar("user");
				   //echo hmailGetVar(track);
				   
            	   if ($error == "1")
            	   {
						EchoTranslation("Server currently unavailable. Try again later.");
						echo "<br/><br/>";  
            	   }
				   else if ($error =='2')
				   {
						EchoTranslation("Account already exist. Try with different username.");
						echo "<br/><br/>";  
				   }				   
				   else if ($error =='3')
				   {
						EchoTranslation("Account Created.");
						echo "<br/><br/>";  
				   }
				   else if ($error =='4')
				   {
						EchoTranslation("Invalid user name or password.");
						echo "<br/><br/>";  
				   }				   
				 
            	?>
               
            	<?php EchoTranslation("Your Prefered Email")?>:<br/>
            	<input type="text" name="username" size="25" maxlength="256" /> 
				<?php EchoTranslation("@yup.mail")?><br/>
		<br/>
            	<?php EchoTranslation("Password")?>:<br/>
            	<input type="password" name="password" size="25" maxlength="256" autocomplete="off" /><br/>
            	<br/>
            	<input type="submit" value="<?php EchoTranslation("Create")?>" />
            </td>
         </tr>
      </table>
   
   </form>
   <a href="http://localhost/YupMail/"> Login </a>
   <script type="text/javascript">
      document.mainform.username.focus();
   </script>
