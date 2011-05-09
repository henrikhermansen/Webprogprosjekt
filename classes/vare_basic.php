<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class BasicVare
{
    protected $VNr,$Varenavn,$Pris, $Beskrivelse, $Bilde, $KatNr, $Antall;
    
    function setVarenavn($navn)
    {
        //kobler til databasen og legger inn $navn
        if(!preg_match("/^\b[a-zæøå0-9.-/ ]{2,100}\b$/i", $navn))
                return "Varenavn kan kun inneholde bokstaver, tall, mellomrom, punktum og - og /. 2-100 tegn.";
        $this->Varenavn = $navn;
        return null;
    }

    function setPris($pris)
    {
        //kobler til databasen og legger inn $pris
        if(!preg_match("/^\b[1-9][0-9]{0,7}\b$/",$pris))
            return "Pris må bestå av kun siffer 0-9.";
        
        $this->Pris = $pris;
    }

    function setBeskrivelse($beskrivelse)
    {
        //kobler til databasen og legger inn $beskrivelse
        if(!preg_match("/^\b[a-zæøå0-9.,-/\()%?:;<>!&+*¨^~_ ]{0,4000}\b$/", $beskrivelse))
            return "Vare beskrivelse kan inneholde maks 4000 tegn.";
        
        $this->Beskrivelse = $beskrivelse;
    }

    function setBilde($bilde)
    {
        //kobler til databasen og legger inn $bilde
      
        $this->Bilde = $bilde;
    }

    function setKatNr($katnr,$db)
    {
        //kobler til databasen og legger inn $katnr
        
        
        $this->KatNr = $katnr;
    }

    function setAntall($antall)
    {
        //kobler til databasen og legger inn $antall
        if(!preg_match("/^\b[0-9]{0,4}\b$/", $antall))
            return "Antall kan kun inneholde tall 0-9 og maks 4 siffer.";
        
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

