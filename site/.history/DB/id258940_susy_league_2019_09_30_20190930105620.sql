-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Set 30, 2019 alle 08:55
-- Versione del server: 10.3.16-MariaDB
-- Versione PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id258940_susy_league`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`id258940_susy79`@`%` PROCEDURE `getAnnunciAttivi` ()  NO SQL
select * from annunci where CURRENT_DATE() >= dal and CURRENT_DATE() < al$$

CREATE DEFINER=`id258940_susy79`@`%` PROCEDURE `getAnnunciMercato` ()  NO SQL
select id, testo, squadra, data_annuncio from mercato as m left join sq_fantacalcio as sqf on m.id_squadra= sqf.id order by m.data_annuncio DESC limit 5$$

CREATE DEFINER=`id258940_susy79`@`%` PROCEDURE `getClassifica` (IN `pIdGirone` INT)  NO SQL
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

left join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc, marcatori desc, golfattit desc$$

CREATE DEFINER=`id258940_susy79`@`%` PROCEDURE `getClassificaAggregateAperturaChiusura` ()  NO SQL
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

left join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc, marcatori desc, golfattit desc$$

CREATE DEFINER=`id258940_susy79`@`%` PROCEDURE `getClassificaGironeCoppaItalia` (IN `pIdGirone` INT, IN `pIdGironeCI` INT)  NO SQL
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
left join sq_fantacalcio sf on sf.id = cc.idsquadrac
order by punti desc, marcatori desc, golfattit desc$$

CREATE DEFINER=`id258940_susy79`@`%` PROCEDURE `getRisposteSondaggio` (IN `idSondaggio` INT)  NO SQL
select * from sondaggi_opzioni where id_sondaggio = idSondaggio$$

CREATE DEFINER=`id258940_susy79`@`%` PROCEDURE `getRisposteSquadreSondaggio` (IN `idSondaggio` INT, IN `idOpzione` INT)  NO SQL
select count(*) as num from sondaggi_risposte where id_sondaggio = idSondaggio and id_opzione = idOpzione$$

CREATE DEFINER=`id258940_susy79`@`%` PROCEDURE `getSondaggiAttivi` ()  NO SQL
SELECT * from sondaggi where scadenza > CURRENT_DATE()$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `annunci`
--

CREATE TABLE `annunci` (
  `id` int(11) NOT NULL,
  `titolo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `testo` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `dal` datetime NOT NULL,
  `al` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `annunci`
--

INSERT INTO `annunci` (`id`, `titolo`, `testo`, `dal`, `al`) VALUES
(4, 'Scelte bonus draft.', 'Prima scelta SC Valle Sant Andrea (residui 21 fmln); Seconda scelta Crossa Pu (residui 8 fmln)', '2019-10-27 12:00:00', '2020-01-31 12:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `calendario`
--

CREATE TABLE `calendario` (
  `id_giornata` int(11) NOT NULL,
  `id_partita` int(11) NOT NULL,
  `gol_casa` int(11) DEFAULT NULL,
  `gol_ospiti` int(11) DEFAULT NULL,
  `punti_casa` float DEFAULT NULL,
  `punti_ospiti` float DEFAULT NULL,
  `fattorecasa` int(11) DEFAULT NULL,
  `md_casa` int(11) NOT NULL DEFAULT 0,
  `numero_giocanti_casa` int(11) NOT NULL DEFAULT 0,
  `md_ospite` int(11) NOT NULL DEFAULT 0,
  `numero_giocanti_ospite` int(11) NOT NULL DEFAULT 0,
  `id_sq_casa` int(11) NOT NULL,
  `id_sq_ospite` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `calendario`
--

INSERT INTO `calendario` (`id_giornata`, `id_partita`, `gol_casa`, `gol_ospiti`, `punti_casa`, `punti_ospiti`, `fattorecasa`, `md_casa`, `numero_giocanti_casa`, `md_ospite`, `numero_giocanti_ospite`, `id_sq_casa`, `id_sq_ospite`) VALUES
(1, 1, 2, 1, 71, 66, 1, 1, 11, 2, 11, 2, 1),
(1, 2, 1, 1, 69.5, 69.5, 1, -1, 11, -3, 11, 8, 7),
(1, 3, 4, 2, 83.5, 68, 1, 0, 11, 2, 11, 11, 4),
(1, 4, 1, 2, 68, 69.5, 1, -2, 11, 2, 11, 5, 3),
(1, 5, 3, 0, 77.5, 66.5, 1, 0, 11, -2, 11, 10, 9),
(1, 6, 1, 0, 66, 65.5, 1, 1, 11, -1, 11, 12, 6),
(2, 1, 1, 0, 65.5, 62.5, 1, 1, 11, -2, 11, 12, 2),
(2, 2, 2, 0, 73.5, 62.5, 1, -1, 11, 0, 11, 1, 8),
(2, 3, 1, 2, 67.5, 75, 1, 1, 11, -1, 11, 7, 11),
(2, 4, 2, 0, 67, 64, 1, 2, 11, -1, 11, 4, 5),
(2, 5, 2, 1, 71.5, 66.5, 1, -2, 11, -1, 11, 3, 10),
(2, 6, 1, 1, 65, 65.5, 1, 1, 11, 0, 11, 6, 9),
(3, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 12),
(3, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 1),
(3, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 7),
(3, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 4),
(3, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 3),
(3, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 6),
(4, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 11),
(4, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 8),
(4, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 5),
(4, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 10),
(4, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 9),
(4, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 3),
(5, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 12),
(5, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 2),
(5, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 1),
(5, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 7),
(5, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 4),
(5, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 6),
(6, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 10),
(6, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 5),
(6, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 11),
(6, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 9),
(6, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 3),
(6, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 4),
(7, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 12),
(7, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 2),
(7, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 8),
(7, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 1),
(7, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 7),
(7, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 6),
(8, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 3),
(8, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 9),
(8, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 10),
(8, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 5),
(8, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 4),
(8, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 7),
(9, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 12),
(9, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 2),
(9, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 8),
(9, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 11),
(9, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 1),
(9, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 6),
(10, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 7),
(10, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 4),
(10, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 3),
(10, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 9),
(10, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 10),
(10, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 1),
(11, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 12),
(11, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 2),
(11, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 8),
(11, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 11),
(11, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 5),
(11, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 6),
(12, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 2),
(12, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 8),
(12, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 11),
(12, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 5),
(12, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 10),
(12, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 12),
(13, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 12),
(13, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 1),
(13, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 7),
(13, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 4),
(13, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 3),
(13, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 6),
(14, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 8),
(14, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 11),
(14, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 5),
(14, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 10),
(14, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 9),
(14, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 2),
(15, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 12),
(15, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 2),
(15, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 1),
(15, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 7),
(15, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 4),
(15, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 6),
(16, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 5),
(16, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 11),
(16, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 10),
(16, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 9),
(16, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 3),
(16, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 8),
(17, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 12),
(17, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 2),
(17, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 8),
(17, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 1),
(17, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 7),
(17, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 6),
(18, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 9),
(18, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 10),
(18, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 5),
(18, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 3),
(18, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 4),
(18, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 11),
(19, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 12),
(19, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 2),
(19, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 8),
(19, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 11),
(19, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 1),
(19, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 6),
(20, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 4),
(20, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 3),
(20, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 9),
(20, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 10),
(20, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 7),
(20, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 5),
(21, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 12),
(21, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 2),
(21, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 8),
(21, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 11),
(21, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 5),
(21, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 6),
(22, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 1),
(22, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 7),
(22, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 4),
(22, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 3),
(22, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 9),
(22, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 10),
(23, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 6),
(23, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 9),
(23, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 4),
(23, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 10),
(23, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 8),
(23, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 7),
(24, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 1),
(24, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 3),
(24, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 5),
(24, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 12),
(24, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 11),
(24, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 8),
(25, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 2),
(25, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 6),
(25, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 9),
(25, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 4),
(25, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 10),
(25, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 7),
(26, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 5),
(26, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 3),
(26, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 12),
(26, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 11),
(26, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 8),
(26, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 10),
(27, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 2),
(27, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 1),
(27, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 6),
(27, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 9),
(27, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 4),
(27, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 7),
(28, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 11),
(28, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 12),
(28, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 5),
(28, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 8),
(28, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 10),
(28, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 4),
(29, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 2),
(29, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 1),
(29, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 3),
(29, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 6),
(29, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 9),
(29, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 7),
(30, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 10),
(30, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 8),
(30, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 11),
(30, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 12),
(30, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 4),
(30, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 9),
(31, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 2),
(31, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 1),
(31, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 3),
(31, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 5),
(31, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 6),
(31, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 7),
(32, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 9),
(32, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 4),
(32, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 10),
(32, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 8),
(32, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 11),
(32, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 6),
(33, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 2),
(33, 2, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 1),
(33, 3, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 3),
(33, 4, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 5),
(33, 5, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 12),
(33, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 7),
(34, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 6),
(35, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 7),
(36, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 1),
(37, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 3),
(38, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 12),
(39, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 7),
(40, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 11),
(41, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 6),
(42, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 1),
(43, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 11, 7),
(44, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 3, 12),
(45, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 6),
(46, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 6, 11),
(47, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 7, 3),
(48, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 12, 1),
(49, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 10),
(50, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 2),
(51, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 4),
(52, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 8),
(53, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 9),
(54, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 2),
(55, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 5),
(56, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 10),
(57, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 4),
(58, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 5, 2),
(59, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 8, 9),
(60, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 4, 10),
(61, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 10, 5),
(62, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 2, 8),
(63, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 9, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `formazioni`
--

CREATE TABLE `formazioni` (
  `id_giornata` int(2) NOT NULL,
  `id_squadra` int(2) NOT NULL,
  `id_posizione` int(2) NOT NULL,
  `sostituzione` tinyint(1) NOT NULL DEFAULT 0,
  `id_squadra_sa` int(2) NOT NULL,
  `voto` float DEFAULT NULL,
  `voto_md` float DEFAULT NULL,
  `id_giocatore` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `formazioni`
--

INSERT INTO `formazioni` (`id_giornata`, `id_squadra`, `id_posizione`, `sostituzione`, `id_squadra_sa`, `voto`, `voto_md`, `id_giocatore`) VALUES
(1, 11, 1, 0, 16, 5.5, 6.5, 2792),
(1, 11, 2, 0, 17, 2.5, 4.5, 365),
(1, 11, 3, 0, 12, 5.5, 6, 2006),
(1, 11, 4, 0, 11, NULL, NULL, 2355),
(1, 11, 5, 0, 12, 10.5, 7.5, 2409),
(1, 11, 6, 0, 6, 8, 7, 2085),
(1, 11, 7, 0, 20, 9, 6, 65),
(1, 11, 8, 0, 19, 6, 6, 2625),
(1, 11, 9, 0, 4, NULL, NULL, 2692),
(1, 11, 10, 0, 6, 10, 7, 785),
(1, 11, 11, 0, 11, 13.5, 7.5, 2819),
(1, 11, 12, 0, 16, NULL, NULL, 2271),
(1, 11, 13, 1, 12, 6, 6, 2289),
(1, 11, 14, 0, 15, 5, 5.5, 2801),
(1, 11, 15, 1, 14, 7, 7, 4514),
(1, 11, 16, 0, 6, 6, 6, 4424),
(1, 11, 17, 0, 5, NULL, NULL, 4385),
(1, 11, 18, 0, 16, 6, 6, 1943),
(1, 11, 19, 0, 20, 6, 6, 1879),
(1, 3, 1, 0, 3, 4, 6, 610),
(1, 3, 2, 0, 10, 6, 6.5, 390),
(1, 3, 3, 0, 14, 6.5, 6.5, 1866),
(1, 3, 4, 0, 5, 6.5, 6.5, 2572),
(1, 3, 5, 0, 16, 5, 5, 1986),
(1, 3, 6, 0, 8, 6, 6.5, 2215),
(1, 3, 7, 0, 10, NULL, NULL, 2776),
(1, 3, 8, 0, 8, 5.5, 5.5, 2779),
(1, 3, 9, 0, 10, 13.5, 7.5, 311),
(1, 3, 10, 0, 4, 5, 5, 2756),
(1, 3, 11, 0, 5, 6, 6, 2764),
(1, 3, 12, 0, 11, 6.5, 6.5, 509),
(1, 3, 13, 0, 15, 5.5, 5.5, 2525),
(1, 3, 14, 0, 3, 10, 7, 2197),
(1, 3, 15, 1, 10, 5.5, 6, 4479),
(1, 3, 16, 0, 11, 6, 6, 827),
(1, 3, 17, 0, 13, 6, 6, 21),
(1, 3, 18, 0, 7, 10, 7, 407),
(1, 3, 19, 0, 5, NULL, NULL, 2475),
(1, 12, 1, 0, 2, NULL, NULL, 453),
(1, 12, 2, 0, 14, 6, 6, 2728),
(1, 12, 3, 0, 8, 4.5, 5.5, 2296),
(1, 12, 4, 0, 9, NULL, NULL, 2192),
(1, 12, 5, 0, 10, 6.5, 6.5, 2860),
(1, 12, 6, 0, 8, 7.5, 6.5, 530),
(1, 12, 7, 0, 8, 6, 6, 779),
(1, 12, 8, 0, 2, NULL, NULL, 184),
(1, 12, 9, 0, 2, 5.5, 5.5, 408),
(1, 12, 10, 0, 19, 6, 6, 2167),
(1, 12, 11, 0, 19, 6, 6, 280),
(1, 12, 12, 1, 2, 6, 7, 282),
(1, 12, 13, 1, 12, 6, 6.5, 2309),
(1, 12, 14, 0, 17, NULL, NULL, 4307),
(1, 12, 15, 1, 14, 6, 6, 20),
(1, 12, 16, 0, 19, 6, 6, 272),
(1, 12, 17, 0, 6, 6, 6, 2284),
(1, 12, 18, 0, 12, 6, 6, 2841),
(1, 12, 19, 0, 19, 5.5, 5.5, 472),
(1, 1, 1, 0, 5, 6, 6, 250),
(1, 1, 2, 0, 9, 6, 6, 226),
(1, 1, 3, 0, 10, NULL, NULL, 2816),
(1, 1, 4, 0, 16, 5, 5.5, 4412),
(1, 1, 5, 0, 9, 6, 6, 238),
(1, 1, 6, 0, 14, 6, 6, 2076),
(1, 1, 7, 0, 8, 5, 5, 2529),
(1, 1, 8, 0, 3, 6.5, 6.5, 4427),
(1, 1, 9, 0, 4, 5.5, 6, 186),
(1, 1, 10, 0, 10, 9.5, 6.5, 409),
(1, 1, 11, 0, 9, 5, 5, 441),
(1, 1, 12, 0, 5, NULL, NULL, 543),
(1, 1, 13, 1, 8, 5.5, 6, 464),
(1, 1, 14, 0, 3, NULL, NULL, 2633),
(1, 1, 15, 0, 13, 6, 6, 2003),
(1, 1, 16, 0, 15, 5.5, 5.5, 4423),
(1, 1, 17, 0, 20, NULL, NULL, 4400),
(1, 1, 18, 0, 7, 6, 6, 1958),
(1, 1, 19, 0, 8, NULL, NULL, 652),
(1, 7, 1, 0, 19, 4, 6, 133),
(1, 7, 2, 0, 17, NULL, NULL, 244),
(1, 7, 3, 0, 9, 5.5, 5.5, 487),
(1, 7, 4, 0, 3, NULL, NULL, 2130),
(1, 7, 5, 0, 18, 6.5, 6.5, 4442),
(1, 7, 6, 0, 11, 10, 7, 526),
(1, 7, 7, 0, 9, 6, 6, 556),
(1, 7, 8, 0, 17, 5.5, 5.5, 4512),
(1, 7, 9, 0, 7, 5.5, 6, 568),
(1, 7, 10, 0, 3, 5, 5, 608),
(1, 7, 11, 0, 17, 9.5, 6.5, 2762),
(1, 7, 12, 0, 19, NULL, NULL, 40),
(1, 7, 13, 1, 3, 6, 6, 2160),
(1, 7, 14, 0, 15, NULL, NULL, 73),
(1, 7, 15, 1, 18, 6, 6.5, 4429),
(1, 7, 16, 0, 21, 10, 7, 2011),
(1, 7, 17, 0, 9, 5, 5, 2789),
(1, 7, 18, 0, 18, 5, 5.5, 4413),
(1, 7, 19, 0, 12, NULL, NULL, 2839),
(1, 6, 1, 0, 8, 5.5, 6.5, 4419),
(1, 6, 2, 0, 10, 6.5, 6.5, 392),
(1, 6, 3, 0, 15, 6, 6, 1864),
(1, 6, 4, 0, 17, 5, 5, 2759),
(1, 6, 5, 0, 13, 5, 5.5, 28),
(1, 6, 6, 0, 2, 5.5, 5.5, 469),
(1, 6, 7, 0, 5, 6.5, 6.5, 1978),
(1, 6, 8, 0, 6, NULL, NULL, 2263),
(1, 6, 9, 0, 13, 5.5, 5.5, 383),
(1, 6, 10, 0, 15, 5, 5, 474),
(1, 6, 11, 0, 5, 10, 7, 2531),
(1, 6, 12, 0, 8, NULL, NULL, 41),
(1, 6, 13, 0, 13, 5, 5, 2261),
(1, 6, 14, 0, 16, NULL, NULL, 2870),
(1, 6, 15, 1, 3, 5, 5.5, 22),
(1, 6, 16, 0, 15, 5, 5.5, 2802),
(1, 6, 17, 0, 12, 6, 6, 170),
(1, 6, 18, 0, 19, 6, 6, 2743),
(1, 6, 19, 0, 15, 6, 6, 2773),
(1, 2, 1, 0, 10, NULL, NULL, 572),
(1, 2, 2, 0, 6, 6, 6, 329),
(1, 2, 3, 0, 17, NULL, NULL, 1979),
(1, 2, 4, 0, 16, 5.5, 5.5, 2315),
(1, 2, 5, 0, 6, 6, 6, 338),
(1, 2, 6, 0, 4, 5.5, 5.5, 375),
(1, 2, 7, 0, 18, 10, 7, 621),
(1, 2, 8, 0, 8, 5, 5.5, 2766),
(1, 2, 9, 0, 3, 10, 7, 177),
(1, 2, 10, 0, 6, 6.5, 6.5, 495),
(1, 2, 11, 0, 10, 6, 6, 2012),
(1, 2, 12, 1, 10, 5, 6, 2468),
(1, 2, 13, 1, 4, 5.5, 5.5, 2168),
(1, 2, 14, 0, 19, 5.5, 6, 2746),
(1, 2, 15, 0, 10, 9.5, 7, 2775),
(1, 2, 16, 0, 15, 5.5, 5.5, 430),
(1, 2, 17, 0, 4, NULL, NULL, 367),
(1, 2, 18, 0, 11, 7.5, 6.5, 643),
(1, 2, 19, 0, 7, 5, 5.5, 2868),
(1, 4, 1, 0, 12, 3.5, 6, 1917),
(1, 4, 2, 0, 10, NULL, NULL, 142),
(1, 4, 3, 0, 4, 5, 5, 460),
(1, 4, 4, 0, 6, 6.5, 6.5, 513),
(1, 4, 5, 0, 2, 5.5, 5.5, 4237),
(1, 4, 6, 0, 17, 4.5, 5, 150),
(1, 4, 7, 0, 12, 8.5, 7.5, 2002),
(1, 4, 8, 0, 2, NULL, NULL, 2379),
(1, 4, 9, 0, 9, 5, 5.5, 315),
(1, 4, 10, 0, 11, 8, 7, 531),
(1, 4, 11, 0, 8, 9.5, 7, 647),
(1, 4, 12, 0, 18, 6, 6, 4425),
(1, 4, 13, 0, 6, NULL, NULL, 4397),
(1, 4, 14, 1, 7, 6.5, 6.5, 2104),
(1, 4, 15, 0, 8, NULL, NULL, 4245),
(1, 4, 16, 1, 2, 5.5, 5.5, 2166),
(1, 4, 17, 0, 5, 6, 6, 181),
(1, 4, 18, 0, 5, 6.5, 6.5, 536),
(1, 4, 19, 0, 12, 5.5, 6, 771),
(1, 9, 1, 0, 17, 3, 6, 1843),
(1, 9, 2, 0, 8, 6.5, 6.5, 2016),
(1, 9, 3, 0, 19, 5, 5.5, 4422),
(1, 9, 4, 0, 11, 5.5, 6, 1895),
(1, 9, 5, 0, 6, 8, 7, 645),
(1, 9, 6, 0, 10, 6.5, 6.5, 152),
(1, 9, 7, 0, 12, 5.5, 5.5, 644),
(1, 9, 8, 0, 17, 5.5, 5.5, 118),
(1, 9, 9, 0, 10, NULL, NULL, 410),
(1, 9, 10, 0, 18, 6, 6, 4452),
(1, 9, 11, 0, 14, 9.5, 7, 1874),
(1, 9, 12, 0, 15, 4, 6, 159),
(1, 9, 13, 0, 9, 5, 5, 2171),
(1, 9, 14, 0, 7, 6.5, 6.5, 259),
(1, 9, 15, 0, 3, 7.5, 6.5, 26),
(1, 9, 16, 0, 11, 6.5, 6.5, 4501),
(1, 9, 17, 0, 4, 5.5, 5.5, 1850),
(1, 9, 18, 1, 3, 5.5, 5.5, 507),
(1, 9, 19, 0, 16, 5, 5.5, 2826),
(1, 8, 1, 0, 6, 6.5, 6.5, 1934),
(1, 8, 2, 0, 8, 10, 7, 2214),
(1, 8, 3, 0, 12, 5.5, 6, 2164),
(1, 8, 4, 0, 5, 6.5, 6.5, 798),
(1, 8, 5, 0, 10, NULL, NULL, 459),
(1, 8, 6, 0, 16, 6, 6, 790),
(1, 8, 7, 0, 4, 5.5, 5.5, 2194),
(1, 8, 8, 0, 13, 5.5, 5.5, 1857),
(1, 8, 9, 0, 12, 6.5, 6.5, 4377),
(1, 8, 10, 0, 10, 6, 6, 4517),
(1, 8, 11, 0, 16, 5, 5, 90),
(1, 8, 12, 0, 6, NULL, NULL, 2770),
(1, 8, 13, 1, 6, 6.5, 6.5, 2335),
(1, 8, 14, 0, 19, 5, 5, 4414),
(1, 8, 15, 0, 9, 6, 6, 376),
(1, 8, 16, 0, 15, 5.5, 6, 2833),
(1, 8, 17, 0, 21, 6.5, 6.5, 236),
(1, 8, 18, 0, 15, 5.5, 5.5, 123),
(1, 8, 19, 0, 19, 9.5, 6.5, 537),
(1, 5, 1, 0, 4, 5, 7, 350),
(1, 5, 2, 0, 4, 4.5, 5, 11),
(1, 5, 3, 0, 2, 6, 6, 662),
(1, 5, 4, 0, 13, 5, 5, 780),
(1, 5, 5, 0, 2, NULL, NULL, 4428),
(1, 5, 6, 0, 14, 6.5, 6.5, 112),
(1, 5, 7, 0, 10, NULL, NULL, 397),
(1, 5, 8, 0, 6, 6, 6.5, 2209),
(1, 5, 9, 0, 2, 6.5, 6.5, 2306),
(1, 5, 10, 0, 2, 6.5, 6.5, 309),
(1, 5, 11, 0, 2, 10.5, 6.5, 2610),
(1, 5, 12, 0, 4, NULL, NULL, 387),
(1, 5, 13, 1, 20, 5.5, 5.5, 2241),
(1, 5, 14, 0, 16, NULL, NULL, 2280),
(1, 5, 15, 1, 4, 6, 6, 4322),
(1, 5, 16, 0, 7, 6, 6, 2008),
(1, 5, 17, 0, 3, 5, 5.5, 2077),
(1, 5, 18, 0, 11, 6, 6, 2832),
(1, 5, 19, 0, 20, 5.5, 5.5, 658),
(1, 10, 1, 0, 9, 5.5, 6.5, 2179),
(1, 10, 2, 0, 5, 6.5, 6.5, 295),
(1, 10, 3, 0, 2, 6.5, 6.5, 286),
(1, 10, 4, 0, 5, 6.5, 6.5, 322),
(1, 10, 5, 0, 12, 6, 6, 287),
(1, 10, 6, 0, 18, 7, 7, 4449),
(1, 10, 7, 0, 10, 6, 6, 406),
(1, 10, 8, 0, 5, 6, 6, 332),
(1, 10, 9, 0, 5, 10, 7, 265),
(1, 10, 10, 0, 2, NULL, NULL, 2504),
(1, 10, 11, 0, 14, 10, 7, 2061),
(1, 10, 12, 0, 9, NULL, NULL, 220),
(1, 10, 13, 0, 11, 6, 6, 640),
(1, 10, 14, 0, 21, 5.5, 6, 581),
(1, 10, 15, 0, 3, 6, 6, 787),
(1, 10, 16, 1, 5, 7.5, 6.5, 1870),
(1, 10, 17, 0, 4, 5, 5, 331),
(1, 10, 18, 0, 16, 5.5, 6, 434),
(1, 10, 19, 0, 20, 5.5, 5.5, 1939),
(2, 5, 1, 0, 4, 2.5, 5, 350),
(2, 5, 2, 0, 4, 5.5, 5.5, 357),
(2, 5, 3, 0, 2, 5.5, 5.5, 662),
(2, 5, 4, 0, 2, 5.5, 6, 4428),
(2, 5, 5, 0, 14, 10, 7, 112),
(2, 5, 6, 0, 2, 5.5, 6, 299),
(2, 5, 7, 0, 10, 5, 5.5, 397),
(2, 5, 8, 0, 3, 6, 6, 2077),
(2, 5, 9, 0, 2, 6, 6, 2306),
(2, 5, 10, 0, 2, 6.5, 6.5, 309),
(2, 5, 11, 0, 20, 6, 6, 658),
(2, 5, 12, 0, 4, NULL, NULL, 387),
(2, 5, 13, 0, 13, 4.5, 4.5, 780),
(2, 5, 14, 0, 19, 6.5, 6.5, 2285),
(2, 5, 15, 0, 4, 5.5, 6, 2818),
(2, 5, 16, 0, 6, 5.5, 5.5, 2209),
(2, 5, 17, 0, 7, NULL, NULL, 2008),
(2, 5, 18, 0, 11, 5.5, 5.5, 2832),
(2, 5, 19, 0, 21, NULL, NULL, 4507),
(2, 11, 1, 0, 16, 7, 7, 2792),
(2, 11, 2, 0, 17, 5, 5.5, 365),
(2, 11, 3, 0, 12, 6.5, 6, 2289),
(2, 11, 4, 0, 21, 6, 6, 2758),
(2, 11, 5, 0, 12, 8, 7, 2409),
(2, 11, 6, 0, 6, 5.5, 6, 2085),
(2, 11, 7, 0, 20, 13, 7, 65),
(2, 11, 8, 0, 19, 6, 6, 2625),
(2, 11, 9, 0, 4, NULL, NULL, 2692),
(2, 11, 10, 0, 6, 5.5, 5.5, 785),
(2, 11, 11, 0, 11, 5, 5, 2819),
(2, 11, 12, 0, 16, NULL, NULL, 2271),
(2, 11, 13, 0, 15, 6, 6.5, 2801),
(2, 11, 14, 0, 6, 5.5, 6, 2062),
(2, 11, 15, 0, 12, 5, 5.5, 2006),
(2, 11, 16, 1, 14, 7.5, 6.5, 4514),
(2, 11, 17, 0, 14, 5.5, 5.5, 627),
(2, 11, 18, 0, 16, NULL, NULL, 1943),
(2, 11, 19, 0, 20, NULL, NULL, 1879),
(2, 7, 1, 0, 19, 6, 6, 133),
(2, 7, 2, 0, 15, 5.5, 6, 73),
(2, 7, 3, 0, 9, 5.5, 5.5, 487),
(2, 7, 4, 0, 3, 6.5, 6.5, 2130),
(2, 7, 5, 0, 18, 5.5, 6, 4442),
(2, 7, 6, 0, 11, NULL, NULL, 526),
(2, 7, 7, 0, 9, 6, 6, 556),
(2, 7, 8, 0, 21, 6.5, 6.5, 2011),
(2, 7, 9, 0, 7, NULL, NULL, 568),
(2, 7, 10, 0, 3, 10, 7, 608),
(2, 7, 11, 0, 17, 5, 5, 2762),
(2, 7, 12, 0, 19, NULL, NULL, 40),
(2, 7, 13, 0, 17, 5.5, 6, 244),
(2, 7, 14, 0, 18, 4, 6, 4429),
(2, 7, 15, 1, 17, 5.5, 5.5, 4512),
(2, 7, 16, 0, 17, 5, 5.5, 4330),
(2, 7, 17, 0, 11, 6, 6, 2857),
(2, 7, 18, 1, 12, 5.5, 6, 2839),
(2, 7, 19, 0, 18, 6, 6, 4413),
(2, 12, 1, 0, 2, 4.5, 5.5, 453),
(2, 12, 2, 0, 12, 10, 7, 2309),
(2, 12, 3, 0, 17, 6, 6.5, 4307),
(2, 12, 4, 0, 3, NULL, NULL, 15),
(2, 12, 5, 0, 7, 5, 5, 1868),
(2, 12, 6, 0, 8, 5.5, 5.5, 530),
(2, 12, 7, 0, 8, 5, 5, 779),
(2, 12, 8, 0, 2, 5.5, 5.5, 184),
(2, 12, 9, 0, 2, 5.5, 5.5, 408),
(2, 12, 10, 0, 19, 5.5, 5.5, 2167),
(2, 12, 11, 0, 19, 6, 6, 280),
(2, 12, 12, 0, 2, NULL, NULL, 282),
(2, 12, 13, 0, 14, NULL, NULL, 2728),
(2, 12, 14, 1, 14, 7, 7, 1869),
(2, 12, 15, 0, 9, 6, 6, 2205),
(2, 12, 16, 0, 19, 6.5, 6.5, 272),
(2, 12, 17, 0, 7, 5.5, 5.5, 2391),
(2, 12, 18, 0, 19, NULL, NULL, 472),
(2, 12, 19, 0, 12, 6, 6, 2841),
(2, 6, 1, 0, 8, 3, 5, 4419),
(2, 6, 2, 0, 10, 4, 5, 392),
(2, 6, 3, 0, 15, 6.5, 6.5, 1864),
(2, 6, 4, 0, 17, 6.5, 6.5, 2759),
(2, 6, 5, 0, 13, 5.5, 5.5, 28),
(2, 6, 6, 0, 2, 10, 7, 469),
(2, 6, 7, 0, 2, 6, 6, 697),
(2, 6, 8, 0, 5, 6.5, 6.5, 1978),
(2, 6, 9, 0, 13, 6, 6, 383),
(2, 6, 10, 0, 15, 5, 5.5, 474),
(2, 6, 11, 0, 5, 6, 6, 2531),
(2, 6, 12, 0, 7, 4.5, 6.5, 761),
(2, 6, 13, 0, 10, 6, 6, 550),
(2, 6, 14, 0, 13, 6, 6, 2261),
(2, 6, 15, 0, 6, 5.5, 5.5, 2263),
(2, 6, 16, 0, 3, 10, 7, 22),
(2, 6, 17, 0, 12, 6, 6, 170),
(2, 6, 18, 0, 19, 6, 6, 2743),
(2, 6, 19, 0, 15, 6, 6, 2773),
(2, 1, 1, 0, 5, 7.5, 7.5, 250),
(2, 1, 2, 0, 9, 6.5, 6.5, 226),
(2, 1, 3, 0, 8, 5, 5, 464),
(2, 1, 4, 0, 10, 5.5, 5.5, 2816),
(2, 1, 5, 0, 4, 5.5, 6, 4292),
(2, 1, 6, 0, 9, 6.5, 6.5, 238),
(2, 1, 7, 0, 13, 7, 6, 2003),
(2, 1, 8, 0, 8, 5.5, 5.5, 2529),
(2, 1, 9, 0, 15, 6, 6, 4423),
(2, 1, 10, 0, 10, 5.5, 5.5, 409),
(2, 1, 11, 0, 9, 13, 7.5, 441),
(2, 1, 12, 0, 5, NULL, NULL, 543),
(2, 1, 13, 0, 11, 6, 6, 4426),
(2, 1, 14, 0, 16, 6, 6.5, 4412),
(2, 1, 15, 0, 20, 6, 6, 423),
(2, 1, 16, 0, 14, 5.5, 6, 2076),
(2, 1, 17, 0, 3, 6.5, 6.5, 4427),
(2, 1, 18, 0, 7, 5.5, 5.5, 1958),
(2, 1, 19, 0, 4, 5.5, 5.5, 186),
(2, 10, 1, 0, 9, 6, 7, 2179),
(2, 10, 2, 0, 5, NULL, NULL, 295),
(2, 10, 3, 0, 2, 6, 6.5, 286),
(2, 10, 4, 0, 5, 7, 7, 322),
(2, 10, 5, 0, 3, NULL, NULL, 787),
(2, 10, 6, 0, 18, 6.5, 6.5, 4449),
(2, 10, 7, 0, 5, 6.5, 6.5, 1870),
(2, 10, 8, 0, 10, 6, 6, 406),
(2, 10, 9, 0, 5, 6, 6, 265),
(2, 10, 10, 0, 14, 5.5, 5.5, 2061),
(2, 10, 11, 0, 17, 5, 5, 2038),
(2, 10, 12, 0, 9, NULL, NULL, 220),
(2, 10, 13, 1, 12, 6, 6, 287),
(2, 10, 14, 1, 21, 6, 6, 581),
(2, 10, 15, 0, 5, NULL, NULL, 332),
(2, 10, 16, 0, 16, 5.5, 6, 434),
(2, 10, 17, 0, 4, NULL, NULL, 331),
(2, 10, 18, 0, 20, NULL, NULL, 1939),
(2, 10, 19, 0, 21, 5.5, 5.5, 2327),
(2, 8, 1, 0, 6, 5.5, 6.5, 1934),
(2, 8, 2, 0, 8, 5.5, 5.5, 2214),
(2, 8, 3, 0, 12, 6, 6, 2164),
(2, 8, 4, 0, 5, 6.5, 6.5, 798),
(2, 8, 5, 0, 16, 6, 6, 790),
(2, 8, 6, 0, 9, 5, 5, 376),
(2, 8, 7, 0, 13, 10, 7, 1857),
(2, 8, 8, 0, 12, 6.5, 6.5, 4377),
(2, 8, 9, 0, 15, 1.5, 4.5, 123),
(2, 8, 10, 0, 10, 5, 5, 4517),
(2, 8, 11, 0, 16, 5, 5, 90),
(2, 8, 12, 0, 6, NULL, NULL, 2770),
(2, 8, 13, 0, 6, 5.5, 5.5, 2335),
(2, 8, 14, 0, 19, 5.5, 6, 4414),
(2, 8, 15, 0, 13, 5, 5, 708),
(2, 8, 16, 0, 4, 6, 6, 2194),
(2, 8, 17, 0, 15, 6, 6, 2833),
(2, 8, 18, 0, 19, 2, 5, 537),
(2, 8, 19, 0, 15, NULL, NULL, 2325),
(2, 4, 1, 0, 12, 5, 6, 1917),
(2, 4, 2, 0, 10, 6, 6, 142),
(2, 4, 3, 0, 6, 6.5, 6.5, 513),
(2, 4, 4, 0, 2, 6, 6, 4237),
(2, 4, 5, 0, 8, 5.5, 5.5, 4245),
(2, 4, 6, 0, 12, 10, 7, 2002),
(2, 4, 7, 0, 2, 5.5, 5.5, 2379),
(2, 4, 8, 0, 2, 6, 6, 2472),
(2, 4, 9, 0, 11, 5.5, 5.5, 531),
(2, 4, 10, 0, 5, 5.5, 5.5, 536),
(2, 4, 11, 0, 8, 5.5, 5.5, 647),
(2, 4, 12, 0, 18, 4, 6, 4425),
(2, 4, 13, 0, 4, 5.5, 6, 460),
(2, 4, 14, 0, 9, 6, 6, 2788),
(2, 4, 15, 0, 5, 5.5, 5.5, 181),
(2, 4, 16, 0, 18, 6, 6, 4445),
(2, 4, 17, 0, 2, NULL, NULL, 2166),
(2, 4, 18, 0, 12, NULL, NULL, 771),
(2, 4, 19, 0, 9, 5, 5.5, 315),
(2, 3, 1, 0, 11, 9, 7, 509),
(2, 3, 2, 0, 14, 6, 6, 1866),
(2, 3, 3, 0, 3, 6.5, 6.5, 2197),
(2, 3, 4, 0, 5, 6.5, 6.5, 2572),
(2, 3, 5, 0, 3, 8, 7, 788),
(2, 3, 6, 0, 16, 5.5, 5.5, 1986),
(2, 3, 7, 0, 10, NULL, NULL, 2776),
(2, 3, 8, 0, 10, NULL, NULL, 4479),
(2, 3, 9, 0, 10, 6, 6, 311),
(2, 3, 10, 0, 7, 5.5, 5.5, 407),
(2, 3, 11, 0, 4, 9, 6, 2756),
(2, 3, 12, 0, 3, 7, 7, 610),
(2, 3, 13, 0, 15, 6.5, 6.5, 2525),
(2, 3, 14, 0, 3, 7, 7, 695),
(2, 3, 15, 0, 8, NULL, NULL, 2779),
(2, 3, 16, 1, 8, 4.5, 4.5, 2215),
(2, 3, 17, 1, 11, 5, 5, 827),
(2, 3, 18, 0, 5, 5, 5.5, 2764),
(2, 3, 19, 0, 5, 6, 6, 2475),
(2, 2, 1, 0, 10, 5, 6, 572),
(2, 2, 2, 0, 5, 7.5, 6.5, 252),
(2, 2, 3, 0, 17, 6, 6, 1979),
(2, 2, 4, 0, 4, 4.5, 5, 2168),
(2, 2, 5, 0, 6, NULL, NULL, 338),
(2, 2, 6, 0, 4, 5.5, 5.5, 375),
(2, 2, 7, 0, 8, 4.5, 5, 2766),
(2, 2, 8, 0, 10, NULL, NULL, 2775),
(2, 2, 9, 0, 3, 5.5, 5.5, 177),
(2, 2, 10, 0, 11, 5.5, 5.5, 643),
(2, 2, 11, 0, 10, 5.5, 5.5, 2012),
(2, 2, 12, 0, 10, NULL, NULL, 2468),
(2, 2, 13, 0, 16, 5, 5.5, 2315),
(2, 2, 14, 0, 7, NULL, NULL, 490),
(2, 2, 15, 0, 14, NULL, NULL, 4454),
(2, 2, 16, 1, 15, 6, 6, 430),
(2, 2, 17, 1, 18, 7, 6, 621),
(2, 2, 18, 0, 6, 5, 5, 495),
(2, 2, 19, 0, 18, 6, 6, 696),
(2, 9, 1, 0, 15, 6, 6, 159),
(2, 9, 2, 0, 8, 5.5, 5.5, 2016),
(2, 9, 3, 0, 19, 5.5, 6, 4422),
(2, 9, 4, 0, 11, 6, 6, 1895),
(2, 9, 5, 0, 3, 7, 7, 26),
(2, 9, 6, 0, 6, 5.5, 5.5, 645),
(2, 9, 7, 0, 10, 5.5, 5.5, 152),
(2, 9, 8, 0, 12, 5.5, 6, 644),
(2, 9, 9, 0, 21, 6.5, 6.5, 4522),
(2, 9, 10, 0, 10, 6.5, 6.5, 410),
(2, 9, 11, 0, 20, 6, 6.5, 183),
(2, 9, 12, 0, 17, 6, 6, 1843),
(2, 9, 13, 0, 9, 5, 5.5, 2171),
(2, 9, 14, 0, 8, 6, 6, 1852),
(2, 9, 15, 0, 7, 3.5, 4.5, 259),
(2, 9, 16, 0, 11, 4.5, 5, 4501),
(2, 9, 17, 0, 17, 5.5, 6, 118),
(2, 9, 18, 0, 14, 6.5, 6.5, 1874),
(2, 9, 19, 0, 18, 9.5, 6.5, 4452),
(3, 1, 1, 0, 5, NULL, NULL, 250),
(3, 1, 2, 0, 9, NULL, NULL, 226),
(3, 1, 3, 0, 10, NULL, NULL, 2816),
(3, 1, 4, 0, 4, NULL, NULL, 4292),
(3, 1, 5, 0, 8, NULL, NULL, 464),
(3, 1, 6, 0, 14, NULL, NULL, 2076),
(3, 1, 7, 0, 8, NULL, NULL, 2529),
(3, 1, 8, 0, 15, NULL, NULL, 4423),
(3, 1, 9, 0, 9, NULL, NULL, 441),
(3, 1, 10, 0, 7, NULL, NULL, 1958),
(3, 1, 11, 0, 10, NULL, NULL, 409),
(3, 1, 12, 0, 5, NULL, NULL, 543),
(3, 1, 13, 0, 11, NULL, NULL, 4426),
(3, 1, 14, 0, 16, NULL, NULL, 4412),
(3, 1, 15, 0, 9, NULL, NULL, 238),
(3, 1, 16, 0, 13, NULL, NULL, 2003),
(3, 1, 17, 0, 4, NULL, NULL, 186),
(3, 1, 18, 0, 8, NULL, NULL, 652),
(3, 1, 19, 0, 21, NULL, NULL, 636),
(3, 5, 1, 0, 4, NULL, NULL, 350),
(3, 5, 2, 0, 4, NULL, NULL, 357),
(3, 5, 3, 0, 20, NULL, NULL, 2241),
(3, 5, 4, 0, 2, NULL, NULL, 4428),
(3, 5, 5, 0, 2, NULL, NULL, 299),
(3, 5, 6, 0, 10, NULL, NULL, 397),
(3, 5, 7, 0, 3, NULL, NULL, 2077),
(3, 5, 8, 0, 4, NULL, NULL, 2818),
(3, 5, 9, 0, 2, NULL, NULL, 309),
(3, 5, 10, 0, 2, NULL, NULL, 2610),
(3, 5, 11, 0, 16, NULL, NULL, 4324),
(3, 5, 12, 0, 14, NULL, NULL, 2836),
(3, 5, 13, 0, 13, NULL, NULL, 780),
(3, 5, 14, 0, 4, NULL, NULL, 11),
(3, 5, 15, 0, 14, NULL, NULL, 112),
(3, 5, 16, 0, 2, NULL, NULL, 2306),
(3, 5, 17, 0, 4, NULL, NULL, 4322),
(3, 5, 18, 0, 20, NULL, NULL, 658),
(3, 5, 19, 0, 11, NULL, NULL, 2832),
(3, 12, 1, 0, 2, NULL, NULL, 282),
(3, 12, 2, 0, 12, NULL, NULL, 2309),
(3, 12, 3, 0, 3, NULL, NULL, 15),
(3, 12, 4, 0, 14, NULL, NULL, 1869),
(3, 12, 5, 0, 9, NULL, NULL, 2205),
(3, 12, 6, 0, 8, NULL, NULL, 530),
(3, 12, 7, 0, 8, NULL, NULL, 779),
(3, 12, 8, 0, 2, NULL, NULL, 184),
(3, 12, 9, 0, 2, NULL, NULL, 408),
(3, 12, 10, 0, 19, NULL, NULL, 2167),
(3, 12, 11, 0, 6, NULL, NULL, 2284),
(3, 12, 12, 0, 2, NULL, NULL, 453),
(3, 12, 13, 0, 17, NULL, NULL, 4307),
(3, 12, 14, 0, 14, NULL, NULL, 2728),
(3, 12, 15, 0, 7, NULL, NULL, 2391),
(3, 12, 16, 0, 14, NULL, NULL, 20),
(3, 12, 17, 0, 19, NULL, NULL, 272),
(3, 12, 18, 0, 12, NULL, NULL, 2841),
(3, 12, 19, 0, 19, NULL, NULL, 280),
(3, 6, 1, 0, 8, NULL, NULL, 4419),
(3, 6, 2, 0, 15, NULL, NULL, 1864),
(3, 6, 3, 0, 17, NULL, NULL, 2759),
(3, 6, 4, 0, 16, NULL, NULL, 2870),
(3, 6, 5, 0, 2, NULL, NULL, 469),
(3, 6, 6, 0, 2, NULL, NULL, 697),
(3, 6, 7, 0, 5, NULL, NULL, 1978),
(3, 6, 8, 0, 6, NULL, NULL, 2263),
(3, 6, 9, 0, 13, NULL, NULL, 383),
(3, 6, 10, 0, 15, NULL, NULL, 474),
(3, 6, 11, 0, 5, NULL, NULL, 2531),
(3, 6, 12, 0, 8, NULL, NULL, 41),
(3, 6, 13, 0, 7, NULL, NULL, 2784),
(3, 6, 14, 0, 13, NULL, NULL, 2261),
(3, 6, 15, 0, 13, NULL, NULL, 28),
(3, 6, 16, 0, 15, NULL, NULL, 234),
(3, 6, 17, 0, 3, NULL, NULL, 22),
(3, 6, 18, 0, 19, NULL, NULL, 2743),
(3, 6, 19, 0, 17, NULL, NULL, 819),
(3, 10, 1, 0, 9, NULL, NULL, 2179),
(3, 10, 2, 0, 5, NULL, NULL, 295),
(3, 10, 3, 0, 2, NULL, NULL, 286),
(3, 10, 4, 0, 5, NULL, NULL, 322),
(3, 10, 5, 0, 3, NULL, NULL, 787),
(3, 10, 6, 0, 18, NULL, NULL, 4449),
(3, 10, 7, 0, 5, NULL, NULL, 1870),
(3, 10, 8, 0, 10, NULL, NULL, 406),
(3, 10, 9, 0, 5, NULL, NULL, 265),
(3, 10, 10, 0, 14, NULL, NULL, 2061),
(3, 10, 11, 0, 17, NULL, NULL, 2038),
(3, 10, 12, 0, 9, NULL, NULL, 220),
(3, 10, 13, 0, 11, NULL, NULL, 640),
(3, 10, 14, 0, 21, NULL, NULL, 581),
(3, 10, 15, 0, 5, NULL, NULL, 332),
(3, 10, 16, 0, 16, NULL, NULL, 434),
(3, 10, 17, 0, 20, NULL, NULL, 1939),
(3, 10, 18, 0, 21, NULL, NULL, 2327),
(3, 10, 19, 0, 4, NULL, NULL, 4510),
(3, 8, 1, 0, 6, NULL, NULL, 1934),
(3, 8, 2, 0, 8, NULL, NULL, 2214),
(3, 8, 3, 0, 12, NULL, NULL, 2164),
(3, 8, 4, 0, 5, NULL, NULL, 798),
(3, 8, 5, 0, 10, NULL, NULL, 459),
(3, 8, 6, 0, 4, NULL, NULL, 2194),
(3, 8, 7, 0, 9, NULL, NULL, 376),
(3, 8, 8, 0, 12, NULL, NULL, 4377),
(3, 8, 9, 0, 15, NULL, NULL, 123),
(3, 8, 10, 0, 10, NULL, NULL, 4517),
(3, 8, 11, 0, 19, NULL, NULL, 537),
(3, 8, 12, 0, 6, NULL, NULL, 2335),
(3, 8, 13, 0, 19, NULL, NULL, 4414),
(3, 8, 14, 0, 16, NULL, NULL, 790),
(3, 8, 15, 0, 15, NULL, NULL, 2833),
(3, 8, 16, 0, 16, NULL, NULL, 4524),
(3, 8, 17, 0, 21, NULL, NULL, 236),
(3, 8, 18, 0, 16, NULL, NULL, 90),
(3, 8, 19, 0, 15, NULL, NULL, 2325),
(49, 8, 1, 0, 6, NULL, NULL, 1934),
(49, 8, 2, 0, 8, NULL, NULL, 2214),
(49, 8, 3, 0, 12, NULL, NULL, 2164),
(49, 8, 4, 0, 5, NULL, NULL, 798),
(49, 8, 5, 0, 10, NULL, NULL, 459),
(49, 8, 6, 0, 4, NULL, NULL, 2194),
(49, 8, 7, 0, 9, NULL, NULL, 376),
(49, 8, 8, 0, 12, NULL, NULL, 4377),
(49, 8, 9, 0, 15, NULL, NULL, 123),
(49, 8, 10, 0, 10, NULL, NULL, 4517),
(49, 8, 11, 0, 19, NULL, NULL, 537),
(49, 8, 12, 0, 6, NULL, NULL, 2335),
(49, 8, 13, 0, 19, NULL, NULL, 4414),
(49, 8, 14, 0, 16, NULL, NULL, 790),
(49, 8, 15, 0, 15, NULL, NULL, 2833),
(49, 8, 16, 0, 16, NULL, NULL, 4524),
(49, 8, 17, 0, 21, NULL, NULL, 236),
(49, 8, 18, 0, 16, NULL, NULL, 90),
(49, 8, 19, 0, 15, NULL, NULL, 2325),
(3, 3, 1, 0, 3, NULL, NULL, 610),
(3, 3, 2, 0, 10, NULL, NULL, 390),
(3, 3, 3, 0, 14, NULL, NULL, 1866),
(3, 3, 4, 0, 15, NULL, NULL, 2525),
(3, 3, 5, 0, 3, NULL, NULL, 788),
(3, 3, 6, 0, 10, NULL, NULL, 2776),
(3, 3, 7, 0, 8, NULL, NULL, 2779),
(3, 3, 8, 0, 10, NULL, NULL, 4479),
(3, 3, 9, 0, 10, NULL, NULL, 311),
(3, 3, 10, 0, 4, NULL, NULL, 2756),
(3, 3, 11, 0, 5, NULL, NULL, 2764),
(3, 3, 12, 0, 3, NULL, NULL, 4),
(3, 3, 13, 0, 3, NULL, NULL, 695),
(3, 3, 14, 0, 13, NULL, NULL, 4407),
(3, 3, 15, 0, 16, NULL, NULL, 1986),
(3, 3, 16, 0, 8, NULL, NULL, 2215),
(3, 3, 17, 0, 11, NULL, NULL, 827),
(3, 3, 18, 0, 5, NULL, NULL, 2475),
(3, 3, 19, 0, 15, NULL, NULL, 2163),
(34, 3, 1, 0, 3, NULL, NULL, 610),
(34, 3, 2, 0, 10, NULL, NULL, 390),
(34, 3, 3, 0, 14, NULL, NULL, 1866),
(34, 3, 4, 0, 15, NULL, NULL, 2525),
(34, 3, 5, 0, 3, NULL, NULL, 788),
(34, 3, 6, 0, 16, NULL, NULL, 1986),
(34, 3, 7, 0, 10, NULL, NULL, 2776),
(34, 3, 8, 0, 8, NULL, NULL, 2779),
(34, 3, 9, 0, 5, NULL, NULL, 2475),
(34, 3, 10, 0, 4, NULL, NULL, 2756),
(34, 3, 11, 0, 5, NULL, NULL, 2764),
(34, 3, 12, 0, 3, NULL, NULL, 4),
(34, 3, 13, 0, 3, NULL, NULL, 695),
(34, 3, 14, 0, 13, NULL, NULL, 4407),
(34, 3, 15, 0, 8, NULL, NULL, 2215),
(34, 3, 16, 0, 10, NULL, NULL, 4479),
(34, 3, 17, 0, 11, NULL, NULL, 827),
(34, 3, 18, 0, 10, NULL, NULL, 311),
(34, 3, 19, 0, 15, NULL, NULL, 2163),
(3, 7, 1, 0, 19, NULL, NULL, 133),
(3, 7, 2, 0, 9, NULL, NULL, 487),
(3, 7, 3, 0, 3, NULL, NULL, 2130),
(3, 7, 4, 0, 3, NULL, NULL, 2160),
(3, 7, 5, 0, 11, NULL, NULL, 526),
(3, 7, 6, 0, 9, NULL, NULL, 556),
(3, 7, 7, 0, 9, NULL, NULL, 706),
(3, 7, 8, 0, 21, NULL, NULL, 2011),
(3, 7, 9, 0, 7, NULL, NULL, 568),
(3, 7, 10, 0, 3, NULL, NULL, 608),
(3, 7, 11, 0, 17, NULL, NULL, 2762),
(3, 7, 12, 0, 19, NULL, NULL, 40),
(3, 7, 13, 0, 17, NULL, NULL, 244),
(3, 7, 14, 0, 15, NULL, NULL, 73),
(3, 7, 15, 0, 11, NULL, NULL, 2857),
(3, 7, 16, 0, 9, NULL, NULL, 2789),
(3, 7, 17, 0, 21, NULL, NULL, 632),
(3, 7, 18, 0, 18, NULL, NULL, 4413),
(3, 7, 19, 0, 12, NULL, NULL, 2839),
(3, 2, 1, 0, 10, NULL, NULL, 2468),
(3, 2, 2, 0, 6, NULL, NULL, 329),
(3, 2, 3, 0, 19, NULL, NULL, 578),
(3, 2, 4, 0, 17, NULL, NULL, 1979),
(3, 2, 5, 0, 6, NULL, NULL, 338),
(3, 2, 6, 0, 4, NULL, NULL, 375),
(3, 2, 7, 0, 16, NULL, NULL, 1933),
(3, 2, 8, 0, 10, NULL, NULL, 2775),
(3, 2, 9, 0, 3, NULL, NULL, 177),
(3, 2, 10, 0, 11, NULL, NULL, 643),
(3, 2, 11, 0, 10, NULL, NULL, 2012),
(3, 2, 12, 0, 10, NULL, NULL, 572),
(3, 2, 13, 0, 16, NULL, NULL, 2315),
(3, 2, 14, 0, 4, NULL, NULL, 2168),
(3, 2, 15, 0, 18, NULL, NULL, 621),
(3, 2, 16, 0, 8, NULL, NULL, 2766),
(3, 2, 17, 0, 15, NULL, NULL, 430),
(3, 2, 18, 0, 6, NULL, NULL, 495),
(3, 2, 19, 0, 18, NULL, NULL, 696),
(3, 11, 1, 0, 16, NULL, NULL, 2792),
(3, 11, 2, 0, 12, NULL, NULL, 2006),
(3, 11, 3, 0, 12, NULL, NULL, 2289),
(3, 11, 4, 0, 15, NULL, NULL, 2801),
(3, 11, 5, 0, 12, NULL, NULL, 2409),
(3, 11, 6, 0, 6, NULL, NULL, 2085),
(3, 11, 7, 0, 20, NULL, NULL, 65),
(3, 11, 8, 0, 19, NULL, NULL, 2625),
(3, 11, 9, 0, 6, NULL, NULL, 785),
(3, 11, 10, 0, 11, NULL, NULL, 2819),
(3, 11, 11, 0, 16, NULL, NULL, 1943),
(3, 11, 12, 0, 16, NULL, NULL, 2271),
(3, 11, 13, 0, 18, NULL, NULL, 1896),
(3, 11, 14, 0, 17, NULL, NULL, 365),
(3, 11, 15, 0, 14, NULL, NULL, 4514),
(3, 11, 16, 0, 14, NULL, NULL, 627),
(3, 11, 17, 0, 20, NULL, NULL, 1879),
(3, 11, 18, 0, 18, NULL, NULL, 380),
(3, 11, 19, 0, 9, NULL, NULL, 1839),
(3, 4, 1, 0, 12, NULL, NULL, 1917),
(3, 4, 2, 0, 10, NULL, NULL, 142),
(3, 4, 3, 0, 4, NULL, NULL, 460),
(3, 4, 4, 0, 6, NULL, NULL, 513),
(3, 4, 5, 0, 8, NULL, NULL, 4245),
(3, 4, 6, 0, 12, NULL, NULL, 2002),
(3, 4, 7, 0, 2, NULL, NULL, 2379),
(3, 4, 8, 0, 2, NULL, NULL, 2472),
(3, 4, 9, 0, 9, NULL, NULL, 315),
(3, 4, 10, 0, 11, NULL, NULL, 531),
(3, 4, 11, 0, 8, NULL, NULL, 647),
(3, 4, 12, 0, 18, NULL, NULL, 4425),
(3, 4, 13, 0, 6, NULL, NULL, 4397),
(3, 4, 14, 0, 7, NULL, NULL, 2104),
(3, 4, 15, 0, 2, NULL, NULL, 2166),
(3, 4, 16, 0, 5, NULL, NULL, 181),
(3, 4, 17, 0, 12, NULL, NULL, 771),
(3, 4, 18, 0, 5, NULL, NULL, 536),
(3, 4, 19, 0, 17, NULL, NULL, 479),
(3, 9, 1, 0, 15, NULL, NULL, 159),
(3, 9, 2, 0, 8, NULL, NULL, 2016),
(3, 9, 3, 0, 11, NULL, NULL, 1895),
(3, 9, 4, 0, 5, NULL, NULL, 253),
(3, 9, 5, 0, 3, NULL, NULL, 26),
(3, 9, 6, 0, 6, NULL, NULL, 645),
(3, 9, 7, 0, 10, NULL, NULL, 152),
(3, 9, 8, 0, 12, NULL, NULL, 644),
(3, 9, 9, 0, 10, NULL, NULL, 410),
(3, 9, 10, 0, 18, NULL, NULL, 4452),
(3, 9, 11, 0, 14, NULL, NULL, 1874),
(3, 9, 12, 0, 17, NULL, NULL, 1843),
(3, 9, 13, 0, 19, NULL, NULL, 4422),
(3, 9, 14, 0, 9, NULL, NULL, 2171),
(3, 9, 15, 0, 8, NULL, NULL, 1852),
(3, 9, 16, 0, 21, NULL, NULL, 4522),
(3, 9, 17, 0, 11, NULL, NULL, 4501),
(3, 9, 18, 0, 20, NULL, NULL, 183),
(3, 9, 19, 0, 16, NULL, NULL, 2826),
(34, 6, 1, 0, 8, NULL, NULL, 4419),
(34, 6, 2, 0, 15, NULL, NULL, 1864),
(34, 6, 3, 0, 17, NULL, NULL, 2759),
(34, 6, 4, 0, 16, NULL, NULL, 2870),
(34, 6, 5, 0, 2, NULL, NULL, 469),
(34, 6, 6, 0, 2, NULL, NULL, 697),
(34, 6, 7, 0, 5, NULL, NULL, 1978),
(34, 6, 8, 0, 6, NULL, NULL, 2263),
(34, 6, 9, 0, 13, NULL, NULL, 383),
(34, 6, 10, 0, 15, NULL, NULL, 474),
(34, 6, 11, 0, 5, NULL, NULL, 2531),
(34, 6, 12, 0, 8, NULL, NULL, 41),
(34, 6, 13, 0, 7, NULL, NULL, 2784),
(34, 6, 14, 0, 13, NULL, NULL, 2261),
(34, 6, 15, 0, 13, NULL, NULL, 28),
(34, 6, 16, 0, 15, NULL, NULL, 234),
(34, 6, 17, 0, 3, NULL, NULL, 22),
(34, 6, 18, 0, 19, NULL, NULL, 2743),
(34, 6, 19, 0, 17, NULL, NULL, 819),
(49, 10, 1, 0, 9, NULL, NULL, 2179),
(49, 10, 2, 0, 5, NULL, NULL, 295),
(49, 10, 3, 0, 2, NULL, NULL, 286),
(49, 10, 4, 0, 5, NULL, NULL, 322),
(49, 10, 5, 0, 3, NULL, NULL, 787),
(49, 10, 6, 0, 18, NULL, NULL, 4449),
(49, 10, 7, 0, 5, NULL, NULL, 1870),
(49, 10, 8, 0, 10, NULL, NULL, 406),
(49, 10, 9, 0, 5, NULL, NULL, 265),
(49, 10, 10, 0, 14, NULL, NULL, 2061),
(49, 10, 11, 0, 17, NULL, NULL, 2038),
(49, 10, 12, 0, 9, NULL, NULL, 220),
(49, 10, 13, 0, 11, NULL, NULL, 640),
(49, 10, 14, 0, 21, NULL, NULL, 581),
(49, 10, 15, 0, 5, NULL, NULL, 332),
(49, 10, 16, 0, 16, NULL, NULL, 434),
(49, 10, 17, 0, 20, NULL, NULL, 1939),
(49, 10, 18, 0, 21, NULL, NULL, 2327),
(49, 10, 19, 0, 4, NULL, NULL, 4510);

-- --------------------------------------------------------

--
-- Struttura della tabella `generale`
--

CREATE TABLE `generale` (
  `nome_parametro` text NOT NULL,
  `valore` text NOT NULL,
  `id_parametro` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `generale`
--

INSERT INTO `generale` (`nome_parametro`, `valore`, `id_parametro`) VALUES
('anno', '19/20', 1),
('fantamilioni', '400', 2),
('addizionale_casa', '1', 3),
('password_presidente', 'vivailpresidente', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `giocatori`
--

CREATE TABLE `giocatori` (
  `id` int(4) NOT NULL,
  `ruolo` varchar(1) DEFAULT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `id_squadra` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `giocatori`
--

INSERT INTO `giocatori` (`id`, `ruolo`, `nome`, `id_squadra`) VALUES
(1, 'R', 'Nome', 1),
(2610, 'A', 'CRISTIANO RONALDO', 2),
(608, 'A', 'ZAPATA D', 3),
(2756, 'A', 'PIATEK', 4),
(2531, 'A', 'LUKAKU R', 5),
(785, 'A', 'IMMOBILE', 6),
(568, 'A', 'QUAGLIARELLA', 7),
(647, 'A', 'DZEKO', 8),
(441, 'A', 'BELOTTI', 9),
(408, 'A', 'HIGUAIN', 2),
(409, 'A', 'INSIGNE', 10),
(410, 'A', 'MERTENS', 10),
(2012, 'A', 'MILIK', 10),
(2819, 'A', 'CAPUTO', 11),
(26, 'C', 'GOMEZ A', 3),
(2002, 'C', 'CHIESA', 12),
(2764, 'A', 'MARTINEZ L', 5),
(309, 'A', 'DYBALA', 2),
(383, 'A', 'PETAGNA', 13),
(177, 'A', 'ILICIC', 3),
(247, 'A', 'PAVOLETTI', 14),
(2475, 'A', 'SANCHEZ A', 5),
(645, 'C', 'MILINKOVIC-SAVIC', 6),
(123, 'A', 'INGLESE', 15),
(4517, 'A', 'LOZANO', 10),
(2085, 'C', 'LUIS ALBERTO', 6),
(1996, 'C', 'DE PAUL', 16),
(312, 'A', 'MANDZUKIC', 2),
(4510, 'A', 'RAFAEL LEAO', 4),
(2038, 'A', 'PINAMONTI', 17),
(495, 'A', 'CORREA', 6),
(531, 'A', 'BERARDI', 11),
(475, 'A', 'IAGO FALQUE', 9),
(406, 'C', 'CALLEJON', 10),
(474, 'A', 'GERVINHO', 15),
(186, 'A', 'REBIC', 4),
(4324, 'A', 'OKAKA', 16),
(184, 'C', 'BERNARDESCHI', 2),
(375, 'C', 'SUSO', 4),
(2201, 'C', 'UNDER', 8),
(2409, 'C', 'RIBERY', 12),
(507, 'A', 'MURIEL', 3),
(696, 'A', 'BALOTELLI ', 18),
(250, 'P', 'HANDANOVIC', 5),
(2472, 'C', 'RAMSEY', 2),
(472, 'A', 'DESTRO', 19),
(2167, 'A', 'ORSOLINI', 19),
(2762, 'A', 'KOUAME', 17),
(2214, 'D', 'KOLAROV', 8),
(226, 'D', 'IZZO', 9),
(2775, 'C', 'RUIZ', 10),
(376, 'C', 'VERDI', 9),
(152, 'C', 'ZIELINSKI', 10),
(4452, 'A', 'DONNARUMMA AL', 18),
(1874, 'A', 'JOAO PEDRO', 14),
(90, 'A', 'LASAGNA', 16),
(453, 'P', 'SZCZESNY', 2),
(467, 'C', 'NAINGGOLAN', 14),
(469, 'C', 'PJANIC', 2),
(367, 'C', 'BONAVENTURA', 4),
(2766, 'C', 'ZANIOLO', 8),
(28, 'C', 'KURTIC', 13),
(311, 'A', 'LLORENTE', 10),
(350, 'P', 'DONNARUMMA G', 4),
(2160, 'D', 'GOSENS', 3),
(2130, 'D', 'HATEBOER', 3),
(798, 'D', 'SKRINIAR', 5),
(288, 'D', 'CHIELLINI', 2),
(2288, 'D', 'NKOULOU', 9),
(2625, 'C', 'SORIANO', 19),
(557, 'C', 'BENASSI', 12),
(1870, 'C', 'BARELLA', 5),
(2200, 'C', 'DOUGLAS COSTA', 2),
(2263, 'C', 'LAZZARI M', 6),
(2779, 'C', 'KLUIVERT', 8),
(771, 'A', 'BOATENG', 12),
(2868, 'A', 'RIGONI E', 7),
(1934, 'P', 'STRAKOSHA', 6),
(2179, 'P', 'SIRIGU', 9),
(2197, 'D', 'CASTAGNE', 3),
(2759, 'D', 'CRISCITO', 17),
(2572, 'D', 'GODIN', 5),
(662, 'D', 'ALEX SANDRO', 2),
(513, 'D', 'ACERBI', 6),
(460, 'D', 'ROMAGNOLI A', 4),
(392, 'D', 'KOULIBALY', 10),
(459, 'D', 'MANOLAS', 10),
(644, 'C', 'PULGAR', 12),
(1978, 'C', 'SENSI', 5),
(2504, 'C', 'CAN ', 2),
(2379, 'C', 'RABIOT', 2),
(342, 'C', 'PAROLO', 6),
(4322, 'C', 'PAQUETA', 4),
(237, 'C', 'PEROTTI', 8),
(2215, 'C', 'VERETOUT', 8),
(2529, 'C', 'MKHITARYAN', 8),
(2061, 'A', 'SIMEONE', 14),
(2284, 'A', 'CAICEDO', 6),
(643, 'A', 'DEFREL', 11),
(183, 'A', 'BABACAR', 20),
(610, 'P', 'GOLLINI', 3),
(572, 'P', 'MERET', 10),
(4419, 'P', 'PAU LOPEZ', 8),
(322, 'D', 'DE VRIJ', 5),
(4428, 'D', 'DE LIGT', 2),
(2296, 'D', 'MANCINI G', 8),
(788, 'C', 'FREULER', 3),
(112, 'C', 'CASTRO', 14),
(2194, 'C', 'CALHANOGLU', 4),
(148, 'C', 'KRUNIC', 4),
(397, 'C', 'ALLAN', 10),
(530, 'C', 'PELLEGRINI LO', 8),
(706, 'C', 'ANSALDI', 9),
(4228, 'C', 'GHEZZAL', 12),
(280, 'A', 'PALACIO', 19),
(537, 'A', 'SANSONE N', 19),
(4453, 'A', 'TORREGROSSA', 18),
(1939, 'A', 'LAPADULA', 20),
(1958, 'A', 'CAPRARI', 7),
(407, 'A', 'GABBIADINI', 7),
(315, 'A', 'ZAZA', 9),
(4500, 'A', 'DI CARMINE', 21),
(652, 'A', 'KALINIC', 8),
(2816, 'D', 'DI LORENZO', 10),
(390, 'D', 'GHOULAM', 10),
(4237, 'D', 'DANILO', 2),
(265, 'C', 'BROZOVIC', 5),
(2306, 'C', 'MATUIDI', 2),
(338, 'C', 'LULIC', 6),
(1850, 'C', 'KESSIE', 4),
(234, 'C', 'KUCKA', 15),
(2857, 'C', 'TRAORE HJ', 11),
(1857, 'C', 'DI FRANCESCO F', 13),
(536, 'A', 'POLITANO', 5),
(2325, 'A', 'KARAMOH', 15),
(2832, 'A', 'BOGA', 11),
(2178, 'P', 'CRAGNO', 14),
(295, 'D', 'ASAMOAH', 5),
(286, 'D', 'BONUCCI', 2),
(487, 'D', 'DE SILVESTRI', 9),
(4245, 'D', 'SMALLING', 8),
(4427, 'C', 'MALINOVSKYI', 3),
(2818, 'C', 'BENNACER', 4),
(2378, 'C', 'PASTORE', 8),
(2008, 'C', 'LINETTY', 7),
(526, 'C', 'DUNCAN', 11),
(827, 'C', 'LOCATELLI M', 11),
(556, 'C', 'BASELLI', 9),
(2172, 'C', 'BARAK', 16),
(1986, 'C', 'FOFANA', 16),
(4512, 'C', 'SCHONE', 17),
(4514, 'C', 'NANDEZ', 14),
(2743, 'A', 'SANTANDER', 19),
(2826, 'A', 'PUSSETTO', 16),
(2327, 'A', 'STEPINSKI', 21),
(133, 'P', 'SKORUPSKI', 19),
(1917, 'P', 'DRAGOWSKI', 12),
(761, 'P', 'AUDERO', 7),
(509, 'P', 'CONSIGLI', 11),
(252, 'D', 'BIRAGHI', 5),
(2164, 'D', 'MILENKOVIC', 12),
(2006, 'D', 'LIROLA', 12),
(2192, 'D', 'BONIFAZI', 9),
(22, 'C', 'DE ROON', 3),
(2077, 'C', 'PASALIC', 3),
(2076, 'C', 'ROG', 14),
(150, 'C', 'SAPONARA', 17),
(299, 'C', 'KHEDIRA', 2),
(2692, 'C', 'CASTILLEJO', 4),
(2287, 'C', 'RAMIREZ', 7),
(4501, 'C', 'OBIANG', 11),
(2789, 'C', 'MEITE', 9),
(632, 'C', 'ZACCAGNI', 21),
(1879, 'A', 'FARIAS', 20),
(245, 'A', 'PANDEV', 17),
(479, 'A', 'SANABRIA', 17),
(1943, 'A', 'NESTOROVSKI', 16),
(636, 'A', 'PAZZINI', 21),
(4527, 'A', 'PEDRO', 12),
(159, 'P', 'SEPE', 15),
(2792, 'P', 'MUSSO', 16),
(2181, 'D', 'PALOMINO', 3),
(695, 'D', 'TOLOI', 3),
(2309, 'D', 'PEZZELLA GER', 12),
(4307, 'D', 'ROMERO C', 17),
(365, 'D', 'ZAPATA C', 17),
(253, 'D', 'DAMBROSIO', 5),
(4397, 'D', 'VAVRO', 6),
(357, 'D', 'CALABRIA', 4),
(1864, 'D', 'BRUNO ALVES', 15),
(2016, 'D', 'FAZIO', 8),
(464, 'D', 'FLORENZI', 8),
(1895, 'D', 'FERRARI G', 11),
(4511, 'D', 'DUARTE', 4),
(554, 'D', 'ZAPPACOSTA', 8),
(374, 'C', 'POLI', 19),
(4445, 'C', 'BISOLI', 18),
(697, 'C', 'CUADRADO', 2),
(2209, 'C', 'LUCAS LEIVA', 6),
(779, 'C', 'CRISTANTE', 8),
(1987, 'C', 'JANKTO', 7),
(2205, 'C', 'BERENGUER', 9),
(238, 'C', 'RINCON', 9),
(264, 'C', 'BESSA', 21),
(2719, 'A', 'BARROW', 3),
(4477, 'A', 'LA MANTIA', 20),
(2163, 'A', 'CORNELIUS', 15),
(126, 'A', 'PALOSCHI', 13),
(4425, 'P', 'JORONEN', 18),
(1843, 'P', 'RADU I', 17),
(316, 'P', 'BERISHA E', 13),
(787, 'D', 'DJIMSITI', 3),
(578, 'D', 'DANILO LAR', 19),
(2746, 'D', 'DIJKS', 19),
(2083, 'D', 'BIRASCHI', 17),
(4332, 'D', 'DEMIRAL', 2),
(4292, 'D', 'HERNANDEZ T', 4),
(2169, 'D', 'RODRIGUEZ R', 4),
(2860, 'D', 'MALCUIT', 10),
(73, 'D', 'GAGLIOLO', 15),
(259, 'D', 'MURILLO', 7),
(2865, 'D', 'AINA', 9),
(2171, 'D', 'LYANCO', 9),
(4412, 'D', 'RODRIGO BECAO', 16),
(2525, 'D', 'DARMIAN', 15),
(2633, 'D', 'KJAER', 3),
(713, 'C', 'DZEMAILI', 19),
(2106, 'C', 'MOROSINI', 18),
(4448, 'C', 'SPALEK', 18),
(627, 'C', 'IONITA', 14),
(4377, 'C', 'CASTROVILLI', 12),
(332, 'C', 'CANDREVA', 5),
(801, 'C', 'GAGLIARDINI', 5),
(4385, 'C', 'LAZARO', 5),
(181, 'C', 'VECINO', 5),
(2166, 'C', 'BENTANCUR', 2),
(65, 'C', 'MANCOSU', 20),
(331, 'C', 'BIGLIA', 4),
(2776, 'C', 'YOUNES', 10),
(2802, 'C', 'BARILLA', 15),
(27, 'C', 'GRASSI', 15),
(58, 'C', 'DIAWARA', 8),
(1933, 'C', 'MANDRAGORA', 16),
(4415, 'A', 'SKOV OLSEN', 19),
(4388, 'A', 'ADEKANYE', 6),
(637, 'A', 'SILIGARDI', 15),
(2873, 'A', 'TEODORCZYK', 16),
(2211, 'P', 'SILVESTRI', 21),
(15, 'D', 'MASIELLO A', 3),
(4414, 'D', 'DENSWIL', 19),
(4442, 'D', 'CISTANA', 18),
(99, 'D', 'CACCIATORE', 14),
(1866, 'D', 'CEPPITELLI', 14),
(294, 'D', 'RUGANI', 2),
(2335, 'D', 'LUIZ FELIPE', 6),
(329, 'D', 'RADU', 6),
(2168, 'D', 'MUSACCHIO', 4),
(140, 'D', 'HYSAJ', 10),
(141, 'D', 'LAURINI', 15),
(1852, 'D', 'SPINAZZOLA', 8),
(1868, 'D', 'MURRU', 7),
(2318, 'D', 'ROGERIO', 11),
(4426, 'D', 'TOLJAN', 11),
(4407, 'D', 'IGOR', 13),
(2261, 'D', 'VICARI', 13),
(2869, 'D', 'DJIDJI', 9),
(790, 'D', 'SAMIR', 16),
(2315, 'D', 'STRYGER LARSEN', 16),
(4420, 'D', 'BOCCHETTI', 21),
(4526, 'D', 'ARANA', 3),
(4447, 'C', 'NDOJ', 18),
(111, 'C', 'BIRSA', 14),
(118, 'C', 'RADOVANOVIC', 17),
(621, 'C', 'ROMULO', 18),
(4479, 'C', 'ELMAS', 10),
(2391, 'C', 'EKDAL', 7),
(4405, 'C', 'MARONI', 7),
(21, 'C', 'DALESSANDRO', 13),
(633, 'C', 'FARES', 13),
(2003, 'C', 'MURGIA', 13),
(2011, 'C', 'MIGUEL VELOSO', 21),
(4513, 'C', 'ZMRHAL', 18),
(236, 'C', 'LAZOVIC', 21),
(2392, 'C', 'WALACE', 16),
(2389, 'C', 'IMBULA', 20),
(4413, 'A', 'AYE', 18),
(533, 'A', 'FLOCCARI', 13),
(385, 'P', 'GABRIEL', 20),
(4429, 'D', 'CHANCELLOR', 18),
(1896, 'D', 'MARTELLA', 18),
(791, 'D', 'SABELLI', 18),
(2871, 'D', 'KLAVAN', 14),
(1979, 'D', 'BARRECA', 17),
(358, 'D', 'DE SCIGLIO', 2),
(2728, 'D', 'PELLEGRINI LU', 14),
(2062, 'D', 'BASTOS', 6),
(4398, 'D', 'BENZAR', 20),
(4470, 'D', 'CALDERONI', 20),
(2784, 'D', 'COLLEY', 7),
(2141, 'D', 'DEPAOLI', 7),
(2769, 'D', 'MAGNANI', 18),
(2355, 'D', 'MARLON', 11),
(780, 'D', 'CIONEK', 13),
(708, 'D', 'FELIPE', 13),
(224, 'D', 'DE MAIO', 16),
(4449, 'C', 'TONALI', 18),
(20, 'C', 'CIGARINI', 14),
(4376, 'C', 'ZURKOWSKI', 12),
(4330, 'C', 'LERAGER', 17),
(305, 'C', 'STURARO', 17),
(170, 'C', 'BADELJ', 12),
(4424, 'C', 'JONY', 6),
(179, 'C', 'PETRICCIONE', 20),
(4423, 'C', 'HERNANI', 15),
(2833, 'C', 'KULUSEVSKI', 15),
(600, 'C', 'VERRE', 21),
(2825, 'C', 'BOURABIA', 11),
(529, 'C', 'MISSIROLI', 13),
(2274, 'C', 'VALOTI', 13),
(2009, 'C', 'LUKIC', 9),
(589, 'C', 'BADU', 21),
(4381, 'A', 'GUMUS', 17),
(2773, 'A', 'SPROCATI', 15),
(2285, 'D', 'BANI', 19),
(50, 'D', 'MBAYE', 19),
(4422, 'D', 'TOMIYASU', 19),
(4373, 'D', 'MATEJU', 18),
(106, 'D', 'MATTIELLO', 14),
(1876, 'D', 'PAJAC', 17),
(2279, 'D', 'ROMAGNA', 11),
(1891, 'D', 'CECCHERINI', 12),
(244, 'D', 'GHIGLIONE', 17),
(2241, 'D', 'LUCIONI', 20),
(54, 'D', 'ROSSETTINI', 20),
(11, 'D', 'CONTI', 4),
(550, 'D', 'MAKSIMOVIC', 10),
(142, 'D', 'MARIO RUI', 10),
(144, 'D', 'TONELLI', 10),
(256, 'D', 'JUAN JESUS', 8),
(2104, 'D', 'BERESZYNSKI', 7),
(45, 'D', 'FERRARI A', 7),
(770, 'D', 'PEZZELLA GIU', 15),
(2870, 'D', 'TROOST-EKONG', 16),
(4493, 'D', 'DAWIDOWICZ', 21),
(581, 'D', 'FARAONI', 21),
(2758, 'D', 'GUNTER', 21),
(4409, 'D', 'RRAHMANI', 21),
(423, 'D', 'RISPOLI', 20),
(4519, 'D', 'CETIN', 8),
(4521, 'D', 'MULDUR', 11),
(2741, 'C', 'PESSINA', 21),
(4384, 'C', 'JAGIELLO', 17),
(2771, 'C', 'BERISHA V', 6),
(333, 'C', 'CATALDI', 6),
(2188, 'C', 'MARUSIC', 6),
(4475, 'C', 'MAJER', 20),
(4400, 'C', 'SHAKHOV', 20),
(241, 'C', 'TACHTSIDIS', 20),
(2187, 'C', 'BORINI', 4),
(235, 'C', 'LAXALT', 9),
(494, 'C', 'BARRETO', 7),
(4404, 'C', 'THORSBY', 7),
(1995, 'C', 'DJURICIC', 11),
(528, 'C', 'MAGNANELLI', 11),
(4498, 'C', 'HENDERSON L', 21),
(430, 'C', 'BRUGMAN', 15),
(2334, 'C', 'LERIS', 7),
(4522, 'C', 'AMRABAT', 21),
(4524, 'C', 'SEMA', 16),
(272, 'C', 'MEDEL', 19),
(306, 'A', 'CERRI', 14),
(819, 'A', 'FAVILLI', 17),
(658, 'A', 'FALCO', 20),
(505, 'A', 'BONAZZOLI', 7),
(2853, 'A', 'MONCINI', 13),
(282, 'P', 'BUFFON', 2),
(2739, 'D', 'RECA', 13),
(2653, 'D', 'LYKOGIANNIS', 14),
(1869, 'D', 'PISACANE', 14),
(2174, 'D', 'VENUTI', 12),
(2120, 'D', 'BASTONI', 5),
(2289, 'D', 'DALBERT', 12),
(4472, 'D', 'MECCARIELLO', 20),
(1847, 'D', 'CALDARA', 4),
(640, 'D', 'CHIRICHES', 11),
(139, 'D', 'DERMAKU', 15),
(2801, 'D', 'IACOPONI', 15),
(4421, 'D', 'AUGELLO', 7),
(4403, 'D', 'CHABOT', 7),
(630, 'D', 'SALA', 13),
(517, 'D', 'DELLORCO', 20),
(418, 'D', 'GOLDANIGA', 17),
(521, 'D', 'PELUSO', 11),
(2788, 'D', 'BREMER', 9),
(2280, 'D', 'NUYTINCK', 16),
(2795, 'D', 'TER AVEST', 16),
(4494, 'D', 'EMPEREUR', 21),
(4496, 'D', 'VITALE L', 21),
(169, 'D', 'TOMOVIC', 13),
(287, 'D', 'CACERES', 12),
(4529, 'D', 'ANKERSEN', 17),
(4393, 'C', 'SCHOUTEN', 19),
(1872, 'C', 'DESSENA', 18),
(2116, 'C', 'FARAGO', 14),
(2290, 'C', 'EYSSERIC', 12),
(2804, 'C', 'SCOZZARELLA', 15),
(405, 'C', 'VALDIFIORI', 13),
(434, 'C', 'JAJALO', 16),
(81, 'C', 'DI GAUDIO', 21),
(4515, 'C', 'AGUDELO', 17),
(2146, 'A', 'HAN', 2),
(2839, 'A', 'SOTTIL', 12),
(2841, 'A', 'VLAHOVIC', 12),
(1998, 'A', 'PJACA', 2),
(380, 'A', 'MATRI', 18),
(1839, 'A', 'EDERA', 9),
(2468, 'P', 'OSPINA', 10),
(47, 'D', 'GASTALDELLO', 18),
(4374, 'D', 'WALUKIEWICZ', 14),
(2664, 'D', 'EL YAMIQ', 17),
(254, 'D', 'DIMARCO', 5),
(261, 'D', 'RANOCCHIA', 5),
(1999, 'D', 'LUKAKU J', 6),
(393, 'D', 'LUPERTO', 10),
(262, 'D', 'SANTON', 8),
(824, 'D', 'ADJAPONG', 21),
(491, 'D', 'SALAMON', 13),
(4495, 'D', 'KUMBULLA', 21),
(1858, 'C', 'KREJCI', 19),
(2744, 'C', 'SVANBERG', 19),
(4327, 'C', 'OLIVA', 14),
(2075, 'C', 'CRISTOFORO', 12),
(2659, 'C', 'DABO', 12),
(172, 'C', 'BORJA VALERO', 5),
(4476, 'C', 'TABANELLI', 20),
(2855, 'C', 'VIEIRA', 7),
(4338, 'C', 'JANKOVIC', 13),
(611, 'P', 'RAFAEL', 14),
(4331, 'D', 'IBANEZ', 3),
(4443, 'D', 'CURCIO', 18),
(4444, 'D', 'SEMPRINI', 18),
(4454, 'D', 'PINNA', 14),
(2752, 'D', 'RASMUSSEN', 12),
(2772, 'D', 'DURMISI', 6),
(4467, 'D', 'JORGE SILVA', 6),
(327, 'D', 'PATRIC', 6),
(805, 'D', 'FIAMOZZI', 20),
(4399, 'D', 'VERA', 20),
(490, 'D', 'REGINI', 7),
(4406, 'D', 'TRIPALDELLI', 11),
(2793, 'D', 'OPOKU', 16),
(4302, 'D', 'SIERRALTA', 16),
(4530, 'D', 'KYRIAKOPOULOS', 11),
(4450, 'C', 'TREMOLADA', 18),
(1871, 'C', 'DEIOLA', 14),
(2213, 'C', 'CASSATA', 17),
(2646, 'C', 'SANDRO', 17),
(4389, 'C', 'ANDERSON A', 6),
(1976, 'C', 'MAZZITELLI', 11),
(1982, 'C', 'PARIGINI', 9),
(2726, 'C', 'DANZI', 21),
(4455, 'A', 'RAGATZU', 14),
(2048, 'A', 'LO FASO', 20),
(4507, 'A', 'TUTINO', 21),
(2657, 'A', 'ANTONUCCI', 8),
(2297, 'P', 'ROSSI F', 3),
(4, 'P', 'SPORTIELLO', 3),
(40, 'P', 'DA COSTA', 19),
(42, 'P', 'SARR M', 19),
(4440, 'P', 'ALFONSO', 18),
(4441, 'P', 'ANDRENACCI', 18),
(1946, 'P', 'ARESTI', 14),
(4351, 'P', 'BRANCOLINI', 12),
(2294, 'P', 'CEROFOLINI', 12),
(2815, 'P', 'TERRACCIANO', 12),
(4325, 'P', 'JANDREI', 17),
(318, 'P', 'MARCHETTI', 17),
(2761, 'P', 'VODISEK', 17),
(248, 'P', 'BERNI', 5),
(543, 'P', 'PADELLI', 5),
(218, 'P', 'PERIN', 2),
(1930, 'P', 'PINSOGLIO', 2),
(317, 'P', 'GUERRIERI', 6),
(2770, 'P', 'PROTO', 6),
(4468, 'P', 'BLEVE', 20),
(2809, 'P', 'VIGORITO', 20),
(216, 'P', 'DONNARUMMA AN', 4),
(387, 'P', 'REINA', 4),
(570, 'P', 'KARNEZIS', 10),
(412, 'P', 'COLOMBI', 15),
(2781, 'P', 'FUZATO', 8),
(41, 'P', 'MIRANTE', 8),
(2836, 'P', 'OLSEN', 14),
(2134, 'P', 'FALCONE', 7),
(510, 'P', 'PEGOLO', 11),
(4485, 'P', 'THIAM D', 13),
(2790, 'P', 'ROSATI', 9),
(2270, 'P', 'ZACCAGNO', 9),
(2271, 'P', 'NICOLAS', 16),
(673, 'P', 'PERISAN', 16),
(4491, 'P', 'BERARDI A', 21),
(3, 'P', 'RADUNOVIC', 21),
(654, 'P', 'ALASTRA', 15),
(4518, 'P', 'RUSSO A', 11),
(4520, 'P', 'LETICA', 13),
(4523, 'P', 'AVOGADRI', 7),
(97, 'P', 'SECULIN', 7),
(220, 'P', 'UJKANI', 9),
(4432, 'D', 'OKOLI', 3),
(4365, 'D', 'CORBO', 19),
(2747, 'D', 'PAZ', 19),
(4504, 'D', 'MANGRAVITI', 18),
(4378, 'D', 'RANIERI L', 12),
(4375, 'D', 'TERZIC', 12),
(4391, 'D', 'CASASOLA', 6),
(4502, 'D', 'GALLO', 20),
(4473, 'D', 'RICCARDI D', 20),
(4401, 'D', 'GABBIA', 4),
(2783, 'D', 'BIANDA', 8),
(4481, 'D', 'BOUAH', 8),
(2724, 'D', 'BUONGIORNO', 9),
(457, 'D', 'CRESCENZI', 21),
(4509, 'D', 'CIPRIANO', 6),
(4528, 'D', 'GASOLINA WESLEY', 21),
(4435, 'C', 'COLLEY E', 3),
(4451, 'C', 'VIVIANI M', 18),
(4353, 'C', 'MONTIEL', 12),
(4459, 'C', 'ROVELLA', 17),
(4383, 'C', 'ZENNARO', 17),
(4411, 'C', 'AGOUME', 5),
(4465, 'C', 'FAGIOLI', 2),
(4370, 'C', 'PORTANOVA', 2),
(2243, 'C', 'CICIRETTI', 10),
(4364, 'C', 'GAETANO', 10),
(1875, 'C', 'MUNARI', 15),
(2852, 'C', 'RICCARDI', 8),
(4486, 'C', 'STREFEZZA', 13),
(4490, 'C', 'DE ANGELIS', 9),
(4499, 'C', 'LUCAS FELIPPE', 21),
(4436, 'A', 'CAMBIAGHI', 3),
(4359, 'A', 'PICCOLI', 3),
(4368, 'A', 'JUWARA', 19),
(606, 'A', 'THEREAU', 12),
(4463, 'A', 'ESPOSITO SE', 5),
(2304, 'A', 'SALCEDO E', 21),
(4387, 'A', 'ADORANTE', 15),
(4483, 'A', 'CANGIANO', 19),
(4508, 'A', 'BAHLOULI', 7),
(4371, 'A', 'RASPADORI', 11),
(4346, 'A', 'MILLICO', 9),
(4489, 'A', 'RAUTI', 9),
(767, 'A', 'TUPTA', 21);

-- --------------------------------------------------------

--
-- Struttura della tabella `giornate`
--

CREATE TABLE `giornate` (
  `id_giornata` int(11) NOT NULL,
  `inizio` datetime DEFAULT NULL,
  `fine` datetime DEFAULT NULL,
  `id_girone` int(11) NOT NULL DEFAULT 1,
  `commento` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `giornate`
--

INSERT INTO `giornate` (`id_giornata`, `inizio`, `fine`, `id_girone`, `commento`) VALUES
(1, '2019-09-19 15:36:00', '2019-09-20 20:44:00', 1, NULL),
(2, '2019-09-21 12:00:00', '2019-09-24 18:59:00', 1, 'Serie A CENTRO TIM\nArchiviate le prime due giornate di campionato e abbiamo già un tormentone: \"ma quanti ne deve fare?\"\nAnche quest\'anno non capisco perchè gli avete fatto fare l\'asta da solo...\nTiene botta Filippo che supera di misura il buon Carletto e uno spento Giorgio.\nProprio il nuovo piccioncino in amore, non riesce ad ingranare, spaesato senza il suo pupillo Higuain e, evidentemente, con la testa tra le nuvole.\nSorprende l\'AS Venere. Se devo essere onesto, non riesco a trovare parole per commentare il suo primato in classifica, abituato sino ad oggi soltanto a deriderlo e sbeffeggiarlo per le sue ignobili prestazioni.\nRiescono ad imporsi anche i NANI dopo un esordio da dimenticare e tornano a fare una paura bestiale come una volta quando al solo pensiero non facevano dormire la notte.\nAnche Bar Fabio ritrova un po\' di slancio, ma l\'avversario di turno non ha offerto una resistenza eccezionale. Resta agli atti, invece, la quaterna rimediata all\'esordio contro un Rodrigo Becao a dir poco arrembante.\nNon si ripete l\'Atletico che dopo aver respinto i nani sulle rive del fiume, si arrende con troppa semplicità in casa dell\'architetto.\nPrimo puntacchione per Valle Sant\'Andrea e Nuova Romanina. Per entrambi forse qualche elogio di troppo in avvio a discapito di quei frutti che, di contro, sul campo stentano a vedersi.\nCossa Pù cambia il nome ma non i risultati. Un punto in due gare sono un bottino troppo magro per il primo possessore della famigerata Coppa.\nMi aspettavo qualcosina in più anche dal PAN UTD. Anche se esordiente, la sua esperienza e sapienza calcistica, oltre a una profonda conoscenza della nostra lega (il suo zampino già era presente in alcune squadre degli anni passati), pensavo potessero fargli fare tutt\'altra partenza. Aspettiamo e vediamo se riesce a trovare la quadratura del cerchio.\nVi attendo anche per l\'inaugurazione della Coppa Italia che offre ricchi premi e cotillon!'),
(3, '2019-09-27 17:05:00', '2019-09-28 14:59:00', 1, NULL),
(4, '2019-10-01 12:00:00', '2019-10-04 20:44:00', 1, NULL),
(5, NULL, NULL, 1, NULL),
(6, NULL, NULL, 1, NULL),
(7, NULL, NULL, 1, NULL),
(8, NULL, NULL, 1, NULL),
(9, NULL, NULL, 1, NULL),
(10, NULL, NULL, 1, NULL),
(11, NULL, NULL, 1, NULL),
(12, NULL, NULL, 1, NULL),
(13, NULL, NULL, 1, NULL),
(14, NULL, NULL, 1, NULL),
(15, NULL, NULL, 1, NULL),
(16, NULL, NULL, 1, NULL),
(17, NULL, NULL, 1, NULL),
(18, NULL, NULL, 1, NULL),
(19, NULL, NULL, 1, NULL),
(20, NULL, NULL, 1, NULL),
(21, NULL, NULL, 1, NULL),
(22, NULL, NULL, 1, NULL),
(23, NULL, NULL, 2, NULL),
(24, NULL, NULL, 2, NULL),
(25, NULL, NULL, 2, NULL),
(26, NULL, NULL, 2, NULL),
(27, NULL, NULL, 2, NULL),
(28, NULL, NULL, 2, NULL),
(29, NULL, NULL, 2, NULL),
(30, NULL, NULL, 2, NULL),
(31, NULL, NULL, 2, NULL),
(32, NULL, NULL, 2, NULL),
(33, NULL, NULL, 2, NULL),
(34, '2019-09-27 19:35:00', '2019-09-28 14:59:00', 4, NULL),
(35, NULL, NULL, 4, NULL),
(36, NULL, NULL, 4, NULL),
(37, NULL, NULL, 4, NULL),
(38, NULL, NULL, 4, NULL),
(39, NULL, NULL, 4, NULL),
(40, NULL, NULL, 4, NULL),
(41, NULL, NULL, 4, NULL),
(42, NULL, NULL, 4, NULL),
(43, NULL, NULL, 4, NULL),
(44, NULL, NULL, 4, NULL),
(45, NULL, NULL, 4, NULL),
(46, NULL, NULL, 4, NULL),
(47, NULL, NULL, 4, NULL),
(48, NULL, NULL, 4, NULL),
(49, '2019-09-27 19:35:00', '2019-09-28 14:59:00', 4, NULL),
(50, NULL, NULL, 4, NULL),
(51, NULL, NULL, 4, NULL),
(52, NULL, NULL, 4, NULL),
(53, NULL, NULL, 4, NULL),
(54, NULL, NULL, 4, NULL),
(55, NULL, NULL, 4, NULL),
(56, NULL, NULL, 4, NULL),
(57, NULL, NULL, 4, NULL),
(58, NULL, NULL, 4, NULL),
(59, NULL, NULL, 4, NULL),
(60, NULL, NULL, 4, NULL),
(61, NULL, NULL, 4, NULL),
(62, NULL, NULL, 4, NULL),
(63, NULL, NULL, 4, NULL),
(64, NULL, NULL, 5, NULL),
(65, NULL, NULL, 5, NULL),
(66, NULL, NULL, 5, NULL),
(67, NULL, NULL, 5, NULL),
(68, NULL, NULL, 5, NULL),
(69, NULL, NULL, 5, NULL),
(70, NULL, NULL, 5, NULL),
(71, NULL, NULL, 5, NULL),
(72, NULL, NULL, 5, NULL),
(73, NULL, NULL, 5, NULL),
(74, NULL, NULL, 5, NULL),
(75, NULL, NULL, 5, NULL),
(76, NULL, NULL, 9, NULL),
(77, NULL, NULL, 6, NULL),
(78, NULL, NULL, 6, NULL),
(80, NULL, NULL, 7, NULL),
(81, NULL, NULL, 7, NULL),
(82, NULL, NULL, 8, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `gironi`
--

CREATE TABLE `gironi` (
  `id_girone` int(11) NOT NULL,
  `nome` text DEFAULT NULL,
  `add_casa` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `gironi`
--

INSERT INTO `gironi` (`id_girone`, `nome`, `add_casa`) VALUES
(1, 'Apertura', 1),
(2, 'Chiusura', 0),
(3, 'popo', 0),
(4, 'coppa italia', 0),
(5, 'tabellone coppa italia', 0),
(6, 'coppa delle coppe', 0),
(7, 'finale campionato', 0),
(8, 'supercoppa', 0),
(9, 'finale coppa italia', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `gironi_ci`
--

CREATE TABLE `gironi_ci` (
  `id` int(11) NOT NULL,
  `descrizione` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `gironi_ci`
--

INSERT INTO `gironi_ci` (`id`, `descrizione`) VALUES
(1, 'Girone A'),
(2, 'Girone B');

-- --------------------------------------------------------

--
-- Struttura della tabella `gironi_ci_squadre`
--

CREATE TABLE `gironi_ci_squadre` (
  `id_girone` int(11) NOT NULL,
  `id_squadra` int(11) NOT NULL,
  `squadra_materasso` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `gironi_ci_squadre`
--

INSERT INTO `gironi_ci_squadre` (`id_girone`, `id_squadra`, `squadra_materasso`) VALUES
(1, 3, b'0'),
(1, 7, b'0'),
(1, 12, b'0'),
(1, 1, b'0'),
(1, 11, b'0'),
(1, 6, b'0'),
(2, 10, b'0'),
(2, 9, b'0'),
(2, 5, b'0'),
(2, 8, b'0'),
(2, 2, b'0'),
(2, 4, b'0');

-- --------------------------------------------------------

--
-- Struttura della tabella `gironi_tc_squadre`
--

CREATE TABLE `gironi_tc_squadre` (
  `id_girone` int(11) NOT NULL,
  `id_squadra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `mercato`
--

CREATE TABLE `mercato` (
  `id_annuncio` int(11) NOT NULL,
  `id_squadra` int(11) NOT NULL,
  `testo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `data_annuncio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `presidente_annunci`
--

CREATE TABLE `presidente_annunci` (
  `id` int(11) NOT NULL,
  `titolo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `testo` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `valido_da` datetime NOT NULL,
  `valido_a` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `rose`
--

CREATE TABLE `rose` (
  `id_sq_fc` int(2) NOT NULL,
  `costo` float DEFAULT NULL,
  `id_giocatore` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `rose`
--

INSERT INTO `rose` (`id_sq_fc`, `costo`, `id_giocatore`) VALUES
(4, 12, 1917),
(4, 1, 2815),
(1, 41, 250),
(1, 1, 543),
(1, 1, 248),
(3, 22, 610),
(3, 1, 4),
(5, 39, 350),
(5, 1, 387),
(10, 36, 2179),
(10, 1, 2790),
(10, 1, 220),
(2, 51, 572),
(8, 42, 1934),
(8, 1, 317),
(8, 1, 2770),
(2, 1, 2468),
(2, 1, 570),
(6, 33, 4419),
(6, 1, 41),
(7, 31, 133),
(7, 1, 40),
(7, 1, 42),
(3, 10, 509),
(9, 6, 1843),
(12, 42, 453),
(12, 1, 282),
(12, 1, 1930),
(11, 7, 2792),
(11, 1, 2271),
(11, 1, 673),
(9, 10, 159),
(6, 1, 385),
(6, 5, 761),
(4, 1, 4425),
(5, 1, 2836),
(9, 1, 412),
(8, 3, 2335),
(1, 19, 226),
(4, 11, 4237),
(10, 10, 295),
(6, 24, 392),
(8, 41, 2214),
(6, 14, 2288),
(8, 17, 2164),
(5, 22, 4428),
(10, 26, 286),
(12, 16, 2309),
(3, 4, 4332),
(8, 28, 798),
(10, 24, 322),
(3, 21, 2572),
(12, 12, 4307),
(4, 19, 513),
(8, 21, 459),
(4, 3, 142),
(1, 24, 464),
(12, 7, 2728),
(5, 6, 357),
(7, 25, 2130),
(3, 8, 2197),
(6, 21, 2759),
(4, 25, 460),
(5, 20, 662),
(10, 12, 787),
(11, 5, 365),
(11, 3, 2318),
(1, 17, 2816),
(1, 10, 4292),
(12, 8, 2296),
(11, 8, 2006),
(5, 1, 2241),
(9, 7, 1852),
(3, 6, 2525),
(11, 3, 1896),
(7, 8, 487),
(4, 1, 2788),
(9, 8, 2016),
(10, 3, 287),
(7, 6, 73),
(1, 8, 554),
(10, 4, 640),
(12, 5, 15),
(5, 1, 780),
(3, 2, 2141),
(9, 7, 4422),
(2, 1, 329),
(9, 8, 1895),
(3, 11, 390),
(1, 4, 4412),
(9, 9, 253),
(6, 12, 1864),
(1, 3, 2633),
(3, 1, 1866),
(12, 1, 358),
(5, 1, 47),
(8, 1, 4526),
(9, 4, 2181),
(7, 11, 2160),
(11, 4, 2355),
(11, 8, 2289),
(10, 1, 581),
(7, 1, 288),
(6, 3, 99),
(7, 9, 244),
(4, 4, 4397),
(2, 2, 2865),
(8, 1, 4414),
(7, 2, 4429),
(12, 4, 1868),
(2, 3, 578),
(4, 6, 4245),
(12, 10, 2192),
(10, 3, 2871),
(11, 3, 2801),
(1, 6, 2169),
(9, 4, 259),
(4, 4, 2104),
(11, 2, 2062),
(11, 2, 2758),
(4, 1, 106),
(2, 3, 2315),
(10, 1, 261),
(3, 5, 695),
(1, 1, 4426),
(3, 3, 4407),
(2, 2, 2746),
(2, 2, 252),
(1, 2, 423),
(2, 3, 1979),
(6, 3, 2870),
(5, 1, 2285),
(9, 1, 2171),
(6, 1, 550),
(5, 1, 2280),
(6, 1, 2261),
(7, 1, 4409),
(8, 1, 790),
(9, 1, 2769),
(2, 1, 2168),
(2, 1, 4454),
(5, 1, 11),
(7, 1, 4442),
(6, 1, 2784),
(8, 1, 708),
(12, 1, 1869),
(4, 28, 2472),
(9, 50, 26),
(11, 39, 2409),
(5, 10, 2209),
(11, 36, 2085),
(11, 50, 1996),
(4, 56, 2002),
(2, 37, 2766),
(9, 61, 645),
(3, 37, 2200),
(8, 18, 2194),
(11, 16, 65),
(10, 28, 4449),
(1, 36, 2529),
(10, 31, 1870),
(2, 38, 375),
(8, 46, 376),
(12, 26, 467),
(8, 56, 2201),
(5, 19, 397),
(10, 40, 406),
(2, 20, 367),
(12, 18, 2205),
(3, 8, 788),
(6, 6, 22),
(1, 12, 4427),
(6, 33, 1978),
(12, 32, 530),
(12, 14, 779),
(5, 20, 4322),
(4, 15, 2379),
(2, 40, 2775),
(3, 14, 2215),
(6, 27, 469),
(10, 16, 332),
(4, 13, 150),
(5, 4, 2077),
(7, 13, 4512),
(5, 10, 299),
(10, 1, 331),
(12, 2, 2391),
(11, 12, 2625),
(4, 1, 2287),
(10, 18, 265),
(7, 17, 556),
(9, 15, 1850),
(3, 1, 21),
(3, 6, 1986),
(4, 2, 2771),
(5, 7, 112),
(10, 2, 2172),
(9, 19, 152),
(10, 4, 713),
(10, 3, 2504),
(12, 20, 184),
(9, 18, 644),
(6, 21, 2263),
(2, 3, 338),
(7, 10, 706),
(1, 9, 4423),
(3, 3, 827),
(7, 16, 2857),
(11, 5, 4514),
(3, 8, 2779),
(5, 2, 2306),
(8, 11, 1857),
(8, 16, 4377),
(5, 6, 2818),
(7, 4, 526),
(4, 2, 4445),
(6, 2, 697),
(1, 6, 237),
(9, 3, 374),
(11, 3, 2692),
(3, 5, 2776),
(6, 4, 2802),
(10, 5, 434),
(4, 2, 181),
(9, 2, 4522),
(2, 2, 1933),
(1, 5, 2076),
(7, 6, 632),
(8, 3, 2833),
(3, 3, 4479),
(2, 3, 621),
(9, 1, 118),
(11, 1, 4424),
(1, 1, 4513),
(6, 3, 234),
(2, 6, 342),
(9, 1, 4501),
(8, 1, 4524),
(11, 1, 4385),
(7, 3, 2011),
(4, 3, 557),
(8, 1, 1987),
(6, 8, 28),
(1, 1, 4400),
(5, 3, 2008),
(8, 1, 148),
(7, 2, 4330),
(7, 1, 2789),
(6, 1, 170),
(1, 3, 238),
(12, 1, 2378),
(1, 1, 2003),
(2, 1, 430),
(12, 1, 20),
(12, 1, 272),
(6, 117, 2531),
(12, 115, 408),
(11, 129, 785),
(3, 108, 2756),
(4, 105, 647),
(4, 28, 771),
(5, 150, 2610),
(10, 40, 2061),
(3, 57, 2764),
(1, 54, 409),
(9, 70, 410),
(2, 56, 2012),
(5, 44, 309),
(7, 54, 568),
(7, 114, 608),
(10, 55, 2038),
(1, 27, 186),
(4, 31, 531),
(7, 49, 2762),
(2, 42, 495),
(10, 18, 1939),
(1, 90, 441),
(3, 29, 2475),
(12, 8, 472),
(10, 1, 4463),
(12, 31, 2167),
(8, 32, 123),
(8, 24, 4517),
(3, 14, 311),
(11, 39, 2819),
(2, 23, 696),
(9, 18, 4452),
(6, 20, 474),
(8, 3, 4453),
(12, 5, 2841),
(2, 35, 177),
(4, 15, 315),
(9, 18, 507),
(6, 27, 383),
(5, 14, 4324),
(8, 15, 90),
(2, 9, 4527),
(9, 6, 475),
(9, 15, 1874),
(11, 11, 1943),
(10, 7, 2327),
(4, 3, 536),
(12, 4, 280),
(1, 3, 2719),
(9, 7, 183),
(4, 2, 479),
(5, 6, 2832),
(2, 6, 643),
(12, 8, 2284),
(3, 6, 407),
(2, 5, 2868),
(8, 11, 537),
(10, 8, 4510),
(5, 1, 658),
(1, 7, 1958),
(9, 8, 2826),
(5, 1, 4507),
(10, 1, 4346),
(11, 6, 1879),
(6, 6, 2743),
(3, 1, 4500),
(3, 3, 4415),
(3, 3, 2163),
(4, 1, 2873),
(12, 5, 533),
(9, 1, 247),
(5, 1, 312),
(1, 3, 652),
(6, 1, 819),
(7, 2, 2839),
(4, 1, 2166),
(6, 1, 126),
(8, 2, 2325),
(7, 1, 306),
(5, 1, 245),
(6, 1, 2773),
(11, 1, 1839),
(7, 1, 4477),
(1, 1, 636),
(7, 1, 4413),
(8, 1, 2304),
(11, 1, 637),
(12, 1, 2860),
(7, 1, 4498),
(11, 1, 380),
(11, 1, 627),
(2, 1, 490),
(8, 1, 236);

-- --------------------------------------------------------

--
-- Struttura della tabella `scambi`
--

CREATE TABLE `scambi` (
  `id` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `note` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `scambi_dettagli`
--

CREATE TABLE `scambi_dettagli` (
  `id` int(11) NOT NULL,
  `scambio_id` int(11) NOT NULL,
  `giocatore_id` int(11) DEFAULT NULL,
  `squadra_or_id` int(11) DEFAULT NULL,
  `squadra_dest_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `sondaggi`
--

CREATE TABLE `sondaggi` (
  `id` int(11) NOT NULL,
  `testo` varchar(120) NOT NULL,
  `scadenza` datetime DEFAULT NULL,
  `risposta_multipla` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `sondaggi_opzioni`
--

CREATE TABLE `sondaggi_opzioni` (
  `id` int(11) NOT NULL,
  `id_sondaggio` int(11) NOT NULL,
  `opzione` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `sondaggi_risposte`
--

CREATE TABLE `sondaggi_risposte` (
  `id_squadra` int(2) NOT NULL,
  `id_sondaggio` int(11) NOT NULL,
  `id_opzione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `squadre_serie_a`
--

CREATE TABLE `squadre_serie_a` (
  `squadra` varchar(10) DEFAULT NULL,
  `squadra_breve` varchar(3) DEFAULT NULL,
  `id` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `squadre_serie_a`
--

INSERT INTO `squadre_serie_a` (`squadra`, `squadra_breve`, `id`) VALUES
('SQUADRA', 'SQU', 1),
('JUVENTUS', 'JUV', 2),
('ATALANTA', 'ATA', 3),
('MILAN', 'MIL', 4),
('INTER', 'INT', 5),
('LAZIO', 'LAZ', 6),
('SAMPDORIA', 'SAM', 7),
('ROMA', 'ROM', 8),
('TORINO', 'TOR', 9),
('NAPOLI', 'NAP', 10),
('SASSUOLO', 'SAS', 11),
('FIORENTINA', 'FIO', 12),
('SPAL', 'SPA', 13),
('CAGLIARI', 'CAG', 14),
('PARMA', 'PAR', 15),
('UDINESE', 'UDI', 16),
('GENOA', 'GEN', 17),
('BRESCIA', 'BRE', 18),
('BOLOGNA', 'BOL', 19),
('LECCE', 'LEC', 20),
('VERONA', 'VER', 21),
('ZVINCOLATI', 'SVI', 22);

-- --------------------------------------------------------

--
-- Struttura della tabella `sq_fantacalcio`
--

CREATE TABLE `sq_fantacalcio` (
  `id` int(11) NOT NULL,
  `squadra` varchar(50) DEFAULT NULL,
  `allenatore` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `ammcontrollata` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sq_fantacalcio`
--

INSERT INTO `sq_fantacalcio` (`id`, `squadra`, `allenatore`, `telefono`, `email`, `password`, `ammcontrollata`) VALUES
(1, 'I NANI', 'Peppino', '3475258776', 'giuseppeaurilio@gmail.com', 'peppino1', 0),
(2, 'Atletico ero na volta', 'Antonio', '3296585405', 'michela.valentini65@gmail.com', 'ziapeppina', 0),
(3, 'Salsino è bello', 'Filippo', '3666652788', 'mdhsurp@tin.it', 'pagliafili74', 0),
(4, 'Bar Fabio dal 1936', 'Salsino', '3205687266', 'danielerotondo@virgilio.it', 'erpolemica', 0),
(5, 'Bono Coppi', 'Giorgio', '3421291939', 'giorgiogasbarrini@gmail.com', 'giorgio1', 0),
(6, 'Nuova Romanina', 'Arcangelo', '3208181537', 'percibol@hotmail.it', 'arcangelo83', 1),
(7, 'Crossa Pù', 'Gianluca', '3470424164', 'gianlucapupparo@libero.it', 'glcppp79', 0),
(8, 'Panchester United', 'Narpini', '3389784253', '', 'doraemon', 0),
(9, 'SC Valle SantAndrea', 'Rotondo', '3284814155', 'rotondo-andrea@libero.it', 'elsanto', 0),
(10, 'Ronie Merda', 'Carlo', '93930259379', 'carlo.sciandrone@gmail.com', 'vecchioporcoficcatore', 1),
(11, 'Rodrigo Becao', 'Figurino', '3332865311', 'campolifigu@hotmail.it', 'claudia1986', 0),
(12, 'AS Venere', 'MDeP', '3488880712', 'dep.mario@gmail.com', 'vivalabevanda1', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `vincitori`
--

CREATE TABLE `vincitori` (
  `competizione` varchar(45) NOT NULL,
  `id_vincitore` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `annunci`
--
ALTER TABLE `annunci`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`id_giornata`,`id_partita`);

--
-- Indici per le tabelle `formazioni`
--
ALTER TABLE `formazioni`
  ADD PRIMARY KEY (`id_giornata`,`id_squadra`,`id_posizione`);

--
-- Indici per le tabelle `generale`
--
ALTER TABLE `generale`
  ADD PRIMARY KEY (`id_parametro`);

--
-- Indici per le tabelle `giocatori`
--
ALTER TABLE `giocatori`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `gironi`
--
ALTER TABLE `gironi`
  ADD PRIMARY KEY (`id_girone`);

--
-- Indici per le tabelle `mercato`
--
ALTER TABLE `mercato`
  ADD PRIMARY KEY (`id_annuncio`);

--
-- Indici per le tabelle `presidente_annunci`
--
ALTER TABLE `presidente_annunci`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `rose`
--
ALTER TABLE `rose`
  ADD PRIMARY KEY (`id_sq_fc`,`id_giocatore`),
  ADD UNIQUE KEY `id_giocatore_UNIQUE` (`id_giocatore`),
  ADD KEY `fk_Rose_sq_fantacalcio_idx` (`id_sq_fc`);

--
-- Indici per le tabelle `scambi`
--
ALTER TABLE `scambi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `scambi_dettagli`
--
ALTER TABLE `scambi_dettagli`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sondaggi`
--
ALTER TABLE `sondaggi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sondaggi_opzioni`
--
ALTER TABLE `sondaggi_opzioni`
  ADD PRIMARY KEY (`id`,`id_sondaggio`);

--
-- Indici per le tabelle `sondaggi_risposte`
--
ALTER TABLE `sondaggi_risposte`
  ADD PRIMARY KEY (`id_opzione`,`id_sondaggio`,`id_squadra`);

--
-- Indici per le tabelle `squadre_serie_a`
--
ALTER TABLE `squadre_serie_a`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `squadra` (`squadra`),
  ADD UNIQUE KEY `squadra_breve` (`squadra_breve`);

--
-- Indici per le tabelle `sq_fantacalcio`
--
ALTER TABLE `sq_fantacalcio`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `vincitori`
--
ALTER TABLE `vincitori`
  ADD UNIQUE KEY `competizione` (`competizione`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `annunci`
--
ALTER TABLE `annunci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `calendario`
--
ALTER TABLE `calendario`
  MODIFY `id_partita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `generale`
--
ALTER TABLE `generale`
  MODIFY `id_parametro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `giocatori`
--
ALTER TABLE `giocatori`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4531;

--
-- AUTO_INCREMENT per la tabella `mercato`
--
ALTER TABLE `mercato`
  MODIFY `id_annuncio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `presidente_annunci`
--
ALTER TABLE `presidente_annunci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `scambi`
--
ALTER TABLE `scambi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `scambi_dettagli`
--
ALTER TABLE `scambi_dettagli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `sondaggi`
--
ALTER TABLE `sondaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `squadre_serie_a`
--
ALTER TABLE `squadre_serie_a`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `sq_fantacalcio`
--
ALTER TABLE `sq_fantacalcio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
