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

