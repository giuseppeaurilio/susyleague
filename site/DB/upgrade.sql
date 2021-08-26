CREATE TABLE `formazione_standard` ( `id_squadra` INT NOT NULL , `id_giocatore` INT NOT NULL , `id_posizione` INT NOT NULL , `id_squadra_sa` INT NOT NULL , `id_tipo_formazione` INT NOT NULL );
CREATE TABLE `giornate_serie_a` ( `id` INT NOT NULL AUTO_INCREMENT , `descrizione` VARCHAR(100) NOT NULL , `inizio` DATETIME NULL , `fine` DATETIME NULL , PRIMARY KEY (`id`));
ALTER TABLE `giornate` DROP `inizio`;
ALTER TABLE `giornate` DROP `fine`;
ALTER TABLE `giornate` ADD `giornata_serie_a_id` INT NULL AFTER `id_girone`;
CREATE TABLE `giocatori_voti` ( `id` INT NULL AUTO_INCREMENT , `giocatore_id` INT NOT NULL , `giornata_serie_a_id` INT NOT NULL , `voto` FLOAT NOT NULL , `voto_md` FLOAT NOT NULL , PRIMARY KEY (`id`));
ALTER TABLE `giocatori_voti` ADD `voto_ufficio` BOOLEAN NULL AFTER `voto_md`;
ALTER TABLE `formazioni` DROP `id_squadra_sa`;
ALTER TABLE `formazioni` DROP `voto`;
ALTER TABLE `formazioni` DROP `voto_md`;
CREATE TABLE `rose_asta` (`id_giocatore` int(11) NOT NULL,  `id_sq_fc` int(11) NOT NULL,  `costo` int(11) NOT NULL,  `ordine` int(11) NOT NULL);
ALTER TABLE `rose_asta`  ADD PRIMARY KEY (`ordine`),  ADD UNIQUE KEY `unique_id_giocatore` (`id_giocatore`);
ALTER TABLE `rose_asta`  MODIFY `ordine` int(11) NOT NULL AUTO_INCREMENT