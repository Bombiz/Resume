<?php
require_once '../functions.php';
$App=GET_appdetails();
$Urls=GET_urls();
if(!isset($_SESSION['user']))
{
	//Application Configurations
	$app_id		= $App['AppID'];
	$app_secret	= $App['Secret'];
	$fbVersion	= "v2.0";
	$site_url	= $Urls['site'];

	try{
		include_once "src/facebook.php";
	}catch(Exception $e){
		error_log($e);
	}
	// Create our application instance
	$facebook = new Facebook(array(
		'appId'		=> $app_id,
		'secret'	=> $app_secret,
		'version'   => $fbVersion,
		));

	// Get User ID
	$user = $facebook->getUser();
	// We may or may not have this data based 
	// on whether the user is logged in.
	// If we have a $user id here, it means we know 
	// the user is logged into
	// Facebook, but we don’t know if the access token is valid. An access
	// token is invalid if the user logged out of Facebook.
	//print_r($user);
	if($user){
		// Get logout URL
		$logoutUrl = $facebook->getLogoutUrl();
	}else{
		// Get login URL
		$loginUrl = $facebook->getLoginUrl(array(
			'scope'			=> 'email',
			'redirect_uri'	=> $site_url,
			));
	}

	if($user){

		try{
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
		$DB=DB_info();

		$conn = DB_connection($DB['db_host'], $DB['db_user'], $DB['db_pass'], $DB['db_name']);
		$first_name = $user_profile['first_name'];
		$middle_name = $user_profile['middle_name'];
		$last_name = $user_profile['last_name'];
		$email = $user_profile['email'];
		$link =  $user_profile['link']; 
		$locale =  $user_profile['locale']; 
		$timezone =  $user_profile['timezone']; 
		setcookie('cookie1',$first_name);
		setcookie('cookie2',$last_name);
		$gender = $user_profile['gender'];
		$sqlselect = "SELECT * FROM ".$DB['db_table']." WHERE email = :email";
		$stmnt=$conn->prepare($sqlselect);
		$stmnt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmnt->execute();

		$table = $DB['db_table'];
		$mobile = 1;
		if($stmnt->rowCount() <= 0)
		{

			$insertsql = "INSERT INTO $table (first_name, last_name, email, gender, link, locale, timezone, mobile) 
			VALUES ( :first_name, :last_name, :email, :gender, :link, :locale, :timezone, :mobile)";
			$insertstmnt=$conn->prepare($insertsql);
			$params = array (
                            ':first_name' => $first_name,
                            ':last_name' => $last_name,
                            ':email' => $email,
                            ':gender' => $gender,
                            ':link' => $link,
                            ':locale' => $locale,
                            ':timezone' => $timezone,
                            ':mobile' => $mobile
            );
			$insertstmnt->execute($params);
			$_SESSION['user'] = $user_profile['email'];
			$_SESSION['id'] = $first_name;

		}
		else
		{
			$row = $stmnt->fetch();
			$_SESSION['user'] = $row['email'];
			$_SESSION['id'] = $user_profile['id'];
		}
		}catch(FacebookApiException $e){
				error_log($e);
				$user = NULL;
			}

	}

}
?>