<h2>Logg inn</h2>

<?php
$innlogget=false;
if($_POST['logginn']=="Logg inn")
{
	$kunde=new Kunde();
	if($kunde->login($_POST['epost'],$_POST['passord']))
	{
		$innlogget=true;
		$_SESSION['kunde']=serialize($kunde);
		echo"<p>Velkommen ".$kunde->getFornavn().". Du er nå logget inn og kan <a href=\"index.php\">gå videre til nettbutikken.</p>";
	}
	else
	   echo"<p class=\"feilmelding\">Feil e-post eller passord.</p>";
}
if(!$innlogget)
{
?>

<form action="index.php?side=logginn" method="POST">
<p>
	<label for="epost">E-post</label>
	<input type="text" name="epost" id="epost" maxlength="100" required>
</p>
<p>
	<label for="passord">Passord</label>
	<input type="password" name="brukernavn" id="passord" maxlength="100" required>
</p>
<p>
	<input type="submit" name="logginn" id="logginn" value="Logg inn">
</p>
</form>
<?php } ?>