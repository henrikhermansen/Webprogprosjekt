<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Legg til ny vare</h2>

    <?php
        if($_POST['legg_til']=="Legg til vare")
        {
            if(!empty($_FILES['filstreng']) && $_FILES['filstreng']['error'] == 0)
            {
                if($_FILES['filstreng']['type'] == "image/jpeg" && $_FILES['filstreng']['size'] < 1000000)
                {
                    $temp_fil = $_FILES["filstreng"]["tmp_name"];
                    $filnavn = $_FILES["filstreng"]["name"];
                    $helt_filnavn="images/varebilder/".$filnavn;
                    $ok = move_uploaded_file($temp_fil, $helt_filnavn);
                }
                else
                {
                    echo "<p class=\"advarselmelding\">Feil - bildet må være av typen jpeg og være under 1MB (021)</p>";
                    $helt_filnavn = "";
                }
            }
            else
            {
                echo "<p class=\"advarselmelding\">Du har ikke valgt bilde. Dette kan lastes opp senere under \"Endre\" i vareoversikten.</p>";
                $helt_filnavn = "";
            }

            $vare= new Vare();
            $feilmeldinger = $vare->leggTilVare($_POST['varenavn'],$_POST['pris'],$_POST['beskrivelse'],$helt_filnavn,$_POST['katnr'],$_POST['antall']);
            $error=false;
            foreach($feilmeldinger as $value)
            if($value!=null)
	      $error=true;

            if(!$error)
                echo $vare->lagreVare();
        }
    
   
    if(!isset($_POST['legg_til']) || $error)
    {?>

<form action="" method="post" name="ny_vare" enctype="multipart/form-data" onSubmit="return validerAlle()" >
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
        <p class="feilmelding" style="display:<?php echo $feilmeldinger['katnr']==null?"none":"block";?>"><?php echo $feilmeldinger['katnr']; ?></p>
  
        <p><label>Varenavn</label><input type="text" name="varenavn" value="<?php echo $_POST['varenavn'] ?>" onKeyUp="validerVarenavn()"/></p>
        <p id="feilVarenavn" class="feilmelding" style="display:<?php echo $feilmeldinger['varenavn']==null?"none":"block";?>"><?php echo $feilmeldinger['varenavn']; ?></p>

        <p><label>Pris</label><input type="text" name="pris" value="<?php echo $_POST['pris'] ?>" onKeyUp="validerPris()"/></p>
        <p id="feilPris" class="feilmelding" style="display:<?php echo $feilmeldinger['pris']==null?"none":"block";?>"><?php echo $feilmeldinger['pris']; ?></p>

        <p><label>Antall varer</label><input type="text" name="antall" value="<?php echo $_POST['antall'] ?>" onKeyUp="validerAntall()"/></p>
        <p id="feilAntall" class="feilmelding" style="display:<?php echo $feilmeldinger['antall']==null?"none":"block";?>"><?php echo $feilmeldinger['antall']; ?></p>

        <p>Beskrivelse<br/><textarea cols="40" rows="10" name="beskrivelse" onKeyUp="validerBeskrivelse()"><?php echo $_POST['beskrivelse'] ?></textarea></p>
        <p id="feilBeskrivelse" class="feilmelding" style="display:<?php echo $feilmeldinger['beskrivelse']==null?"none":"block";?>"><?php echo $feilmeldinger['beskrivelse']; ?></p>

        <p><label>Legg til bilde</label><input type="file" size="20" name="filstreng" /></p>
        <p class="feilmelding" style="display:<?php echo $feilmeldinger['bilde']==null?"none":"block";?>"><?php echo $feilmeldinger['bilde']; ?></p>
        
        <p><input type="submit" name="legg_til" value="Legg til vare"/></p>

</form><?php } ?>


