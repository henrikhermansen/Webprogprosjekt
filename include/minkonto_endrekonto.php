<?php if(!$gjennomIndex) die("Access denied.");?>

<h3>Endre kontoinformasjon</h3>

<?php
if($_POST['endrekunde']=="Endre kundeinfo")
{
	$feilmeldinger=$kunde->endreKunde($_POST['fornavn'],$_POST['etternavn'],$_POST['adresse'],$_POST['postnr'],$_POST['telefonnr']);
	$error=false;
	foreach($feilmeldinger as $value)
	   if($value!=null)
	      $error=true;

	if(!$error)
	{
	   $lagreKunde=$kunde->lagreKunde();
	   if($lagreKunde==1)
	   {
	      echo"<p class=\"okmelding\">Brukerinformasjonen din ble oppdatert.</p>";
			$_SESSION['kunde']=serialize($kunde);
		}
		if($lagreKunde==-1)
		   echo"<p class=\"feilmelding\">Vi beklager! En feil har oppstått ved lagring av informasjonen. (EK01)</p>";
		if($lagreKunde==-2)
		   echo"<p class=\"feilmelding\">Vi beklager! En feil har oppstått ved lagring av informasjonen. (EK02)</p>";
	}
	   
}

if($_POST['endrekunde']!="Endre kundeinfo")
		foreach($kunde->getInfo() as $key=>$value)
		   $_POST[$key]=$value;
		   
$_POST['epost']=$kunde->getEpost();
?>

<form action="index.php?side=minkonto&amp;kontoside=endrekonto" method="POST" name="kundeSkjema" onSubmit="return validerAlle()">
<p>
	<label for="fornavn">Fornavn</label>
	<span>
		<input type="text" name="fornavn" id="fornavn" maxlength="45" value="<?php echo $_POST['fornavn']; ?>" required onKeyUp="validerFornavn()">
	</span>
</p>
<p id="feilFornavn" class="feilmelding" style="display:<?php echo $feilmeldinger['fornavn']==null?"none":"block";?>">
	<span><?php echo $feilmeldinger['fornavn']; ?></span>
</p>
<p>
	<label for="etternavn">Etternavn</label>
	<span>
		<input type="text" name="etternavn" id="etternavn" maxlength="45" value="<?php echo $_POST['etternavn']; ?>" required onKeyUp="validerEtternavn()">
	</span>
</p>
<p id="feilEtternavn" class="feilmelding" style="display:<?php echo $feilmeldinger['etternavn']==null?"none":"block";?>">
	<span><?php echo $feilmeldinger['etternavn']; ?></span>
</p>
<p>
	<label for="adresse">Adresse</label>
	<span>
		<input type="text" name="adresse" id="adresse" maxlength="100" value="<?php echo $_POST['adresse']; ?>" required onKeyUp="validerAdresse()">
	</span>
</p>
<p id="feilAdresse" class="feilmelding" style="display:<?php echo $feilmeldinger['adresse']==null?"none":"block";?>">
	<span><?php echo $feilmeldinger['adresse']; ?></span>
</p>
<p>
	<label for="postnr">Postnummer</label>
	<span>
		<input type="text" name="postnr" id="postnr" maxlength="4" value="<?php echo $_POST['postnr']; ?>" required onKeyUp="sjekkPostnummer(this.value);validerPostnr()">
	</span>
</p>
<p id="feilPostnr" class="feilmelding" style="display:<?php echo $feilmeldinger['postnr']==null?"none":"block";?>">
	<span><?php echo $feilmeldinger['postnr']; ?></span>
</p>
<p>
	<label for="poststed">Poststed</label>
	<span id="poststed"><?php echo $kunde->getPoststed(); ?></span>
</p>
<p>
	<label for="telefonnr">Telefonnummer</label>
	<span>
		<input type="text" name="telefonnr" id="telefonnr" maxlength="8" value="<?php echo $_POST['telefonnr']; ?>" required onKeyUp="validerTelefonnr()">
	</span>
</p>
<p id="feilTelefonnr" class="feilmelding" style="display:<?php echo $feilmeldinger['telefonnr']==null?"none":"block";?>">
	<span><?php echo $feilmeldinger['telefonnr']; ?></span>
</p>
<p>
	<label for="epost">E-post</label>
	<span>
		<input type="text" name="epost" id="epost" maxlength="100" value="<?php echo $_POST['epost']; ?>" disabled>
	</span>
</p>
<p id="feilEpost" class="feilmelding" style="display:<?php echo $feilmeldinger['epost']==null?"none":"block";?>">
	<span><?php echo $feilmeldinger['epost']; ?></span>
</p>
<p>
	<input type="submit" name="endrekunde" id="endrekunde" value="Endre kundeinfo">
	<input type="reset" name="reset" id="reset" value="Nullstill endringer" onClick="nullstill()">
</p>
</form>