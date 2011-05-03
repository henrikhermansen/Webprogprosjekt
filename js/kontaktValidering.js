function valider_navn()
{
    regEx = /^[a-zA-ZÊ¯Â∆ÿ≈ .\- ]{2,}\s[a-zA-ZÊ¯Â∆ÿ≈ .\- ]{2,}$/;
    if(regEx.test(document.epostskjema.navn.value))
    {
        document.getElementById("feilnavn").innerHTML = "";
        return true;
    }
    document.getElementById("feilnavn").innerHTML = "&nbsp;Skriv inn et korrekt navn"
    return false;
}
function valider_epost()
{
    regEx = /^[0-9a-zA-ZÊ¯Â∆ÿ≈ .\-\_ ]+@[0-9a-zA-ZÊ¯Â∆ÿ≈ .\-\_ ]{2,}\.[a-zA-Z]{2,4}$/;
    if(regEx.test(document.epostskjema.epost.value))
    {
        document.getElementById("feilepost").innerHTML = "";
        return true;
    }
    document.getElementById("feilepost").innerHTML = "&nbsp;Skriv inn en gyldig epostadresse"
    return false;
}
function valider_melding()
{
    if(!document.epostskjema.melding.value == "")
    {
        document.getElementById("feilmelding").innerHTML = "";
        return true;
    }
    document.getElementById("feilmelding").innerHTML = "<p class=\"feilmelding\">Du m&aring; skrive noe i meldingsfeltet</p>";
    return false;
}
function valider_alle()
{
    return valider_navn() && valider_epost() && valider_melding();
}