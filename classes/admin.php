<?php if(!$gjennomIndex) die("Access denied.");

class Admin
{
    private $brukernavn, $passord, $utlogging;
    private $sessionExpire;

    function __construct()
    {
        $this->sessionExpire=60*30;
    }

    function login($brukernavn, $passord)
    {
        $db = new sql();
        $brukernavn = renStreng($brukernavn, $db);
        $passord = renStreng($passord, $db);
        $info = $db->query("SELECT * FROM webprosjekt_admin WHERE Brukernavn = '$brukernavn'");
        $rader = $db->affected_rows;
        $db->close();
        if($rader == 0)
            return false;
        $info = $info->fetch_assoc();
        if($info['Passord'] != cryptPass($passord, $brukernavn))
            return false;
        $this->brukernavn = $brukernavn;
        $this->passord = $passord;
        $this->utlogging = time() + $this->sessionExpire;
        return true;
    }

    function refreshSession()
    {
        if(time() > $this->utlogging)
            return false;
        $this->utlogging = time() + $this->sessionExpire;
            return true;
    }
    
	function nyAdmin($brukernavn,$passord1,$passord2,$rotpassord)
	{
	   if($rotpassord!="superhemmeligHBHLpassord")
	      return"<p class=\"feilmelding\">Feil rotpassord.</p>";
		if(!preg_match("/^[a-zæøå]{2,45}$/i",$brukernavn))
			return "<p class=\"feilmelding\">Brukernavn kan kun inneholde bokstaver. Minst to og maks 45.</p>";
		if($passord1!=$passord2)
		   return"<p class=\"feilmelding\">Passordene er ikke like.</p>";
		if(strlen($passord1)<6)
		   return"<p class=\"feilmelding\">Passordet må være på minst 6 tegn.</p>";
		$db=new sql();
		$brukernavn=renStreng($brukernavn,$db);
		$passord1=renStreng($passord1,$db);
		$resultat=$db->query("SELECT * FROM webprosjekt_admin WHERE Brukernavn='$brukernavn'");
		if(!$resultat)
		   return"<p class=\"feilmelding\">En databasefeil oppsto ved oppretting av ny admin. (NYA01)</p>";
		if($db->affected_rows==1)
		   return"<p class=\"feilmelding\">En administrator med dette brukernavnet finnes fra før.</p>";
		$dbPassord=cryptPass($passord1,$brukernavn);
		$resultat=$db->query("INSERT INTO webprosjekt_admin (Brukernavn,Passord) VALUES('$brukernavn','$dbPassord')");
		if(!$resultat || $db->affected_rows<1)
		   return"<p class=\"feilmelding\">En databasefeil oppsto ved oppretting av ny admin. (NYA02)</p>";
		return"<p class=\"okmelding\">Administratorbrukeren ble opprettet.</p><p>Brukernavn: $brukernavn<br>Passord: <a onClick=\"alert('$passord1')\">********</a> (klikk på stjernene for å se passordet)</p>";
	}
}
?>
