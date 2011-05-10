<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Kategori
{
	private $katnr,$katnavn;
	
	function setKategori($katnr)
	{
		$db=new sql();
		$katnr=renStreng($katnr,$db);
		$resultat=$db->query("SELECT Navn FROM webprosjekt_kategori WHERE KatNr='$katnr'");
		if(!$resultat || $db->affected_rows<1)
		   return"<p class=\"feilmelding\">Fant ingen kategori med ID $katnr.</p>";
		$katinfo=$resultat->fetch_assoc();
		$db->close();
		$this->katnr=$katnr;
		$this->katnavn=$katinfo['Navn'];
		return null;
	}
	
	function slettKategori()
	{
	   $katnr=$this->katnr;
	   $katnavn=$this->katnavn;
		if($katnr=="")
		   return"<p class=\"feilmelding\">Databasefeil ved sletting av kategori (KS01).</p>";
		$db=new sql();
		$resultat=$db->query("SELECT * FROM webprosjekt_vare WHERE KatNr='$katnr'");
		if($db->affected_rows>0)
		   return"<p class=\"feilmelding\">Kan ikke slette: det finnes en eller flere varer i denne kategorien.</p>";
		$resultat=$db->query("DELETE FROM webprosjekt_kategori WHERE KatNr='$katnr'");
		if(!$resultat || $db->affected_rows<1)
		   return"<p class=\"feilmelding\">Databasefeil ved sletting av kategori (KS02).</p>";
		$db->close();
		return"<p class=\"okmelding\">Kategorien $katnavn er nå slettet.</p>";
	}

	function nyKategori($katnavn)
	{
	   $db=new sql();
		$katnavn=renStreng($katnavn,$db);
		if(!preg_match("/^[a-zæøå0-9 .,:;\-\_\+\(\)\/\&\\\ ]{2,30}$/i", $katnavn))
			return "<p class=\"feilmelding\">Kategorinavn kan kun inneholde bokstaver, tall, mellomrom, og (.,:;-+/\&), og må være mellom 2-30 tegn.</p>";
		$this->katnavn=$katnavn;

		$resultat = $db->query("INSERT INTO webprosjekt_kategori (Navn) VALUES('$katnavn')");
		if(!$resultat)
			return"<p class=\"feilmelding\">Databasefeil ved oppretting av ny kategori (H03).</p>";
		if($db->affected_rows<1)
			return"<p class=\"feilmelding\">Databasefeil ved oppretting av ny kategori (H04).</p>";
		$db->close();
		return"<p class=\"okmelding\">Kategorien $katnavn er nå opprettet.</p>";
	}

   function getKatnr() {return $this->katnr;}
	function getKatnavn() {return $this->katnavn;}
}
?>
