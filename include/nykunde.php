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
		<span id="feilFornavn"><?php if($feilmeldinger['fornavn']!=null) echo "<span class=\"feilmelding\">".$feilmeldinger['fornavn']."</span>"; ?></span>
	</span>
</p>
<p>
	<label for="etternavn">Etternavn</label>
	<span>
		<input type="text" name="etternavn" id="etternavn" maxlength="45" value="<?php echo $_POST['etternavn']; ?>" required onKeyUp="validerEtternavn()">
		<span id="feilEtternavn"><?php if($feilmeldinger['etternavn']!=null) echo "<span class=\"feilmelding\">".$feilmeldinger['etternavn']."</span>"; ?></span>
	</span>
</p>
<p>
	<label for="adresse">Adresse</label>
	<span>
		<input type="text" name="adresse" id="adresse" maxlength="100" value="<?php echo $_POST['adresse']; ?>" required onKeyUp="validerAdresse()">
		<span id="feilAdresse"><?php if($feilmeldinger['adresse']!=null) echo "<span class=\"feilmelding\">".$feilmeldinger['adresse']."</span>"; ?></span>
	</span>
</p>
<p>
	<label for="postnr">Postnummer</label>
	<span>
		<input type="text" name="postnr" id="postnr" maxlength="4" value="<?php echo $_POST['postnr']; ?>" required onKeyUp="sjekkPostnummer(this.value);validerPostnr()">
		<span id="feilPostnr"><?php if($feilmeldinger['postnr']!=null) echo "<span class=\"feilmelding\">".$feilmeldinger['postnr']."</span>"; ?></span>
	</span>
</p>
<p>
	<label for="poststed">Poststed</label>
	<span id="poststed"></span>
</p>
<p>
	<label for="telefonnr">Telefonnummer</label>
	<span>
		<input type="text" name="telefonnr" id="telefonnr" maxlength="8" value="<?php echo $_POST['telefonnr']; ?>" required onKeyUp="validerTelefonnr()">
		<span id="feilTelefonnr"><?php if($feilmeldinger['telefonnr']!=null) echo "<span class=\"feilmelding\">".$feilmeldinger['telefonnr']."</span>"; ?></span>
	</span>
</p>
<p>
	<label for="epost">E-post</label>
	<span>
		<input type="text" name="epost" id="epost" maxlength="100" value="<?php echo $_POST['epost']; ?>" required onKeyUp="validerEpost()">
		<span id="feilEpost"><?php if($feilmeldinger['epost']!=null) echo "<span class=\"feilmelding\">".$feilmeldinger['epost']."</span>"; ?></span>
	</span>
</p>
<p>
	<input type="submit" name="nykunde" id="nykunde" value="Registrer ny kunde">
</p>
</form>
<?php } ?>