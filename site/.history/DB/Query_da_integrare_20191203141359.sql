ALTER TABLE `calendario` ADD `formazione_casa_inviata` BOOLEAN NOT NULL DEFAULT FALSE AFTER `id_sq_casa`;
ALTER TABLE `calendario` ADD `formazione_ospite_inviata` BOOLEAN NOT NULL DEFAULT FALSE AFTER `id_sq_ospite`;

DELIMITER $$
CREATE PROCEDURE `widget_prossimoturno`(IN `pGirone` INT)
    NO SQL
BEGIN
	SELECT g.id_giornata, sqf1.squadra as sq_casa, 
        sqf2.squadra as sq_ospite,
        c.formazione_casa_inviata as luc, 
         c.formazione_ospite_inviata as luo
    
        FROM giornate as g 
        left join calendario as c on g.id_giornata =  c.id_giornata
        left  join sq_fantacalcio as sqf1 on sqf1.id=c.id_sq_casa 
        LEFT join sq_fantacalcio as sqf2 on sqf2.id=c.id_sq_ospite
        where fine > DATE_ADD(NOW(), INTERVAL 2 HOUR)
        AND inizio < DATE_ADD(NOW(), INTERVAL 2 HOUR)
		
		and id_girone = pGirone
        order by id_partita;
        END$$
DELIMITER ;
