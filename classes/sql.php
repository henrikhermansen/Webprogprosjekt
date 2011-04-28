<?php

class sql extends mysqli
{
	function __construct($dbinfo)
	{
		parent::__construct($dbinfo[0], $dbinfo[1], $dbinfo[2], $dbinfo[3], $dbinfo[4]);

		//if(mysqli_connect_error())
		//	die("Kunne ikke opprette tilkobling til databasen: (".mysqli_connect_errno().") ".mysqli_connect_error());
	}
	
	function close()
	{
	   parent::kill($this->thread_id);
	   parent::close();
	}
}
?>
