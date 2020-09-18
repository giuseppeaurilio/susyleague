ALTER DATABASE id258940_susy_league_20_21 CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE annunci CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE calendario CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE contafusti CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE formazioni CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE generale CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE giocatori CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE giornate CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE gironi CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE gironi_ci CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE gironi_ci_squadre CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE gironi_tc_squadre CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE mercato CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE presidente_annunci CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE rose CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE scambi CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE scambi_dettagli CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE sondaggi CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE sondaggi_opzioni CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE sondaggi_risposte CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE squadre_serie_a CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE sq_fantacalcio CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE vincitori CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `sq_fantacalcio` ADD `ammcontrollata_anno` INT NOT NULL DEFAULT '0' AFTER `ammcontrollata`;
DROP TABLE `vincitori`;
CREATE TABLE `vincitori` ( `id` INT NOT NULL AUTO_INCREMENT , `competizione_id` INT NULL, `desc_competizione` VARCHAR(50) NOT NULL , `posizione` INT NULL , `sq_id` INT NULL , PRIMARY KEY (`id`))
ALTER TABLE `giocatori` ADD `quotazione` INT NOT NULL DEFAULT '0' AFTER `id_squadra`;
ALTER TABLE `rose` ADD `ordine` INT NOT NULL AUTO_INCREMENT AFTER `id_giocatore`, ADD UNIQUE `unique_ordine` (`ordine`);

CREATE TABLE `giocatori_statistiche` ( `id` INT NOT NULL , `giocatore_id` INT NOT NULL , `anno` VARCHAR(50) NOT NULL , `pg` INT NOT NULL , `mv` DECIMAL NOT NULL , `mf` DECIMAL NOT NULL , `gf` INT NOT NULL , `gs` INT NOT NULL , `rp` INT NOT NULL , `rc` INT NOT NULL , `r+` INT NOT NULL , `r-` INT NOT NULL , `ass` INT NOT NULL , `amm` INT NOT NULL , `esp` INT NOT NULL , `au` INT NOT NULL , PRIMARY KEY (`id`));
ALTER TABLE `giocatori_statistiche` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `giocatori_statistiche` CHANGE `mv` `mv` FLOAT NOT NULL;
ALTER TABLE `giocatori_statistiche` CHANGE `mf` `mf` FLOAT NOT NULL;
CREATE TABLE `giocatori_pinfo` ( `id` INT NOT NULL AUTO_INCREMENT , `ip` INT NOT NULL , PRIMARY KEY (`id`)) ;
ALTER TABLE `giocatori_pinfo` ADD `giocatore_id` INT NOT NULL AFTER `id`;
ALTER TABLE `giocatori_pinfo` ADD `titolarita` INT NOT NULL AFTER `giocatore_id`, ADD `cp` INT NOT NULL AFTER `titolarita`, ADD `cr` INT NOT NULL AFTER `cp`, ADD `ca` INT NOT NULL AFTER `cr`, ADD `val` INT NOT NULL AFTER `ca`, ADD `ia` INT NOT NULL AFTER `val`;
