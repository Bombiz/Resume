<?php
require_once 'facebook.php';
require_once 'functions.php';
$App=GET_appdetails();
$Urls=GET_urls();
$title=GET_title();
$tel='yes';
// check si la app a été acceptée deja...
$facebook = new Facebook(array(
	'appId' => $App['AppID'],
	'secret' => $App['Secret'],
	'cookie' => true,            //enable cookies to allow the server to access the session
	));

try {
	$me = $facebook->api('/me');
} catch (FacebookApiException $e) {
	error_log($e);
} 
if ($facebook->getSession()) { 
	echo "<script>location.href = 'accepted.php'</script>";         //load accepted
} 

$send =  isset($_GET['send']) ? $_GET['send']: "";

$validation = "non";
$DB=DB_info();
$conn = DB_connection($DB['db_host'], $DB['db_user'], $DB['db_pass'], $DB['db_name']);

if($send=="yes"){
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];;
	if (GET_telephone()) 
		$telephone = $_POST['telephone'];
	$email = $_POST ['email'];
	$error_telephone = false;

	$full_name = (isset($_POST['full_name'])) ? $_POST['full_name'] : '';
	$link = (isset($_POST['link'])) ? $_POST['link'] : '';
	$gender = (isset($_POST['gender'])) ? $_POST['gender'] : '';
	$locale = (isset($_POST['locale'])) ? $_POST['locale'] : '';
	$timezone = (isset($_POST['timezone'])) ? $_POST['timezone'] : '';

	if($first_name=="" || $first_name==" "){
		  $error_firstname = true;
	}else {
		$valid_prenom = "yes";
	}
	if($last_name=="" || $last_name==" "){
		$erreur_nom = true;
	}else {
		$valid_nom = "yes";
	}
	if (GET_telephone()) {
		if(preg_match("/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/", $telephone)){
			$valid_telephone = "yes";
		}else {
			$error_telephone = true;
		}
    }

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){   //filter out bad emails                   
		$erreur_email = true;
	}
	
	else{
		$courriel_ok ="yes";
	}

	if($valid_nom=="yes" && $valid_prenom=="yes" && $courriel_ok=="yes")
	{
		$DB=DB_info();
		$table=$DB['db_table'];
		$conn = DB_connection($DB['db_host'], $DB['db_user'], $DB['db_pass'], $DB['db_name']);
		$sqlselect = "SELECT email FROM ".$table." WHERE email = :email";
		
		$stmnt=$conn->prepare($sqlselect);
		
		$stmnt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmnt->execute();
		// $result = $stmnt->fetch();
		// var_dump($result);
		if ($stmnt->fetch()) 
		{
			?><script type="text/javascript">
			alert("L'adresse courriel <?php echo $_POST['email']; ?> a d\351j\340 \351t\351 utilis\351e... SVP utilisez une autre adresse.");
			location.href = 'index.php'
			</script>
			<?php return;
		}

        $desktop=1;
		if (GET_telephone()) {
			// var_dump($error_telephone);
			// exit();
			if(!$error_telephone)
			{

				$insertsql = "INSERT INTO $table (first_name, last_name, email, telephone, gender, link, locale, timezone, desktop) 
				VALUES ( :first_name, :last_name, :email, :telephone, :gender, :link, :locale, :timezone, :desktop)";
				$insertstmnt=$conn->prepare($insertsql);

				$params = array (
                                ':first_name' => $first_name,
                                ':last_name' => $last_name,
                                ':email' => $email,
                                ':telephone' => $telephone,
                                ':gender' => $gender,
                                ':link' => $link,
                                ':locale' => $locale,
                                ':timezone' => $timezone,
                                ':desktop' => $desktop
                );
				$insertstmnt->execute($params);
				echo "<script>location.href = 'accepted.php'</script>"; //load accepted
			}
		}
		else
		{
            $insertsql = "INSERT INTO $table (first_name, last_name, email, gender, link, locale, timezone, desktop) 
			VALUES ( :first_name, :last_name, :email, :gender, :link, :locale, :timezone, :desktop)";
			$insertstmnt=$conn->prepare($insertsql);

			$params = array (
                		  ':first_name' => $first_name,
                          ':last_name' => $last_name,
                          ':email' => $email,
                          ':gender' => $gender,
                          ':link' => $link,
                          ':locale' => $locale,
                          ':timezone' => $timezone,
                          ':desktop' => $desktop
            );
			$insertstmnt->execute($params);

			// $insertsql = "INSERT INTO $table (first_name, last_name, email, gender, link, local, timezone, desktop) VALUES ( ?,?,?,?,?,?,?,?)"; 
			// $insertstmnt=$conn->prepare($insertsql);
			// $insertstmnt->bind_param("sssssssi", $first_name, $last_name, $email, $gender, $link, $local, $timezone, $desktop);
			// $insertstmnt->execute();
			// $insertstmnt->close();
			echo "<script>location.href = 'accepted.php'</script>"; //load accepted
		}

	}
		
	

}


?>

<!DOCTYPE html>
<html>
<head>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link rel="stylesheet" href="css/style.css">

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/png" href="IMG/favicon.png"/>
	<title><?php echo $title ?></title>
</head>

<body>
	
	<div align="center" class="tel_container">
		<?php if($validation == "non"){ ?>
		<div class="fb_btn_new"></div>
		<form class="form_new" id="tel_form2" method="POST" action="index.php?send=yes">
			<div>
				<fieldset class="field_prenom">
					<input class="first_name <?php echo ($error_firstname) ? "warning_red" : "" ?>" name="first_name" type="text" value="<? echo  $me['first_name']; ?>" />
					<div class="warning_nom">
						<?php echo ($error_firstname) ? "Prenom invalide" : "" ?>
					</div>
				</fieldset>
				<fieldset class="field_name">
					<input class="last_name <?php echo ($erreur_nom) ? "warning_red" : "" ?>" name="last_name" type="text" value="<? echo $me['last_name']; ?>" />
					<div class="warning_nom">
						<?php echo ($erreur_nom) ? "Nom invalide" : "" ?>
					</div>
				</fieldset>
				<!-- if they want the telephone -->
				<?php if(GET_telephone()) { ?>	
				<fieldset class="field_telephone">
					<input class="telephone <?php echo ($error_telephone) ? "warning_red" : "" ?>" name="telephone" type="text" value="<? echo  $me['telephone']; ?>" />
					<div class="warning_telephone">
						<?php echo ($error_telephone) ? "Numéro de Téléphone" : "" ?>
					</div>
				</fieldset>						
				<?php } ?>
				<fieldset class="field_email">
					<input class="email <?php echo ($erreur_email) ? "warning_red" : "" ?>" name="email" id="email" type="text" value="<? echo $me['email']; ?>" />
					<div class="warning_email">
						<?php echo ($erreur_email) ? "Courriel invalide" : "" ?>
					</div>
				</fieldset>
				
				<input class="btn_suivant" type="submit">
				<input class="name" type="hidden" name="full_name" value="<?php echo (isset($me['name'])) ? $me['name'] : "" ?>"/>
				<input class="gender" type="hidden" name="gender" value="<?php echo (isset($me['gender'])) ? $me['gender'] : "" ?>"/>
				<input class="link" type="hidden" name="link" value="<?php echo (isset($me['link'])) ? $me['link'] : "" ?>"/>
				<input class="locale" type="hidden" name="locale" value="<?php echo (isset($me['local'])) ? $me['local'] : "" ?>"/>
				<input class="timezone" type="hidden" name="timezone" value="<?php echo (isset($me['timezone'])) ? $me['timezone'] : "" ?>"/>


				<p class="no-fb"><a href=<?php echo $Urls['non_FB'] ?> target="_blank">Je n'ai pas Facebook</a></p>
			</div>
		</form>
		<div class="reglements">
			<p><a href=<?php echo $Urls['reglements'] ?> target="_blank">Règlements</a></p>
		</div>
	</div>

	<?php } ?>

	<div id="fb-root"></div> 
	<script src="https://connect.facebook.com/fr_FR/sdk.js"></script> 

	<script>	
		window.fbAsyncInit = function() {
			FB.init({
				appId: <?php echo $App['AppID'] ?>,
				version: 'v2.2',
				status : true,
				xfbml  : true, 
				cookie : true,             //enable cookies to allow the server to access the session
				oauth  : true
			});



			/*facebook login button.*/
			$('.fb_btn_new').click(function() {		//on click
				FB.login(function(response) {

					if (response.authResponse) {
						console.log('Welcome!  Fetching your information.... ');
				  /*console.log(response); // dump complete info*/
				  access_token = response.authResponse.accessToken; //get access token
				  user_id = response.authResponse.userID; //get FB User ID

				  FB.api('/me', function(response) {	//getting all the user's public information
					user_first = response.first_name; //get user first_name
					user_last = response.last_name;   //get user last_name
					user_email = response.email;      //get user email 			(returns '******@*****.com')
					name = response.name;             //get user full name 		(returns 'bob edger smith')
					gender = response.gender;         //get user gender 		(returns 'male')
					link = response.link;             //get user profile link 	(returns 'https://www.facebook.com/app_scoped_user_id/[user_id]/')
					locale = response.locale;         //get user location 		(returns 'en_US')
					timezone = response.timezone;     //get user time zone 		(returns '-5')
					 // console.log(response); // dump complete info

				/* storing these values into hidden feilds 
				   so that we can store them in the database */ 
				$('input.first_name').val(user_first); 
				$('input.last_name').val(user_last);  
				$('input.email').val(user_email);
				$('input.name').val(name);
				$('input.gender').val(gender); 
				$('input.link').val(link); 
				$('input.locale').val(locale); 
				$('input.timezone').val(timezone);        
			});


				} else {
				  //user hit cancel button
				  console.log('User cancelled login or did not fully authorize.');

				}
			}, {
				scope: 'email'
			});


			});

		}

	</script>
</body>
</html>