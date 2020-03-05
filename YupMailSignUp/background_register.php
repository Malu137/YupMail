<?php
if (!defined('IN_WEBADMIN'))
   exit();


class ProcessTrack {
    public $pt = 0;
	public $user = "";
}


$processTrack = new ProcessTrack;
$username	= hmailGetVar("username","") . "@yup.mail";
$password	= hmailGetVar("password","");

RegistrationStatus(NewUserRegister($username, $password, $processTrack),$processTrack);


function RegistrationStatus($errorValue, $processTrack)
{
	global $hmail_config;
	header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=register&status=".$errorValue . "&track=" . $processTrack->pt. "&user=".$processTrack->user);
	exit();	   
}



function NewUserRegister($username, $password, $processTrack)
{
	global $obBaseApp;
  
	if($username == "" || $password == "")
	{
		return 4;
	}
   
	try
	{
		$obAccount = $obBaseApp->Authenticate("administrator", "malu1324");
		$processTrack->pt = 1;
		$obDomain = $obBaseApp->Domains->ItemByName("yup.mail");
		$processTrack->pt = 2;
		
		try 
		{
			$obAccountCheck = $obDomain->Accounts->ItemByAddress($username);
			$processTrack->pt = 3;
			return 2;
		}
		catch (Exception $e) 
		{
			$processTrack->pt = 4;
		}
	
		$obAccountNew = $obDomain->Accounts->Add();
	   
		$processTrack->pt = 5;
		//Set the account properties
		$obAccountNew->Address = $username;
		$processTrack->user = $username;
		$obAccountNew->Password = $password;
		$obAccountNew->Active = True;
		$obAccountNew->MaxSize = 100; // Allow max 100 megabytes

		$processTrack->pt = 6;
		$obAccountNew->Save();
		$processTrack->pt = 7;
		return 3;
	}
	catch (Exception $e) 
	{
		return 1;
	}	
}
?>

