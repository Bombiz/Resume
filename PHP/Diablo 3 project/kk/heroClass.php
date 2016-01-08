<?php
session_start();
class Hero {
      private $id;
      private $name;
      private $class;
      private $level;
      private $gender;
      private $hardcore;

      function __construct($id, $name, $class, $level, $gender, $hardcore){
               $this->id = $id;
         $this->name = $name;
         $this->class = $class;
         $this->level = $level;
         $this->gender = $gender;
         $this->hardcore = $hardcore;
      }

      public function get_id(){
             return $this->id;
      }

      public function get_name(){
             return $this->name;
      }

      public function get_class(){
             return $this->class;
      }

      public function get_level(){
             return $this->level;
      }

      public function get_gender(){
             return $this->gender;
      }

      public function get_hardcore(){
             return $this->hardcore;
      }

      public function get_skills(){
        $activeskills=array();
        $allskills=array();
        $allrunes=array();

        $battle_tag = $_SESSION['battleTag'];
        $hero_id = $this->get_id();
        $file=file_get_contents("http://us.battle.net/api/d3/profile/$battle_tag/hero/$hero_id");
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
          $skill['unlocklevel'] = 'N/A';
          $skill['description'] = 'N/A';

          $rune['name'] = 'N/A';
          $rune['unlocklevel'] = 'N/A';
          $rune['description'] = 'N/A';

          foreach ($json['skills']['active'][$key] as $key => $value) {

            if ($key == 'skill' ) {
              $skill['name'] = $value['name'];
              $skill['unlocklevel'] = $value['level'];
              $skill['description'] = nl2br($value['description']);
              
            }

            if ($key == 'rune') {
              $rune['name'] = $value['name'];
              $rune['unlocklevel'] = $value['level'];
              $rune['description'] = nl2br($value['description']);
              
            }
          }
          $allskills[]=$skill;      //array holds all skills
          $allrunes[]=$rune;        //array holds all runes
        }
        /*combine both skill and runes array into one array 
        holding all the active skills and associating runes*/
        $activeskills[]=$allskills;
        $activeskills[]=$allrunes;
        return $activeskills;
      }
}
?>

