<?php
session_start();

require_once("smarty/libs/Smarty.class.php");
require_once("heroClass.php");
require_once("functions.php");

$hero=$_GET['hero'];
$smarty = Smart();

if( isset($_SESSION['battleTag']) )
{
	$api_key="6mxq9g3c5ycpzg3se5xa29eb967j4edj";
	$battle_tag = $_SESSION['battleTag'];
	$file=file_get_contents("https://us.api.battle.net/d3/profile/$battle_tag/?apikey=$api_key/");

	$json=json_decode($file, true);

	foreach($json['heroes'] as $key => $value)
        {
		if($hero == $value['name'])
		{			
			$myHero = new Hero($value['id'], $value['name'], $value['class'], $value['level'],
			$value['gender']?"female":"male", $value['hardcore']?"true":"false");
			break;
		}
        }

	if(isset($myHero))
	{
		$smarty->assign("hero", $myHero);
		$smarty->assign("battleTag", str_replace('-','#',$battle_tag));
		$smarty->display("hero.html");
	}
	else
	{
		 $smarty->assign("hero", $hero);
		 $smarty->display("heroError.html");
	}
}
else
{
	$smarty->assign("hero", $hero);
	$smarty->display("heroError.html");
}
?>
