<?php

	//include pgconnection.php;
	$host        = "host = localhost";
	$port        = "port = 5432";
	$dbname      = "dbname = hmailrepo";
	$credentials = "user = mailadm password=mailadm";
	   
    $accountAddress = $_SESSION['session_username'];
    
    try
	{
		$db = pg_connect( "$host $port $dbname $credentials"  );
		if(!$db) {
		  echo "Error : Unable to open database\n";
        }
    }
    catch (Exception $e)
    {}
    $get_contacts =pg_query($db,
		"SELECT username, gender, city, state, country, dob, useremail
        FROM public.yupm_addressbook where accountaddress ='$accountAddress'");
    
    echo "Address book of ".$accountAddress;
    ?>
    </br>
    <a href="index.php?page=modifyaddressbk&action=add&accountid=' . $obAccount->ID . '&domainid='. $obDomain->ID" style='text-decoration:none;color:white;'> Add Contact
		</a> 
		</br>
    <?php
	
	$error =hmailGetVar("error","");
	if($error==1)
	{
		echo "Contact name and email is required to create account.";
	}
	elseif($error==2)
	{
		echo "Enter Valid Email Id";
	}

    while ($row = pg_fetch_assoc($get_contacts)) {
        ?>
        </br>
        <table>
        <tr>
        <td>
            <ul>
            <?php echo $row['username']?>
            </ul>
        </td> 
        <td>
        <table >
			<tr> 
				<td> <ul>User Mail : 		</ul></td>
				<td> <ul><?php echo $row['useremail']; ?></ul></td>
			</tr>
			<tr>
				<td> <ul> Date of Birth:	</ul></td>
				<td><ul><?php echo $row['dob']; ?></ul></td>
			</tr>
			<tr>
				<td><ul>Gender :			</ul></td>
				<td><ul><?php echo $row['gender']; ?></ul></td>
			</tr>
			<tr>
				<td><ul>City : 				</ul></td>
				<td><ul><?php echo $row['city'] ?></ul></td>
			</tr>
			<tr>
			<td><ul>State :					</ul></td>
			<td><ul><?php echo $row['state']; ?></ul>
			</td>
			</tr>
			<tr>
			<td><ul>Country :				</ul></td>
			<td>
				<ul>
			<?php echo $row['country']; ?>
		</ul>
			</td>
            </tr>
            <tr>
            <td>
                <a href="index.php?page=modifyaddressbk&action=edit&contact='<?php echo $row['useremail']; ?>'">Edit</a>
            </td>
            </tr>


		</table>
		
        </td>
        </tr>
    </br>
        
        
    <?php
    }    
    ?>
    </table>
