<?php

/*
Software Designer: Kombiz Khayami
Script Name: install.php
Company: NADdesign
Description:       
            script installs a facebook contest for a client. Gets info(the company name and date) from contest.php.
            All contests are orginized by the name of the company 
            if this is the company's first time making a contest with us then it creates a "MAIN" directory for all of that company's contest
================================================================================================================================================
*/
include 'classes.php';   							   //includes database classe for use in programm
require_once("smarty/libs/Smarty.class.php");          

$html='';                                              //html code holder
$success=false; 									   //successfull installation 
$mySmarty = new Smarty();                              //initizize smarty template
$mySmarty->setTemplateDir("smarty/templates");         //select template directory
$mySmarty->setCompileDir("smarty/templates_c");        //select compile directory

if(!isset($_POST['date']))
{
	$html = 'nothing to install.';
	$title = 'error';                                     	//set html page title
	$mySmarty->assign('html', $html);						//asign html php variable to smarty html variable
	$mySmarty->assign('title', $title);						
	$mySmarty->assign('success', $success);                 //Page returned an error 
	$mySmarty->display("install.html");						
	exit();
}

/*Handle Image Uploading first*/
foreach ($_FILES as $key => $value) {	
	/*
	$value['error'] gets the current upload error code for the file
	with 0 meaning there is no error.
	*/
	switch ($value['error']) 
	{
		case UPLOAD_ERR_INI_SIZE:
			$html.='Image/File size is too large. Maximum file size allowed: 2mb<br/>';
			break;
		case UPLOAD_ERR_FORM_SIZE:
			$html.='Image/File size is too large. Maximum file size allowed: 2mb<br/>';
			break;
		case UPLOAD_ERR_PARTIAL:
			$html.='The Image was only partialy uploaded. <br/>';
			break;
		case UPLOAD_ERR_NO_FILE:
			$html.='No file was selected for uploading <br/>';
			break;
		case UPLOAD_ERR_NO_TMP_DIR:
			$html.="Missing a temporary folder<br/>";
			break;
		case UPLOAD_ERR_CANT_WRITE:
			$html.="Failed to write file to disk<br/>";
			break;
		case UPLOAD_ERR_EXTENSION:
			$html.="File upload stopped by extension<br/>";
			break;
		case UPLOAD_ERR_OK:
		    $array[$key]=$_FILES[$key]["tmp_name"];
			break;
		default:
			$html.="Unkown upload error<br/>";
			break;
	}


}
if($html != '')
{
	$title = 'error';                                     	//get html page title
	$mySmarty->assign('html', $html);						//asign html php variable to smarty html variable
	$mySmarty->assign('title', $title);						//
	$mySmarty->assign('success', $success);                 //
	$mySmarty->display("install.html");
	exit();	
}



$a=explode('/', $_POST['date']);                       //'explode' splits string based variables on a provided delimiter. returns array

/*rearrange the date to format [yyyy_mm_dd]*/
$year=$a[2].'_';									   
$day=$a[1];											   
$month=$a[0].'_';
$date=$year.$month.$day;

$_POST['company'] = ($_POST['select']!='') ? $_POST['select'] : $_POST['company'] ; //was company name selected from combo-box 
																					//or was it typed in the input box?
$_POST['company']=strtolower($_POST['company']);	   //get company foldername

$folder_name=$date;                                    //get contest folder name [yyyy_mm_dd]
$main_dir='Template_files';							   //directory that holds all of the template files
if (!file_exists("FB_Contests")) {                     //make main contest directory if their isn't one alredy
	mkdir("FB_Contests");
}

if (file_exists("FB_Contests/".$_POST['company']."/".$folder_name)) {  						                 //if the contest we are trying to make already exists
	$html .= '<br>Company already has a contest for that date.<br> Please choose another date or company.';  //ask to change the date or company 
	$title = 'error';                                     												     //get html page title
	$mySmarty->assign('html', $html);																	     //asign html php variable to smarty html variable
	$mySmarty->assign('title', $title);																	     //
	$mySmarty->assign('success', $success);                                                                  //
	$mySmarty->display("install.html");
	exit();																						             //then leave
}

$source = "FB_Contests/".$_POST['company'].'/'.$folder_name;		                                               //source of  the files
$nonFB='http://naddesign.ca/fb_dev_app/FB_Contests/'.$_POST['company'].'/'.$date.'/nonfb/';                        //assemble the nonFB url
$site='https://www.naddesign.ca/fb_dev_app/FB_Contests/'.$_POST['company'].'/'.$date.'/mobile/';

/*=================================================================================================================================
makes the 'functions.php' file. uses fopen to create the file and writes to it with fwrite.
=================================================================================================================================*/
$functionsfile=fopen("functions.php", "w") or die("Unable to open file!"); //open file stream or give error message if unable to open file

/*telephone field checking*/
if ($_POST['tel']=='Yes')		//did the client ask for a telephone field?
								//if so then add the field 
{ $telephone = '
/*
=======================GET_Telephone=========================
Gets the boolean required for producing the "Telephone" field
on the contest sign up page.
=============================================================
*/
function GET_telephone() {
	return true;
}';
}
else
{ $telephone = ' 
/*
=======================GET_Telephone=========================
Gets the boolean required for producing the "Telephone" field
on the contest sign up page.
=============================================================
*/
function GET_telephone() {
	return false;
}';
}

$txt="<?php 
/*
Software Designer: Kombiz Khayami
Company: NADdesign 
Script Name: functions.php
Description:       
            script contains common functions used throught project:
            														-DB_info()        //Gets the data base information
            														-DB_connection()  //Connects to the datbase
            														-GET_appdetails() //Gets App info
            														-GET_title()      //Gets the title for the html pages
            														-GET_urls()       //Gets all url's used 
            														-GET_telephone()  //See if the client wants the telephone field
            														-GET_html()       //function work in progress
========================================================================================================================*/


/*
==============DB_info======================
Used to get the Data Base information.
returns an associative array.
===========================================
*/
function DB_info() {
	\$DB_info=Array();

	\$DB_info['db_host'] = 'localhost';  	                //  host address
	\$DB_info['db_user'] = 'naddesig'; 	                    //  username
	\$DB_info['db_pass'] = 'Wesare37frutu8';  	            //  password
	\$DB_info['db_name'] = 'naddesig_fbdev'; 	            //  database name
	\$DB_info['db_table'] = '`".$_POST['company'].'_'.$folder_name."`'; //  table name
	
	return \$DB_info;
}


/*
==============DB_connection======================
Connects to the sql database. Connection info 
needs to be passed 
=================================================
*/
function DB_connection(\$host, \$user, \$pass, \$name) {
	\$dns = 'mysql:dbname='.\$name.';host='.\$host;
	\$lbd = new PDO(\$dns, \$user, \$pass)                              //connect to mySQL
	or die(\"Sorry, Unable to connect to the Database server <br />\"	//or if their's an error 
		. \"<br>Error number : \" . mysql_errno()						//exit and send an error message 
		. \"<br>Error Message : \" . mysql_error());
	return \$lbd;
}



/*
==============GET_AppDetails========================
Gets all the variables for the FacebookApp and Api. 
Returns them in an associative array.
====================================================
*/
function GET_appdetails() {
	\$App=Array();

	/*App info*/
	\$App['AppID'] = '".$_POST['AppID']."';
	\$App['Secret'] = '".$_POST['Secret']."';


	return \$App;
}

/*
==============GET_urls========================
get all the urls. returns an associative array
with all the urls 
==============================================
*/
function GET_urls() {
	\$urls=Array();

	\$urls['reglements']='".$_POST['reglements']."';
	\$urls['non_FB']='".$nonFB."';
	     
	\$urls['smart']='".$_POST['smart']."';    //smarturl used by the mobile
	\$urls['visitez']='".$_POST['visitez']."';
	\$urls['page']='".$_POST['page']."';      //the facebook page of the client. used for likes
	\$urls['site']='".$site."'; //url to the comment box for the mobile site

	return \$urls;
}

/*
==============GET_title=======================
Gets the title of the all the html files. 
Returns a string with the title.
==============================================
*/
function GET_title() {
	return '".$_POST['title']."';
}
/*
==============GET_moderators===============================================================
Get the Facebook ID of all the moderators for the app.
(People who have Insights on the Domain i.e: they can see 
all of the Domain statistics)
info on FB Domain insights: https://developers.facebook.com/docs/platforminsights/domains
===========================================================================================
*/
function GET_moderators() {
	\$Mods=Array();

	//a list of facebook ID's who are moderators 
	\$Mods[]='558640573';    
	\$Mods[]='1118385862';
	\$Mods[]='100000817642688';
	\$Mods[]='501466932';

	return \$Mods;
}

".$telephone."

function GET_html(){
	return '".$_POST['html']."';
}

?>";
fwrite($functionsfile, $txt); //write to file'functions.php' aka create functions.php
fclose($functionsfile);       //close file stream

/*=================================================================================================================================*/


if (!file_exists("FB_Contests/".$_POST['company'])) { //if this is the companys first time 
	mkdir("FB_Contests/".$_POST['company']);		  //create a folder to store all contests in
}


/*
===========================================
Make all the 'desktop' directories
===========================================
*/
mkdir("FB_Contests/".$_POST['company']."/".$folder_name);
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/canvas");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/css");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/IMG");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/politique-confidentialite");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/reglements");
/*
===========================================
Make  all the 'nonfb' directories
===========================================
*/
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/nonfb");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/nonfb/css");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/nonfb/images");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/nonfb/templates");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/nonfb/templates_c");

/*
===========================================
Make  all the 'mobile' directories
===========================================
*/
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/mobile");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/mobile/css");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/mobile/images");
mkdir("FB_Contests/".$_POST['company']."/".$folder_name."/mobile/src");


/*
===========================================
Copy all the 'desktop' files from the 
template directory into the contest folder
===========================================
*/

$uploads_dir = $source.'/IMG';
foreach ($array as $key => $value)
{
	$a = str_split($key, 5);
	$d = str_split($key, 6);
	if ($a[0] == 'nonfb')
		move_uploaded_file($value, $source."/nonfb/images/$key.jpg");
	elseif ($d[0] == 'mobile')
	{
		$key = str_replace("mobile_", "", $key);
		move_uploaded_file($value, $source."/mobile/images/$key.jpg");
	}
	else
		move_uploaded_file($value, "$uploads_dir/$key.jpg");
}

copy($main_dir.'/index.php', $source.'/index.php');
copy($main_dir.'/facebook.php', $source.'/facebook.php');
copy('functions.php', $source.'/functions.php');
copy($main_dir.'/accepted.php', $source.'/accepted.php');
copy($main_dir.'/merci.php', $source.'/merci.php');
copy($main_dir.'/jquery-1.10.2.min.js', $source.'/jquery-1.10.2.min.js');
copy($main_dir.'/css/style.css', $source.'/css/style.css');
copy($main_dir.'/canvas/index.php', $source.'/canvas/index.php');
copy($main_dir.'/politique-confidentialite/index.html', $source.'/politique-confidentialite/index.html');



/*
===========================================
Copy all the 'nonfb' files from the 
template directory into the contest folder
===========================================
*/
copy($main_dir.'/nonfb/index.php', $source.'/nonfb/index.php');
copy($main_dir.'/nonfb/index_sent.php', $source.'/nonfb/index_sent.php');
copy($main_dir.'/nonfb/css/style.css', $source.'/nonfb/css/style.css');
copy($main_dir.'/smarty_stuff/nonfb_index.html', $source.'/nonfb/templates/nonfb_index.html'); 

/*
===========================================
Copy all the 'mobile' files from the 
template directory into the contest folder
===========================================
*/
copy($main_dir.'/mobile/index.php', $source.'/mobile/index.php');
copy($main_dir.'/mobile/fbconnect.php', $source.'/mobile/fbconnect.php');
copy($main_dir.'/mobile/commentbox.php', $source.'/mobile/commentbox.php');
copy($main_dir.'/mobile/like.php', $source.'/mobile/like.php'); 
copy($main_dir.'/mobile/logout.php', $source.'/mobile/logout.php');
copy($main_dir.'/mobile/merci.html', $source.'/mobile/merci.html');
copy($main_dir.'/mobile/style.css', $source.'/mobile/style.css');
copy($main_dir.'/mobile/jquery-1.9.0.min.js', $source.'/mobile/jquery-1.9.0.min.js'); 
copy($main_dir.'/mobile/jquery.nivo.slider.js', $source.'/mobile/jquery.nivo.slider.js');
copy($main_dir.'/mobile/jquery.validate.js', $source.'/mobile/jquery.validate.js');

copy($main_dir.'/mobile/src/base_facebook.php', $source.'/mobile/src/base_facebook.php');
copy($main_dir.'/mobile/src/facebook.php', $source.'/mobile/src/facebook.php'); 
copy($main_dir.'/mobile/src/fb_ca_chain_bundle.crt', $source.'/mobile/src/fb_ca_chain_bundle.crt');

copy($main_dir.'/mobile/css/default.css', $source.'/mobile/css/default.css');
copy($main_dir.'/mobile/css/demo.css', $source.'/mobile/css/demo.css'); 
copy($main_dir.'/mobile/css/nivo-slider.css', $source.'/mobile/css/nivo-slider.css');
copy($main_dir.'/mobile/css/reset.css', $source.'/mobile/css/reset.css');
copy($main_dir.'/mobile/css/style.css', $source.'/mobile/css/style.css'); 



/*
============================================
creating the database table
============================================
*/

$DB=new Database;                                                //a new connection to the database 
$DB->table = strtolower($_POST['company'].'_'.$folder_name);     //set table name
$table = $DB->table;                                             //get table name
if(!$DB->TableExists($table))                                    //create the table if it doesn't already exist 
{   //sql to create a table
	$sql="CREATE TABLE `$table` (          
		Id int(7) NOT NULL AUTO_INCREMENT,
		first_name varchar(50) NOT NULL,
		last_name varchar(50) NOT NULL,
		middle_name varchar(50),
		name varchar(150),
		email varchar(50) NOT NULL,
		telephone varchar(15),
		timezone tinyint(4), 
		gender varchar(20),
		locale varchar(50),
		link varchar(50),
		desktop tinyint(1),
		mobile tinyint(1),
		non_fb tinyint(1),
		PRIMARY KEY (Id),
		UNIQUE id (Id)
	)";
	$DB->MakeTable($sql);            
}
else                                     //Table name already exists. ask client to pick a diffrent name
{
	$title = 'Error';          				   
	$html .= "<br>That table already exists";  
	$mySmarty->assign('html', $html);
	$mySmarty->assign('success', $success);
	$mySmarty->assign('title', $title);
	$mySmarty->display("install.html");
	exit();		
}
$DB->CloseDB();                            //close database connection
$title = 'Success';                        //the title of the html page
$success = true;                           //no errors have occured up to this point. we have had a successfull installation  
$html .= "To add the app to your Facebook page<br><hr>
Please copy the link below into your browser search bar then hit enter.<br>
MAKE SURE YOU ARE LOGGED IN ON FACEBOOK<br>
https://www.facebook.com/dialog/pagetab?app_id=".$_POST['AppID']."&redirect_uri=https://www.naddesign.ca/fb_dev_app/FB_Contests/".$_POST['company'].'/'.$date;
$mySmarty->assign('title', $title);
$mySmarty->assign('html', $html);
$mySmarty->assign('success', $success);
$mySmarty->display("install.html");

?>
