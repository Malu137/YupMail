<?php 
if (!defined('IN_WEBADMIN'))
exit();

$host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = hmailrepo";
$credentials = "user = mailadm password=mailadm";

$action = hmailGetVar("action","");;
$contactMail = hmailGetVar("contact","");
$accountAddress = $_SESSION['session_username'];

if ($action=='add')
{
    echo " Adding new Contact ";
}
elseif ($action =='edit')
{
    echo " Modifying existing contact ";
}


try
{
    if($action=='edit')
    {
    $db = pg_connect( "$host $port $dbname $credentials"  );
    if(!$db) {
      echo "Error : Unable to open database\n";
    } else {
      //echo "Opened database successfully\n";
    }


    //$conn = pg_connect($connStr);
    //$get_user = pg_query($db, "select accountaddress as username from public.yupm_accounts where accountaddress = '$username' LIMIT 1" );
    $get_contacts =pg_query($db,
		"SELECT username, gender, city, state, country, dob, useremail
        FROM public.yupm_addressbook where accountaddress ='$accountAddress' and useremail= ".$contactMail); // need to modify here
   }
}
catch (Exception $e)
{}

$profileUsername = "";
$profileGender = "";
$profileCity ="";
$profileState="";
$profileCountry="";
$profileDOB="";
$profileEmail="";

if($action=='edit')
    {
        while ($row = pg_fetch_assoc($get_contacts)) {
        //echo $row['username'];
        //echo "\n";
        $profileUsername = $row['username'];
        $profileGender = $row['gender'];
        $profileCity=$row['city'];
        $profileState=$row['state'];
        $profileCountry=$row['country'];
        $profileDOB=$row['dob'];
        $profileEmail=$row['useremail'];

    }
  

    pg_close($db);}
    elseif($action=='add')
    {
        $profileDOB=date("Y-m-d");
    }


    ?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" />
<link rel="stylesheet" type="text/css" href="style_editprofile.css">


<div class="container" id="container">
<div class="form-container">

<form method = 'POST' action ="<?php echo $hmail_config['rooturl']; ?>index.php" onSubmit="return formCheck(this);" name= "mainform">
	<?php
		PrintHiddenCsrfToken();
      	PrintHidden("page", "background_modifyaddressbk");

       ?>
    
    <table >
       <tr> 
			<td> <ul>Contact Name : 		</ul></td>
			<td> <ul>
                <input type="text" name="contactName" size="25" maxlength="256" value ="<?php echo $profileUsername ?>">
            </ul></td>
        </tr>
        
		<tr> 
				<td> <ul>Contact Mail : 		</ul></td>
				<td> <ul>
                <input type="text" name="contactEmail" size="25" maxlength="256" value ="<?php echo $profileEmail ?>">
                <input type="hidden" name="contact" size="25" maxlength="256" value ="<?php echo $profileEmail ?>">
                </ul></td>
		</tr>
			<tr>
				<td> <ul> Date of Birth:	</ul></td>
				<td><ul>
                <input type="date" name="contactDOB" size="25" maxlength="256" value ="<?php echo $profileDOB ?>">
                </ul></td>
			</tr>
			<tr>
				<td><ul>Gender :			</ul></td>
				<td><ul>
                <!--<input type="text" name="contactGender" size="25" maxlength="256" value ="<?php echo $profileGender ?>">-->
                <input type="radio" name="contactGender" value="Male" style="width:30%;background:#bef0eb;"> Male
                <br>
                    <input type="radio" name="contactGender" value="Female"style="width:30%;background:#bef0eb;"> Female
                    <br>
                    <input type="radio" name="contactGender" value="Other" style="width:30%;background:#bef0eb;"> Other
                    
                </ul></td>
			</tr>
			<tr>
				<td><ul>City : 				</ul></td>
				<td><ul>
                <input type="text" name="contactCity" size="25" maxlength="256" value ="<?php echo $profileCity?>">
                </ul></td>
			</tr>
			<tr>
			<td><ul>State :					</ul></td>
			<td><ul>
            <input type="text" name="contactState" size="25" maxlength="256" value ="<?php echo $profileState ?>">    
            </ul></td>
			</tr>
			<tr>
			<td><ul>Country :				</ul></td>
			<td>
				<ul>
                <input type="text" name="contactCountry" size="25" maxlength="256" value ="<?php echo $profileCountry?>">
		    </ul>
			</td>
            </tr>
            <tr>
                <td>
            <input type="submit" name="Add" value ="Add" class="reset_bt">
            </td>
            </tr>

        </table>
</form>
</div>
</div>