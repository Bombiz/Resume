<?php 
require("../functions.php");
$tely = GET_telephone() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>NON-FB</title>
	<link href="css/reset.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="screen"/>
</head>
<body>
<div id="container_formulaire">
	
	<div id="content_formulaire">
    	<form method="POST" action="index_sent.php?send=yes" name="inscription">
        <div id="field_first_name">
	        FIRST NAME<br />
	        <input name="first_name" id="first_name"/>  
        </div>

         <div id="field_last_name">
	         LAST NAME<br />
	         <input name="last_name" id="last_name" />  
         </div>

         <?if($tely){ ?> 
	         <div id="field_telephone">
		         TELEPHONE<br />
		         <input name="telephone" id="telephone" />  
	         </div>
         <? } ?> 

         <div id="field_email">
	         EMAIL<br />
	         <input name="email" id="email" />
	     </div>


    	<input type="submit" id="submit" name="submit" value="Envoyez" />
        </form>
    </div>
</body>
</html>