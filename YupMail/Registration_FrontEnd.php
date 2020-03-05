
Chandralekha Srinivasan 

Mon, Feb 24, 9:13 PM (20 hours ago)



to me 






<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>SignUp</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-image: url('bgg.jpg'); background-size: cover">
  <div class="header">
   <h2>Register</h2>
  </div>
 
  <form method="post" action="register.php">
   <?php include('errors.php'); ?>
   <div class="input-group">
     <label>Username</label>
     <input type="text" name="username" value="<?php echo $username; ?>">
   </div>
   <div class="input-group">
     <label>Email</label>
     <input type="email" name="email" value="<?php echo $email; ?>">
   </div>
   <div class="input-group">
     <label>Password</label>
     <input type="password" name="password_1">
   </div>
   <div class="input-group">
     <label>Confirm password</label>
     <input type="password" name="password_2">
   </div>
   <div class="input-group">
     <button type="submit" class="btn" name="reg_user">Register</button>
   </div>
   <p>
    Already a member? <a href="login.php">Sign in</a>
   </p>
  </form>
</body>
</html>

