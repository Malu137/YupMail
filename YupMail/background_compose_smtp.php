<?php
if (!defined('IN_WEBADMIN'))
   exit();

   $sendersAddress = $_SESSION['session_username'];
   $password = $_SESSION['session_password'];
   

   $receiverAddress = hmailGetVar("recieverEmail","");
   $msgSubject = hmailGetVar("subject","");
   $msgBody = hmailGetVar("body","");

   $act = hmailGetVar("buttonVal","");
    
    $replybody = hmailGetVar("replybody","");
    $replyfrom = hmailGetVar("replyfrom","");
	$replysubject = hmailGetVar("replysubject","");
	$replyto = hmailGetVar("replyto","");

   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/vendor/autoload.php';

   
class Mailer extends PHPMailer {

    /**
     * Save email to a folder (via IMAP)
     *
     * This function will open an IMAP stream using the email
     * credentials previously specified, and will save the email
     * to a specified folder. Parameter is the folder name (ie, Sent)
     * if nothing was specified it will be saved in the inbox.
     *
     * @author David Tkachuk <http://davidrockin.com/>
     * 
     * 
     */


    



    public function copyToFolderSENT($folderPath = null) {
        $message = $this->MIMEHeader ."\r\n". $this->MIMEBody;

        $connection = imap_open('{yup.mail}', $this->Username, $this->Password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
        $folders = imap_listmailbox($connection, "{imap.example.org:143}", "*");
        $res = false;
        
        foreach($folders as $f){
            if (strpos($f,'Sent') || strpos($f,'SENT') ){
                $res = true;
            break;
            }
        }
        if ( $res == false ){
            //echo("Inhere");
            imap_createmailbox($connection , '{imap.example.org:143}SENT' ) ;
        }
        imap_close($connection);
        //var_dump($this);
        //var_dump($message);

        $path = "SENT" . (isset($folderPath) && !is_null($folderPath) ? ".".$folderPath : ""); // Location to save the email
        $imapStream = imap_open("{" . $this->Host . "}" . $path , $this->Username, $this->Password);
        imap_append($imapStream, "{" . $this->Host . "}" . $path, $message);
        imap_close($imapStream);
    }




}

try{


$mail = new Mailer();
$mail->isSMTP(); // Tell PHPMailer we're going to use SMTP
$mail->Host = 'yup.mail'; // Set SMTP host
$mail->Username = $sendersAddress; // Set the our email address
$mail->Password = $password; // Set email address password
$mail->From = $sendersAddress; // The sender's email
$mail->FromName = $sendersAddress ; // The sender's name

$mail->addReplyTo($mail->From, $mail->FromName); // Add a reply to
$mail->Subject = $msgSubject; // Message subject
$mail->Body    = $msgBody; // Message contents

if ($act == 'Send'){
    //echo"In act = send";
    $mail->addAddress($receiverAddress); // Recipient's email
    if ($receiverAddress == "")
    {
        //echo("Invalid Email Address");
    }
    else if($mail->send()) { // Attempt to send the email
    $mail->copyToFolderSENT(); // Will save into Sent
} else {
    header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=compose_mail&alert=1");
} 
}
else if ($act == 'Drafts'){
    
    //$mail->copyToFolderDRAFTS();

    $connection = imap_open('{yup.mail}', $sendersAddress, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
    $folders = imap_listmailbox($connection, "{imap.example.org:143}", "*");
    $res = false;
    foreach($folders as $f){
        if (strpos($f,'DRAFTS')){
            $res = true;
            break;
            }
        }
        if ( $res == false ){
            //echo("Inhere");
            imap_createmailbox($connection , '{imap.example.org:143}DRAFTS' ) ;
        }
    imap_close($connection);

    $stream = imap_open('{yup.mail}DRAFTS', $sendersAddress, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
        $check = imap_check($stream);
        //echo "Msg Count before append: ". $check->Nmsgs . "\n";

        imap_append($stream, "{yup.mail}Drafts"
                   , "From:".$sendersAddress."\r\n"
                   . "To: ".$receiverAddress."\r\n"
                   . "Subject: ".$msgSubject."\r\n"
                   . "\r\n"
                   .$msgBody ."\r\n"
                   );

$check = imap_check($stream);
//echo "Msg Count after append : ". $check->Nmsgs . "\n";

imap_close($stream);
    

    header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=imapfolderview&imapfolderName=DRAFTS&alert=2");
}
elseif($act=='Reply')
{
    $receiverAddress=$replyfrom;
    $mail->addAddress($receiverAddress); 
    if($mail->Subject=="")
    {
        $mail->Subject="Reply:".$replysubject;
        
    }
    $mail->Body=$mail->Body."\r\n\r\nIn Reply To:\r\n     FROM:".$replyfrom."\r\n       TO:".$replyto."\r\n       SUBJECT:".$replysubject."\r\nBODY:\r\n".$replybody;
    $mail->isBodyHtml = false;
    if ($receiverAddress == "")
    {
        header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=compose_mail&alert=1");
    }
    else if($mail->send()) { // Attempt to send the email
    $mail->copyToFolderSENT(); // Will save into Sent
} else {
    header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=compose_mail&alert=1");
} 

}
}
catch(Exception $e)
{
    
}
header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=imapfolderview&imapfolderName=SENT&alert=1");
?>