<?php
if (!defined('IN_WEBADMIN'))
   exit();

   $sendersAddress = $_SESSION['session_username'];
   $password = $_SESSION['session_password'];

   $receiverAddress = hmailGetVar("recieverEmail","");
   $msgSubject = hmailGetVar("subject","");
   $msgBody = hmailGetVar("body","");

   function composeError($error)
   {
       echo "Unable to Send Message Error : ".$error ;
   }

   $MsgUID = -1;
   $error ="";
   $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
   if(!preg_match($email_exp,$receiverAddress)) {
       $error .= 'The Email Address you entered does not appear to be valid.<br />';
       composeError($error);
    }
    else
    {
        $trackStage = 0;
        try {
            $oMessage = new COM("hMailServer.Message", NULL, CP_UTF8);
            $trackStage++;
            $oMessage->From = $sendersAddress;
            $trackStage++;
            $oMessage->FromAddress = $sendersAddress;
            $trackStage++;
            $oMessage->Subject = $msgSubject;
            $trackStage++;
            $oMessage->AddRecipient($receiverAddress, $receiverAddress);
            $trackStage++;
            $oMessage->Body = $msgBody;
            $trackStage++;
            $oMessage->Save();
            $MsgID = $oMessage->ID;
            $MsgUID = $oMessage->UID;

            Echo("Message Sent successfully");
        }
        catch(Exception $e)
        {
            composeError($trackStage);
        }

        try{
            Echo $MsgID;
            
            $Sentmailbox = '{imap.yup.mail:143/imap}';
            $connection = imap_open($Sentmailbox, $sendersAddress, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
            $folders = imap_listmailbox($connection, "{imap.example.org:143}", "*");
            var_dump($folders);
            $res = false;
            foreach($folders as $f){
                if (strpos($f,'SENT')){
                    $res = true;
                break;
                }
            }
            echo $res;
            //echo $res;
            if ( $res == false ){
                echo("Inhere");
                imap_createmailbox($connection , '{imap.example.org:143}SENT' ) ;
            }
            imap_close($connection);
            $Sentmailbox = '{imap.yup.mail:143/imap}INBOX';
            $connection = imap_open($Sentmailbox, $sendersAddress, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
            $copy = imap_mail_copy($connection, (string) 3, 'SENT');
            var_dump($copy);
            echo("Successfully copied mail to SENT");
            imap_close($connection);
            
        }
        catch(Exception $e)
        {
        
        composeError("Could not copy message to Sent mailbox");

        }

        /*
        dim oMessage
        Set oMessage = CreateObject("hMailServer.Message")
        oMessage.From = "Me <myaddress@mydomain.com>"
        oMessage.FromAddress = "myaddress@mydomain.com"
        oMessage.Subject = "Hi"
        oMessage.AddRecipient "My friend", "myfriend@myfriend.com"
        oMessage.Body = "This is the contents of the email."
        oMessage.Save
        */
    }
    


   ?>