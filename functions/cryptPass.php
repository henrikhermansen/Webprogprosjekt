<?if(!$gjennomIndex) die("Access denied.");?>

<?

function cryptPass($passord,$salt)
{
	return hash("sha512",hash("md5",$salt).hash("md5",$passord));
}

?>