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

	function setTelefonnr($tlf)
	{
		if(!preg_match("/^\b\d{8}\b$/",$tlf))
		   return "Telefonnummer må inneholde 8 siffer.";
		$this->telefon=$tlf;
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

	function getId()			{ return $this->id; }
	function getUtlogging()	{ return $this->utlogging; }

	/*function lagreBruker()
	{
	   $id=$this->id;
	   $fornavn=$this->fornavn;
	   $etternavn=$this->etternavn;
	   $epost=$this->epost;
	   $telefon=$this->telefon;

		$db=new sqlConnection();
		$resultat=$db->update("brukere","fornavn='$fornavn',etternavn='$etternavn',epost='$epost',telefon='$telefon'","id=$id");
		$db->close();
		if(!(is_bool($resultat) && $resultat==true))
			return false;
		return true;
	}

	function endrePassord($gammelt,$nytt,$nytt2)
	{
	   $db=new sqlConnection();
	   $gammelt=trim(mysql_real_escape_string($gammelt,$db->getLink()));
	   $nytt=trim(mysql_real_escape_string($nytt,$db->getLink()));
	   $nytt2=trim(mysql_real_escape_string($nytt2,$db->getLink()));
	   $db->close();
		$kryptGammelt=new CryptPass($gammelt,$this->etternavn.$this->fornavn);
		if($kryptGammelt->getPass()!=$this->passord)
		   return "<span class=\"skjemafeil\">Feil nåværende passord.</span>";
		if($nytt!=$nytt2)
         return "<span class=\"skjemafeil\">Passordene du skrev var ikke like.</span>";
		if(!(strlen($nytt)>=6))
		   return "<span class=\"skjemafeil\">Passordet må være på minst 6 tegn.</span>";

		$kryptNytt=new CryptPass($nytt,$this->etternavn.$this->fornavn);
		$db=new sqlConnection();
		$resultat=$db->update("brukere","passord='".$kryptNytt->getPass()."'","id=".$this->id);
		if(!(is_bool($resultat) && $resultat==true))
			return "<span class=\"skjemafeil\">Databasefeil ved lagring av nytt passord. Vennligst prøv igjen eller kontakt Henrik.</span>";
		$this->passord=$kryptNytt->getPass();
		$_SESSION['bruker']=serialize($this);
		return "<span class=\"skjemaOk\">Passordet ditt ble endret.</span>";
	}*/
}

?>