<?php 
/*setcookie function
takes 3 arguments: 
				-name(refrence name)
				-value(cookie value)
				-time(is a unix timestamp)*/
setcookie("testcookie", "test", time()+(24 * 60 * 60));  //setcookie
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>test - lightbox</title>
	<script src="https://code.jquery.com/jquery-1.6.2.min.js"></script>
<style type="text/css">
	#lightbox 
	{
	    position:fixed; /* keeps the lightbox window in the current viewport */
	    top:0; 
	    left:0; 
	    width:100%; 
	    height:100%; 
	    background: rgba(0,0,0,.7);
	    text-align:center;
	}
	#lightbox p {
    text-align:right; 
    color:#fff; 
    margin-right:20px; 
    font-size:12px; 
}
#lightbox img {
    box-shadow:0 0 25px #111;
    -webkit-box-shadow:0 0 25px #111;
    -moz-box-shadow:0 0 25px #111;
    max-width:940px;
}
</style>
<script>
window.addEventListener("load", doLoad);

	function doLoad()
	{
	   var close_box = document.getElementById('tt'); 
	   close_box.addEventListener("click", close);

	   var contest = document.getElementById('contest');
	   contest.addEventListener("click", contest);

	}

	function close(event)
	{
		var close_box = document.getElementById('tt');
		var lightbox = document.getElementById('lightbox');
		close_box.style.display = "none";
		lightbox.style.display = "none";
	}

	// function contest(event)
	// {

	// }


</script>
</head>
<body>
<div id="wrapper">
    <h1>Super Simple Lightbox</h1>
    <p>Our super simple lightbox demo. Here are the image links:
        <ul>
            <li>
                <a href="https://farm7.static.flickr.com/6130/5935338876_47b61c93a5.jpg" class="lightbox_trigger">
                Picture 1
                </a>
            </li>
            <li>
                <a href="https://farm7.static.flickr.com/6020/5924329054_4bdc419c3a_o.jpg" class="lightbox_trigger">
                Picture 2
                </a>
            </li>
            <li>
                <a href="https://farm7.static.flickr.com/6020/5931933181_ddb737e528.jpg" class="lightbox_trigger">
                Picture 3
                </a>
            </li> 
        </ul>
     </p>
</div> <!-- #/wrapper -->
<div id="lightbox">
    <p id="tt">Click to close</p>
    <div id="content">
    <html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title>Your download is starting - Mod DB</title>
	<style type="text/css">
	body, p, blockquote, table, tr, th, td {
		margin: 0;
		padding: 0;
		border: 0;
	}

	body {
		background-color: #fff;
	}
	
	a, a:link, a:visited {
		color: #000;
		text-decoration: none;
		font-size: 14px;
	}

	a:visited {
		color: #999;
	}
	
	a:hover, a:active {
		color: #ff6600; 
		text-decoration: underline;
	}

	p {
		color: #000;
		font-size: 12px;
		padding-bottom: 15px;
		clear: both;
	}
	
	p a, p a:link, p a:visited {
		color: #000;
		font-size: 12px;
		text-decoration: underline;
	}
	
	p a:hover, p a:active {
		color: #ff6600; 
		text-decoration: underline;
	}
	
	body {
		background-color: #fff;
		font-size: 62.5%;
		font-family: "Trebuchet MS", sans-serif, Tahoma, Arial, Verdana;
		color: #000;
		padding: 20px 20px 0;
	}
	
	blockquote {
		padding: 0 20px;
	}
	
	blockquote p {
		color: #666;
		font-style: italic;
	}
	
	blockquote p a, blockquote p a:link, blockquote p a:visited {
		color: #666;
	}
	
	
	.sponsor {
		background-color: #000;
		height: 480px;
		width: 640px;
	}
	</style>
	
</head>
<body>

<div align="center">
	<div class="sponsor">HELLO</div>
</div>
 


</body></html>
        <button id='contest'>Enter contest</button>
    </div>
</div>
</body>
</html>