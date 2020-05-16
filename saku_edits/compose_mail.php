<!DOCTYPE html>
<html>
<head>
	<title>Compose Email</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="compose_mail.css">
</head>
<body>
<div class="compose-mail">
	<h3 style="color: #000; margin: 10px;">Compose Email</h3>
    <form action="#">
	<p style="margin-top: 30px; margin-left: 10px; font-size: 20px;">To : </p>
	<input type="Email" name="email" class="input-email" placeholder="Enter Receipant's Email">
	<p style="margin-top: 15px; margin-left: 10px;font-size: 20px;">Subject : </p>
	<input type="text" name="subject" class="input-email" placeholder="Write Subject">
	<p style="margin-top: 15px; margin-left: 10px;font-size: 20px;">Message: </p>
	<textarea rows="8" cols="128" style="border: 1px solid; border-color: grey; border-top: 1px solid; margin-left: 10px; margin-bottom: 20px;"></textarea>

	<div style="margin : auto; width: 50%; text-align: center;">
		<button class="btn btn-primary" type="submit" style="background-color: #000; padding: 3%; margin-right: 20px;" name="#">Save as draft</button>
		<button class="btn btn-primary" type="submit" name="#" style="padding: 3%;">Send</button>
	</div>
	</form>
	

	
	
</div>
</body>
</html>