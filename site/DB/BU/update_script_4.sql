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
DELIMITER $$
CREATE  PROCEDURE `statistiche_mediadifesa`(IN `pIdGirone` INT)
    NO SQL
select mdfc.id_sq_casa, mdfc.squadra , 
md_f_c, md_f_t, (md_f_c+md_f_t) as md_f,
md_c_c, md_c_t, (md_c_c+md_c_t) as md_c,
((md_c_c+md_c_t) - (md_f_c+md_f_t)) as md
from 
(
SELECT c.id_sq_casa, sqf.squadra squadra, sum(md_ospite) as md_f_c
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_casa

where g.id_girone = pIdGirone
GROUP by c.id_sq_casa
) as mdfc
join 
(
SELECT c.id_sq_ospite, sqf.squadra, sum(md_casa) as md_f_t
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_ospite

where g.id_girone = pIdGirone
GROUP by c.id_sq_ospite
)as mdft
on mdfc.id_sq_casa = mdft.id_sq_ospite
join
(
SELECT c.id_sq_casa, sqf.squadra squadra, sum(md_casa) as md_c_c
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_casa

where g.id_girone = pIdGirone
GROUP by c.id_sq_casa
) as mdcc
on mdfc.id_sq_casa = mdcc.id_sq_casa
join 
(
SELECT c.id_sq_ospite, sqf.squadra, sum(md_ospite) as md_c_t
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_ospite

where g.id_girone = pIdGirone
GROUP by c.id_sq_ospite
) as  mdct
on mdfc.id_sq_casa = mdct.id_sq_ospite
order by md desc$$
DELIMITER ;