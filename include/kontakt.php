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

    if(!preg_match("/^[a-zA-ZÊ¯Â∆ÿ≈ .\- ]{2,}\s[a-zA-ZÊ¯Â∆ÿ≈ .\- ]{2,}$/", $navn))
        die("<p>Navnet er ikke p&aring; riktig format</p>");
    if(!preg_match("/^[0-9a-zA-ZÊ¯Â∆ÿ≈ .\-\_ ]+@[0-9a-zA-ZÊ¯Â∆ÿ≈ .\-\_ ]{2,}\.[a-zA-Z]{2,4}$/", $epost))
        die("<p>E-postadressen er ikke p&aring; riktig format</p>");
    if($melding == "")
        die("Meldingen er blank");

    @mail("s171200@stud.hio.no", "Melding fra nettbutikken", $melding."\r\n\\r\nAvsender: ".$navn, "From: ".$epost);

    echo "<p>Din foresp&oslash;rsel er n&aring; sendt. Vi kommer tilbake til deg s&aring; raskt vi kan!</p>";
}
?>