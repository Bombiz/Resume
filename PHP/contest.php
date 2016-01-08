<?php  $today = date("m/d/Y");
$dir='FB_Contests';
$file = Array();
//loop the Iterates(loops) through the contest directory
foreach (new DirectoryIterator($dir) as $fileInfo) {  //start iteration(loop)
    if($fileInfo->isDot()) continue;                  //skip hidden files
    if ($fileInfo->isDir()) {                         //if we have a directory
    	$file[] =  $fileInfo->getFilename();          //Save it
    }  
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>INSTALL</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
  <style>

  hr { 
    border-width: 3px;
} 
.file_center{
	display: block;
    margin-left: auto;
    margin-right: 75px;
}
.center{
    text-align: center;
    background-color: #00FA9A;
    width: 700px;
    margin-left: auto ;
    margin-right: auto ;
    border: 25px solid navy;
    padding: 25px;
}


small {
    display: none;
    color: red;
    font-family: sans-serif;
	font-size: 14px;
}
.warning {
	border:2px red solid !important;
}

</style>

<script>
	window.addEventListener("load", doLoad);

    /*
    =======================================================
    function conatains actions to be done when the page loads
    =======================================================
    */
	function doLoad()
	{
	   var cmpy_name = document.getElementById('company_name'); //get company_name field object
       cmpy_name.addEventListener("click", click);              //preforme 'click' function on button click
	
	   var subButton = document.getElementById("install_btn");  //get install_btn field object
	   subButton.addEventListener("click", doSubmitClicked);    //preforme 'doSubmitClicked' function on button click
	}

    /*
    =======================================================
    function adds a new company 
    =======================================================
    */
	function click(event)
	{
		var cmpy_name = document.getElementById('company_name');
		var selectbox = document.getElementById('mySelect');
		cmpy_name.type='text';                                  //change field from button to text
		cmpy_name.value='';
		selectbox.value='';
		$('select').attr('disabled', 'disabled');               //disable selectbox
	}

	function doSubmitClicked(event)
	{
       var FieldElements={
       		text:["company_name", "datepicker", "AppID", "Secret", "Title", "visit", "reglements", "smart", "page"],
       		images:["main_index", "FB_login", "thank_you", "FB_invite", "visit", "accept_header", "accept_footer", "participate", "accept1", "accept2"]
       	}; //contains all field idsvar correctAppID = /^[0-9]*$/;                            //regex that contains correct AppID format
	   var is_error = false;                                     
	   var is_IMG_error =false;									 // is_error but for images
	   var error = document.getElementById('Blank');             // get Blank html element 
	   var IMG_error = document.getElementById('IMG_Blank');     // 

	   // var goodDate=/^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/;  //regex that contains good date format
 
	   /*
	   =======================================================
	   Checks all input fields for blank errors. 
	   if their is even one blank field then we have an error. 
	   other wise they're no errors.
	   =======================================================
	   */
	   	   
	   for(var key in FieldElements)
	   {
		   	for(var i = 0; i < FieldElements[key].length; i++)
		   	{
		   		var input = document.getElementById(FieldElements[key][i]); //

			    if (input.value=="") {  if(key!='images'){ input.className="warning"; is_error=true;} else {is_IMG_error=true;} event.preventDefault(); } else { if(key!='images'){ input.className="";}}
		   }
	   }

	   if (is_error) {error.style.display="block";} else {error.style.display="none";}
	   if (is_IMG_error) {IMG_error.style.display="block";} else {IMG_error.style.display="none";}
	}
	
	/*
	=================================================
	A jQuery UI plugin called datepicker. 
	it's an input field that when clcked opens up 
	a small calendar overlay. 
	=================================================
	*/
	$(function() {
	    $( "#datepicker" ).datepicker({                    
	      changeMonth: true,              //brings up month drop down menu
	      changeYear: true,				  //brings up Year drop down menu
	      minDate: 0,                     //set minimum date to current date
	      maxDate: "+10Y"                 //can only select up to 20years in advance 
	    });
	  });

	/*
	==================================================
	Function  checks the appID field on field cahnge 
	gives error message if appID value does not match 
	correct format
	==================================================
	*/
	function AppIDfunction() 
	{
	    var AppID = document.getElementById("AppID");         //gets AppID field object
	    var errormsg = document.getElementById('Format');     //get 
	    var subbtn = document.getElementById('install_btn');  //get submit field element
	    var correctAppID = /^[0-9]*$/;                        //regex that contains correct AppID format
	    if(!correctAppID.test(AppID.value))                   //if AppID value does not match correct format
	    {
            errormsg.style.display='block';                   //show error message
            subbtn.disabled=true;                             //make sure user doens't leave page until they change appID
		    AppID.value == '';								  //reset appID value
		}
		else                                                  //else
		{	errormsg.style.display='none';                    //do nothing
			subbtn.disabled=false;
		}

    }
		
</script>

</head>
<body style="background-color:lightblue">
<form action="install.php" method="post"  enctype="multipart/form-data">
<div class="center">
	Company Name <br>
	<select id="mySelect" name="select">
	<?php foreach ($file as $key => $value) {?>
	  <option value="<?php echo "$value"; ?>"><?php echo "$value"; ?>
    <?php } ?>
	</select> <div id='spaces'>&nbsp;or&nbsp;</div> <input type="button" name="company" id="company_name" value="Add a new company"/><br><br>
	
    Date (MM/DD/YYYY)<br><input type="text" name="date" id="datepicker" value="<?php echo $today; ?>" readonly='true'><br>
	<br><br>

	App<br>
	<hr>
	AppID       <br><input type="text" name="AppID" id="AppID" onchange="AppIDfunction()"/><br><small id="Format"> Please use only number</small>
	Secret      <br><input type="text" name="Secret" id="Secret"/><br><br>

	URlLs<br>
	<hr>
	Reglements(rules) <br><input type="text" name="reglements" id="reglements"/><br>
	Smart      <br><input type="text" name="smart" id="smart"/><br>
	Visitez    <br><input type="text" name="visitez" id="visit"/><br>
	Page       <br><input type="text" name="page" id="page"/><br>

	<!-- HTML<br>
	Thank you message: <br>
	<textarea name"html" rows="9" cols="75"></textarea><br><br> -->
	<br>
    Other<br>
    <hr>
	Title	 <br><input type="text" name="title" id="Title"/><br>
	Telephone  <input type="checkbox" name="tel" value="Yes"><br><br>
	<br>
    Images<br>
    <hr>
    Main index page                <input class='file_center' id ='main_index' type="file" name="index_bg" accept="image/*"/> <br> 
    Facebook login button 			<input class='file_center' id ='FB_login' type="file" name="btn_fb" accept="image/*"/> <br>
    Thank you page  				<input class='file_center' id ='thank_you' type="file" name="merci_bg" accept="image/*"/> <br>
    Facebook friend invite button   <input class='file_center' id ='FB_invite' type="file" name="btn_invitez" accept="image/*"/>  <br>
    Visit site button 				<input class='file_center' id ='visit' type="file" name="btn_visitez" accept="image/*"/> <br>
    Accept page header 				<input class='file_center' id ='accept_header' type="file" name="accepted_header" accept="image/*"/> <br>
    Accept page footer 				<input class='file_center' id ='accept_footer' type="file" name="accepted_footer" accept="image/*"/>  <br>
    Participate button 				<input class='file_center' id ='participate' type="file" name="btn_participez" accept="image/*"/> <br>
    Accepted1 						<input class='file_center' id ='accept1' type="file" name="accepted_01" accept="image/*"/> <br>
    Accepted2						<input class='file_center' id ='accept2' type="file" name="accepted_02" accept="image/*"/> <br><br>
    <hr>
    Non-Facebook<br>
    <hr>
    nonfb index page                <input class='file_center' id ='nonfb_index' type="file" name="nonfb_index" accept="image/*"/> <br><br>
    <hr>
    Mobile<br>
    <hr>
    Mobile index page              <input class='file_center' id ='main_index' type="file" name="mobile_participez_header" accept="image/*"/> <br> 
    Non-Facebook button 			<input class='file_center' id ='non_facebook' type="file" name="mobile_participez_bouton_nonfb" accept="image/*"/> <br>
    Thank you page  				<input class='file_center' id ='thank_you_mobile' type="file" name="mobile_merci_bg" accept="image/*"/> <br>
    Participate button 				<input class='file_center' id ='participate_mobile' type="file" name="mobile_participez_bouton" accept="image/*"/> <br>
    Like page 						<input class='file_center' id ='like_page' type="file" name="mobile_like" accept="image/*"/> <br>
    Comment box Page 				<input class='file_center' id ='comment_box_page' type="file" name="mobile_comment" accept="image/*"/> <br>

	<input type="submit" value="Install" id="install_btn" name="install_btn"/>
	<small id="Blank"> Fields highlighted red are required</small><br>
	<small id="IMG_Blank">All images are required </small>
</div>
</form>
</body>
</html>