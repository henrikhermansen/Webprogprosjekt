<?if(!$gjennomIndex) die("Access denied.");?>

<?

function fixSpecialChars($streng)
{
	$streng=str_replace("�","&aelig;",$streng);
	$streng=str_replace("�","&Aelig;",$streng);
	$streng=str_replace("�","&oslash;",$streng);
	$streng=str_replace("�","&Oslash;",$streng);
	$streng=str_replace("�","&aring;",$streng);
	$streng=str_replace("�","&Aring;",$streng);
	return $streng;
}

?>