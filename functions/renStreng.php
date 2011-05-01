<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

function renStreng($streng,$mysqliObject)
{
	return trim($mysqliObject->real_escape_string(strip_tags($streng)));
}

?>