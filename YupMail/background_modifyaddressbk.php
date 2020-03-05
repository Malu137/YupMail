<?php 
if (!defined('IN_WEBADMIN'))
exit();
$accountAddress = $_SESSION['session_username'];

ProfileUpdateStatus(SaveProfile($accountAddress));
//ProfileUpdateStatus(1,$processTrack);
//echo "in background_editprofile";

$action = hmailGetVar("action","");


function ProfileUpdateStatus($errorValue)
{
	global $hmail_config;
	header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=addressbk&status=".$errorValue );
    exit();	   
}


function SaveProfile($accountAddress)
{
   
    $requireUpdate = False;

    $editcontact =  hmailGetVar("contact","");    
    $editedUsername = hmailGetVar("contactName","");
	$editedGender = hmailGetVar("contactGender","");
	$editedCity = hmailGetVar("contactCity","");
	$editedState = hmailGetVar("contactState","");
	$editedCountry = hmailGetVar("contactCountry","");
	$editedDOB = hmailGetVar("contactDOB","");
    $editedEmail = hmailGetVar("contactEmail","");

	
    

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


       $get_contacts =pg_query($db,
       "SELECT count(*) as dataavailable
		FROM public.yupm_addressbook where accountaddress = '$accountAddress' AND useremail ='$editcontact'");
		
		$getGender= pg_query($db,"SELECT gender FROM public.yupm_addressbook where accountaddress = '$accountAddress' AND useremail ='$editcontact'");

        $insertFlag = True;
       while ($row = pg_fetch_assoc($get_contacts)) {
            if($row['dataavailable'] > 0) {
				$insertFlag = False;
		}
		if (!$insertFlag)
		{
			$getGender= pg_query($db,"SELECT gender FROM public.yupm_addressbook where accountaddress = '$accountAddress' AND useremail ='$editcontact'");
			while($row = pg_fetch_assoc($getGender))
				{
					$profileGender=$row['gender'];
				}

		}
		
	}
		
		if ($editedUsername == null || $editedEmail == null)
	{
		global $hmail_config;
			header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=addressbk&error=1");
		exit();

	}
		elseif (!filter_var($editedEmail, FILTER_VALIDATE_EMAIL))
		{
			global $hmail_config;
			header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=addressbk&error=2");
		exit();

		}
		if(!$insertFlag){
		if($editedGender != $profileGender) {
			if($editedGender != null)
			$requireUpdate = True;
			else
			$editedGender=$profileGender;
		}
	}
        if($insertFlag){
            $query = "INSERT INTO public.yupm_addressbook(
                accountaddress, username, gender, city, state, country, dob, useremail)
                VALUES ('$accountAddress', '$editedUsername', '$editedGender', '$editedCity', '$editedState', '$editedCountry', '$editedDOB', '$editedEmail')";

			$result = pg_query($query);
		} else {
			$query = "UPDATE public.yupm_addressbook
				SET username='$editedUsername', gender='$editedGender', city='$editedCity', state='$editedState', 
				country='$editedCountry', dob='$editedDOB', useremail='$editedEmail'
				WHERE accountaddress = '$accountAddress' and useremail = '$editcontact' ;";

			$result = pg_query($query);				
		}

        pg_close($db);

		
    }
    catch( Exception $e)
    {
        echo $e;
		return 1;
    }


}
?>