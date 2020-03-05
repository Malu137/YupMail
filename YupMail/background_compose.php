<?php
if (!defined('IN_WEBADMIN'))
   exit();

   $sendersAddress = $_SESSION['session_username'];
   $receiverAddress = hmailGetVar("recieverEmail","");
   $msgSubject = hmailGetVar("subject","");
   $msgBody = hmailGetVar("body","");

   function composeError($error)
   {
       echo "Unable to Send Message Error : ".$error ;
   }

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
        }
        catch(Exception $e)
        {
            composeError($trackStage);
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