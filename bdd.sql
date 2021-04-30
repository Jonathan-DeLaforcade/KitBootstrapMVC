DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) DEFAULT NULL,
  `Pseudo` varchar(50) DEFAULT NULL,
  `Mail` varchar(50) DEFAULT NULL,
  `Password` varchar(80) DEFAULT NULL,
  `Role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELETE FROM `users`;
INSERT INTO `users` (`ID`, `Pseudo`, `Mail`, `Password`, `Role`) VALUES
	(1, 'Admin', 'admin@webadmin.com', '$2y$10$Y/PWDSzYL6Cv4tIKh9s4O.EL57R9g6dhRCukz8h0r7.SrAhQuaMCi', 4);
