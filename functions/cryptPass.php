<?if(!$gjennomIndex) die("Access denied.");?>

<?

function cryptPass($passord,$salt)
{
	return crypt(md5($passord),md5($salt));
}

?>