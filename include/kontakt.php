<script type="text/javascript">
function valider_navn()
{
    regEx = /^[a-zA-Z������ .\- ]{2,}\s[a-zA-Z������ .\- ]{2,}$/;
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
    regEx = /^[0-9a-zA-Z������ .\-\_ ]+@[0-9a-zA-Z������ .\-\_ ]{2,}\.[a-zA-Z]{2,4}$/;
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
</script>

<h2>Kontakt oss</h2>

<h3>Postadresse:</h3>
<p>H&oslash;yskolen i Oslo<br/>
    Postboks 4 St. Olavs plass<br/>
    0130 Oslo</p>



<?php
if(!isset ($_POST['knapp']))
{?>
<h3>Kontakskjema:</h3>
<p>Ved &aring; fylle ut skjemaet under, tar vi kontakt med deg s&aring; raskt vi kan!</p>
<form action="" name="epostskjema" method="post">
        <p><label>Fullt navn</label><input type="text" name="navn" onChange="valider_navn()" /><span id="feilnavn" style="color: #ff0000;">&nbsp;*</span></p>
        <p><label>E-post</label><input type="text" name="epost" onChange="valider_epost()" /><span id="feilepost" style="color: #ff0000;">&nbsp;*</span></p>
        <div id="feilmelding"></div>
        <p>
        Melding<br/>
        <textarea cols="40" rows="10" name="melding" onChange="valider_melding()"></textarea>
        </p>
        <p><input type="submit" name="knapp" value="Send inn" onClick="return valider_alle()" /></p>
</form>
<?php }
else
{
    $navn = $_POST['navn'];
    $epost = $_POST['epost'];
    $melding = $_POST['melding'];

    if(!preg_match("/^[a-zA-Z������ .\- ]{2,}\s[a-zA-Z������ .\- ]{2,}$/", $navn))
        die("<p>Navnet er ikke p&aring; riktig format</p>");
    if(!preg_match("/^[0-9a-zA-Z������ .\-\_ ]+@[0-9a-zA-Z������ .\-\_ ]{2,}\.[a-zA-Z]{2,4}$/", $epost))
        die("<p>E-postadressen er ikke p&aring; riktig format</p>");
    if($melding == "")
        die("Meldingen er blank");

    mail("s171200@stud.hio.no", "Melding fra nettbutikken", $melding."\r\n\\r\nAvsender: ".$navn, "From: ".$epost);

    echo "<p>Din foresp&oslash;rsel er n&aring; sendt. Vi kommer tilbake til deg s&aring; raskt vi kan!</p>";
}
?>