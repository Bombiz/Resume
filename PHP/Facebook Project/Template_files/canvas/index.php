<?php 
require '../functions.php'; 
$App=GET_appdetails();
$urls=GET_urls();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
<script>
window.top.location = <?php echo $urls['page'].$App['AppID'] ?>
</script>
</body>
</html>