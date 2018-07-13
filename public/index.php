<?php
	include_once '../sys/core/init.inc.php';
?>

<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="theme-color" content="#1d263b">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=no">
	    <title></title>
	    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="css/global/global.css">   
	</head>

	<body>
		<section id="root"></section>
		
		<input id="session-token" type="hidden" value="<?php echo $_SESSION['token']; ?>"/>
		<input id="login-token" type="hidden" value="<?php if(!isset($_SESSION['company']['id']) || !isset($_SESSION['company']['email']) || !isset($_SESSION['company']['name'])) {echo 'false';} else {echo 'true';} ?>"/>

		<script src="js/home.js"></script>
	</body>
</html>