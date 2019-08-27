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