<html>

<head>

<style>

table, td, th {

	border-bottom: 1px solid rgb(208,208,208);

	text-align: left;

}

table{

	border-collapse: collapse; 

}

th, td {

  padding: 15px;

}

tr:hover {

	background-color: #f5f5f5;

}

.ab:link, ab:visited {

  background-color:rgb(0,129,129);

  color: white;

  padding: 14px 25px;

  text-align: center;

  text-decoration: none;

  display: block;

}
.ab{
	text-decoration: none;
	color:white;
}



ab:hover, ab:active {

  background-color: rgb(0,129,129);

}

</style>

</head>

<body>

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

    

    echo "<h3 style='color:rgb(0,129,129); text-align:center;'>Address book of '.$accountAddress'</h3>";

?>

    </br>

    <a href="index.php?page=modifyaddressbk&action=add&accountid=' . $obAccount->ID . '&domainid='. $obDomain->ID" class="ab"> Add Contact

		</a> 

		</br>

    <?php

	

	$error =hmailGetVar("error","");

	if($error==1)

	{

		echo "<h4 style='color:red; text-align:center;'>Contact name and email is required to create account.</h4>";

	}

	elseif($error==2)

	{

		echo "<h4 style='color:red; text-align:center;'>Enter valid email id</h4>";

	}



    while ($row = pg_fetch_assoc($get_contacts)) {

    ?>
		<div style="border:solid #2a7886;width:80%" align="center">
        </br>

        <h4 style="text-align:center;border: 1px #e1f4f3;">

            <?php echo $row['username']?>

        </h4>

        </br>



        <table style="background:#e1f4f3;width:100%;" >

			<tr> 

				<td> User Mail </td>

				<td> <?php echo $row['useremail']; ?></td>

			</tr>

			<tr>

				<td>Date of Birth</td>

				<td><?php echo $row['dob']; ?></td>

			</tr>

			<tr>

				<td>Gender</td>

				<td><?php echo $row['gender']; ?></td>

			</tr>

			<tr>

				<td>City </td>

				<td><?php echo $row['city'] ?></td>

			</tr>

			<tr>

				<td>State </td>

				<td><?php echo $row['state']; ?></td>

			</tr>

			<tr>

				<td>Country</td>

				<td><?php echo $row['country']; ?></td>

			</tr>

	</table>

				<a href="index.php?page=modifyaddressbk&action=edit&contact='<?php echo $row['useremail'];  ?>'" class="ab">Edit</a><br/>
				<a href="index.php?page=delete_contact&contact='<?php echo $row['useremail']; ?>'" class="ab">Delete</a>
	</div>
	<br/>
		   
	<?php
	 }
	 ?>
	 </body>

</html>