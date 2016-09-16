<?php 
/*Software Designer: Kombiz Khayami
Script Name: classes.php
Description:       
            script contains claases.
            	-Database: contains general functions used by a dataabase
========================================================================================================================*/
/**
 * Database class
 * class is used to preforme basic data base function like connecting and making tables
 */
class Database 
{
	//=====Database connection info==========//
	private $host = 'localhost';
	private $user = 'naddesig';
	private $pass = 'Wesare37frutu8';
	private $name = 'naddesig_fbdev';
	//=======================================//
	public $table = '';

	function __construct()
	{
		$lbd = mysql_connect($this->host, $this->user, $this->pass)              //connect to the SQL server 
		or die("Sorry, Unable to connect to the Database server <br />"		     //or if their's an error 
		. "<br>Error number : " . mysql_errno()							         //exit and send an error message 
		. "<br>Error Message : " . mysql_error());

		mysql_select_db($this->name)											//connect to the database
		or die("Sorry, Unable to open the Database :$name.<br>"			        //or send an error message if 
		. "<br>Error number : " . mysql_errno()						            //unable to open database
		. "<br>Error message : " . mysql_error());

		mysql_set_charset('utf8',$lbd);
	} 

	public function MakeTable($sql)
	{
		mysql_query($sql) 
		or die("Sorry, unable to make table <br />"
		. "<br>Error number : " . mysql_errno()							         
		. "<br>Error Message : " . mysql_error());
		echo "made table";

	}
	/*Make sure their isn't duplicts of any tables*/
	public function TableExists($table) 
	{
		$result = mysql_query("SHOW TABLES LIKE '".$table."'");
		if (mysql_num_rows($result) > 0) 
			return true;
		else
			return false;
	}

	/*Used to close the Database connection*/
	public function CloseDB()
	{
		mysql_close();
	}
}

?>