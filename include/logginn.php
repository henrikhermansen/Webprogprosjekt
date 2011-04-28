<h2>Logg inn</h2>

<form action="index.php?side=logginn" method="POST">
<p>
	<label for="epost">E-post</label>
	<input type="text" name="epost" id="epost" maxlength="100" require>
</p>
<p>
	<label for="passord">Passord</label>
	<input type="password" name="brukernavn" id="brukernavn" maxlength="100" require>
</p>
<p>
	<input type="submit" name="logginn" id="logginn" value="Logg inn">
</p>
</form>

<?php
if($_POST['logginn']=="Logg inn")
{
	$kunde=new Kunde();
	if($kunde->login($_POST['epost'],$_POST['passord']))
	   echo"Innlogging OK";
	else
	   echo"Innlogging feilet";
}
?>