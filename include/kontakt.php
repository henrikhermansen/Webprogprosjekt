<script type="text/javascript">
function valider_navn()
{
    regEx = /^[a-zA-ZøæåØÆÅ .\- ]{2,}\s[a-zA-ZøæåØÆÅ .\- ]{2,}$/;
    if(regEx.test(document.epostskjema.navn.value))
    {
        document.getElementById("feilnavn").innerHTML = "";
        return true;
    }
    document.getElementById("feilnavn").innerHTML = " Skriv inn et korrekt navn"
    return false;
}
function valider_epost()
{
    regEx = /^[a-zA-ZøæåØÆÅ .\- ]+@[a-zA-ZøæåØÆÅ .\- ]{2,}\.[a-zA-Z]{2,3}$/;
    if(regEx.test(document.epostskjema.epost.value))
    {
        document.getElementById("feilepost").innerHTML = "";
        return true;
    }
    document.getElementById("feilepost").innerHTML = " Skriv inn en gyldig epostadresse"
    return false;
}
function valider_melding()
{
    if(!document.epostskjema.melding.value == "")
    {
        document.getElementById("feilmelding").innerHTML = "";
        return true;
    }
    document.getElementById("feilmelding").innerHTML = "Du må skrive noe i meldingsfeltet<br/>";
    return false;
}
function valider_alle()
{
    return valider_navn() && valider_epost() && valider_melding();
}
</script>

<h2>Kontakt oss</h2>

<h3>Postadresse:</h3>
<p>Høyskolen i Oslo<br/>
    Postboks 4 St. Olavs plass<br/>
    0130 Oslo</p>

<h3>Kontakskjema:</h3>
<p>Ved å fylle ut skjemaet under, tar vi kontakt med deg så raskt vi kan!</p>

<?php
if(!isset ($_REQUEST['knapp']))
echo
'<form action="" name="epostskjema" method="post">
        <span style="display: inline-block; width:5em">Fullt navn:</span><input type="text" name="navn" onChange="valider_navn()" /><span id="feilnavn" style="color: #ff0000;"> *</span><br/>
        <span style="display: inline-block; width:5em">E-post:</span><input type="text" name="epost" onChange="valider_epost()" /><span id="feilepost" style="color: #ff0000;"> *</span><br/>
        <br/>
        Melding:<br/>
        <textarea cols="40" rows="10" name="melding" onChange="valider_melding()"></textarea><br/>
        <span id="feilmelding" style="color: #ff0000;"></span>
        <br/>
        <input type="submit" name="knapp" value="Send inn" onClick="return valider_alle()" />
</form>';
else
{
    echo "Hei og hopp!";
}
?>