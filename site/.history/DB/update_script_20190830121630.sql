/*creazione nuova competizioni */
INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 4, 'coppa italia', 0) AS tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 4
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 5, 'finale coppa italia', 0) AS tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 5
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT  6, 'torneo di consolazione', 0) AS tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 6
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 7, 'finale campionato', 0) AS tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 7
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 8, 'coppa delle  coppe', 0) AS tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 8
) LIMIT 1;


/*coppaitalia: creazione tabelle gironi_ci */
DROP TABLE IF EXISTS `gironi_ci`;
CREATE TABLE `gironi_ci` ( `id` INT NOT NULL , `descrizione` VARCHAR(100) NOT NULL) ENGINE = InnoDB;

INSERT INTO `gironi_ci` (`id`, `descrizione`)
SELECT * FROM (SELECT 1, 'Girone A') AS tmp
WHERE NOT EXISTS (
    SELECT `descrizione` FROM `gironi_ci` WHERE `id` = 1
) LIMIT 1;

INSERT INTO `gironi_ci` (`id`, `descrizione`)
SELECT * FROM (SELECT 2, 'Girone B') AS tmp
WHERE NOT EXISTS (
    SELECT `descrizione` FROM `gironi_ci` WHERE `id` = 2
) LIMIT 1;

/*coppaitalia: creazione tabelle gironi_ci_squadre */
DROP TABLE IF EXISTS `gironi_ci_squadre`;
CREATE TABLE `gironi_ci_squadre` ( `id_girone` INT NOT NULL , `id_squadra` INT NOT NULL, `squadra_materasso` bit ) ENGINE = InnoDB;

/*torneoconsolazione: creazione tabelle gironi_ci_squadre */
DROP TABLE IF EXISTS `gironi_tc_squadre`;
CREATE TABLE `gironi_tc_squadre` ( `id_girone` INT NOT NULL , `id_squadra` INT NOT NULL ) ENGINE = InnoDB;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getClassifica`(IN `pIdGirone` INT)
    NO SQL
select cc.idsquadrac as idsquadra,sf.squadra, 
cc.puntic + ct.puntit as punti,
cc.marcatoric + ct.marcatorit as marcatori,
cc.vittoriec + ct.vittoriet as vittorie	,
cc.pareggic + ct.pareggit as pareggi,
cc.sconfittec + ct.sconfittet as sconfitte,
cc.golfattic + ct.golfattit as golfatti,
cc.golsubitic + ct.golsubitit as golsubiti,
cc.marcatoric,  cc.vittoriec, cc.pareggic, cc.sconfittec, cc.golfattic, cc.golsubitic,
ct.marcatorit, ct.vittoriet, ct.pareggit, ct.sconfittet, ct.golfattit, ct.golsubitit
from

(SELECT c.id_sq_casa as idsquadrac, 
SUM(case 
	when gol_casa> gol_ospiti then 3 
    when gol_casa = gol_ospiti then 1
    when gol_casa< gol_ospiti then 0 
end) as puntic,
SUM(punti_casa) as marcatoric, 
SUM(case 
	when gol_casa> gol_ospiti then 1 
    ELSE 0
end) as vittoriec,
SUM(case 
	when gol_casa = gol_ospiti then 1 
    ELSE 0
end) as pareggic,
SUM(case 
	when gol_casa < gol_ospiti then 1 
    ELSE 0
end) as sconfittec,
SUM(gol_casa) as golfattic,
SUM(gol_ospiti) as golsubitic
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone = pIdGirone
group by id_sq_casa
order by puntic desc) AS cc
JOIN  (
SELECT c.id_sq_ospite as idsquadrat, 
SUM(case 
	when gol_ospiti > gol_casa then 3 
    when gol_ospiti = gol_casa then 1
    when gol_ospiti < gol_casa then 0 
end) as puntit,
SUM(punti_ospiti) as marcatorit, 
SUM(case 
	when gol_ospiti > gol_casa then 1 
    ELSE 0
end) as vittoriet,
SUM(case 
	when gol_ospiti = gol_casa then 1 
    ELSE 0
end) as pareggit,
SUM(case 
	when gol_ospiti < gol_casa then 1 
    ELSE 0
end) as sconfittet,
SUM(gol_casa) as golsubitit,
SUM(gol_ospiti) as golfattit
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone = pIdGirone
group by id_sq_ospite
order by puntit desc)as ct
ON cc.idsquadrac=ct.idsquadrat

left  join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getClassificaAggregate`()
    NO SQL
select cc.idsquadrac as idsquadra,sf.squadra, 
cc.puntic + ct.puntit as punti,
cc.marcatoric + ct.marcatorit as marcatori,
cc.vittoriec + ct.vittoriet as vittorie,
cc.pareggic + ct.pareggit as pareggi,
cc.sconfittec + ct.sconfittet as sconfitte,
cc.golfattic + ct.golfattit as golfatti,
cc.golsubitic + ct.golsubitit as golsubiti,
cc.marcatoric,  cc.vittoriec, cc.pareggic, cc.sconfittec, cc.golfattic, cc.golsubitic,
ct.marcatorit, ct.vittoriet, ct.pareggit, ct.sconfittet, ct.golfattit, ct.golsubitit
from

(SELECT c.id_sq_casa as idsquadrac, 
SUM(case 
	when gol_casa> gol_ospiti then 3 
    when gol_casa = gol_ospiti then 1
    when gol_casa< gol_ospiti then 0 
end) as puntic,
SUM(punti_casa) as marcatoric, 
SUM(case 
	when gol_casa> gol_ospiti then 1 
    ELSE 0
end) as vittoriec,
SUM(case 
	when gol_casa = gol_ospiti then 1 
    ELSE 0
end) as pareggic,
SUM(case 
	when gol_casa < gol_ospiti then 1 
    ELSE 0
end) as sconfittec,
SUM(gol_casa) as golfattic,
SUM(gol_ospiti) as golsubitic
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone in (1,2)
group by id_sq_casa
order by puntic desc) AS cc
JOIN  (
SELECT c.id_sq_ospite as idsquadrat, 
SUM(case 
	when gol_ospiti > gol_casa then 3 
    when gol_ospiti = gol_casa then 1
    when gol_ospiti < gol_casa then 0 
end) as puntit,
SUM(punti_ospiti) as marcatorit, 
SUM(case 
	when gol_ospiti > gol_casa then 1 
    ELSE 0
end) as vittoriet,
SUM(case 
	when gol_ospiti = gol_casa then 1 
    ELSE 0
end) as pareggit,
SUM(case 
	when gol_ospiti < gol_casa then 1 
    ELSE 0
end) as sconfittet,
SUM(gol_casa) as golsubitit,
SUM(gol_ospiti) as golfattit
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone in (1,2)
group by id_sq_ospite
order by puntit desc)as ct
ON cc.idsquadrac=ct.idsquadrat

left  join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc$$
DELIMITER ;

ALTER TABLE `formazioni` ADD `sostituzione` BOOLEAN NOT NULL AFTER `id_posizione`;

DROP VIEW IF EXISTS `classifiche`;
DROP VIEW IF EXISTS `media_difesa_casa`;
DROP VIEW IF EXISTS `media_difesa_ospite`;
DROP VIEW IF EXISTS `numero_difensori`;
DROP VIEW IF EXISTS `numero_giocanti`;
DROP VIEW IF EXISTS `punteggio_casa`;
DROP VIEW IF EXISTS `punteggio_finale`;
DROP VIEW IF EXISTS `punteggio_ospite`;
DROP VIEW IF EXISTS `sommario`;

ALTER TABLE `calendario` ADD `fattorecasa` int NOT NULL AFTER `punti_ospiti`;
ALTER TABLE `calendario` ADD `md_casa` int NOT NULL DEFAULT '0' AFTER `fattorecasa` ;
ALTER TABLE `calendario` ADD `numero_giocanti_casa` int NOT NULL DEFAULT '0' AFTER `md_casa`;
ALTER TABLE `calendario` ADD `md_ospite` int NOT NULL DEFAULT '0' AFTER `numero_giocanti_casa`;
ALTER TABLE `calendario` ADD `numero_giocanti_ospite` int NOT NULL DEFAULT '0' AFTER `md_ospite`;
