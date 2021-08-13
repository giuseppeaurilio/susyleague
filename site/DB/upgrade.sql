CREATE TABLE `formazione_standard` ( `id_squadra` INT NOT NULL , `id_giocatore` INT NOT NULL , `id_posizione` INT NOT NULL , `id_squadra_sa` INT NOT NULL , `id_tipo_formazione` INT NOT NULL )

CREATE TABLE `giornate_serie_a` ( `id` INT NOT NULL AUTO_INCREMENT , `descrizione` VARCHAR(100) NOT NULL , `inizio` DATETIME NULL , `fine` DATETIME NULL , PRIMARY KEY (`id`))
ALTER TABLE `giornate` DROP `inizio`;
ALTER TABLE `giornate` DROP `fine`;
ALTER TABLE `giornate` ADD `giornata_serie_a_id` INT NULL AFTER `id_girone`;

CREATE TABLE `giocatori_voti` ( `id` INT NULL AUTO_INCREMENT , `giocatore_id` INT NOT NULL , `giornata_serie_a_id` INT NOT NULL , `voto` FLOAT NOT NULL , `voto_md` FLOAT NOT NULL , PRIMARY KEY (`id`));
ALTER TABLE `formazioni` DROP `id_squadra_sa`;
ALTER TABLE `formazioni` DROP `voto`;
ALTER TABLE `formazioni` DROP `voto_md`;
CREATE TABLE `rose_asta_ap` (`id_giocatore` int(11) NOT NULL,  `id_sq_fc` int(11) NOT NULL,  `costo` int(11) NOT NULL,  `ordine` int(11) NOT NULL)