<?php if(!$gjennomIndex) die("Access denied.");?>

<?php
function getVarer($kategori=0)
{
	$db=new sql();
	if($kategori == 0)
	   $resultat = $db->query("SELECT * FROM webprosjekt_vare;");
	else
	   $resultat = $db->query("SELECT * FROM webprosjekt_vare WHERE KatNr = '$kategori';");
	if(!$resultat)
		die("Feil - finner ikke vare i databasen (B02)");
	if($db->affected_rows==0)
	   return false;
	$db->close();
	$returarray;
	while($rad = $resultat->fetch_assoc())
	{
		$varelinje = array($rad['Bilde'],$rad['VNr'],$rad['Varenavn'],$rad['Beskrivelse'],$rad['Pris'],$rad['Antall']);
		$returarray[] = $varelinje;
	}
	return $returarray;
}
?>
