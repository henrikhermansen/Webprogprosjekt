<?if(!$gjennomIndex) die("Access denied.");?>

<?

function renStreng($streng,$dblink)
{
	return trim(mysql_real_escape_string(strip_tags($streng),$dblink));
}

?>