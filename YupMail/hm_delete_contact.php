<?php 
if (!defined('IN_WEBADMIN'))
exit();
$host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = hmailrepo";
$credentials = "user = mailadm password=mailadm";

$action = hmailGetVar("action","");
$contactMail = hmailGetVar("contact","");
$accountAddress = $_SESSION['session_username'];

try{
    $db = pg_connect( "$host $port $dbname $credentials"  );
    if(!$db) {
        echo "Error : Unable to open database\n";
      }
    $res = pg_query($db,"DELETE FROM public.yupm_addressbook where accountaddress ='$accountAddress' and useremail= ".$contactMail);
    //var_dump($res);
    pg_close();
}
catch(Exception $e)
{
    Echo("Unable to delete");
}
header("refresh: 0; url=" . $hmail_config['rooturl'] . "index.php?page=addressbk_CL");
?>

