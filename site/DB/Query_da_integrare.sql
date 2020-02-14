select mdfc.id_sq_casa, mdfc.squadra , 
md_f_c, md_f_t, (md_f_c+md_f_t) as md_f,
md_c_c, md_c_t, (md_c_c+md_c_t) as md_c,
((md_c_c+md_c_t) - (md_f_c+md_f_t)) as md
from 
(
SELECT c.id_sq_casa, sqf.squadra squadra, sum(md_ospite) as md_f_c
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_casa

where g.id_girone = 1 
GROUP by c.id_sq_casa
) as mdfc
join 
(
SELECT c.id_sq_ospite, sqf.squadra, sum(md_casa) as md_f_t
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_ospite

where g.id_girone = 1 
GROUP by c.id_sq_ospite
)as mdft
on mdfc.id_sq_casa = mdft.id_sq_ospite
join
(
SELECT c.id_sq_casa, sqf.squadra squadra, sum(md_casa) as md_c_c
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_casa

where g.id_girone = 1 
GROUP by c.id_sq_casa
) as mdcc
on mdfc.id_sq_casa = mdcc.id_sq_casa
join 
(
SELECT c.id_sq_ospite, sqf.squadra, sum(md_ospite) as md_c_t
FROM calendario c 
left join giornate gio on c.id_giornata = gio.id_giornata
left join gironi g on gio.id_girone = g.id_girone
left join sq_fantacalcio sqf on sqf.id = c.id_sq_ospite

where g.id_girone = 1 
GROUP by c.id_sq_ospite
) as  mdct
on mdfc.id_sq_casa = mdct.id_sq_ospite
order by md desc