<?php 
require_once '../functions.php';
$App=GET_appdetails(); 
$Urls=GET_urls();
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<meta charset="UTF-8">
<meta name="viewport" content="user-scalable=0, initial-scale = 1.0,maximum-scale = 1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<head>
    <title>MTLARABAIS - Concours 1 an de resto gratuit !</title>
    <style>
     body {margin:0; padding:0;}
     html {margin:0; padding:0;}
     a {outline:none; text-decoration:none;}
     img {display:block;}
     .container {width:100%; max-width:640px; height:auto; margin:0 auto;}
 </style>

</head>
<body>
    <div id="fb-root"></div>
    <script src="https://connect.facebook.net/fr_FR/sdk.js"></script>
    <script type="application/x-javascript">
        FB.init({
            appId : <?php echo $App['AppID']; ?>,
            version    : 'v2.0',
            status : true,
            cookie : true,
            xfbml : true,
            oauth : true
        });
        
        FB.Event.subscribe('edge.create', function(href, widget) {
         top.window.location = 'merci.html';
     });
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);

        function hideURLbar(){
            window.scrollTo(0,1);
        };
    </script>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/fr_FR/sdk.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div align="center">
        <img  align="center" src=<?php echo $Urls['site']."images/like.jpg";?> width="100%" >
        <div align="center" class="fb-like" data-href=<?php echo $Urls['page']; ?> data-width="100%" data-height="450" data-show-faces="true" data-stream="false" data-show-border="false" data-header="false"></div>
    </div>
</body>
</html>