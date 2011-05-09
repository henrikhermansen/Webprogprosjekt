<?php if(!$gjennomIndex) die("Access denied.");

class Ordre
{
    private $OrdreNr, $KNr, $OrdreDato, $ordrelinjer;

    // Må kalle new Ordre($OrdreNr) for å hente eksisterende ordre
    // eller new Ordre(false,$KNr) for å opprette ny ordre.
    function  __construct($OrdreNr, $KNr=false)
    {
        if(!$KNr) //Henter frem eksisterende ordre
        {
            $db = new sql();
            $OrdreNr=renStreng($OrdreNr,$db);
            $resultat = $db->query("SELECT * FROM webprosjekt_ordre WHERE OrdreNr = '$OrdreNr';");
            $rader = $db->affected_rows;
            $db->close();
            if($rader == 0)
                die("Feil - finner ikke ordre i databasen (002)");
            $resultat = $resultat->fetch_assoc();
            $this->OrdreNr = $resultat['OrdreNr'];
            $this->KNr = $resultat['KNr'];
            $this->OrdreDato = $resultat['OrdreDato'];
            $this->ordrelinjer=$this->setOrdrelinjerFraDb();
        }
        else //Oppretter ny ordre
        {
            $db = new sql();
            $this->KNr=renStreng($KNr,$db);
            $db->close();
        }
    }

    function getOrdreNr() {return $this->OrdreNr;}
    function getKNr() {return $this->KNr;}
    function getOrdreDato() {return $this->OrdreDato;}
    function getOrdrelinjer() { return $this->ordrelinjer; }

    function getOrdretotal()
    {
        $total=0;
        foreach($this->ordrelinjer as $ordrelinje)
				$total+=$ordrelinje[2]*$ordrelinje[3];
		  return $total;
    }

    private function setOrdrelinjerFraDb()
    {
        $db = new sql();
        $resultat = $db->query("SELECT webprosjekt_vare.VNr, Varenavn, Pris, webprosjekt_ordrelinje.Antall, Pris*webprosjekt_ordrelinje.Antall AS Total
                                FROM webprosjekt_vare INNER JOIN webprosjekt_ordrelinje ON webprosjekt_vare.VNr = webprosjekt_ordrelinje.VNr
                                WHERE OrdreNr = '$this->OrdreNr';");
        if(!$resultat)
            die("Feil - finner ikke ordre i databasen (003)");
        $db->close();
        $returarray;
        while($rad = $resultat->fetch_assoc())
        {
            $ordrelinje = array($rad['VNr'],$rad['Varenavn'],$rad['Pris'],$rad['Antall'],$rad['Total']);
            $returarray[] = $ordrelinje;
        }
        return $returarray;
    }

    function slettOrdre()
    {
        $db = new sql();
        $resultat = $db->query("DELETE FROM webprosjekt_ordrelinje WHERE OrdreNr = '$this->OrdreNr';");
        if($db->affected_rows == 0)
            die("Feil - finner ikke ordre i databasen (004)");
        $resultat = $db->query("DELETE FROM webprosjekt_ordre WHERE OrdreNr = '$this->OrdreNr';");
        if($db->affected_rows == 0)
            die("Feil - finner ikke ordre i databasen (005)");
        $db->close();
    }

    function setOrdrelinjer($ordrelinjer)	{ $this->ordrelinjer=$ordrelinjer; }

	 function setOrdrelinje($vnr,$antall)
	 {
	 	$ordrelinjer=$this->ordrelinjer;
	 	$ordrelinjer[$vnr]+=$antall;
	 	$this->ordrelinjer=$ordrelinjer;
	 }

	 function lagreOrdre()
	 {
		$db = new sql();
		$KNr=$this->KNr;
		$ok=true;
		$db->query("START TRANSACTION");
		$now=now();
		$resultat = $db->query("INSERT INTO webprosjekt_ordre(KNr, OrdreDato) VALUES('$KNr','$now')");
		if($db->affected_rows == 0)
			$ok=false;
		$ordreNr = $db->insert_id;
		$this->OrdreNr=$ordreNr;
		$this->OrdreDato = $now;
		foreach($this->ordrelinjer as $VNr=>$antall)
		{
			$resultat=$db->query("INSERT INTO webprosjekt_ordrelinje(OrdreNr,VNr,Antall) VALUES('$ordreNr','$VNr','$antall')");
			if(!$resultat || $db->affected_rows==0)
			   $ok=false;
			$resultat=$db->query("UPDATE webprosjekt_vare SET Antall=(Antall-$antall) WHERE VNr='$VNr'");
			if(!$resultat || $db->affected_rows==0)
			   $ok=false;
		}
		if(!$ok)
		{
		   $db->query("ROLLBACK");
		   $db->close();
			return false;
		}
		$db->query("COMMIT");
		$db->close();
		return true;
	 }
}
?>
