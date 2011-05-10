<?if(!$gjennomIndex) die("Access denied.");?>

<?

function logError($feilmelding)
{
	$root=$_SERVER['DOCUMENT_ROOT'];
	$folder=substr($_SERVER['PHP_SELF'],0,-9);
	error_log($feilmelding."\r\n",3,$root.$folder."log/error.log");
}

function logFatal($feilmelding)
{
	$root=$_SERVER['DOCUMENT_ROOT'];
	$folder=substr($_SERVER['PHP_SELF'],0,-9);
   error_log($feilmelding."\r\n",3,$root.$folder."log/fatal.log");
}

function shutdown()
{
	$error=error_get_last();
	if(is_array($error))
	{
	   if($error['type']==E_ERROR || $error['type']==E_CORE_ERROR || $error['type']==E_COMPILE_ERROR) // Håndterer fatal errors
	   {
			$feilmelding=now();
			foreach($error as $value)
			{
				$feilmelding.=" - $value";
			}
			logFatal($feilmelding);
			header("Location: error.php");
		}
		if($error['type']==E_WARNING || $error['type']==E_PARSE) // Håndterer warning og parse
	   {
			$feilmelding=now();
			foreach($error as $value)
			{
				$feilmelding.=" - $value";
			}
			logError($feilmelding);
		}
	}
}

?>