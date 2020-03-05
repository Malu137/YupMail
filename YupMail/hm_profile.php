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
<!DOCTYPE html>
<html>    
<head>        
	<meta charset="UTF-8">
			<title><?php //echo $profile_data['username'] ?>'s Profile</title>
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

 
    
	<?php //echo $profile_username ?>
    <h3>Personal Information 
	<?php 
		//$visitor = $_SESSION['username'];
        //if ($user == $visitor)
		{ 
	?>      
	   
		<table >
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





		</br>
		</br>
		<a href="index.php?page=editprofile&action=edit&accountid=' . $obAccount->ID . '&domainid='. $obDomain->ID">Edit Profile
		</a> 
	<?php
		}
	?>
	</h3>        
</body>
</html> 
