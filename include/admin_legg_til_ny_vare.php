<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Legg til ny vare</h2>

<form name="ny_vare" action="" method="post">
    
        <p><label>Vare navn</label><input type="text" name="vnavn"/></p>
        <p><label>Pris</label><input type="text" name="vpris"/></p>
        <p><label>Antall varer</label><input type="text" name="vantall"/></p>
        <p>Beskrivelse<br/><textarea cols="40" rows="10" name="beskrivelse"></textarea></p>

        <p><input type="submit" name="legg_til" value="Legg til vare"</p>

</form>

<?php

?>
