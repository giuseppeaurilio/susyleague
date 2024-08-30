<?php
class RisultatoSquadra
{
    public $punteggio;
    public $giocatoriconvoto;
    public $mediadifesa;
    public function RisultatoSquadra($punteggio, $giocatoriconvoto, $mediadifesa)
    {
        $this->punteggio = $punteggio;
        $this->giocatoriconvoto = $giocatoriconvoto;
        $this->mediadifesa = $mediadifesa;
    }
}

class RisultatoPartita
{
    public $punteggioCasa;
    public $punteggioMediaDifesaAvversariaCasa;
    public $punteggioFattoreCasa;
    public $golCasa;
    public $punteggioTotalaCasa;

    public $punteggioOspite;
    public $punteggioMediaDifesaAvversariaOspite;
    public $punteggioFattoreOspite;
    public $golOspite;
    public $punteggioTotalaOspite;

    public function RisultatoPartita($punteggioCasa, $punteggioMediaDifesaAvversariaCasa, $punteggioFattoreCasa, $golCasa, $punteggioTotalaCasa, 
    $punteggioOspite, $punteggioMediaDifesaAvversariaOspite, $punteggioFattoreOspite, $golOspite, $punteggioTotalaOspite)
    {
        $this->punteggioCasa = $punteggioCasa;
        $this->punteggioMediaDifesaAvversariaCasa = $punteggioMediaDifesaAvversariaCasa;
        $this->punteggioFattoreCasa = $punteggioFattoreCasa;
        $this->golCasa = $golCasa;
        $this->punteggioTotalaCasa = $punteggioTotalaCasa;

        $this->punteggioOspite = $punteggioOspite;
        $this->punteggioMediaDifesaAvversariaOspite = $punteggioMediaDifesaAvversariaOspite;
        $this->punteggioFattoreOspite = $punteggioFattoreOspite;
        $this->golOspite = $golOspite;
        $this->punteggioTotalaOspite = $punteggioTotalaOspite;
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
    public $idgiornata;
    public $idpartita;
    public $idcasa;
    public $idospite;

    public $usamediadifesa;
    public $valorefattorecasa;

    public function Partita($_idgiornata, $_idcasa, $_idospite, $_usamediadifesa, $_valorefattorecasa)
    {
        $this->idgiornata = $_idgiornata;
        $this->idcasa = $_idcasa;
        $this->idospite = $_idospite;
        $this->usamediadifesa = $_usamediadifesa;
        $this->valorefattorecasa = $_valorefattorecasa;

    }
    public function calcolaRisultatoPartita()
    {
        $punteggiocasa = $this->calcolaRisultatoSquadra($this->idgiornata, $this->idcasa);
        $punteggioospite = $this->calcolaRisultatoSquadra($this->idgiornata, $this->idospite);
        include "../globalsettings.php"; 
        // if($boolprint) print("<pre>".print_r($punteggiocasa,true)."</pre>").'<br>';
        // if($boolprint) print("<pre>".print_r($punteggioospite,true)."</pre>").'<br>';

        $punteggiototalecasa = $punteggiocasa->punteggio + $this->valorefattorecasa + $this->usamediadifesa ?  $punteggioospite->mediadifesa: 0;
        $punteggiototaleospite = $punteggioospite->punteggio + $this->usamediadifesa ?  $punteggiocasa->mediadifesa: 0;

        $golcasa = $this->calcolaGol($punteggiototalecasa );
        $golospite =$this->calcolaGol($punteggiototaleospite );
     
        return new RisultatoPartita($punteggiocasa->punteggio,$this->usamediadifesa ?  $punteggioospite->mediadifesa: 0 ,$this->valorefattorecasa, $golcasa, $punteggiototalecasa ,
        $punteggioospite->punteggio,$this->usamediadifesa ?  $punteggiocasa->mediadifesa: 0 ,0, $golospite, $punteggiototaleospite );
    }
    
    private function calcolaRisultatoSquadra($idgiornata, $idsquadra)
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
        WHERE id_giornata =' . $idgiornata .
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
        // if($boolprint) echo        'Squadra ID='. $idsquadra .' -> voti: ';
        // if($boolprint) echo  print("<pre>".print_r($arrayvoti,true)."</pre>").'<br>';
        // if($boolprint) echo        'Riserve portieri con voto';
        // if($boolprint) echo  print("<pre>".print_r($risporcv,true)."</pre>").'<br>';
        // if($boolprint) echo        'Riserve difensori con voto';
        // if($boolprint) echo  print("<pre>".print_r($risdifcv,true)."</pre>").'<br>';
        // if($boolprint) echo        'Riserve centrocampisti con voto';
        // if($boolprint) echo  print("<pre>".print_r($riscencv,true)."</pre>").'<br>';
        // if($boolprint) echo        'Riserve attaccanti con voto';
        // if($boolprint) echo  print("<pre>".print_r($risattcv,true)."</pre>").'<br>';
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
        // if($boolprint) echo  print("<pre>".print_r($sostituzionidafare,true)."</pre>").'<br>';
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
        // if($boolprint) echo  print("<pre>".print_r($difdasostituire,true)."</pre>").'<br>';
        if($sostituzionidafare > $sostituzionifatte && $difdasostituire > 0 )// se devo sostituire difensori
        {
            for($index = 1; $index<= $difdasostituire; $index++)//ciclo per i difensori da sostituire 
            {
                if(count($risdifcv)> 0)
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

        // if($boolprint) echo  print("sommavoti= ".$sumvoti).'<br>';
        // if($boolprint) echo  print("numvoti= ".$numvoti).'<br>';
        // if($boolprint) echo  print("mediadifesa= ".$mediadifesa).'<br>';
        // if($boolprint) echo  '<br>';
        return new RisultatoSquadra($sumvoti, $numvoti, $mediadifesa);
    }

    private function calcolaMediaDifesa($_numdif, $_sommavoti)
    {
        include "../globalsettings.php"; 
        // if($boolprint) echo  print("numdifcv= ".$_numdif).'<br>';
        // if($boolprint) echo  print("sumdifesa= ".$_sommavoti).'<br>';
        $ret  = 0;
        // $base = 0;
        // $step = 0;
        // switch ($_numdif) {
        //     case 3:{
        //             $base = 18.00;
        //             $step = 0.75;
        //             break;
        //         }
        //     case 4:{
        //             $base = 23.00;
        //             $step = 1;
        //             break;
        //         }
        //     case 5:{
        //             $base = 27.50;
        //             $step = 1.25;
        //             break;
        //         }
        
        // }
        if ($_numdif == 0)
        {$ret = 10;}
        else if ($_numdif == 1)
        {$ret = 6;}
        else if ($_numdif == 2)
        {$ret = 4;}
        else if ($_numdif == 3)
        {

            if ($_sommavoti < 12.75) {$ret = 8;} 
            elseif ($_sommavoti >= 12.75 && $_sommavoti < 13.5) {$ret = 7;} 
            elseif ($_sommavoti >= 13.5 && $_sommavoti < 14.25) {$ret = 6;} 
            elseif ($_sommavoti >= 14.25 && $_sommavoti < 15) {$ret = 5;} 
            elseif ($_sommavoti >= 15 && $_sommavoti < 15.75) {$ret = 4;} 
            elseif ($_sommavoti >= 15.75 && $_sommavoti < 16.5) {$ret = 3;} 
            elseif ($_sommavoti >= 16.5 && $_sommavoti < 17.25) {$ret = 2;} 
            elseif ($_sommavoti >= 17.25 && $_sommavoti < 18) {$ret = 1;} 
            elseif ($_sommavoti >= 18 && $_sommavoti < 18.75) {$ret = 0;} 
            elseif ($_sommavoti >= 18.75 && $_sommavoti < 19.5) {$ret = -1;} 
            elseif ($_sommavoti >= 19.5 && $_sommavoti < 20.25) {$ret = -2;} 
            elseif ($_sommavoti >= 20.25 && $_sommavoti < 21) {$ret = -3;} 
            elseif ($_sommavoti >= 21 && $_sommavoti < 21.75) {$ret = -4;} 
            elseif ($_sommavoti >= 21.75 && $_sommavoti < 22.5) {$ret = -5;} 
            elseif ($_sommavoti >= 22.5 && $_sommavoti < 23.25) {$ret = -6;} 
            elseif ($_sommavoti >= 23.25) {$ret = -7;} 
            
        }
        if ($_numdif == 4)
        {
            if ($_sommavoti < 17) {$ret = 7;} 
            elseif ($_sommavoti >= 17 && $_sommavoti < 18) {$ret = 6;} 
            elseif ($_sommavoti >= 18 && $_sommavoti < 19) {$ret = 5;} 
            elseif ($_sommavoti >= 19 && $_sommavoti < 20) {$ret = 4;} 
            elseif ($_sommavoti >= 20 && $_sommavoti < 21) {$ret = 3;} 
            elseif ($_sommavoti >= 21 && $_sommavoti < 22) {$ret = 2;} 
            elseif ($_sommavoti >= 22 && $_sommavoti < 23) {$ret = 1;} 
            elseif ($_sommavoti >= 23 && $_sommavoti < 24) {$ret = 0;} 
            elseif ($_sommavoti >= 18 && $_sommavoti < 25) {$ret = -1;} 
            elseif ($_sommavoti >= 18.75 && $_sommavoti < 26) {$ret = -2;} 
            elseif ($_sommavoti >= 19.5 && $_sommavoti < 27) {$ret = -3;} 
            elseif ($_sommavoti >= 20.25 && $_sommavoti < 28) {$ret = -4;} 
            elseif ($_sommavoti >= 21 && $_sommavoti < 29) {$ret = -5;} 
            elseif ($_sommavoti >= 21.75 && $_sommavoti < 30) {$ret = -6;} 
            elseif ($_sommavoti >= 22.5 && $_sommavoti < 31) {$ret = -7;} 
            elseif ($_sommavoti >= 31) {$ret = -8;} 
        }
        if ($_numdif == 5)
        {
            if ($_sommavoti < 21.25) {$ret = 7;} 
            elseif ($_sommavoti >= 21.25 && $_sommavoti < 22.5) {$ret = 6;} 
            elseif ($_sommavoti >= 22.5 && $_sommavoti < 23.25) {$ret = 5;} 
            elseif ($_sommavoti >= 23.25 && $_sommavoti < 24.5) {$ret = 4;} 
            elseif ($_sommavoti >= 24.5 && $_sommavoti < 25.75) {$ret = 3;} 
            elseif ($_sommavoti >= 25.75 && $_sommavoti < 27) {$ret = 2;} 
            elseif ($_sommavoti >= 27 && $_sommavoti < 28.25) {$ret = 1;} 
            elseif ($_sommavoti >= 28.25 && $_sommavoti < 29.5) {$ret = 0;} 
            elseif ($_sommavoti >= 29.5 && $_sommavoti < 30.75) {$ret = -1;} 
            elseif ($_sommavoti >= 30.75 && $_sommavoti < 32) {$ret = -2;} 
            elseif ($_sommavoti >= 32 && $_sommavoti < 33.25) {$ret = -3;} 
            elseif ($_sommavoti >= 33.25 && $_sommavoti < 34.5) {$ret = -4;} 
            elseif ($_sommavoti >= 34.5 && $_sommavoti < 35.75) {$ret = -5;} 
            elseif ($_sommavoti >= 35.75 && $_sommavoti < 37) {$ret = -6;} 
            elseif ($_sommavoti >= 37 && $_sommavoti < 37.25) {$ret = -7;} 
            elseif ($_sommavoti >= 38.25) {$ret = -8;} 
        }
        // if ($_numdif == 3 || $_numdif == 4 || $_numdif == 5) {
        //     if ($_sommavoti >= $base && $_sommavoti < ($base + ($step * 1))) {$ret = 0;} 
        //     else if ($_sommavoti < ($base) && $_sommavoti >= ($base - ($step * 1))) {$ret = 1;} 
        //     else if ($_sommavoti < ($base - ($step * 1)) && $_sommavoti >= ($base - ($step * 2))) {$ret = 2;} 
        //     else if ($_sommavoti < ($base - ($step * 2)) && $_sommavoti >= ($base - ($step * 3))) {$ret = 3;} 
        //     else if ($_sommavoti < ($base - ($step * 3)) && $_sommavoti >= ($base - ($step * 4))) {$ret = 4;} 
        //     else if ($_sommavoti < ($base - ($step * 4))) {$ret = 5;} 
        //     else if ($_sommavoti >= ($base) && $_sommavoti < ($base < ($step * 1))) {$ret = -1;} 
        //     else if ($_sommavoti >= ($base + ($step * 1)) && $_sommavoti < ($base - ($step * 2))) {$ret = -2;} 
        //     else if ($_sommavoti >= ($base + ($step * 2)) && $_sommavoti < ($base - ($step * 3))) {$ret = -3;} 
        //     else if ($_sommavoti >= ($base + ($step * 3)) && $_sommavoti < ($base - ($step * 4))) {$ret = -4;} 
        //     else if ($_sommavoti >= ($base + ($step * 4))) {$ret = 5;}
        // } else if ($_numdif == 2) {

        // } else if ($_numdif == 1) {

        // } else if ($_numdif == 0) {

        // }
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

    private function calcolaGol($sommavoti)
    {
        $ret = 0;
        $sogliaprimogol = 65;
        $step = 5;
        if($sommavoti < $sogliaprimogol){$ret = 0;}
        else
        {
            $ret = floor(($sommavoti-$sogliaprimogol)/5);
        }
        return $ret;
    }
}
