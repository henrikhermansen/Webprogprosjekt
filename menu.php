<?php if(!$gjennomIndex) die("Access denied.");?>

<h3>Kategorier:</h3>
<ul>
	<?php
//	$db = new sql();
//	$resultat = $db->query("SELECT * FROM webprosjekt_kategori;");
//	if($db->affected_rows == 0)
//		die("Feil (001)");
//	while($rad = $resultat->fetch_assoc())
//		echo '<li><a href="index.php?side=varer&amp;kat='.$rad["KatNr"].'">'.$rad["Navn"].'</a></li>';
//	$db->close();
	?>
	<li><a href="index.php?side=varer&amp;kat=1">Speilreflekskamera</a></li>
	<li><a href="index.php?side=varer&amp;kat=2">Superzoomkamera</a></li>
	<li><a href="index.php?side=varer&amp;kat=3">Kompaktkamera</a></li>
	<li><a href="index.php?side=varer&amp;kat=4">Undervannskamera</a></li>
	<li><a href="index.php?side=varer&amp;kat=5">Objektiv</a></li>
	<li><a href="index.php?side=varer&amp;kat=6">Tilbeh&oslash;r</a></li>
	<li><a href="index.php?side=varer&amp;kat=0">Alle kategorier</a></li>
</ul>
<hr/>
<ul>
	<li><a href="index.php?side=kontakt">Kontakt oss</a></li>
	<?php if((!isset($kunde) && !isset($admin)) || $side=="loggut") {?>
		<li><a href="index.php?side=logginn">Logg inn</a></li>
		<li><a href="index.php?side=nykunde">Ny kunde</a></li>
		<li><a href="index.php?side=admlogginn">Administrator</a></li>
	<?php } if(isset($kunde) && $side!="loggut") {?>
		<li><a href="index.php?side=minkonto">Min konto</a></li>
	<?php } if(isset($admin) && $side!="loggut") {?>
		<li><a href="index.php?side=admin_ordre">Ordre</a></li>
		<li><a href="index.php?side=admin_varer">Varer</a></li>
		<li><a href="index.php?side=admin_kunder">Kunder</a></li>
	<?php } if((isset($kunde) || isset($admin)) && $side!="loggut") { ?>
	   <li><a href="index.php?side=loggut">Logg ut</a></li>
	<?php } ?>
</ul>