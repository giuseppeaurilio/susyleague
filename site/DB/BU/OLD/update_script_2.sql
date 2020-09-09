/*SCAMBI */
DROP TABLE IF EXISTS scambi;
CREATE TABLE scambi ( id INT NOT NULL AUTO_INCREMENT, data DATETIME NOT NULL ,note  VARCHAR(500) NULL DEFAULT NULL , PRIMARY KEY (id)) ;


DROP TABLE IF EXISTS scambi_dettagli;
CREATE TABLE scambi_dettagli ( id INT NOT NULL AUTO_INCREMENT, scambio_id INT NOT NULL , giocatore_id INT NULL , squadra_or_id INT NULL , squadra_dest_id INT NULL ,  PRIMARY KEY (id)) ;

/*annunci*/
DROP TABLE IF EXISTS presidente_annunci;
CREATE TABLE presidente_annunci ( id INT NOT NULL AUTO_INCREMENT, titolo VARCHAR(100) NOT NULL , testo VARCHAR(1000) NOT NULL , valido_da DATETIME NOT NULL , valido_a DATETIME NOT NULL , PRIMARY KEY (id));