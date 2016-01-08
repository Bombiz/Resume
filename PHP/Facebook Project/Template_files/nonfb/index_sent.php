<?php
	require("../functions.php");
	require_once("../../../../smarty/libs/Smarty.class.php");
	$DB=DB_info();
	$URLs=GET_urls();
    $table=$DB['db_table'];
    $skipped=false;
    $mySmarty = new Smarty();                       //initizize smarty template
	$mySmarty->setTemplateDir("templates");         //select template directory
	$mySmarty->setCompileDir("templates_c");        //select compile directory
	if (!isset($_POST["email"])) {
		$valid_forum="no";
		$skipped=true;
		$mySmarty->assign('skipped', $skipped);
		$mySmarty->display("nonfb_index.html");
		exit();
	}
	
	$send =  isset($_GET['send']) ? $_GET['send']: "";
	$incomplet_last_name="";
	$incomplet_first_name="";
	$incomplet_email="";
	$valid_forum = "no";	
	
	if($send=="yes"){
		$last_name =  $_POST["last_name"];
		$first_name = $_POST["first_name"];
		$email = $_POST["email"];

		if (GET_telephone()) 
			$telephone = $_POST['telephone'];
		
		$validation_mail = "";
		$conn = DB_connection($DB['db_host'], $DB['db_user'], $DB['db_pass'], $DB['db_name']);

		$sqlselect = "SELECT email FROM ".$table." WHERE email = :email";
		$stmnt=$conn->prepare($sqlselect);
		$stmnt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmnt->execute();

		if ($stmnt->fetch()) 
			$validation_mail = "no";
		
		if($last_name==""){
			$incomplet_last_name="<br/><span class='warning'>Last name can't be blank</span>";
		}else
		{
			$field_last_name = $last_name;
			$last_name_ok="yes";
		}

		if (GET_telephone()) {
			$tely=true;
			if(preg_match("/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/", $telephone)){
				$field_telephone = $telephone;
				$telephone_ok="yes";
			}else {
				$incomplet_telephone = "<br/><span class='warning'>Telephone can't be blank</span>";
			}
		}

		if($first_name==""){
			$incomplet_first_name="<br/><span class='warning'>First name can't be blank</span>";
		}
		else
		{
			$field_first_name = $_POST["first_name"];
			$first_name_ok="yes";
		}

		if($email==""){
			$incomplet_email="<br/><span class='warning'>Email can't be blank</span>";
		}
		elseif ($validation_mail == 'no') {
			$incomplet_email="<br/><span class='warning'>Email already in use</span>";
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			   $incomplet_email="<br/><span class='warning'>Invalide Email</span>";
			}
		else{
			$field_email = $_POST["email"];
			$email_ok ="yes";
		}

		if($last_name_ok==="yes" & $first_name_ok=="yes" & $email_ok =="yes")
		{
			$non_fb=1;
			if (GET_telephone()) {
				if($telephone_ok =="yes"){
					$insertsql = "INSERT INTO $table (first_name, last_name, email, telephone, non_fb) 
					VALUES ( :first_name, :last_name, :email, :telephone, :non_fb)";
					$insertstmnt=$conn->prepare($insertsql);
					$params = array (
	                                ':first_name' => $first_name,
	                                ':last_name' => $last_name,
	                                ':email' => $email,
	                                ':telephone' => $telephone,
	                                ':non_fb' => $non_fb
	                );
					$insertstmnt->execute($params);
				}
			}
			else
			{    
				$insertsql = "INSERT INTO $table (first_name, last_name, email, non_fb) 
				VALUES ( :first_name, :last_name, :email, :non_fb)";
				$insertstmnt=$conn->prepare($insertsql);
				$params = array (
	                            ':first_name' => $first_name,
	                            ':last_name' => $last_name,
	                            ':email' => $email,
	                            ':non_fb' => $non_fb
	            );
				$insertstmnt->execute($params);
			}
			$valid_forum="yes";
		}	
	}else{
		$field_last_name="";
		$field_first_name="";
		$field_email="";
	}

if($valid_forum == "no")
{
	$visitez = $URLs['visitez'];
	$mySmarty->assign('skipped', $skipped);
	$mySmarty->assign('valid_forum', $valid_forum);
	$mySmarty->assign('incomplet_first_name', $incomplet_first_name);
	$mySmarty->assign('incomplet_last_name', $incomplet_last_name);
	$mySmarty->assign('incomplet_telephone', $incomplet_telephone);
	$mySmarty->assign('incomplet_email', $incomplet_email);
	$mySmarty->assign('field_first_name', $field_first_name);
	$mySmarty->assign('field_telephone', $field_telephone);
	$mySmarty->assign('field_last_name', $field_last_name);
	$mySmarty->assign('field_email', $field_email);
	$mySmarty->assign('visitez',$visitez);
	$mySmarty->assign('tely', $tely);
	
	$mySmarty->display("nonfb_index.html");
}
else
{
	$mySmarty->assign('tely', $tely);
	$mySmarty->assign('valid_forum', $valid_forum);
	$mySmarty->assign('skipped', $skipped);
	$mySmarty->display("nonfb_index.html");	
}

mysqli_close($conn);


?>

