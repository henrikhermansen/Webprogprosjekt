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
        $info = $db->query("SELECT * FROM webprosjekt_admin WHERE Brukernavn = '$brukernavn';");
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
}
?>
