/*SCAMBI */
DROP TABLE IF EXISTS `scambi`;
CREATE TABLE `scambi` ( `id` INT NOT NULL , `data` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


DROP TABLE IF EXISTS `scambi_dettagli`;
CREATE TABLE `scambi_dettagli` ( `id` INT NOT NULL , `scambio_id` INT NOT NULL , `giocatore_id` INT NULL , `squadra_or_id` INT NULL , `squadra_dest_id` INT NULL , `note` VARCHAR NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

