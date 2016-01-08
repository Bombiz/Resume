<?php 
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
	$DB_info=Array();

	$DB_info['db_host'] = 'localhost';  	                //  host address
	$DB_info['db_user'] = 'naddesig'; 	                    //  username
	$DB_info['db_pass'] = 'Wesare37frutu8';  	            //  password
	$DB_info['db_name'] = 'naddesig_fbdev'; 	            //  database name
	$DB_info['db_table'] = '`comeonandslam_2015_07_21`'; //  table name
	
	return $DB_info;
}


/*
==============DB_connection======================
Connects to the sql database. Connection info 
needs to be passed 
=================================================
*/
function DB_connection($host, $user, $pass, $name) {
	$dns = 'mysql:dbname='.$name.';host='.$host;
	$lbd = new PDO($dns, $user, $pass)                       //connect to mySQL
	or die("Sorry, Unable to connect to the Database server <br />"	//or if their's an error 
		. "<br>Error number : " . mysql_errno()						//exit and send an error message 
		. "<br>Error Message : " . mysql_error());
	return $lbd;
}



/*
==============GET_AppDetails========================
Gets all the variables for the FacebookApp and Api. 
Returns them in an associative array.
====================================================
*/
function GET_appdetails() {
	$App=Array();

	/*App info*/
	$App['AppID'] = '728461117265183';
	$App['Secret'] = '31e983789590badfd0f732682ada8371';


	return $App;
}

/*
==============GET_urls========================
get all the urls. returns an associative array
with all the urls 
==============================================
*/
function GET_urls() {
	$urls=Array();

	$urls['reglements']='http://www.cbc.ca/books/canadawrites/rules-and-regulations---cbc-literary-prizes.html';
	$urls['non_FB']='http://naddesign.ca/fb_dev_app/FB_Contests/comeonandslam/2015_07_21';
	     
	$urls['smart']='.hjhkjlh';    //smarturl used by the mobile
	$urls['visitez']='http://comeonandsl.am/';
	$urls['page']='https://www.facebook.com/pages/Testapp/1057105320971277';      //the facebook page of the client. used for likes
	$urls['site']='https://www.naddesign.ca/fb_dev_app/FB_Contests/comeonandslam/2015_07_21/mobile/'; //url to the comment box for the mobile site

	return $urls;
}

/*
==============GET_title=======================
Gets the title of the all the html files. 
Returns a string with the title.
==============================================
*/
function GET_title() {
	return 'COME ON AND SLAM';
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
	$Mods=Array();

	//a list of facebook ID's who are moderators 
	$Mods[]='558640573';    
	$Mods[]='1118385862';
	$Mods[]='100000817642688';
	$Mods[]='501466932';

	return $Mods;
}


/*
=======================GET_Telephone=========================
Gets the boolean required for producing the "Telephone" field
on the contest sign up page.
=============================================================
*/
function GET_telephone() {
	return true;
}

function GET_html(){
	return '';
}

?>