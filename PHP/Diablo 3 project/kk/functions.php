<?php


#require_once("postClass.php");
function TableBody($ff, $l, $prov, $html_output="") {

  $html_output.="<td>$ff</td>\n";
  $html_output.="<td>$l</td>\n";
  $html_output.="<td>$prov</td>\n</tr>\n";

  return $html_output;

}

function JSON_TABLE($json) {                                                                        
  
  foreach($json->heroes as $item)
  {
	echo $item;
    # foreach($json->heros->$hero as $item)
    # {
    #   echo $item;
    # }   
  }
  
}



function UpdateDatabase($statment, $dbcon) {

  $updateStmnt=$dbcon->prepare($statment);
  $updateStmnt->execute();
  $updateStmnt->close();

}

function Table() {
  $html="";
  $html.="<th>First Name</th>";
  $html.="<th>Last Name</th>";
  $html.="<th>Province</th>";
  $html.="</tr>";
  return $html;
}

function ErrorBlank($user, $msg, $pass, $fname="d", $lname="d") {
  if($user=="")
  {
   $msg.="Username should not be blank.<br>";
  }

  if($fname=="")
  {
   $msg.="First name should not be blank.<br>";
  }

  if($lname=="")
  {
   $msg.="Last name should not be blank.<br>";
  }

  if($pass=="")
  {
   $msg.="Password should not be blank.<br>";
  }

  return $msg;
}

function sql_result_one($sql, $dbcon) {

   $stmnt=$dbcon->prepare($sql);
   $stmnt->bind_result($result);
   $stmnt->execute();
   $stmnt->fetch();
   $stmnt->close();

   return  $result;
}

function Connection() {

  $conn= new mysqli("localhost", "cs506_f14_6", "kombiz", "cs506_f14_6");
  return $conn;
}


function Smart() {
  $mySmarty = new Smarty();
  $mySmarty->setTemplateDir("smarty/templates");
  $mySmarty->setCompileDir("smarty/templates_c");
  return $mySmarty;
}

function getList($parent_id, $offset, $theList) {
   $childList = array();
   foreach($theList as $post)
   {
	if($post->get_parentID() == $parent_id)
	{
		$post->set_offset($offset);
		$childList[] = $post;
		$childList = array_merge($childList, getList($post->get_id(), $offset+1, $theList));	
	}
   }   
   return $childList;
}