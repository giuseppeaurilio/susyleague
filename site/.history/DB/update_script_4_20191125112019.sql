DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `widget_prossimoturno`(IN `pGirone` INT)
    NO SQL
BEGIN
	CREATE TEMPORARY TABLE formazioni_inviate
        select count(*) as lineup,  id_giornata ,id_squadra  from formazioni 
        group by id_giornata, id_squadra ;
	
	SELECT g.id_giornata, sqf1.squadra as sq_casa, 
        sqf2.squadra as sq_ospite,
        if(f1.lineup = 19, true, false) as luc, 
        if(f2.lineup = 19, true, false) as luo
    
        FROM giornate as g 
        left join calendario as c on g.id_giornata =  c.id_giornata
        left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
		left join formazioni_inviate as f1 on f1.id_giornata = c.id_giornata and  f1.id_squadra=c.id_sq_casa 
		left join formazioni_inviate as f2 on f2.id_giornata = c.id_giornata and  f2.id_squadra=c.id_sq_ospite
        where fine > DATE_ADD(NOW(), INTERVAL 2 HOUR)
        AND inizio < DATE_ADD(NOW(), INTERVAL 2 HOUR)
		
		and id_girone = pGirone
        order by id_partita;
        END$$
DELIMITER ;