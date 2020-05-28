<?php
if (!defined('IN_WEBADMIN'))
      exit();

    $MsgUID = hmailGetVar("uid");
    $username =  $_SESSION['session_username'];
    $password = $_SESSION['session_password'];
    $MailFolderName = hmailGetVar("imapfolderName","");
    $mailbox = '{imap.yup.mail:143/imap}'.$MailFolderName;
    
    try{
        $connection = imap_open($mailbox, $username, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
        
        if($MailFolderName != "Trash")
    {   
        $mailhead = imap_fetch_overview($connection, (string) $MsgUID,CP_UID);
        $mailbody = imap_fetchbody($connection,$MsgUID,1,CP_UID);

        $stream = imap_open('{yup.mail}Trash', $username, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
        $check = imap_check($stream);
        echo "Msg Count before append: ". $check->Nmsgs . "\n";

        imap_append($stream, "{yup.mail}Trash"
                   , "From:".$mailhead[0]->from."\r\n"
                   . "To: ".$mailhead[0]->to."\r\n"
                   . "Subject: ".$mailhead[0]->subject."\r\n"
                   . "\r\n"
                   .$mailbody ."\r\n"
                   );

$check = imap_check($stream);
echo "Msg Count after append : ". $check->Nmsgs . "\n";

imap_close($stream);
        

        
    }
    
        
        imap_delete($connection, $MsgUID,FT_UID);
        imap_expunge($connection);
        imap_close($connection);
        
    }
    catch(Exception $e)
    {
        echo("Imap Error");
    }
    header("Location: ".$hmail_config['rooturl']."index.php?page=imapfolderview&imapfolderName=".$MailFolderName);

?>


