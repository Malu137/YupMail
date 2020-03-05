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
$dtree .= "d.add(" . $dtitem++ .",0,'" . $accountaddress . "','','','','" . "images/user.png','" . "images/user.png');\r\n";


$IMAPFolderList = array("Inbox", "Drafts", "Sent", "Trash");

foreach ($IMAPFolderList as &$Item) {
    try{
        $obIMAPFolder = $obIMAPFolders->ItemByName($Item);
        $IMAPFolderName = $obIMAPFolder->Name;
        $IMAPFolderDBID = $obIMAPFolder->ID;
        $urlIMAP = htmlentities("index.php?page=imapfolderview&imapfolderindex=".$IMAPFolderDBID);
        $dtree .= "d.add(" . $dtitem++ .",1,'" . GetStringForJavaScript("$IMAPFolderName") . "','$urlIMAP','','','" . "images/user.png','" . "images/user.png');\r\n";    
    }
    catch(Exception $e){

    }

    //$value = $value * 2;
}


$urlEP = htmlentities("index.php?page=profile");
//&action=view&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID);
$dtree .= "d.add(" . $dtitem++ .",1,'" . GetStringForJavaScript("View Profile") . "','$urlEP','','','" . "images/user.png','" . "images/user.png');\r\n";

$urlcp = htmlentities("index.php?page=changepw");
$dtree .= "d.add(" . $dtitem++ .",1,'" . GetStringForJavaScript("Change Password") . "','$urlcp','','','" . "images/user.png','" . "images/user.png');\r\n";

$urlCom = htmlentities("index.php?page=compose");
//&action=edit&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID);
$dtree .= "d.add(" . $dtitem++ .",0,'" . GetStringForJavaScript("Compose Mail") . "','$urlCom','','','" . "images/user.png','" . "images/user.png');\r\n";

$urlCom = htmlentities("index.php?page=addressbk");
//&action=edit&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID);
$dtree .= "d.add(" . $dtitem++ .",0,'" . GetStringForJavaScript("View Addressbook") . "','$urlCom','','','" . "images/user.png','" . "images/user.png');\r\n";

$dtree .= "d.add(" . $dtitem++ .",-1,'" . GetStringForJavaScript("Logout") . "','logout.php','" . "" ."');\r\n";

$dtree .= "document.write(d);";
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