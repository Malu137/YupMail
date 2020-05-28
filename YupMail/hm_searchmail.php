<?php
if (!defined('IN_WEBADMIN'))
exit();


    $MailFolderName = hmailGetVar("imapfolderName","");
    $mailbox = '{imap.yup.mail:143/imap}'.$MailFolderName;
    $username =  $_SESSION['session_username'];
    $password = $_SESSION['session_password'];

    $words = hmailGetVar("searchmail","");
    //var_dump($words);
    if($words==""){
        Echo("You have not entered a valid search");
    }
    else{
    try{
        $connection = imap_open($mailbox, $username, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
        //var_dump($words);
        //echo('SUBJECT "'.$words.'"');
        $match = imap_search($connection, 'SUBJECT "'.$words.'"', SE_UID);
        //var_dump($match);
        
    }
    catch(Exception $e)
    {
        Echo("Unable to search");
    }
    
    if(!$match)
    {
        echo("No Matches Found.");
    }
    else 
    {
?>
<link rel="stylesheet" type="text/css" href="style_mailView.css">
<div id="listData" class="list-form-container">
<table>
<?php
            for ($i = 0; $i < sizeof($match); $i++) {
                
                $overview = imap_fetch_overview($connection, $match[$i],FT_UID);
                $date = date("d F, Y", strtotime($overview[0]->date));
                $flag = $overview[0]->seen ;
                $MsgUID = $overview[0]->uid;
                ?>
       <tr> 
            <td> <span class = "mailcolumn">
            
                    <?php echo $overview[0]->from; ?> 
            </span>  </td>
            <td>
                <?php echo $overview[0]->to; ?>
            </td>
            <td class ="mailcontent-div>"><span class ="column">
            <a href ="<?php echo $hmail_config['rooturl']?>index.php?page=openmail&uid=<?php echo $MsgUID?>&imapfolderName=<?php echo $MailFolderName;?>">        
            <?php echo $overview[0]->subject;?></a>
            </span>
            <span class ="maildate">
                    <?php echo $date; ?>
            </span>
            </td>
            
            <td>
            <a href ="<?php echo $hmail_config['rooturl']?>index.php?page=deletemail&uid=<?php echo $MsgUID?>&imapfolderName=<?php echo $MailFolderName;?>">
            Delete 
            </a>
            </td>
        </tr>
        <?php
            } 
            ?>

        </table>
        </div>
        <?php }
        imap_close($connection);
    }
        ?>