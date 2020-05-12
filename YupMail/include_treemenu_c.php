<html>
<head>
	<title>Yup Mail</title>
	<link rel="stylesheet" href="indexcss.css">
	<script type="text/javascript" src="indexjs.js"></script>
</head>
<body>

<?php
if (!defined('IN_WEBADMIN'))
    exit();


// Build tree menu
$dtitem=0;
$dtree = "d.add(" . $dtitem++ .",-1,'" . GetStringForJavaScript("Welcome") . "','index.php','','','','');\r\n";
$username = $_SESSION['session_username'];


// User
$domainname = hmailGetUserDomainName($username);

$obDomain = $obBaseApp->Domains->ItemByName($domainname);
$obAccounts = $obDomain->Accounts;

$obAccount	= $obAccounts->ItemByAddress($username);

$accountaddress = $obAccount->Address;
$accountaddress = PreprocessOutput($accountaddress);
$accountaddress = EscapeStringForJs($accountaddress);
$obIMAPFolders = $obAccount->IMAPFolders;
$imapFolderCount = $obIMAPFolders->Count;

//$url = htmlentities("index.php?page=account&action=edit&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID);
//$di = $dtitem++;

//$dtree .= "d.add(" . $dtitem++ .",0,'" . $accountaddress . "','$url','','','" . "images/user.png','" . "images/user.png');\r\n";
//$dtree .= "d.add(" . $dtitem++ .",0,'" . $accountaddress . "','','','','" . "images/user.png','" . "images/user.png');\r\n";






?>

<div id="sidebar">
	<div class="toggle-btn" onclick="toggleSidebar()">
		<span></span>
		<span></span>
		<span></span>
	</div>
<ul>
	<li style="color: white;">Welcome <?php echo $username; ?></li>

    <?php

    
        $IMAPFolderList = array("Inbox", "Drafts", "Sent", "Trash");

        foreach($IMAPFolderList as &$Item) {
        try{
        $obIMAPFolder = $obIMAPFolders->ItemByName($Item);
        $IMAPFolderName = $obIMAPFolder->Name;
        $IMAPFolderDBID = $obIMAPFolder->ID;
        $urlIMAP = htmlentities("https://localhost/YupMail/index.php?page=imapfolderview&imapfolderName=".$IMAPFolderName);
        

        //$dtree .= "d.add(" . $dtitem++ .",1,'" . GetStringForJavaScript("$IMAPFolderName") . "','$urlIMAP','','','" . "images/user.png','" . "images/user.png');\r\n";    
        
        ?>
        

        <li style="color: white;" ><a href = "<?php echo $urlIMAP; ?>" ><?php echo $IMAPFolderName?></a></li>
        <?php
        }
        catch(Exception $e){

        }

    //$value = $value * 2;
}

    ?>

	<li style="color: white;" onclick="to_profile()">Profile</li>
	<li style="color: white;" onclick="to_change()">Change Password</li>
	<li style="color: white;" onclick="to_compose()">Compose Mail</li>
	<li style="color: white;" onclick="to_address()">Address Book</li>
	<li style="color: white;" onclick="to_logout()">Logout</li>
</ul>	
</div>


<?php
/*
function GetStringForDomain($obDomain, $parentid)
{
    global $dtree, $dtitem, $domain_root;
    
    $current_domainid = hmailGetVar("domainid",0);
    $current_accountid = hmailGetVar("accountid",0);
    
    $domainname = $obDomain->Name;
    $domainname = PreprocessOutput($domainname);
    $domainname = EscapeStringForJs($domainname);
    
    $dtree .= "d.add($domain_root,$parentid,'" . $domainname . "','index.php?page=domain&action=edit&domainid=" . $obDomain->ID . "','','','" . "images/server.png','" . "images/server.png');\r\n";
    
    if ($current_domainid != $obDomain->ID && hmailGetAdminLevel() == ADMIN_SERVER)
    {
        // If the user is logged on as a system administrator, only show accounts
        // for the currently selected domain.
        return;
    }
    
    $obAccounts 	= $obDomain->Accounts();
    $AccountsCount	= $obAccounts->Count();
    $accounts_root = $dtitem++;
    $dtree .= "d.add($accounts_root,$domain_root,'" . GetStringForJavaScript("Accounts") . " ($AccountsCount)','index.php?page=accounts&domainid=" . $obDomain->ID . "','','','" . "images/folder.png','" . "images/folder.png');\r\n";
    for ($j = 0; $j < $AccountsCount; $j++)
    {
        $obAccount	= $obAccounts->Item($j);
        
        $accountaddress = $obAccount->Address;
        $accountaddress = PreprocessOutput($accountaddress);
        $accountaddress = EscapeStringForJs($accountaddress);
        
        $accountid = $obAccount->ID;
        
        $di = $dtitem++;
        $url = htmlentities("index.php?page=account&action=edit&accountid=" . $accountid . "&domainid=" . $obDomain->ID);
        $dtree .= "d.add($di,$accounts_root,'" . $accountaddress . "','$url','','','" . "images/user.png','" . "images/user.png');\r\n";
        
        // Only show sub-nodes for the currently selected account.
        if ($current_accountid == $accountid)
        {
            $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript("External accounts") . "','index.php?page=account_externalaccounts&accountid=" . $accountid . "&domainid=" . $obDomain->ID. "');\r\n";
        }
    }
    
    $obAliases		= $obDomain->Aliases();
    $AliasesCount	= $obAliases->Count();
    $aliases_root	= $dtitem++;
    $dtree .= "d.add($aliases_root,$domain_root,'" . GetStringForJavaScript("Aliases") . " ($AliasesCount)','index.php?page=aliases&domainid=" . $obDomain->ID . "','','','" . "images/folder.png','" . "images/folder.png');\r\n";
    
    for ($j = 0; $j < $AliasesCount; $j++)
    {
        $obAlias	= $obAliases->Item($j);
        
        $aliasname = $obAlias->Name;
        $aliasname = PreprocessOutput($aliasname);
        $aliasname = EscapeStringForJs($aliasname);
        
        $di = $dtitem++;
        $dtree .= "d.add($di,$aliases_root,'" . $aliasname . "','index.php?page=alias&action=edit&aliasid=" . $obAlias->ID . "&domainid=" . $obDomain->ID  . "','','','" . "images/arrow_switch.png','" . "images/arrow_switch.png');\r\n";
    }
    
    $obDistributionLists	= $obDomain->DistributionLists();
    $DListCount				= $obDistributionLists->Count();
    $dlist_root				= $dtitem++;
    $dtree .= "d.add($dlist_root,$domain_root,'" . GetStringForJavaScript("Distribution lists") . " ($DListCount)','index.php?page=distributionlists&domainid=" . $obDomain->ID . "','','','" . "images/folder.png','" . "images/folder.png');\r\n";
    
    for ($j = 0; $j < $DListCount; $j++)
    {
        $obDistributionList	= $obDistributionLists->Item($j);
        $di = $dtitem++;
        
        $address = PreprocessOutput($obDistributionList->Address);
        $address = EscapeStringForJs($address);
        
        $dtree .= "d.add($di,$dlist_root,'" . $address .  "','index.php?page=distributionlist&action=edit&distributionlistid=" . $obDistributionList->ID . "&domainid=" . $obDomain->ID . "','','','" . "images/arrow_out.png','" . "images/arrow_out.png');\r\n";
        $dtree .= "d.add(" . $dtitem++ .",$di,'" . GetStringForJavaScript("Members") . " (" . $obDistributionList->Recipients->Count() . ")','index.php?page=distributionlist_recipients&distributionlistid=" . $obDistributionList->ID . "&domainid=" . $obDomain->ID. "');\r\n";
    }
    
    
}*/

unset($obDomain);
unset($obAccount);


?>

</body>
</html>