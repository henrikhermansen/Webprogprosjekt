<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Registrer ny kunde</h2>

<?php
if($_POST['nykunde']=="Registrer ny kunde")
{
	$nyKunde=new NyKunde($_POST['fornavn'],$_POST['etternavn'],$_POST['adresse'],$_POST['postnr'],$_POST['telefonnr'],$_POST['epost']);
	$error=false;
	$feilmeldinger=$nyKunde->getFeilmeldinger();
	foreach($feilmeldinger as $value)
	   if($value!=null)
	      $error=true;

	if(!$error)
	   echo $nyKunde->regKunde();
}

if(!isset($_POST['nykunde']) || $error)
{
?>

<form action="index.php?side=nykunde" method="POST" name="nykundeSkjema" onSubmit="return validerAlle()">
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
	<span id="poststed"></span>
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
		<input type="text" name="epost" id="epost" maxlength="100" value="<?php echo $_POST['epost']; ?>" required onKeyUp="validerEpost()">
	</span>
</p>
<p id="feilEpost" class="feilmelding" style="display:<?php echo $feilmeldinger['epost']==null?"none":"block";?>">
	<span><?php echo $feilmeldinger['epost']; ?></span>
</p>
<p>
	<input type="submit" name="nykunde" id="nykunde" value="Registrer ny kunde">
</p>
</form>
<?php } ?>