--Somma Media difesa applicata agli avversari

select mdc.id_sq_casa, mdc.squadra , somma1, somma2, (somma1+somma2) as somma
from 
(
SELECT c.id_sq_casa, sqf.squadra squadra, sum(md_ospite) as somma1
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_casa

where g.id_girone = 1 
GROUP by c.id_sq_casa
order by somma1) as mdc
join 
(
SELECT c.id_sq_ospite, sqf.squadra, sum(md_casa) as somma2
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_ospite

where g.id_girone = 1 
GROUP by c.id_sq_ospite
order by somma2) mdo
on mdc.id_sq_casa = mdo.id_sq_ospite
order by somma

--Somma Media difesa applicata dagli avversari
select mdc.id_sq_casa, mdc.squadra , somma1, somma2, (somma1+somma2) as somma
from 
(
SELECT c.id_sq_casa, sqf.squadra squadra, sum(md_casa) as somma1
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_casa

where g.id_girone = 1 
GROUP by c.id_sq_casa
order by somma1) as mdc
join 
(
SELECT c.id_sq_ospite, sqf.squadra, sum(md_ospite) as somma2
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_ospite

where g.id_girone = 1 
GROUP by c.id_sq_ospite
order by somma2) mdo
on mdc.id_sq_casa = mdo.id_sq_ospite
order by somma


