<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Legg til ny vare</h2>

    <?php
        if($_POST['legg_til']=="Legg til vare")
        {
            if($_POST['filstreng'] != "")
            {
                $temp_fil=$_FILES["filstreng"]["tmp_name"];
                $filnavn=$_FILES["filstreng"]["name"];
                $helt_filnavn="images/varebilde/".$filnavn;
                move_uploaded_file($temp_fil, $helt_filnavn);
            }
            else
                $helt_filnavn = "";

            $vare= new Vare();
            $feilmeldinger = $vare->leggTilVare($_POST['varenavn'],$_POST['pris'],$_POST['beskrivelse'],$helt_filnavn,$_POST['katnr'],$_POST['antall']);
            $error=false;
            foreach($feilmeldinger as $value)
            if($value!=null)
	      $error=true;

            if(!$error)
                echo $vare->lagreVare();
        }
    
   
    if(!isset($_POST['nyvare']) || $error)
    {?>

<form action="" method="post" name="ny_vare" enctype="multipart/form-data" >
    <?php
        $db = new sql();
	$resultat = $db->query("SELECT * FROM webprosjekt_kategori;");
	if($db->affected_rows == 0)
		die("Feil (H05)");
    ?>            
        <select name="katnr"><?php while($rad = $resultat->fetch_assoc())
               if($rad)
                echo '<option value="'.$rad["KatNr"].'">'.$rad["Navn"].'</option>';
               else
                   echo"";
                ?> </select>
	<?php $db->close(); ?>
        <p class="feilmelding"><?php echo $feilmeldinger['katnr']; ?></p>
  
        <p><label>Varenavn</label><input type="text" name="varenavn" value="<?php echo $_POST['varenavn'] ?>"/></p>
        <p class="feilmelding"><?php echo $feilmeldinger['varenavn']; ?></p>
        <p><label>Pris</label><input type="text" name="pris" value="<?php echo $_POST['pris'] ?>"/></p>
        <p class="feilmelding"><?php echo $feilmeldinger['pris']; ?></p>
        <p><label>Antall varer</label><input type="text" name="antall" value="<?php echo $_POST['antall'] ?>"/></p>
        <p class="feilmelding"><?php echo $feilmeldinger['antall']; ?></p>
        <p>Beskrivelse<br/><textarea cols="40" rows="10" name="beskrivelse"><?php echo $_POST['beskrivelse'] ?></textarea></p>
        <p class="feilmelding"><?php echo $feilmeldinger['beskrivelse']; ?></p>
        <p><label>Legg til bilde</label><input type="file" size="20" name="filstreng" value="<?php echo $_POST['filstreng'] ?>"/></p>
        <p class="feilmelding"><?php echo $feilmeldinger['bilde']; ?></p>
        <p><input type="submit" name="legg_til" value="Legg til vare"</p>

</form><?php } ?>


