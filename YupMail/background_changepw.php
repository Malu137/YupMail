<?php
if (!defined('IN_WEBADMIN'))
   exit();

   $confirmCurrentPW = hmailGetVar("cPassword","");
   $newPassword1 = hmailGetVar("newPassword1","");
   $newPassword2 = hmailGetVar("newPassword2","");

   $emailid = $_SESSION['session_username'];

   if($confirmCurrentPW==$_SESSION['session_password'])
   {
       if($confirmCurrentPW == $newPassword1)
       {
        global $hmail_config;
        header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=changepw&errorpw=4");
        exit();	

       }
       if($newPassword1 == $newPassword2)
       {
        global $hmail_config;
        global $obBaseApp;
        $obDomain = $obBaseApp->Domains->ItemByName("yup.mail");
        $obAccount = $obDomain->Accounts->ItemByAddress("$emailid");
        $obAccount->Password = $newPassword1 ;
        $obAccount->Save();
        $_SESSION['session_password'] = $newPassword1;
        header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=changepw&errorpw=3");
        exit();	
       }
       else
       {
        global $hmail_config;
        header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=changepw&errorpw=2");
        exit();	
       }

   }
   else
   {
    global $hmail_config;
	header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=changepw&errorpw=1");
	exit();	
   }
   ?>