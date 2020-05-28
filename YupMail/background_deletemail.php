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
        imap_delete($connection, $MsgUID);
        imap_expunge($connection);
        imap_close($connection);
    }
    catch(Exception $e)
    {
        echo("Imap Error");
    }
    header("Location: ".$hmail_config['rooturl']."index.php?page=imapfolderview&imapfolderName=".$MailFolderName);

?>


