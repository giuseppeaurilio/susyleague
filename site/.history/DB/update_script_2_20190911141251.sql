/*creazione nuova competizioni */
INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 4, 'coppa italia', 0)  as    tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 4
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 5, 'tabellone coppa italia', 0)  as    tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 5
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT  6, 'coppa delle coppe', 0)  as    tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 6
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 7, 'finale campionato', 0)  as    tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 7
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 8, 'supercoppa', 0)  as    tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 8
) LIMIT 1;

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`)
SELECT * FROM (SELECT 9, 'finale coppa italia', 0)  as    tmp
WHERE NOT EXISTS (
    SELECT nome FROM `gironi` WHERE id_girone = 9
) LIMIT 1;


/*coppaitalia: creazione tabelle gironi_ci */
DROP TABLE IF EXISTS `gironi_ci`;
CREATE TABLE `gironi_ci` ( `id` INT NOT NULL , `descrizione` VARCHAR(100) NOT NULL) ENGINE = InnoDB;

INSERT INTO `gironi_ci` (`id`, `descrizione`)
SELECT * FROM (SELECT 1, 'Girone A')  as    tmp
WHERE NOT EXISTS (
    SELECT `descrizione` FROM `gironi_ci` WHERE `id` = 1
) LIMIT 1;

INSERT INTO `gironi_ci` (`id`, `descrizione`)
SELECT * FROM (SELECT 2, 'Girone B')  as    tmp
WHERE NOT EXISTS (
    SELECT `descrizione` FROM `gironi_ci` WHERE `id` = 2
) LIMIT 1;

/*coppaitalia: creazione tabelle gironi_ci_squadre */
DROP TABLE IF EXISTS `gironi_ci_squadre`;
CREATE TABLE `gironi_ci_squadre` ( `id_girone` INT NOT NULL , `id_squadra` INT NOT NULL, `squadra_materasso` bit ) ENGINE = InnoDB;

/*torneoconsolazione: creazione tabelle gironi_ci_squadre */
DROP TABLE IF EXISTS `gironi_tc_squadre`;
CREATE TABLE `gironi_tc_squadre` ( `id_girone` INT NOT NULL , `id_squadra` INT NOT NULL ) ENGINE = InnoDB;

DROP PROCEDURE IF EXISTS `getClassifica`;

DELIMITER $$
CREATE PROCEDURE `getClassifica`(IN `pIdGirone` INT)
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
COALESCE( SUM( case 
	when gol_casa> gol_ospiti then 3 
    when gol_casa = gol_ospiti then 1
    when gol_casa< gol_ospiti then 0 
end) ,0 ) as   puntic,
COALESCE( SUM( punti_casa) ,0 ) as   marcatoric, 
COALESCE( SUM( case 
	when gol_casa> gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   vittoriec,
COALESCE( SUM( case 
	when gol_casa = gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   pareggic,
COALESCE( SUM( case 
	when gol_casa < gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   sconfittec,
COALESCE( SUM( gol_casa) ,0 ) as   golfattic,
COALESCE( SUM( gol_ospiti) ,0 ) as   golsubitic
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone = pIdGirone
group by id_sq_casa
order by puntic desc)  as    cc
JOIN  (
SELECT c.id_sq_ospite as idsquadrat, 
COALESCE( SUM( case 
	when gol_ospiti > gol_casa then 3 
    when gol_ospiti = gol_casa then 1
    when gol_ospiti < gol_casa then 0 
end) ,0 ) as   puntit,
COALESCE( SUM( punti_ospiti) ,0 ) as   marcatorit, 
COALESCE( SUM( case 
	when gol_ospiti > gol_casa then 1 
    ELSE 0
end) ,0 ) as   vittoriet,
COALESCE( SUM( case 
	when gol_ospiti = gol_casa then 1 
    ELSE 0
end) ,0 ) as   pareggit,
COALESCE( SUM( case 
	when gol_ospiti < gol_casa then 1 
    ELSE 0
end) ,0 ) as   sconfittet,
COALESCE( SUM( gol_casa) ,0 ) as   golsubitit,
COALESCE( SUM( gol_ospiti) ,0 ) as   golfattit
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone = pIdGirone
group by id_sq_ospite
order by puntit desc)as ct
ON cc.idsquadrac=ct.idsquadrat

left  join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `getClassificaAggregateAperturaChiusura`;

DELIMITER $$
CREATE PROCEDURE `getClassificaAggregateAperturaChiusura`()
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
COALESCE( SUM( case 
	when gol_casa> gol_ospiti then 3 
    when gol_casa = gol_ospiti then 1
    when gol_casa< gol_ospiti then 0 
end) ,0 ) as   puntic,
COALESCE( SUM( punti_casa) ,0 ) as   marcatoric, 
COALESCE( SUM( case 
	when gol_casa> gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   vittoriec,
COALESCE( SUM( case 
	when gol_casa = gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   pareggic,
COALESCE( SUM( case 
	when gol_casa < gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   sconfittec,
COALESCE( SUM( gol_casa) ,0 ) as   golfattic,
COALESCE( SUM( gol_ospiti) ,0 ) as   golsubitic
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone in (1,2)
group by id_sq_casa
order by puntic desc)  as    cc
JOIN  (
SELECT c.id_sq_ospite as idsquadrat, 
COALESCE( SUM( case 
	when gol_ospiti > gol_casa then 3 
    when gol_ospiti = gol_casa then 1
    when gol_ospiti < gol_casa then 0 
end) ,0 ) as   puntit,
COALESCE( SUM( punti_ospiti) ,0 ) as   marcatorit, 
COALESCE( SUM( case 
	when gol_ospiti > gol_casa then 1 
    ELSE 0
end) ,0 ) as   vittoriet,
COALESCE( SUM( case 
	when gol_ospiti = gol_casa then 1 
    ELSE 0
end) ,0 ) as   pareggit,
COALESCE( SUM( case 
	when gol_ospiti < gol_casa then 1 
    ELSE 0
end) ,0 ) as   sconfittet,
COALESCE( SUM( gol_casa) ,0 ) as   golsubitit,
COALESCE( SUM( gol_ospiti) ,0 ) as   golfattit
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
WHERE g.id_girone in (1,2)
group by id_sq_ospite
order by puntit desc)as ct
ON cc.idsquadrac=ct.idsquadrat

left  join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `getClassificaGironeCoppaItalia`;

DELIMITER $$
CREATE PROCEDURE `getClassificaGironeCoppaItalia`(IN `pIdGirone` INT, IN `pIdGironeCI` INT)
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
COALESCE( SUM( case 
	when gol_casa> gol_ospiti then 3 
    when gol_casa = gol_ospiti then 1
    when gol_casa< gol_ospiti then 0 
end) ,0 ) as   puntic,
COALESCE( SUM( punti_casa) ,0 ) as   marcatoric, 
COALESCE( SUM( case 
	when gol_casa> gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   vittoriec,
COALESCE( SUM( case 
	when gol_casa = gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   pareggic,
COALESCE( SUM( case 
	when gol_casa < gol_ospiti then 1 
    ELSE 0
end) ,0 ) as   sconfittec,
COALESCE( SUM( gol_casa) ,0 ) as   golfattic,
COALESCE( SUM( gol_ospiti) ,0 ) as   golsubitic
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
left JOIN gironi_ci_squadre gcis on c.id_sq_casa = gcis.id_squadra
WHERE g.id_girone = pIdGirone
AND gcis.id_girone = pIdGironeCI
group by id_sq_casa
order by puntic desc)  as    cc
JOIN  (
SELECT c.id_sq_ospite as idsquadrat, 
COALESCE( SUM( case 
	when gol_ospiti > gol_casa then 3 
    when gol_ospiti = gol_casa then 1
    when gol_ospiti < gol_casa then 0 
end) ,0 ) as   puntit,
COALESCE( SUM( punti_ospiti) ,0 ) as   marcatorit, 
COALESCE( SUM( case 
	when gol_ospiti > gol_casa then 1 
    ELSE 0
end) ,0 ) as   vittoriet,
COALESCE( SUM( case 
	when gol_ospiti = gol_casa then 1 
    ELSE 0
end) ,0 ) as   pareggit,
COALESCE( SUM( case 
	when gol_ospiti < gol_casa then 1 
    ELSE 0
end) ,0 ) as   sconfittet,
COALESCE( SUM( gol_casa) ,0 ) as   golsubitit,
COALESCE( SUM( gol_ospiti) ,0 ) as   golfattit
FROM `calendario` as c
left JOIN giornate g on g.id_giornata = c.id_giornata
left JOIN gironi_ci_squadre gcis on c.id_sq_casa = gcis.id_squadra
WHERE g.id_girone = pIdGirone
AND gcis.id_girone = pIdGironeCI
group by id_sq_ospite
order by puntit desc)as ct
ON cc.idsquadrac=ct.idsquadrat
left  join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc$$
DELIMITER ;

DROP VIEW IF EXISTS `classifiche`;
DROP VIEW IF EXISTS `media_difesa_casa`;
DROP VIEW IF EXISTS `media_difesa_ospite`;
DROP VIEW IF EXISTS `numero_difensori`;
DROP VIEW IF EXISTS `numero_giocanti`;
DROP VIEW IF EXISTS `punteggio_casa`;
DROP VIEW IF EXISTS `punteggio_finale`;
DROP VIEW IF EXISTS `punteggio_ospite`;
DROP VIEW IF EXISTS `sommario`;

ALTER TABLE `formazioni` ADD `sostituzione` BOOLEAN NOT NULL AFTER `id_posizione`;
ALTER TABLE `calendario` ADD `fattorecasa` int NOT NULL DEFAULT '0' NULL AFTER `punti_ospiti`;
ALTER TABLE `calendario` ADD `md_casa` int NOT NULL DEFAULT '0' AFTER `fattorecasa` ;
ALTER TABLE `calendario` ADD `numero_giocanti_casa` int NOT NULL DEFAULT '0' AFTER `md_casa`;
ALTER TABLE `calendario` ADD `md_ospite` int NOT NULL DEFAULT '0' AFTER `numero_giocanti_casa`;
ALTER TABLE `calendario` ADD `numero_giocanti_ospite` int NOT NULL DEFAULT '0' AFTER `md_ospite`;

ALTER TABLE `sq_fantacalcio` ADD `ammcontrollata` int NOT NULL DEFAULT '0' AFTER `password`;


