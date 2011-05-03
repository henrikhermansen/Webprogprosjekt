<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class BasicKunde
{
	protected $KNr, $fornavn, $etternavn, $adresse, $postnr, $poststed, $telefonnr, $epost, $passord;

	function setFornavn($navn)
	{
		if(!preg_match("/^\b[a-zæøå ]{2,45}\b$/i",$navn))
         return "Fornavn kan kun inneholde bokstaver. Minst to og maks 45.";
		$this->fornavn=$navn;
		return null;
	}

	function setEtternavn($navn)
	{
		if(!preg_match("/^\b[a-zæøå ]{2,45}\b$/i",$navn))
			return "Etternavn kan kun inneholde bokstaver. Minst to og maks 45.";
		$this->etternavn=$navn;
		return null;
	}
	
	function setAdresse($adresse)
	{
		if(!preg_match("/^\b[a-zæøå0-9. ]{2,100}\b$/i",$adresse))
			return "Adresse kan kun inneholde bokstaver, tall, mellomrom og punktum. 2-100 tegn.";
		$this->adresse=$adresse;
		return null;
	}
	
	function setPostnr($postnr,$db)
	{
		if(!preg_match("/^\b\d{4}\b$/i",$postnr))
			return "Postnummer må bestå av 4 siffer.";
		$sjekkPostnr=$db->query("SELECT Poststed FROM webprosjekt_poststeder WHERE Postnr='$postnr'");
		if($db->affected_rows==0)
		   return "Postnummeret finnes ikke.";
		$poststed=$sjekkPostnr->fetch_row();
		$this->poststed=$poststed[0];
		$this->postnr=$postnr;
		return null;
	}

	function setTelefonnr($tlf)
	{
		if(!preg_match("/^\b\d{8}\b$/",$tlf))
		   return "Telefonnummer må bestå av 8 siffer.";
		$this->telefonnr=$tlf;
		return null;
	}

	function setEpost($epost,$db)
	{
		$sjekkEpost=$db->query("SELECT COUNT(Epost) FROM webprosjekt_kunde WHERE Epost='$epost'");
		$sjekkEpost=$sjekkEpost->fetch_row();
		if($sjekkEpost[0]>0 && $epost!=$this->epost)
		   return "E-postadressen er allerede registrert.";
		if(!preg_match("/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i",$epost))
			return "Feil format på e-postadressen.";
	   if(strlen($epost)>100)
	      return "E-postadressen kan maks inneholde 100 tegn.";
		$this->epost=$epost;
		return null;
	}
	
	function getFornavn()	{ return $this->fornavn; }
	function getEtternavn()	{ return $this->etternavn; }
	function getNavn()		{ return $this->fornavn." ".$this->etternavn; }
	function getAdresse()	{ return $this->adresse; }
	function getPostnr()		{ return $this->postnr; }
	function getPoststed()	{ return $this->poststed; }
	function getTelefonnr()	{ return $this->telefonnr; }
	function getEpost()		{ return $this->epost; }

	function getKNr()			{ return $this->KNr; }
	function getUtlogging()	{ return $this->utlogging; }
}

?>