<?if(!$gjennomIndex) die("Access denied.");?>

<?

function renStreng($streng,$mysqliObject)
{
	return trim($mysqliObject->real_escape_string(strip_tags($streng)));
}

?>