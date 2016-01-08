<?php 
require_once 'functions.php'; 
$App=GET_appdetails();
$Urls=GET_urls();
$title=GET_title();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

<title><?php echo $title ?></title>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/style.css" />
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
</head>

<body id="merci">
	<div class="visitez">
			<h3><b>Merci</b> d’avoir participé ! <br />
		Les gagnants du concours
		seront dévoilés le :</h3>
		<h4>7 Avril 2015</h4>
		<a href=<?php echo $Urls['visitez'] ?> target="_blank"><div class="visitez-btn"></div></a>
		<h3>mtlarabais.com</h3>
	</div>
<div class="reglements">
	<p><a href=<?php echo $Urls['reglements'] ?> target="_blank">Règlements</a></p>
</div>

<div id="fb-root"></div>
<script src="//connect.facebook.net/en_US/all.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

window.fbAsyncInit = function() {
			FB.init({
				appId: <?php echo $App['AppID'] ?> ,
				version: 'v2.0',
				status : true,
				xfbml  : true, 
				cookie : true,
				oauth  : true
			});
			FB.Canvas.setSize({height:600});
			setTimeout("FB.Canvas.setAutoGrow()",500);
		}

$('.btn_visitez').click(function() {
   window.open(<?php echo $Urls['visitez'] ?>);
      });

</script>

</body>
</html>