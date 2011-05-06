<?php if(!$gjennomIndex) die("Access denied.");?>

<h3>Endre passord</h3>

<?php
if($_POST['endrepassord']=="Endre passord")
	echo $kunde->endrePassord($_POST['gammeltPass'],$_POST['nyttPass1'],$_POST['nyttPass2']);
?>

<form action="index.php?side=minkonto&amp;kontoside=endrepassord" method="POST" name="passordSkjema" onSubmit="return validerNyttPassord()">
<p>
	<label for="gammeltPass">Nåværende passord</label>
	<span>
		<input type="password" name="gammeltPass" id="gammeltPass" maxlength="50" required>
	</span>
</p>
<p>
	<label for="nyttPass1">Nytt passord</label>
	<span>
		<input type="password" name="nyttPass1" id="nyttPass1" maxlength="50" required onKeyUp="validerNyttPassord()">
	</span>
</p>
<p id="feilNyttPass" class="feilmelding" style="display:<?php echo $feilmeldinger['fornavn']==null?"none":"block";?>">
	<span><?php echo $feilmeldinger['fornavn']; ?></span>
</p>
<p>
	<label for="nyttPass2">Bekreft passord</label>
	<span>
		<input type="password" name="nyttPass2" id="nyttPass2" maxlength="50" required>
	</span>
</p>
<p>
	<input type="submit" name="endrepassord" id="endrepassord" value="Endre passord">
</p>
</form>