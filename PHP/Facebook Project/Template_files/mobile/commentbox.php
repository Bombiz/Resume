<?php 
require_once '../functions.php';
$App=GET_appdetails(); 
$Urls=GET_urls();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<meta charset="UTF-8">
<meta name="viewport" content="user-scalable=0, initial-scale = 1.0,maximum-scale = 1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<head>
	<title>MTLARABAIS - Concours 1 an de resto gratuit !</title>

	<style type="text/css">
		html, body {margin:0;}
	</style>

</head>
<body>
	<div id="fb-root"></div>
	<script src="http://connect.facebook.com/fr_FR/sdk.js"></script>
	<script type="application/x-javascript">
		addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);

		function hideURLbar(){
			window.scrollTo(0,1);
		};

		window.fbAsyncInit = function() {
			FB.init({
				appId      : <?php echo $App['AppID']; ?>, 
				version    : 'v2.0',                       
				status     : true,                                 
				xfbml      : true,
				oauth      : true                            
			});

			
			FB.Event.subscribe('comment.create', function(response) {
				console.log("test");
				top.window.location = 'like.php';
			});     
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.com/fr_FR/sdk.js#xfbml=1&appId="+<?php echo $App['AppID']; ?>;
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
	</script>

	<img  align="center" src=<?php echo $Urls['site']."images/comment.jpg";?> width="100%" >
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.com/fr_FR/sdk.js#xfbml=1&appId="+<?php echo $App['AppID']; ?>;
		fjs.parentNode.insertBefore(js, fjs);

		
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-comments" data-href=<?php echo $Urls['site'].'commentbox.php'; ?> data-width="470" data-num-posts="2" order_by="reverse_time" mobile="yes"></div>
</body>
</html>