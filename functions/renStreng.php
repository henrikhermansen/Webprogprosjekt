<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

function renStreng($streng,$mysqliObject,$allowed_tags="")
{
	return trim($mysqliObject->real_escape_string(strip_tags($streng,$allowed_tags)));
}

?>