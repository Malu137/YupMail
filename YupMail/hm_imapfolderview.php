
<?php
    if (! function_exists('imap_open')) {
        echo "IMAP is not configured.";
        exit();
    } else {
        ?>
        <link rel="stylesheet" type="text/css" href="style_mailView.css">


        <style>
        .alertg {
  padding: 10px;
  background-color: #6decb9;
  color: white;
  margin-bottom: 15px;
  width:40%;
}

/* The close button */
.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

/* When moving the mouse over the close button */
.closebtn:hover {
  color: black;
}
        </style>
        
    <?php

        $MailFolderName = hmailGetVar("imapfolderName","");
		//The location of the mailbox.
		$mailbox = '{imap.yup.mail:143/imap}'.$MailFolderName;
		//The username / email address that we want to login to.
		$username =  $_SESSION['session_username'];
		//The password for this email address.
        $password = $_SESSION['session_password'];
        $alert = hmailGetVar("alert","");
        
        if($alert=='1'){
            ?>
            <div align="center">
            <div class="alertg">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        Mail has been Sent.
</div>
<div>
            
            <?php
        }
        elseif($alert=='2')
        {
            ?>
            <div align="center">
            <div class="alertg">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        Message saved to Drafts.
</div>
<div>
            
            <?php

        }

 
		//Attempt to connect using the imap_open function.
		$connection = imap_open($mailbox, $username, $password)or die('Cannot connect to Yup Mail: ' . imap_last_error());
   
        /* Search Emails having the specified keyword in the email subject */
        $emailData = imap_search($connection, "ALL");
        
        
        if (! empty($emailData)) {
            ?>
    <table>
        <tr>
            <td>
            <div align ="right">
            <p style="font-size:30px;"><?php echo $MailFolderName ;?></p>
        </div>    
        </td>
            <td>
    <div align="right" >
    <form action="<?php echo $hmail_config['rooturl'];?>index.php?page=searchmail&imapfolderName=<?php $MailFolderName ?>" method="POST" onSubmit="return formCheck(this);" name= "mainform" >
    <?php 
    PrintHiddenCsrfToken();
    PrintHidden("page", "hm_searchmail"); ?>
    <input name="searchmail" type="text" placeholder="Type here">
    <input id="submit" type="submit" value="Search">
    </form>
    </div>
        </td>
        </tr>
        </table>
    <br>

    <div id="listData" class="list-form-container">
    
    <table>
            
        <?php



            foreach ($emailData as $emailIdent) {
                
                $overview = imap_fetch_overview($connection, $emailIdent,0);
                $date = date("d F, Y", strtotime($overview[0]->date));
                $flag = $overview[0]->seen ;
                $MsgUID = $overview[0]->uid;

    

                ?>
        <tr class="mailrow<?php echo $flag;?>"> 
                <td>
                

                    <?php 
                    if ($flag == 1){
                        ?>
                         <img src="images/mail_opened.png" height=30px >
                        <?php

                    }
                    else {
                        ?>
                        <img src="images/mail_unopened.png" height = 30px>
                        <?php
                    }
                    ?>

                </td>
            <td> <span class = "mailcolumn">
            
                    <?php echo $overview[0]->from; ?> 
            </span>  </td>
            <td>
                <?php echo $overview[0]->to; ?>
            </td>
            <td class ="mailcontent-div"><span class ="column">
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
            
            <a href ="<?php echo $hmail_config['rooturl']?>index.php?page=compose_mail&action=reply&uid=<?php echo $MsgUID?>&imapfolderName=<?php echo $MailFolderName;?>">
            Reply 
            </a>

            </td>

            
        </tr>
        <?php
            } // End foreach
            ?>
    </table>

    
    <?php
        } // end if
        
        imap_close($connection);
    }
    ?>
</div>
