<?php

session_start();

if ( isset($_GET['battleTag']) )
{
	$battle_tag = str_replace('#', '-', $_GET['battleTag']);
	$api_key="6mxq9g3c5ycpzg3se5xa29eb967j4edj";
	$_SESSION['battleTag'] = $battle_tag;
	$file=file_get_contents("https://us.api.battle.net/d3/profile/$battle_tag/?apikey=$api_key/");
	
	$heroes = Array();
	$json=json_decode($file, true);

	$paragon = $json['paragonLevel'];
	$battle_name = explode("-", $battle_tag, 2)[0];
	
	$heroes[] = $paragon;
	foreach($json['heroes'] as $key => $value)
	{
		$hero = "";
  		foreach($json['heroes'][$key] as $key => $value)
  		{
			if( preg_match("/name|level|class/", $key, $matches) )
    			{
				$hero[$key]=$value;
    			}
  		}
  		$heroes[] = $hero;
	}
	
	echo json_encode($heroes);
}
?>
