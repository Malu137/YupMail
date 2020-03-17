<?php
   if (!defined('IN_WEBADMIN'))
      exit();

?>
   
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>YupMail</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="style_login.css">

</head>
<body>
<section class="container">
		    <article class="half">
			        <h1>YupMail</h1>
			        <div class="tabs">
					<span class="tab signin "><a href="http://localhost/YupMail/">Sign in</a></span>
					<span class="tab signup active"><a href="http://localhost/YupMailSignUP/">Sign up</a></span>
					</div>
					<div class="content">
                 	<div class="signin-cont cont">
   					<form action="<?php echo $hmail_config['rooturl']; ?>index.php" method="post" onSubmit="return formCheck(this);" name="mainform">
      				<?php
	     				PrintHiddenCsrfToken();
           				PrintHidden("page", "background_register");
      				?>
      
            		<?php
            	   		$error = hmailGetVar("status");
				   
				   //echo  hmailGetVar("user");
				   //echo hmailGetVar(track);
				   
            	   if ($error == "1")
				   { ?>
				    	<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
						Server currently unavailable. Try again later.
                        </div>
				    <?php
            	   }
				   else if ($error =='2')
				   { ?>
				   		<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
						Account already exist. Try with different username.
                        </div>
				    <?php
				   }				   
				   else if ($error =='3')
				   {
					?>
					<div class="alertg">
				    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
					Account Created.
				 	</div>
			 		<?php
				   }
				   else if ($error =='4')
				   {
					?>
					<div class="alert">
				    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
					Invalid user name or password.
				 	</div>
			 		<?php
				   }				   
				 
				?>
				
				<p style = "font-size:14px;">
            	<?php EchoTranslation("Your Prefered Email")?>
            	<input type="text" name="username" size="25" maxlength="256" class="inpt" /> 
				<?php EchoTranslation("@yup.mail")?><br/>
				</p>
				<p style = "font-size:14px;">
            	<?php EchoTranslation("Password")?>:<br/>
            	<input type="password" name="password" size="25" maxlength="256" autocomplete="off" class = "inpt" /><br/>
				</p>
				<div class="submit-wrap">
            	<input type="submit" value="<?php EchoTranslation("Create")?>" class = "submit"/>
				</div>
				  
   				</form>
   </div>
                 </div>
          </article>
          <div class="half bg" style="background-color: black;text-align:center;"><img src ="images\YupMailLogo.png" >
         <p style="color:aliceblue;"> Your secure Mail</br>[need to edit] </p></div>
</section>
   
   <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="function_login.js"></script>

</body>
</html>
