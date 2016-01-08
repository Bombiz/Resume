<?php 
$dir='FB_Contests';
$file = Array();
$directories = Array();
//loop Iterates(loops) through the contest directory
foreach (new DirectoryIterator($dir) as $fileInfo) {  //start iteration(loop)
    if($fileInfo->isDot()) continue;                  //skip hidden files
    if ($fileInfo->isDir()) {                         //if we have a directory
    	$dir[] =  $fileInfo->getFilename();          //Save it
    }
    else
    {
    	$file[] = $fileInfo->getFilename();
    }  
} 

?>