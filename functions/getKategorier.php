<?php if(!$gjennomIndex) die("Access denied.");?>

<?php
function getKategorier()
{
	$db=new sql();
	$resultat = $db->query("SELECT * FROM webprosjekt_kategori;");
	if(!$resultat)
		die("Feil - finner ikke kategorier i databasen (B02)");
	if($db->affected_rows==0)
	   return false;
	$db->close();
	$returarray;
	while($rad = $resultat->fetch_assoc())
		$returarray[$rad['KatNr']]=$rad['Navn'];
	return $returarray;
}
?>
