<?php 
$activeskills=array();
$allskills=array();
$allrunes=array();

$battleTag = $_SESSION['battleTag'];
$api_key="6mxq9g3c5ycpzg3se5xa29eb967j4edj";
$hero_id = $this->get_id();
$file=file_get_contents("https://us.api.battle.net/d3/profile/$battle_tag/hero/$hero_id?apikey=$api_key/");
$json=json_decode($file, true);
  	


/*
foreach to parse hero api and collect current 
active skills along with their associating runes. 
*/
foreach ($json['skills']['active'] as $key => $value) {
  /*
  Error handling
  ------------------
  if either skill or rune name is 'N/A' by the end of parsing
  means no skill or rune was selected
  */
  $skill['name'] = 'N/A';        
  $rune['name'] = 'N/A';

  foreach ($json['skills']['active'][$key] as $key => $value) {

    if ($key == 'skill' ) {
      $skill['name'] = $value['name'];
      $skill['unlocklevel'] = $value['level'];
      $skill['description'] = $value['description'];
      
    }

    if ($key == 'rune') {
      $rune['name'] = $value['name'];
      echo '['.$rune['name'].']';
      $rune['unlocklevel'] = $value['level'];
      $rune['description'] = $value['description'];
      
    }
  }
  $allskills[]=$skill;      //array holds all skills
  $allrunes[]=$rune;        //array holds all runes
}
/*combine both skill and runes array into one array 
holding all the active skills and associating runes*/
$activeskills[]=$allskills;
$activeskills[]=$allrunes;
var_dump($allrunes);

?>
