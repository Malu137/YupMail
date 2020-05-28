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
        $mailbody = imap_fetchbody($connection,$MsgUID,1,CP_UID);
        $mailhead = imap_fetch_overview($connection,$MsgUID,FT_UID);

        imap_close($connection);
    }
    catch(Exception $e)
    {
        echo("Imap Error");
    }
?>

<style>
.omtable{
    background:#e1f4f3;
    width:95%;
    margin:20px;
    
}
.om{
    background:#e1f4f3;
    
    border:c#e0dfdf 1px solid;
    padding:20px;
    border-radius:2px;
    align:center;

}
.omr1{
    align-self:center;
    padding:10px;
    font-size: 20px;
    width: 40%;

}

.omr2{
    padding:10px;
    font-size: 18px;
}
</style>
<div class ="om">
<table class ="omtable" >
    <tr>
        <td style="font-size:30px;padding:10px;"><?php echo $mailhead[0]->subject; ?></td>
    </tr>
    <tr>
        <td class="omr1">From         :</td>
        <td class="omr2"><?php echo $mailhead[0]->from; ?></td>
    </tr>
    <tr>
    <td class="omr1"> To           :</td>
    <td class="omr2"><?php echo $mailhead[0]->to; ?></td>
    </tr>
    <tr>
        <td class="omr1"> Body         :</td>
    </tr>
    <tr>
    <td>
    <div style="width:150%;background:white;padding:10px;margin-left:10px;"><span style="white-space: pre-line"><?php echo $mailbody; ?></span></div>
    <td>
    </tr>
    
</table>
<div style="width:75%;" align="right">
<a href ="<?php echo $hmail_config['rooturl']?>index.php?page=compose_mail&action=reply&uid=<?php echo $MsgUID?>&imapfolderName=<?php echo $MailFolderName;?>">
    Reply </a>
</div>
</div>
