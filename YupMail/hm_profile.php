<?php

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


 
    
	<?php //echo $profile_username ?>
    <h3>Personal Information </h3>       
	<?php 
		//$visitor = $_SESSION['username'];
        //if ($user == $visitor)
		{ 
	?>    
	
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" />
<link rel="stylesheet" type="text/css" href="style_profile.css">
	
<div class="container" id="container">
	<div class="form-container" align="center">
		<table align="center" >
			<tr> 
				<td> <ul>User Mail : 		</ul></td>
				<td> <ul><?php echo $accountAddress; ?></ul></td>
			</tr>
			<tr>
				<td><ul>User Name :			</ul></td>
				<td> <ul><?php echo $profileUsername; ?></ul></td>
			</tr>
			<tr>
				<td> <ul> Date of Birth:	</ul></td>
				<td><ul><?php echo $profileDOB; ?></ul></td>
			</tr>
			<tr>
				<td><ul>Gender :			</ul></td>
				<td><ul><?php echo $profileGender; ?></ul></td>
			</tr>
			<tr>
			<td><ul>Alternate Email :		</ul></td>
			<td><ul><?php echo $profileAltEmail; ?></ul>
			</td>
			</tr>
			<tr>
				<td><ul>City : 				</ul></td>
				<td><ul><?php echo $profileCity; ?></ul></td>
			</tr>
			<tr>
			<td><ul>State :					</ul></td>
			<td><ul><?php echo $profileState; ?></ul>
			</td>
			</tr>
			<tr>
			<td><ul>Country :				</ul></td>
			<td>
				<ul>
			<?php echo $profileCountry; ?>
		</ul>
			</td>
			</tr>
		</table>
		</div>
		</div>
		<div align="right" style="width:70%;">
		<br>
		<button >
		<a href="index.php?page=editprofile&action=edit&accountid=' . $obAccount->ID . '&domainid='. $obDomain->ID">Edit Profile
		</a>
		
		</div>
			
	</button>

		 
	<?php
		}
	?>
	 

