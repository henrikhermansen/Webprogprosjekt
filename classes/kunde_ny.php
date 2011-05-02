<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class NyKunde extends BasicKunde
{
	private $KNr, $fornavn, $etternavn, $adresse, $postnr, $poststed, $telefonnr, $epost, $passord, $utlogging;
	private $sessionExpire;

	function __construct()
	{ $this->sessionExpire=60*30; }

	function login($epost,$passord)
	{
		$db=new sql();
		$passord=renStreng($passord,$db);
		$epost=renStreng($epost,$db);
		$brukerinfo=$db->query("SELECT * FROM webprosjekt_kunde WHERE epost='$epost'");
		$rows=$db->affected_rows;
		$db->close();
		if($rows==0)
			return false;
		$brukerinfo=$brukerinfo->fetch_assoc();
		//if($brukerinfo['passord']!=$cryptPass($passord,$post)) // Denne linjen skal settes inn igjen når vi begynner med krypterte passord!
		if($brukerinfo['passord']!=$passord)                     // Denne linjen skal FJERNES
		   return false;
		$this->KNr=$brukerinfo['KNr'];
		$this->fornavn=$brukerinfo['Fornavn'];
		$this->etternavn=$brukerinfo['Etternavn'];
		$this->adresse=$brukerinfo['Adresse'];
		$this->postnr=$brukerinfo['PostNr'];
		$this->telefon=$brukerinfo['Telefonnr'];
		$this->epost=$brukerinfo['epost'];
		$this->passord=$brukerinfo['passord'];
		$this->utlogging=time()+$this->sessionExpire;
		return true;
	}

	function refreshSession()
	{
	   if(time()>$this->utlogging)
	      return false;
		$this->utlogging=time()+$this->sessionExpire;
		return true;
	}

	/*function endreBruker($fornavn, $etternavn, $epost, $telefon)
	{
	   $db=new sqlConnection();
		$error['fornavn']=$this->setFornavn(trim(mysql_real_escape_string($fornavn,$db->getLink())));
		$error['etternavn']=$this->setEtternavn(trim(mysql_real_escape_string($etternavn,$db->getLink())));
		$error['epost']=$this->setEpost(trim(mysql_real_escape_string($epost,$db->getLink())),$db);
		$error['telefon']=$this->setTelefon(trim(mysql_real_escape_string($telefon,$db->getLink())));
		$db->close();
		unset($db);
		return $error;
	}

	function setFornavn($navn)
	{
		if(preg_match("/^\b[a-å ]{2,30}\b$/i",$navn))
		{
		  $this->fornavn=$navn;
		  return null;
		}
		else
		  return "Fornavn kan kun inneholde bokstaver. Minst to og maks 30.";
	}

	function setEtternavn($navn)
	{
		if(preg_match("/^\b[a-å ]{2,50}\b$/i",$navn))
		{
		  $this->etternavn=$navn;
		  return null;
		}
		else
		  return "Etternavn kan kun inneholde bokstaver. Minst to og maks 50.";
	}

	*/function getFornavn()
	{
		return $this->fornavn;
	}/*

	function getEtternavn()
	{
		return $this->etternavn;
	}

	function getNavn()
	{
		return $this->fornavn." ".$this->etternavn;
	}

	function setTelefon($tlf)
	{
		if(preg_match("/^\b\d{8}\b$/",$tlf))
		{
			$this->telefon=$tlf;
			return null;
		}
		else
		  return "Telefonnummer må inneholde 8 siffer.";
	}

	function getTelefon()
	{
		return $this->telefon;
	}

	function getAdgang()
	{
		return $this->adgang;
	}

	function setEpost($epost,$db)
	{
		$sjekkEpost=$db->count("epost","brukere","epost='$epost'");
		if($sjekkEpost>0 && $epost!=$this->epost)
		   return "E-postadressen er allerede registrert.";
	   if(strlen($epost)>255)
	      return "E-postadressen kan maks inneholde 255 tegn.";
		if(preg_match("/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i",$epost))
		{
		  $this->epost=$epost;
		  return null;
		}
		else
		  return "Feil format på e-postadressen.";
	}

	function getEpost()
	{
		return $this->epost;
	}

	function getId()
	{
		return $this->id;
	}

	function getUtlogging()
	{
		return $this->utlogging;
	}

	function lagreBruker()
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