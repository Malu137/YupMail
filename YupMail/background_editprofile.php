<?php
if (!defined('IN_WEBADMIN'))
   exit();

class ProcessTrack {
    public $pt = 0;
	public $user = "";
}


$processTrack = new ProcessTrack;

$accountAddress = $_SESSION['session_username'];


	


ProfileUpdateStatus(SaveProfile($accountAddress, $processTrack),$processTrack);
//ProfileUpdateStatus(1,$processTrack);
//echo "in background_editprofile";

function ProfileUpdateStatus($errorValue, $processTrack)
{
	global $hmail_config;
	header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=profile&status=".$errorValue . "&track=" . $processTrack->pt. "&user=".$processTrack->user);
	exit();	   
}



function SaveProfile($accountAddress, $processTrack)
{
   
	$requireUpdate = False;

	$profileUsername = hmailGetVar("username","");
	$profileGender = hmailGetVar("gender","");
	$profileCity = hmailGetVar("city","");
	$profileState = hmailGetVar("state","");
	$profileCountry = hmailGetVar("country","");
	$profileDOB = hmailGetVar("DOB","");
	$profileAltEmail = hmailGetVar("altEmail","");

	$editedUsername = hmailGetVar("editedUsername","");
	$editedGender = hmailGetVar("editedGender","");
	$editedCity = hmailGetVar("editedCity","");
	$editedState = hmailGetVar("editedState","");
	$editedCountry = hmailGetVar("editedCountry","");
	$editedDOB = hmailGetVar("editedDOB","");
	$editedAltEmail = hmailGetVar("editedAltEmail","");

	if($editedUsername != $profileUsername) {
		$requireUpdate = True;
	}elseif($editedGender != $profileGender) {
		if($editedGender != null)
		$requireUpdate = True;
		else
		$editedGender=$profileGender;
	}elseif($editedCity != $profileCity) {
		$requireUpdate = True;
	}elseif($profileState != $editedState) {
		$requireUpdate = True;
	}elseif($editedCountry != $profileCountry) {
		$requireUpdate = True;
	}elseif($editedDOB != $profileDOB) {
		$requireUpdate = True;
	}elseif($editedAltEmail != $profileAltEmail) {
		$requireUpdate = True;
	}

	if (!filter_var($editedAltEmail, FILTER_VALIDATE_EMAIL))
		{
			global $hmail_config;
			header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=editprofile&error=1");
		exit();

		}

	//include pgconnection.php;
	$host        = "host = localhost";
	$port        = "port = 5432";
	$dbname      = "dbname = hmailrepo";
	$credentials = "user = mailadm password=mailadm";

	try
	{
		$db = pg_connect( "$host $port $dbname $credentials"  );
		if(!$db) {
		  echo "Error : Unable to open database\n";
		} else {
		  //echo "Opened database successfully\n";
		}

		$get_profile =pg_query($db,
		"SELECT count(*) as dataavailable
		FROM public.yupm_userprofile where accountaddress ='$accountAddress' Limit 1");

		$insertFlag = True;

		while ($row = pg_fetch_assoc($get_profile)) {
			if($row['dataavailable'] > 0) {
				$insertFlag = False;
			}
		}

		echo $insertFlag;

		if($insertFlag){
			$query = "INSERT INTO public.yupm_userprofile(
				accountaddress, username, gender, city, state, country, dob, altemail)
				VALUES ('$accountAddress', '$editedUsername', '$editedGender', '$editedCity', '$editedState', '$editedCountry', '$editedDOB', '$editedAltEmail');";

			$result = pg_query($query);
		} else {
			$query = "UPDATE public.yupm_userprofile
				SET username='$editedUsername', gender='$editedGender', city='$editedCity', state='$editedState', 
				country='$editedCountry', dob='$editedDOB', altemail='$editedAltEmail'
				WHERE accountaddress = '$accountAddress';";

			$result = pg_query($query);				
		}

		pg_close($db);
	}
	catch (Exception $e) 
	{
		echo $e;
		return 1;
	}	
}
?>

