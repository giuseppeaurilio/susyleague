CREATE TABLE `annunci` ( `id` INT NOT NULL AUTO_INCREMENT , `titolo` VARCHAR(100) NOT NULL , `testo` VARCHAR(1000) NOT NULL , `dal` DATETIME NOT NULL , `al` DATETIME NOT NULL , PRIMARY KEY (`id`))

DROP PROCEDURE IF EXISTS `getAnnunciAttivi`; 
CREATE PROCEDURE `getAnnunciAttivi`() NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER select * from annunci where CURRENT_DATE() >= dal and CURRENT_DATE() < al;

DROP PROCEDURE IF EXISTS `getAnnunciMercato`;
CREATE PROCEDURE `getAnnunciMercato`() NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER select id, testo, squadra, data_annuncio from mercato as m left join sq_fantacalcio as sqf on m.id_squadra= sqf.id order by m.data_annuncio DESC limit 5;

DROP PROCEDURE IF EXISTS `getSondaggiAttivi`; 
CREATE PROCEDURE `getSondaggiAttivi`() NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER SELECT * from sondaggi where scadenza > CURRENT_DATE();

DROP PROCEDURE IF EXISTS `getRisposteSondaggio`; 
CREATE PROCEDURE `getRisposteSondaggio`(IN `idSondaggio` INT) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER select * from sondaggi_opzioni where id_sondaggio = idSondaggio;

DROP PROCEDURE IF EXISTS `getRisposteSquadreSondaggio`; 
CREATE PROCEDURE `getRisposteSquadreSondaggio`(IN `idSondaggio` INT, IN `idOpzione` INT) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER select count(*) count(*) as num from sondaggi_risposte where id_sondaggio = idSondaggio and id_opzione = idOpzione;

