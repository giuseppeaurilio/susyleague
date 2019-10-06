<?php
function getDescrizioneGiornata($id)
{
    $descrizioneGiornata = "";
    if($id <= 22)
    { $descrizioneGiornata ="Campionato - Apertura. Giornata ". $id;}
    else if ($id>22 && $id<= 33)
    { $descrizioneGiornata ="Campionato - Chiusura. Giornata ". $id - 22;}
    else if ($id>33 && $id<= 48)
    { $descrizioneGiornata ="Coppa Italia - Girone Narpini. Giornata ".(ceil (($id-33) /3));}
    else if ($id>48 && $id<= 63)
    { $descrizioneGiornata ="Coppa Italia - Girone Gianluca. Giornata ".(ceil (($id-48) /3));}//(floor(($id-48)/3) + 1);}
    else if ($id == 64 )
    { $descrizioneGiornata ="Coppa Italia - Quarto 1 - Andata";}
    else if ($id == 65 )
    { $descrizioneGiornata ="Coppa Italia - Quarto 1 - Ritorno";}

    else if ($id == 66 )
    { $descrizioneGiornata ="Coppa Italia - Quarto 2 - Andata";}
    else if ($id == 67 )
    { $descrizioneGiornata ="Coppa Italia - Quarto 2 - Ritorno";}

    else if ($id == 68 )
    { $descrizioneGiornata ="Coppa Italia - Quarto 3 - Andata";}
    else if ($id == 69 )
    { $descrizioneGiornata ="Coppa Italia - Quarto 3 - Ritorno";}

    else if ($id == 70 )
    { $descrizioneGiornata ="Coppa Italia - Quarto 4 - Andata";}
    else if ($id == 71 )
    { $descrizioneGiornata ="Coppa Italia - Quarto 4 - Ritorno";}

    else if ($id == 72 )
    { $descrizioneGiornata ="Coppa Italia - Semifinale 1 - Andata";}
    else if ($id == 73 )
    { $descrizioneGiornata ="Coppa Italia - Semifinale 1 - Ritorno";}

    else if ($id == 74 )
    { $descrizioneGiornata ="Coppa Italia - Semifinale 2 - Andata";}
    else if ($id == 75 )
    { $descrizioneGiornata ="Coppa Italia - Semifinale 2 - Ritorno";}

    else if ($id == 76 )
    { $descrizioneGiornata ="Finale COPPA ITALIA";}
    else if ($id == 77 || $id == 78)
    { $descrizioneGiornata ="Coppa delle coppe - Giornata" . ($id-76);}

    else if ($id == 79)
    { $descrizioneGiornata ="Finale CAMPIONATO";}

    else if ($id == 79)
    { $descrizioneGiornata ="SUPERCOPPA";}

    else
    { $descrizioneGiornata ="mancante ".$id ;}

    return $descrizioneGiornata;

    
}
?>