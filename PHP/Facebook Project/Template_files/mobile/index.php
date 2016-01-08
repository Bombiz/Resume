<?php
include_once "fbconnect.php";
require_once '../functions.php';
$Urls=GET_urls();
$App=GET_appdetails();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<meta charset="UTF-8">
<meta name="viewport" content="user-scalable=0, initial-scale = 1.0,maximum-scale = 1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />

<script type="text/javascript" src="jquery-1.9.0.min.js"></script>

<head>
	<title>MTLARABAIS - Concours 1 an de resto gratuit !</title>

	<style>
		body {margin:0; padding:0;}
		html {margin:0; padding:0;}
		a {outline:none; text-decoration:none;}
		img {display:block;}
		.container {width:100%; max-width:640px; height:auto; margin:0 auto;}

	</style>

</head>
<body>
	<script type="application/x-javascript">
		addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);

		function hideURLbar(){
			window.scrollTo(0,1);
		};
	</script>

	<?php 
	if(isset($_SESSION['id'])) { 
		session_start();
		session_unset();
		session_destroy();
	} 

if(!isset($_SESSION['user'])) {

	?>
	<div class="container">
		<img src="images/participez_header.jpg" width="100%">
		<a href='<?php echo $loginUrl ?>'>
			<img src="images/participez_bouton.jpg" width="100%">
		</a>
		<a href=<?php echo $Urls['non_FB'] ?> target="_blank">
			<img src="images/participez_bouton_nonfb.jpg" width="100%">
		</a>
	</div>

	<?php } else { 

		// $DB=DB_info();

		// $conn = DB_connection($DB['db_host'], $DB['db_user'], $DB['db_pass'], $DB['db_name']);


		// $email = GetSQLValueString($_SESSION['user'], "text");
		// $query = sprintf("SELECT * FROM mobile WHERE email = %s",$email);
		// $res = mysql_query($query) or die('Query failed: ' . mysql_error() . "<br />
		// 	\n$sql");
		// $row = mysql_fetch_array($res);
		// mysqli_close($conn);
	}?> 

	<?php
	if ($user) {
		try {
			$likes = $facebook->
			api("/v2.0/me/likes/".$App['AppID']);
			if( !empty($likes['data']) )
				echo "
			<meta http-equiv=\"refresh\" content=\"0;URL=commentbox.php\"> 
			";
			else
				echo "
			<meta http-equiv=\"refresh\" content=\"0;URL=commentbox.php\">
			";
		} catch (FacebookApiException $e) {
			error_log($e);
			$user = null;
		}
	}
	?>
</body>
</html>