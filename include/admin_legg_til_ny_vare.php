<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Legg til ny vare</h2>

    <?php
        if($_POST['nyvare']=="Legg til vare")
        {
            $nyVare=new NyVare ($_POST['varenavn'],$_POST['pris'],$_POST['beskrivelse'],$_POST['bilde'],$_POST['katnr'],$_POST['antall']);
            $error=false;
            $feilmeldinger=$nyVare->getFeilmeldinger();
            foreach($feilmeldinger as $value)
            if($value!=null)
	      $error=true;

            if(!$error)
                echo $nyVare->regKunde();
        }
    
   
    if(!isset($_POST['nyvare']) || $error)
    {?>

<form action="admin_legg_til_ny_vare" method="post" name="ny_vare"  >
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

        <form action="index.php?side=admin_legg_til_ny_vare" method="post" enctype="multipart/form-data">
            <p>Legg til bilde
            <input type="file" size="20" name="filstreng"/>
<!--            <input type="submit" name="knapp" value="Legg til"/></p>-->
        </form>

        <?php
            $temp_fil=$FILES["filstreng"]["tmp_name"];
            $filnavn=$_FILES["filstreng"]["name"];
            $helt_filnavn="C:\xampp\htdocs\Nettbutikk\images".$filnavn;
            move_uploaded_file($temp_fil, $helt_filnavn);

            echo "<img src='C:\xampp\htdocs\Nettbutikk\images\.$filnavn' hight='200' align='left'";

         ?>
        <p><input type="submit" name="legg_til" value="Legg til vare"</p>

</form><?php } ?>


