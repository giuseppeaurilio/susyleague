CREATE TABLE `contafusti` (
  `Id` int(11) NOT NULL,
  `Presidente` varchar(50) NOT NULL,
  `Motivazione` varchar(100) DEFAULT NULL,
  `Stato` tinyint(4) NOT NULL,
  `DataUM` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contafusti`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `contafusti`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;