<?php
class RisultatoSquadra
{
    public $punteggio;
    public $giocatoriconvoto;
    public $mediadifes;
    public function Risultato($punteggio, $giocatoriconvoto, $mediadifes)
    {
        $this->punteggio = $punteggio;
        $this->giocatoriconvoto = $giocatoriconvoto;
        $this->giocatoriconvoto = $giocatoriconvoto;
    }
}

class Votazione
{
    public $idgiocatore;
    public $ruolo;
    public $idposizione;
    public $voto;
    public $votomd;
    public function Votazione($_idgiocatore, $_ruolo, $_idposizione, $_voto, $_votomd)
    {
        $this->idgiocatore = $_idgiocatore;
        $this->ruolo = $_ruolo;
        $this->idposizione = $_idposizione;
        $this->voto = $_voto;
        $this->votomd = $_votomd;
    }
}

class Partita
{
    public $idpartita;
    public $idcasa;
    public $idospite;

    public $usamediadifesa;
    public $usafattorecasa;

    public function Partita($_idpartita, $_idcasa, $_idospite, $_usamediadifesa, $_usafattorecasa)
    {
        $this->idpartita = $_idpartita;
        $this->idcasa = $_idcasa;
        $this->idospite = $_idospite;
        $this->usamediadifesa = $_usamediadifesa;
        $this->usafattorecasa = $_usafattorecasa;

    }
    public function calcolaRisultatoPartita()
    {
        $risultatocasa = $this->calcolaRisultatoSquadra($this->idpartita, $this->idcasa);
        $risultatoospite = $this->calcolaRisultatoSquadra($this->idpartita, $this->idospite);
    }
    
    private function calcolaRisultatoSquadra($idpartita, $idsquadra)
    {
        include "../globalsettings.php"; 
        include "../dbinfo_susyleague.inc.php";

        // Create connection
        $conn = new mysqli($localhost, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = 'SELECT f.*, g.ruolo
        FROM `formazioni`  f
        left join giocatori g on g.id = f.id_giocatore
        WHERE id_giornata =' . $idpartita .
        ' and f.id_squadra =' . $idsquadra .
            ' order by id_posizione';

        $result=$conn->query($query);
        // if($boolprint) echo 'resultformazione'.print("<pre>".print_r($result,true)."</pre>").'<br>';
        
        $arrayvoti = array();
        //recupero i dati dal DB e li trasferisco nell'array di oggetti
        while ($giocatore = $result->fetch_assoc()) {
            array_push($arrayvoti,new Votazione(
                $giocatore["id_giocatore"],
                $giocatore["ruolo"],
                $giocatore["id_posizione"],
                $giocatore["voto"],
                $giocatore["voto_md"]
            ));
        }
        $conn->close();

        $numdif = 0;
        $numcen = 0;
        $numatt = 0;

        $numporcv = 0;
        $numdifcv = 0;
        $numcencv = 0;
        $numattcv = 0;

        $risporcv = array();
        $risdifcv = array();
        $riscencv = array();
        $risattcv = array();

        $sumdifesa = 0;
        
        $numvoti = 0;
        $sumvoti = 0;
        
        
        foreach($arrayvoti as $voto)
        {
            //cerco tra i titolari
            if($voto->idposizione <= 11)
            {
                //determino il modulo
                switch ($voto->ruolo){
                    case"D": $numdif++; break;
                    case"C": $numcen++; break;
                    case"A": $numatt++; break;
                }
                //considero i voti non nulli
                if(!is_null($voto->voto) )
                {
                    $numvoti++;
                    $sumvoti+= $voto->voto;
                    switch ($voto->ruolo){
                        case"P": $numporcv++; break;
                        case"D": $sumdifesa += $voto->votomd; $numdifcv++; break;
                        case"C": $numcencv++; break;
                        case"A": $numattcv++; break;
                    }                   
                }
            }
            else{
                //creo 4 array con le riserve con voto
                if(!is_null($voto->voto) ){
                    switch ($voto->ruolo){
                        case"P": 
                            array_push($risporcv,$voto);
                            break;
                        case"D": 
                            array_push($risdifcv,$voto);
                            break;
                        case"C": 
                            array_push($riscencv,$voto);
                            break;
                        case"A": 
                            array_push($risattcv,$voto);
                            break;
                    }    
                }
            }
        }
        if($boolprint) echo        'Squadra '. $idsquadra .' voti: ';
        if($boolprint) echo  print("<pre>".print_r($arrayvoti,true)."</pre>").'<br>';
        if($boolprint) echo        'Riserve portieri con voto';
        if($boolprint) echo  print("<pre>".print_r($risporcv,true)."</pre>").'<br>';
        if($boolprint) echo        'Riserve difensori con voto';
        if($boolprint) echo  print("<pre>".print_r($risdifcv,true)."</pre>").'<br>';
        if($boolprint) echo        'Riserve centrocampisti con voto';
        if($boolprint) echo  print("<pre>".print_r($riscencv,true)."</pre>").'<br>';
        if($boolprint) echo        'Riserve attaccanti con voto';
        if($boolprint) echo  print("<pre>".print_r($risattcv,true)."</pre>").'<br>';
        // print_r($arrayvoti);

        //calcolo il numero di sostituzione da fare considerando il numero di titolari con voto e che il max numero di sostituzione è 3
        $sostituzionidafare = 0;
        if($numvoti < 11)
        {
            if((11- $numvoti) >= 3 ){
                $sostituzionidafare = 3;
            }
            else{
                $sostituzionirimanenti = 11- $numvoti;
            }
        }
        $sostituzionifatte = 0;
        
        //gestisco i voti delle riserve
        if($sostituzionidafare > $sostituzionifatte && $numporcv != 1)// se manca il portiere
        {
            if(count($risporcv)> 0)
            {
                $votosostituto = $risporcv[0];
                $numvoti++;
                $sumvoti+= $voto->voto;
                $sostituzionifatte++;
                array_shift($risporcv);
            }
        }
        //se mancano difensori
        $difdasostituire = $numdif  - $numdifcv;
        if($sostituzionidafare > $sostituzionifatte && $difdasostituire > 0 )// se devo sostituire difensori
        {
            for($index = 1; $index<= $difdasostituire; $index++)//ciclo per i difensori da sostituire 
            {
                if(count($risdiffcv)> 0)
                {
                    $votosostituto = $risdifcv[0];
                    $numvoti++;
                    $sumvoti+= $votosostituto->voto;
                    $sumdifesa += $votosostituto->votomd; 
                    $numdifcv++;
                    $sostituzionifatte++;
                    array_shift($risdifcv);
                }
            }
        }
        //calcolo la media difesa 
        $mediadifesa = $this->calcolaMediaDifesa($numdifcv, $sumdifesa );

        //se il numero di voti mancanti è superiore alle sostituzioni disponibili, scelgo le piu convenienti
        while($sostituzionidafare > $sostituzionifatte)
        {
            $cendasostituire = $numcen  - $numcencv;
            $attdasostituire = $numatt  - $numattcv;    
            if($sostituzionidafare > ($cendasostituire + $attdasostituire) && $cendasostituire > 0 && $attdasostituire > 0)
            {
                //calcolo la sostituzione migliore e faccio la sostituzione
                $cencandidate = $riscencv[0];
                $attcandidate = $risattcv[0];
                if($cencandidate->voto > $attcandidate->voto)
                {
                    $votosostituto = $cencandidate;
                    $numvoti++;
                    $sumvoti+= $votosostituto->voto;
                    $numcencv++;
                    array_shift($riscencv);
                }
                else
                {
                    $votosostituto = $attcandidate;
                    $numvoti++;
                    $sumvoti+= $votosostituto->voto;
                    $numattcv++;
                    array_shift($risattcv); 
                }
            }
            else
            {
                //sostituisco un centrocampista
                if($cendasostituire > 0 && count($riscencv)> 0)
                {
                    $votosostituto = $riscencv[0];
                    $numvoti++;
                    $sumvoti+= $votosostituto->voto;
                    $numcencv++;
                    array_shift($riscencv);      
                }
                //sostituisco un attaccante
                else if($attdasostituire > 0  && count($risattcv)> 0)
                {
                    $votosostituto = $risattcv[0];
                    $numvoti++;
                    $sumvoti+= $votosostituto->voto;
                    $numattcv++;
                    array_shift($risattcv);                   
                }
            }
            $sostituzionifatte++;
        }
        return new RisultatoSquadra($sumvoti, $numvoti, $mediadifesa);
    }

    private function calcolaMediaDifesa($_numdif, $_sommavoti)
    {
        $ret;
        switch ($_numdif) {
            case 3:{
                    $base = 18.00;
                    $step = 0.75;
                    break;
                }
            case 4:{
                    $base = 23.00;
                    $step = 1;
                    break;
                }
            case 5:{
                    $base = 27.50;
                    $step = 1.25;
                    break;
                }
        }
        if ($_numdif == 3 || $_numdif == 4 || $_numdif == 5) {
            if ($_sommavoti >= $base && $_sommavoti < ($base + ($step * 1))) {$ret = 0;} 
            else if ($_sommavoti < ($base) && $_sommavoti >= ($base - ($step * 1))) {$ret = 1;} 
            else if ($_sommavoti < ($base - ($step * 1)) && $_sommavoti >= ($base - ($step * 2))) {$ret = 2;} 
            else if ($_sommavoti < ($base - ($step * 2)) && $_sommavoti >= ($base - ($step * 3))) {$ret = 3;} 
            else if ($_sommavoti < ($base - ($step * 3)) && $_sommavoti >= ($base - ($step * 4))) {$ret = 4;} 
            else if ($_sommavoti < ($base - ($step * 4))) {$ret = 5;} 
            else if ($_sommavoti >= ($base) && $_sommavoti < ($base < ($step * 1))) {$ret = -1;} 
            else if ($_sommavoti >= ($base + ($step * 1)) && $_sommavoti < ($base - ($step * 2))) {$ret = -2;} 
            else if ($_sommavoti >= ($base + ($step * 2)) && $_sommavoti < ($base - ($step * 3))) {$ret = -3;} 
            else if ($_sommavoti >= ($base + ($step * 3)) && $_sommavoti < ($base - ($step * 4))) {$ret = -4;} 
            else if ($_sommavoti >= ($base + ($step * 4))) {$ret = 5;}
        } else if ($_numdif == 2) {

        } else if ($_numdif == 1) {

        } else if ($_numdif == 0) {

        }
        return $ret;
        // difesa a 3
        // 14.25 > +5
        // 15.00 > +4
        // 15.75 > +3
        // 16.5. > +2
        // 17.25 > +1
        // 18 > 0
        // 18.75 > 1
        // 19.50 > 2
        // 20.25 > 3
        // 21.00 > 4
        // 21.75 > 5

        // difesa a 4
        // 18 > +5
        // 19 > +4
        // 20 > +3
        // 21 > +2
        // 22 > +1
        // 23 > 0
        // 24 > 1
        // 25 > 2
        // 26 > 3
        // 27 > 4
        // 28 > 5

        // difesa a 5
        // 21.25 > +5
        // 22.50 > +4
        // 23.75 > +3
        // 25.00 > +2
        // 26.25 > +1
        // 27.5 > 0
        // 28.75 > 1
        // 30.00 > 2
        // 31.25 > 3
        // 32.50 > 4
        // 33.75 > 5
    }

    private function calcolaGol($sommavoti, $fattorecasa, $mediadifesaavversaria)
    {
        $punteggio = $sommavoti + $fattorecasa + $mediadifesaavversaria;
        $ret = 0;
        $sogliaprimogol = 65;
        $step = 5;
        if($punteggio < $sogliaprimogol){$ret = 0;}
        else
        {
            $ret = floor(($punteggio-$sogliaprimogol)/5);
        }
        return $ret;
    }
}
