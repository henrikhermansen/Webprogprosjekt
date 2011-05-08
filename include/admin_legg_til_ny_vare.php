<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Legg til ny vare</h2>

<form name="ny_vare" action="" method="post">
        
   <?php
        $db = new sql();
	$resultat = $db->query("SELECT * FROM webprosjekt_kategori;");
	if($db->affected_rows == 0)
		die("Feil (001)");
    ?>            
        <select><?php while($rad = $resultat->fetch_assoc())
               if($rad)
                echo '<option><a href="index.php?side=varer&amp;kat='.$rad["KatNr"].'">'.$rad["Navn"].'</a></option>';
               else
                   echo"";
                ?> </select>
	<?php $db->close(); ?>
  
        <p><label>Varenavn</label><input type="text" name="varenavn"/></p>
        <p><label>Pris</label><input type="text" name="varepris"/></p>
        <p><label>Antall varer</label><input type="text" name="vareantall"/></p>
        <p>Beskrivelse<br/><textarea cols="40" rows="10" name="varebeskrivelse"></textarea></p>

        <form action="vare.php" method="post" enctype="multipart/form-data">
            <p>Legg til bilde
            <input type="file" size="20" name="filstreng"/>
            <input type="submit" name="knapp" value="Legg til"/></p>
        </form>

        <p><input type="submit" name="legg_til" value="Legg til vare"</p>

</form>

<?php

?>
