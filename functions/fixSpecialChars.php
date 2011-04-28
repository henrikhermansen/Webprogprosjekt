<?if(!$gjennomIndex) die("Access denied.");?>

<?

function fixSpecialChars($streng)
{
	$streng=str_replace("æ","&aelig;",$streng);
	$streng=str_replace("Æ","&Aelig;",$streng);
	$streng=str_replace("ø","&oslash;",$streng);
	$streng=str_replace("Ø","&Oslash;",$streng);
	$streng=str_replace("å","&aring;",$streng);
	$streng=str_replace("Å","&Aring;",$streng);
	return $streng;
}

?>