<?php

if (!defined('IN_WEBADMIN'))
   exit();

	//include pgconnection.php;
	$host        = "host = localhost";
	$port        = "port = 5432";
	$dbname      = "dbname = hmailrepo";
	$credentials = "user = mailadm password=mailadm";
	   
	$accountAddress = $_SESSION['session_username'];
	//echo $username;

	$profileUsername = "";
	$profileGender ="";
	$profileCity="";
	$profileState="";
	$profileCountry="";
	$profileDOB="";
	$profileAltEmail="";
	

	
	try
	{
		$db = pg_connect( "$host $port $dbname $credentials"  );
		if(!$db) {
		  echo "Error : Unable to open database\n";
		} else {
		  //echo "Opened database successfully\n";
		}
		echo "In Edit Profile";

		//$conn = pg_connect($connStr);
		//$get_user = pg_query($db, "select accountaddress as username from public.yupm_accounts where accountaddress = '$username' LIMIT 1" );
		$get_profile =pg_query($db,
		"SELECT username, gender, city, state, country, dob, altemail
		FROM public.yupm_userprofile where accountaddress ='$accountAddress' Limit 1");


		while ($row = pg_fetch_assoc($get_profile)) {
			//echo $row['username'];
			//echo "\n";
			$profileUsername = $row['username'];
			$profileGender = $row['gender'];
			$profileCity=$row['city'];
			$profileState=$row['state'];
			$profileCountry=$row['country'];
			$profileDOB=$row['dob'];
			$profileAltEmail=$row['altemail'];

		}

		pg_close($db);

 
	}
	catch(Exception $e)
	{
	}
	
	
?>
<!DOCTYPE html>
<html>    
<head>        
	<meta charset="UTF-8">
	        <title><?php //echo $profile_data['username'] ?>'s Profile</title>
</head>
<body>

 
    
	<?php //echo $profile_username ?>
    <h3>Personal Information </h3>
	
	<?php 
	$error=hmailGetVar("error","");
	if($error==1)
	{
		echo "Enter a valid Email ID";
	}
		{ 
	?> 
	
     
	<form method = 'POST' action ="<?php echo $hmail_config['rooturl']; ?>index.php" onSubmit="return formCheck(this);" name= "mainform">
	<?php
		PrintHiddenCsrfToken();
      	PrintHidden("page", "background_editprofile");

   	?>
	   </br>
		<table >
			<tr> 
				<td> <ul>User Mail : 		</ul></td>
				<td> <ul><?php echo $accountAddress; ?></ul></td>
			</tr>
			<tr>
				<td><ul>User Name :			</ul></td>
				<td> <ul>
					<input type="text" name="editedUsername" size="25" maxlength="256" value ="<?php echo $profileUsername; ?> "/>
					<input type="hidden" name="username" size="25" maxlength="256" value ="<?php echo $profileUsername; ?> "/>
				</ul></td>
			</tr>
			<tr>
				<td> <ul> Date of Birth:	</ul></td>
				<td><ul>
					<input type="date" name="editedDOB" size="25" maxlength="256" value="<?= date("Y-m-d"); ?>" />
					<input type="hidden" name="DOB" size="25" maxlength="256" value="<?= date("Y-m-d"); ?>" />
				</ul></td>
			</tr>
			<tr>
				<td><ul>Gender :			</ul></td>
				<td><ul>
					
					<input type="hidden" name="gender" size="25" maxlength="256" value ="<?php echo $profileGender; ?>" />
					<input type="radio" name="editedGender" value="Male"> Male
					<input type="radio" name="editedGender" value="Female"> Female
					<input type="radio" name="editedGender" value="Other"> Other
				</ul></td>
			</tr>
			<tr>
			<td><ul>Alternate Email :		</ul></td>
			<td><ul>
				<input type="text" name="editedAltEmail" size="25" maxlength="256" value ="<?php echo $profileAltEmail; ?>" />
				<input type="hidden" name="altEmail" size="25" maxlength="256" value ="<?php echo $profileAltEmail; ?>" />
			</ul></td>
			</tr>
			<tr>
				<td><ul>City : 				</ul></td>
				<td><ul>
					<input type="text" name="editedCity" size="25" maxlength="256" value ="<?php echo $profileCity; ?>" />
					<input type="hidden" name="city" size="25" maxlength="256" value ="<?php echo $profileCity; ?>" />
				</ul></td>
			</tr>
			<tr>
			<td><ul>State :					</ul></td>
			<td><ul>
				<input type="text" name="editedState" size="25" maxlength="256" value ="<?php echo $profileState; ?>" />
				<input type="hidden" name="state" size="25" maxlength="256" value ="<?php echo $profileState; ?>" />
			</ul></td>
			</tr>
			<tr>
			<td><ul>Country :				</ul></td>
			<td>
				<ul>
				<input type="text" name="editedCountry" size="25" maxlength="256" value ="<?php echo $profileCountry; ?>" />
				<input type="hidden" name="country" size="25" maxlength="256" value ="<?php echo $profileCountry; ?>" />
		</ul>
			</td>
			</tr>


		</table>
		<input type="submit" value="Save" />

	</form>
		</br>
		</br>
		<a href=<?php echo $hmail_config['rooturl']; ?>index.php?page=profile>View Profile
		</a> 
	<?php
		}
	?>
	</h3>        
</body>
</html> 
