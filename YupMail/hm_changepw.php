<?php
if (!defined('IN_WEBADMIN'))
    exit();
    ?>

<form method = 'POST' action ="<?php echo $hmail_config['rooturl']; ?>index.php" onSubmit="return formCheck(this);" name= "mainform">
	<?php
		PrintHiddenCsrfToken();
      	PrintHidden("page", "background_changepw");

        $errorPW = hmailGetVar("errorpw","");
        if($errorPW =='1')
        {
            echo "Incorrect Password";
        }
        elseif ($errorPW =='2')
        {
            echo "New Password doesnot match";
        }
        elseif($errorPW =='3')
        {
            echo "Password changed";
        }
        elseif($errorPW =='4')
        {
            echo "New Password should be different.";
        }

       ?>
       
    <table>
        <tr>
            <td>
            <ul>Enter Current Password :</ul>
            </td>
            <td>
            <ul><input type="password" name="cPassword" size="25" maxlength="256" value =""/></ul>
            </td>
        </tr>
        <tr>
            <td>
            <ul> Enter New Password :</ul>
            </td>
            <td>
            <ul><input type="password" name="newPassword1" size="25" maxlength="256" value =""/></ul>
            </td>
        </tr>
        <tr>
            <td>
            <ul>Confirm New Password :</ul>
            </td>
            <td>
            <ul><input type="password" name="newPassword2" size="25" maxlength="256" value =""/></ul>
            </td>
        </tr>
        <tr>
        <td>
        <input type="submit" name="sub" size="25" maxlength="256" value ="Set"/>
        </td>
        </tr>
    </table>
</form>