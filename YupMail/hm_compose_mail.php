<!DOCTYPE html>

<?php
   if (!defined('IN_WEBADMIN'))
	  exit();
	  
	$action =hmailGetVar("action","");
	$MsgUID=hmailGetVar("uid","");
	$MailFolderName = hmailGetVar("imapfolderName","");
	$mailbox = '{imap.yup.mail:143/imap}'.$MailFolderName;
	$sendersAddress = $_SESSION['session_username'];
	$password = $_SESSION['session_password'];
	$alert =hmailGetVar("alert"," ")

?>


	

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style_composemail.css">

	<style>
        .alerto {
  padding: 10px;
  background-color: #f5a31a;
  color: white;
  margin-bottom: 15px;
  width:40%;
}

/* The close button */
.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

/* When moving the mouse over the close button */
.closebtn:hover {
  color: black;
}
        </style>
        

<?php
if ($alert=='1')
{?>
	<div class="alerto">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  Please Enter a Valid Details.
</div>
<?php	
}

if($action=="")
	

{
?>
<div class="compose-mail">

	<h3 style="color: #000; margin: 10px;">Compose Email</h3>

    <form method= 'POST' action ="<?php echo $hmail_config['rooturl']; ?>index.php" onSubmit="return formCheck(this);" name= "mainform">
    <?php
		PrintHiddenCsrfToken();
      	PrintHidden("page", "background_compose_smtp");

   	?>

	<p style="margin-top: 30px; margin-left: 10px; font-size: 20px;">To : </p>

	<input type="Email" name="recieverEmail" class="input-email" placeholder="Enter Receipant's Email">

	<p style="margin-top: 15px; margin-left: 10px;font-size: 20px;">Subject : </p>

	<input type="text" name="subject" class="input-email" placeholder="Write Subject">

	<p style="margin-top: 15px; margin-left: 10px;font-size: 20px;">Message: </p>

	<textarea name = "body" rows="8" cols="128" style="border: 1px solid; border-color: grey; border-top: 1px solid; margin-left: 10px; margin-bottom: 20px;"></textarea>



	<div style="margin : auto; width: 50%; text-align: center;">

		<input class="square_btn" type="submit"  name="buttonVal" value="Save as Draft" ></button>

		<input class="square_btn" type="submit" name="buttonVal"  name="Button" value="Send"></button>

	</div>

	</form>

	



	

	

</div>

<?php }
elseif($action=="reply") {
	$connection = imap_open($mailbox, $sendersAddress, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
	$mailbody = imap_fetchbody($connection,$MsgUID,1,CP_UID);
    $mailhead = imap_fetch_overview($connection,$MsgUID,FT_UID);
	imap_close($connection);
	$replysub = "REPLY :".$mailhead[0]->subject;
	$replyfrom = $mailhead[0]->from;
	$replysubject =$mailhead[0]->subject;
	$replyto = $mailhead[0]->to;
	$replybody=$mailbody;
	$receiverAddress = $mailhead[0]->from;

	//var_dump($replybody);
	//var_dump($replysub);
	?>


	<div class="compose-mail">

	<h3 style="color: #000; margin: 10px;">Compose Email</h3>

    <form method= 'POST' action ="<?php echo $hmail_config['rooturl']; ?>index.php" onSubmit="return formCheck(this);" name= "mainform">
    <?php
		PrintHiddenCsrfToken();
      	PrintHidden("page", "background_compose_smtp");

   	?>

	<p style="margin-top: 30px; margin-left: 10px; font-size: 20px;">To : </p>

	<input type="Email" name="recieverEmail" class="input-email" placeholder= <?php echo $receiverAddress?> >

	<p style="margin-top: 15px; margin-left: 10px;font-size: 20px;">Subject : </p>

	<input type="text" name="subject" class="input-email" placeholder="<?php echo $replysub ;?>">

	<p style="margin-top: 15px; margin-left: 10px;font-size: 20px;">Message: </p>

	<textarea name = "body" rows="8" cols="128" style="border: 1px solid; border-color: grey; border-top: 1px solid; margin-left: 10px; margin-bottom: 20px;"></textarea>

	<input type="hidden" name="replybody" value=<?php echo $replybody;?> >
	<input type="hidden" name="replysubject" value=<?php echo $replysubject;?> >
	<input type="hidden" name="replyfrom" value=<?php echo $replyfrom;?> >
	<input type="hidden" name="replyto" value=<?php echo $replyto;?> >

	<div style="margin : auto; width: 50%; text-align: center;">

		<input class="square_btn" type="submit"  name="buttonVal" value="Save as Draft" ></button>

		<input class="square_btn" type="submit"  name="buttonVal" value="Reply"></button>

	</div>

	</form>
	
	<?php
}
?>