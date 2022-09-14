<?php
function statistiche_miglioreformazione_digiorntata($idGiornataSerieA, $idFantasquadra){
    global $localhost;
    global $username;
    global $password;
    global $database;

    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // $query = "SELECT g.*, ga.inizio, ga.fine
    // FROM `giornate` as g
    // left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
    // where id_girone in (1,2) order by id_giornata ASC";
    $query = "SELECT g.id, g.nome, g.ruolo, gv.voto as voto, gv.voto_md as voto_md, gv.voto_ufficio as voto_ufficio
    FROM giocatori as g
    left join rose as r on  g.id = r.id_giocatore
    left join `giocatori_voti` as gv on gv.giocatore_id = g.id
    where gv.`giornata_serie_a_id`= $idGiornataSerieA
    and r.id_sq_fc = $idFantasquadra
    order by g.ruolo desc, gv.voto desc";
    // if($idFantasquadra == 3)
    //     echo $query;
    $result=$conn->query($query) or die($conn->error);
    $voti = array();
    while ($row=$result->fetch_assoc()) {
        array_push($voti, array(
            "id"=>$row["id"],
            "nome"=>$row["nome"],
            "ruolo"=>$row["ruolo"],
            "voto"=>$row["voto"],
            "voto_md"=>$row["voto_md"],
            "voto_ufficio"=>$row["voto_ufficio"],
            )
        );
    }
    if($idFantasquadra == 3)
        print_r($voti);
    $num_att = 0;
    $num_cen = 0;
    $num_dif = 0;
    $num_por = 0;
    $sum541 = 0;
    $sum532 = 0;
    $sum451 = 0;
    $sum442 = 0;
    $sum433 = 0;
    $sum352 = 0;
    $sum343 = 0;
    $formazione541="";
    $formazione532=""; 
    $formazione451="";
    $formazione442="";
    $formazione433="";
    $formazione352="";
    $formazione343="";
    // echo "squadra: ". $idFantasquadra ."\r\n";
    foreach ($voti as $row){	
        $ruolo=$row["ruolo"];
        $voto = $row["voto"];
        $id = $row["id"];

        
        //541; 532;  451; 442; 433; 352; 343
        switch ( $ruolo) {
            case "P":
                if($num_por < 1)
                {
                    $num_por++;
                    $sum541 += $voto;
                    $formazione541 .= $id.",";
                    $sum532 += $voto;
                    $formazione532 .= $id.",";
                    $sum451 += $voto;
                    $formazione451 .= $id.",";
                    $sum442 += $voto;
                    $formazione442 .= $id.",";
                    $sum433 += $voto;
                    $formazione433 .= $id.",";
                    $sum352 += $voto;
                    $formazione352 .= $id.",";
                    $sum343 += $voto;
                    $formazione343 .= $id.",";
                }
                break;
            case "D":
                if($num_dif < 3)
                {
                    $num_dif++;
                    $sum541 += $voto;
                    $formazione541 .= $id.",";
                    $sum532 += $voto;
                    $formazione532 .= $id.",";
                    $sum451 += $voto;
                    $formazione451 .= $id.",";
                    $sum442 += $voto;
                    $formazione442 .= $id.",";
                    $sum433 += $voto;
                    $formazione433 .= $id.",";
                    $sum352 += $voto;
                    $formazione352 .= $id.",";
                    $sum343 += $voto;
                    $formazione343 .= $id.",";
                }
                else if ($num_dif < 4)
                {
                    $num_dif++;
                    $sum541 += $voto;
                    $formazione541 .= $id.",";
                    $sum532 += $voto;
                    $formazione532 .= $id.",";
                    $sum451 += $voto;
                    $formazione451 .= $id.",";
                    $sum442 += $voto;
                    $formazione442 .= $id.",";
                    $sum433 += $voto;
                    $formazione433 .= $id.",";
                    // $sum352 += $voto;
                    // $formazione352 .= $id.",";
                    // $sum343 += $voto;
                    // $formazione343 .= $id.",";
                }
                else if ($num_dif < 5)
                {
                    $num_dif++;
                    $sum541 += $voto;
                    $formazione541 .= $id.",";
                    $sum532 += $voto;
                    $formazione532 .= $id.",";
                    // $sum451 += $voto;
                    // $formazione451 .= $id.",";
                    // $sum442 += $voto;
                    // $formazione442 .= $id.",";
                    // $sum433 += $voto;
                    // $formazione433 .= $id.",";
                    // $sum352 += $voto;
                    // $formazione352 .= $id.",";
                    // $sum343 += $voto;
                    // $formazione343 .= $id.",";
                }
                break;
            case "C":
                if($num_cen < 3)
                {
                    $num_cen++;
                    $sum541 += $voto;
                    $formazione541 .= $id.",";
                    $sum532 += $voto;
                    $formazione532 .= $id.",";
                    $sum451 += $voto;
                    $formazione451 .= $id.",";
                    $sum442 += $voto;
                    $formazione442 .= $id.",";
                    $sum433 += $voto;
                    $formazione433 .= $id.",";
                    $sum352 += $voto;
                    $formazione352 .= $id.",";
                    $sum343 += $voto;
                    $formazione343 .= $id.",";
                }
                else if ($num_cen < 4)
                {
                    $num_cen++;
                    $sum541 += $voto;
                    $formazione541 .= $id.",";
                    // $sum532 += $voto;
                    // $formazione532 .= $id.",";
                    $sum451 += $voto;
                    $formazione451 .= $id.",";
                    $sum442 += $voto;
                    $formazione442 .= $id.",";
                    // $sum433 += $voto;
                    // $formazione433 .= $id.",";
                    $sum352 += $voto;
                    $formazione352 .= $id.",";
                    $sum343 += $voto;
                    $formazione343 .= $id.",";
                }
                else if ($num_cen < 5)
                {
                    $num_cen++;
                    // $sum541 += $voto;
                    // $formazione541 .= $id.",";
                    // $sum532 += $voto;
                    // $formazione532 .= $id.",";
                    $sum451 += $voto;
                    $formazione451 .= $id.",";
                    // $sum442 += $voto;
                    // $formazione442 .= $id.",";
                    // $sum433 += $voto;
                    // $formazione433 .= $id.",";
                    $sum352 += $voto;
                    $formazione352 .= $id.",";
                    // $sum343 += $voto;
                    // $formazione343 .= $id.",";
                }
                break;
            case "A":
                if($num_att < 1)
                {
                    $num_att++;
                    $sum541 += $voto;
                    $formazione541 .= $id.",";
                    $sum532 += $voto;
                    $formazione532 .= $id.",";
                    $sum451 += $voto;
                    $formazione451 .= $id.",";
                    $sum442 += $voto;
                    $formazione442 .= $id.",";
                    $sum433 += $voto;
                    $formazione433 .= $id.",";
                    $sum352 += $voto;
                    $formazione352 .= $id.",";
                    $sum343 += $voto;
                    $formazione343 .= $id.",";
                }
                else if($num_att < 2)
                {
                    $num_att++;
                    // $sum541 += $voto;
                    // $formazione541 .= $id.",";
                    $sum532 += $voto;
                    $formazione532 .= $id.",";
                    // $sum451 += $voto;
                    // $formazione451 .= $id.",";
                    $sum442 += $voto;
                    $formazione442 .= $id.",";
                    $sum433 += $voto;
                    $formazione433 .= $id.",";
                    $sum352 += $voto;
                    $formazione352 .= $id.",";
                    $sum343 += $voto;
                    $formazione343 .= $id.",";
                }
                else if($num_att < 3)
                {
                    $num_att++;
                    // $sum541 += $voto;
                    // $formazione541 .= $id.",";
                    // $sum532 += $voto;
                    // $formazione535 .= $id.",";
                    // $sum451 += $voto;
                    // $formazione451 .= $id.",";
                    // $sum442 += $voto;
                    // $formazione442 .= $id.",";
                    $sum433 += $voto;
                    $formazione433 .= $id.",";
                    // $sum352 += $voto;
                    // $formazione352 .= $id.",";
                    $sum343 += $voto;
                    $formazione343 .= $id.",";
                }
                break;
            default:
                break;
        }
        // if($idFantasquadra == 3)
        // {
        //     print_r($row);
        //     echo "por: ".$num_por ."; ";
        //     echo "dif: ".$num_dif."; ";
        //     echo "cen: ".$num_cen."; ";
        //     echo "att: ".$num_att."; ";
        //     echo "541: ".$sum541."; ";
        //     echo "532: ".$sum532."; ";
        //     echo "541: ".$sum451."; ";
        //     echo "451: ".$sum451."; ";
        //     echo "442: ".$sum442."; ";
        //     echo "433: ".$sum433."; ";
        //     echo "352: ".$sum352."; ";
        //     echo "343: ".$sum343."; ";
        //     echo "\r\n";
        // }
    } 
    $max_score = 0;
    $max_score_modulo = 0;
    $max_score_formazione = 0;

    
    
    if($max_score < $sum541 )
    {
        $max_score = $sum541;
        $max_score_modulo = "541";
        $max_score_formazione = $formazione541;
    }
    if($max_score < $sum532 )
    {
        
        $max_score = $sum532;
        $max_score_modulo = "532";
        $max_scomax_score_formazionere_modulo = $formazione532;
    }
    if($max_score < $sum451 )
    {
        
        $max_score = $sum451;
        $max_score_modulo = "451";
        $max_score_formazione = $formazione451;
    }
    if($max_score < $sum442 )
    {
        
        $max_score = $sum442;
        $max_score_modulo = "442";
        $max_score_formazione = $formazione442;
    }
    if($max_score < $sum433 )
    {
        
        $max_score = $sum433;
        $max_score_modulo = "433";
        $max_score_formazione = $formazione433;
    }
    if($max_score < $sum352 )
    {
        
        $max_score = $sum352;
        $max_score_modulo = "352";
        $max_score_formazione = $formazione343;
    }
    if($max_score < $sum343 )
    {
        
        $max_score = $sum343;
        $max_score_modulo = "343";
        $max_score_formazione = $formazione343;
    }
    $query = "DELETE FROM `sq_fantacalcio_statistiche_giornata` WHERE `giornata_serie_a_id` = $idGiornataSerieA and `sq_fantacalcio_id` = $idFantasquadra";
    $result=$conn->query($query) or die($conn->error);
    // return $giornatefc;
    $query = "INSERT INTO `sq_fantacalcio_statistiche_giornata`(`sq_fantacalcio_id`, `giornata_serie_a_id`, `punteggio`, `modulo`, `formazione_ideale`) VALUES ($idFantasquadra,$idGiornataSerieA,$max_score,'$max_score_modulo', '$max_score_formazione') ";
    // if($idFantasquadra == 3) echo $query;
    $result=$conn->query($query) or die($conn->error);

    // echo  "formazione_ideale: ".$max_score_modulo."; ".$max_score_formazione ."\r\n";
}

?>