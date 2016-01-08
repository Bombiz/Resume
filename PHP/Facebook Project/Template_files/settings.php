<?php 
/*Software Designer: Kombiz Khayami
Script Name: settings.php
Description:       
            Script creates "functions.php". 
========================================================================================================================*/
if(!isset($_SESSION)) {     // if session isn't started
   session_start();	
   //unset($_SESSION);		// start session
}
$functionsfile=fopen("functions.php", "w") or die("Unable to open file!"); //open file stream 

/*telephone field checking*/
if ($_POST['tel']=='Yes')		//did the client ask for a telephone field?
								//if so then add the field 
{ $telephone = '
/*
==============GET_Telephone============================
Gets the html required for producing the "Telephone" field
on the contest sign up page.
========================================================
*/
function GET_telephone() {
	return true;
}';
}
else
{ $telephone = '
/*
==============GET_Telephone============================
Gets the html required for producing the "Telephone" field
on the contest sign up page.
========================================================
*/
function GET_telephone() {
	return false;
}';
}

$txt="<?php 
/*
Software Designer: Kombiz Khayami
Script Name: functions.php
Description:       
            script contains commen functions used throught project:
            														-DB_info()        //Gets the data base information
            														-DB_connection()  //Connects to the datbase
            														-GET_appdetails() //Gets App info
            														-GET_title()      //
            														-GET_urls()
========================================================================================================================*/


/*
==============DB_info======================
Used to get the Data Base information.
returns an associative array.
===========================================
*/
function DB_info() {
	\$DB_info=Array();

	\$DB_info['db_host'] = '".$_POST['db_host']."';  	//  host address
	\$DB_info['db_user'] = '".$_POST['db_user']."'; 	//  username
	\$DB_info['db_pass'] = '".$_POST['db_pass']."';  	//  password
	\$DB_info['db_name'] = '".$_POST['db_name']."'; 	//  database name
	\$DB_info['db_table'] = '".$_SESSION['db_table']."'; 	//  table name
	
	return \$DB_info;
}


/*
==============DB_connection======================
Connects to the sql database
=================================================
*/
function DB_connection(\$host, \$user, \$pass, \$name) {
	\$lbd = mysql_connect(\$host, \$user, \$pass)                            //connect to mySQL
	or die(\"Sorry, Unable to connect to the Database server <br />\"		 //or if their's an error 
		. \"<br>Error number : \" . mysql_errno()							 //exit and send an error message 
		. \"<br>Error Message : \" . mysql_error());

	mysql_select_db(\$name)												 //select a database to use 
	or die(\"Sorry, Unable to open the Database :\$name.<br>\"			 //or ext and send an error  
		. \"<br>Error number : \" . mysql_errno()						 //message if unable to open database
		. \"<br>Error message : \" . mysql_error());
	
	mysql_set_charset('utf8',\$lbd); 

}



/*
==============GET_AppDetails========================
Gets all the variables for the FacebookApp and Api. 
Returns them in an array.
====================================================
*/
function GET_appdetails() {
	\$App=Array();

	/*App info*/
	\$App['AppID'] = '".$_POST['AppID']."';
	\$App['Secret'] = '".$_POST['Secret']."';

	/*Facebook Api/Post info*/
	\$App['message']= '".$_POST['message']."';            //post Message
	\$App['name']= '".$_POST['name']."';                  //
	\$App['description']= '".$_POST['description']."';    //message in post
	\$App['caption']= '".$_POST['caption']."';            //
	\$App['picture']= '".$_POST['picture']."';            //link to the picture
	\$App['link']= '".$_POST['link']."';                  //link to the FB App


	return \$App;
}

/*
==============GET_urls========================
get all the urls. returns an array
with all the urls 
==============================================
*/
function GET_urls() {
	\$urls=Array();

	\$urls['reglements']='".$_POST['reglements']."';
	\$urls['non_FB']='".$_POST['non_FB']."';
	     
	\$urls['smart']='".$_POST['smart']."';
	\$urls['visitez']='".$_POST['visitez']."';
	\$urls['page']='".$_POST['page']."';

	return \$urls;
}

/*
==============GET_title=======================
Gets the title of the all the html files
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

?>


";
fwrite($functionsfile, $txt); //write to file'functions.php' aka create functions.php
fclose($functionsfile);       //close file stream

 ?>