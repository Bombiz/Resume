<?php 
/*
Software Designer: Kombiz Khayami
Script Name: functions.php
Description:       
            script contains commen functions used throught project:
            														-DB_info()        //Gets the data base information
            														-DB_connection()  //Connects to the datbase
            														-GET_session()    //Gets all the Session variables
            														-GET_appdetails() //Gets App info
========================================================================================================================*/
if(!isset($_SESSION)) {     // if session isn't started
   session_start();			// start session
}



/*
==============DB_info======================
Used to get the Data Base information.
returns an associative array.
===========================================
*/
function DB_info() {
	$DB_info=Array();

	$DB_info['db_host'] = 'localhost';  	                //  host address
	$DB_info['db_user'] = 'naddesig'; 	                    //  username
	$DB_info['db_pass'] = 'Wesare37frutu8';  	            //  password
	$DB_info['db_name'] = 'naddesig_fbdev'; 	            //  database name
	$DB_info['db_table'] = '`mtlarabais-test_2015_05_06`'; //  table name
	
	return $DB_info;
}



/*
==============DB_connection======================
Used to connect to the database.
=================================================
*/
function DB_connection($host, $user, $pass, $name) {
	$dns = 'mysql:dbname='.$name.';host='.$host;
	$lbd = new PDO($dns, $user, $pass)                       //connect to mySQL
	or die("Sorry, Unable to connect to the Database server <br />"	//or if their's an error 
		. "<br>Error number : " . mysql_errno()						//exit and send an error message 
		. "<br>Error Message : " . mysql_error());
	echo "string";
	return $lbd;

}

/*
==============GET_SESSION======================
Gets all SESSION data, saves it in an  associative
array and returns that array.
===============================================
*/
function GET_sesion() {
	$Info=Array();                             //stores of the values in the _SESSION 

	foreach ($_SESSION as $key => $value) {    //loop through the _SESSION
		$Info[$key]=$_SESSION[$value];         //save each _SESSION value into the array
	}

	return $Info;							   //send Info back
}



/*
==============GET_AppDetails========================
Gets the AppID and AppSecret for the App and returns 
them in an array.
====================================================
*/
function GET_appdetails() {
	$App=Array();
	$App['AppID']='774358549320881';
	$App['Secret']='eecd2a7d41ccf7360dd9175613ca3e22';

	return $App;
}

function GET_urls() {
	$urls=Array();

	$urls['reglements']='http://reglements.com';
	$urls['non_FB']='http://naddesign.ca/fb_dev_app/MTLARABAIS/nonfb';
	     
	$urls['smart']='http://smarturl.it/mtlarabais';
	$urls['visitez']='http://www.mtlarabais.com';
	$urls['page']='http://facebook.com/mtlarabais';

	return $urls;
}

?>


