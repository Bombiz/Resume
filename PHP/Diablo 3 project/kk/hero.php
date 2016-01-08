<?php
session_start();

require_once("smarty/libs/Smarty.class.php");
require_once("heroClass.php");
require_once("functions.php");

$hero=$_GET['hero'];
$smarty = Smart();

if( isset($_SESSION['battleTag']) )
{
	$battle_tag = $_SESSION['battleTag'];
        $file=file_get_contents("http://us.battle.net/api/d3/profile/$battle_tag/");

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
