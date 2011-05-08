<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Vare
{
    private $VNr, $Varenavn, $Pris, $Beskrivelse, $Bilde, $KatNr, $Antall;

    /**
     * Konstruktør for å legge til vare og hente ut info om vare med gitt varenummer.
     *
     */
    function  __construct($VNr = false)
    {
        if($Vnr) //henter ut info om varen
        {
            $db = new sql();
            $resultat = $db->query("SELECT * FROM webprosjekt_vare WHERE VNr = '$VNr';");
            $rader = $db->affected_rows;
            $db->close();
            if($rader == 0)
                die("Feil - finner ikke vare i databasen (B06)");
            $resultat = $resultat->fetch_assoc();
            $this->Vnr = $resultat['VNr'];
            $this->Varenavn = $resultat['Varenavn'];
            $this->Pris = $resultat['Pris'];
            $this->Beskrivelse = $resultat['Beskrivelse'];
            $this->Bilde = $resultat['Bilde'];
            $this->KatNr = $resultat['KatNr'];
            $this->Antall = $resultat['Antall'];
        }
    }

    function setVarenavn($navn)
    {
        //kobler til databasen og legger inn $navn
        $this->Varenavn = $navn;
    }

    function setPris($pris)
    {
        //kobler til databasen og legger inn $pris
        $this->Pris = $pris;
    }

    function setBeskrivelse($beskrivelse)
    {
        //kobler til databasen og legger inn $beskrivelse
        $this->Beskrivelse = $beskrivelse;
    }

    function setBilde($bilde)
    {
        //kobler til databasen og legger inn $bilde
        $this->Bilde = $bilde;
    }

    function setKatNr($katnr)
    {
        //kobler til databasen og legger inn $katnr
        $this->KatNr = $katnr;
    }

    function setAntall($antall)
    {
        //kobler til databasen og legger inn $antall
        $this->Antall = $antall;
    }

    /**
     * Get-metoder for å hente ut parametere til vare.
     *
     */
    function getVNr() {return $this->VNr;}
    function getVarenavn() {return $this->Varenavn;}
    function getPris() {return $this->Pris;}
    function getBeskrivelse() {return $this->Beskrivelse;}
    function getBilde() {return $this->Bilde;}
    function getKatNr() {return $this->KatNr;}
    function getAntall() {return $this->Antall;}

}
?>
