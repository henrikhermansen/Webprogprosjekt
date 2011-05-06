<?php if(!$gjennomIndex) die("Access denied.");

class Ordre
{
    private $OrdreNr, $KNr, $OrdreDato;

    // Må kalle new Ordre($OrdreNr) for å hente eksisterende ordre
    // eller new Ordre(false,$KNr) for å opprette ny ordre.
    function  __construct($OrdreNr, $KNr=false)
    {
        if(!$KNr) //Henter frem eksisterende ordre
        {
            $db = new sql();
            $resultat = $db->query("SELECT * FROM webprosjekt_ordre WHERE OrdreNr = '$OrdreNr';");
            $rader = $db->affected_rows;
            $db->close();
            if($rader == 0)
                die("Feil - finner ikke ordre i databasen (002)");
            $resultat = $resultat->fetch_assoc();
            $this->OrdreNr = $resultat['OrdreNr'];
            $this->KNr = $resultat['KNr'];
            $this->OrdreDato = $resultat['OrdreDato'];
        }
        else //Oppretter ny ordre
        {
            $db = new sql();
            $now = now();
            $resultat = $db->query("INSERT INTO webprosjekt_ordre(KNr, OrdreDato) VALUES('$KNr','$now()')");
            if($db->affected_rows == 0)
                die("Feil - kunne ikke sette inn ordre i databasen (003)");
            $this->OrdreNr = $db->insert_id;
            $this->KNr = $KNr;
            $this->OrdreDato = $now;
            $db->close();
        }
    }

    function getOrdreNr() {return $this->OrdreNr;}
    function getKNr() {return $this->KNr;}
    function getOrdreDato() {return $this->OrdreDato;}

    function getOrdretotal()
    {
        $db = new sql();
        $resultat = $db->query("SELECT SUM(webprosjekt_ordrelinje.Antall*Pris) AS 'total'
                                FROM webprosjekt_ordrelinje INNER JOIN webprosjekt_Vare ON webprosjekt_ordrelinje.VNr = webprosjekt_Vare.VNr
                                GROUP BY OrdreNr HAVING OrdreNr = '$this->OrdreNr';");
        $rader = $db->affected_rows;
        $db->close();
        if($rader != 1)
            return -1;
        $resultat = $resultat->fetch_assoc();
        return $resultat['total'];
    }

    function getOrdrelinjer()
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
}
?>
