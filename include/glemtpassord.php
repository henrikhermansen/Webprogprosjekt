<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Glemt passord?</h2>

<p>Hvis du har glemt passordet ditt kan vi sende deg et nytt automatisk generert
passord til epost-adressen du har oppgitt.</p>
<p>Passordet kan endres etter du har logget inn.</p>

<?php
$sendt = false;

if(isset($_POST['send']))
{
	$tempKunde=new BasicKunde();
	echo $tempKunde->glemtPassord($_POST['epost'],$_POST['postnr']);
}
?>
<form action="" method="POST">
<p>
	<label for="epost">E-post</label>
	<span><input type="text" name="epost" id="epost" maxlength="100" required></span>
</p>
<p>
	<label for="passord">Postnummer</label>
	<span><input type="text" name="postnr" id="postnr" maxlength="4" required></span>
</p>
<p>
	<input type="submit" name="send" value="Send nytt passord">
</p>
</form>