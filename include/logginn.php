<?php if(!$gjennomIndex) die("Access denied.");?>

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
		echo"<p>Velkommen ".$kunde->getFornavn().". Du er nå logget inn og kan <a href=\"index.php\">gå videre til nettbutikken.<a/></p>";
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
	<span><input type="text" name="epost" id="epost" maxlength="100" required></span>
</p>
<p>
	<label for="passord">Passord</label>
	<span><input type="password" name="passord" id="passord" maxlength="100" required></span>
</p>
<p>
	<input type="submit" name="logginn" id="logginn" value="Logg inn">
        <a id="glemt" href="index.php?side=glemtpassord">Glemt passord?</a>
</p>
</form>
<?php } ?>