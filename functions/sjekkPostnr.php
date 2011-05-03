<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

function sjekkPostnr($postnr)
{
	return trim(strip_tags(file_get_contents("http://fraktguide.bring.no/fraktguide/postalCode.html?pnr=$postnr")));
}

?>