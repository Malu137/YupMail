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
    
            <title><?php //echo $profile_data['username'] ?>'s Profile</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 
        

        

    <div class="card" style="width: 18rem; margin: 0 auto;">
  <img src="myu_black.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">User Mail - </li>
    <li class="list-group-item">User Name - </li>
    <li class="list-group-item">Date of Birth - </li>
    <li class="list-group-item">Gender - </li>
    <li class="list-group-item">Alternate Email - </li>
    <li class="list-group-item">City -</li>
    <li class="list-group-item">State -</li>
    <li class="list-group-item">State -</li>
  </ul>
  </div>
</div>





        </br>
        </br>
        <a href="index.php?page=editprofile&action=edit&accountid=' . $obAccount->ID . '&domainid='. $obDomain->ID">Edit Profile
        </a> 
    </h3>        
</body>
</html>
