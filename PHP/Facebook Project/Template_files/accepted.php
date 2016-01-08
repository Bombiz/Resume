<?php 
require_once 'facebook.php';
require_once 'functions.php';
$App=GET_appdetails();
$Mods=GET_moderators();
$Urls=GET_urls();
$title=GET_title();

$facebook = new Facebook(array(
	'appId' => $App['AppID'],
	'secret' => $App['Secret'],
	'cookie' => true,
	));
try{
	/*Post's a status message to the current user's feed */
	$facebook->api('/me/feed', 'post', array(
		'message' => $App['message'],
		'name' => $App['name'],
		'description' => $App['description'],
		'caption' => $App['caption'],
		'picture' => $App['picture'],
		'link' => $App['link'].$App['AppID'],));
} catch (Exception $e) {

}	
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

	<title><?php echo $title ?></title>

	<!-- FB MODERATORS -->
	<meta property="fb:admins" content="{"<?php echo $Mods[0]; ?>"}"/>
	<meta property="fb:admins" content="{"<?php echo $Mods[1]; ?>"}"/>
	<meta property="fb:admins" content="{"<?php echo $Mods[2]; ?>"}"/>
	<meta property="fb:admins" content="{"<?php echo $Mods[3]; ?>"}"/>
	<!-- FB MODERATORS -->

	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<link rel="stylesheet" href="css/style.css" />
</head>

<body>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.com/fr_FR/sdk.js#xfbml=1&appId="+<?php echo $App['AppID']; ?>;
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

</script>

<div class="container" id="accepted">
	<table width="810" border="0" cellspacing="0" cellpadding="0">
	<tr>	<div class="liked_fb"><div class="fb-like" data-href=<?php echo $Urls['page']; ?> data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div></div>
	</tr>
		<tr>
			<td width="810" height="213" colspan="3"><img src="IMG/accepted_header.jpg" width="810" height="213" /></td>
		</tr>
		<tr>
			<td width="477" height="40"><img src="IMG/accepted_01.jpg" width="477" height="40" /></td>
			<td width="175" height="40" class="btn_invitez"></td>
			<td width="158" height="40"><img src="IMG/accepted_02.jpg" width="158" height="40" /></td>
		</tr>
		<tr>
			<td width="810" height="383" colspan="3"><img src="IMG/accepted_footer.jpg" width="810" height="383" /></td>
		</tr>
	</table>


	<div class="reglements">
		<p><a href=<?php echo $Urls['reglements'] ?> target="_blank">Règlements</a></p>
	</div>

	

	<div class="fb-comments" notify="true" data-href=<?php echo $Urls['smart'] ?> data-width="300" data-num-posts="3" order_by="reverse_time"></div>
	<div id="fb-root"></div>
</div>
<script src="//connect.facebook.com/fr_FR/sdk.js"></script>
<script>

	window.fbAsyncInit = function() {
		FB.init({
			appId: <?php echo $App['AppID'] ?>,
			version: 'v2.0',
			status : true,
			xfbml  : true, 
			cookie : true,
			oauth  : true
		});
		FB.Canvas.setAutoGrow();
		$('.btn_invitez').click(function() {

			FB.ui({method: 'apprequests',
				message: 'Invite tes amis à participer au concours pour augmenter tes chances de gagner !'
			});

			 
		});
		FB.Event.subscribe('comment.create', function(response) {
				window.location = 'merci.php';
			}); 
	};

</script>

</body>
</html>