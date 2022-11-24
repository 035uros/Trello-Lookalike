-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 25, 2022 at 08:34 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upravljanje`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivnosti`
--

DROP TABLE IF EXISTS `aktivnosti`;
CREATE TABLE IF NOT EXISTS `aktivnosti` (
  `idAktivnosti` varchar(225) COLLATE utf8mb4_bin NOT NULL,
  `idProjekta` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `nazivAktivnosti` text COLLATE utf8mb4_bin NOT NULL,
  `opisAktivnosti` text COLLATE utf8mb4_bin NOT NULL,
  `statusAktivnosti` text COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`idAktivnosti`),
  KEY `idProjekta` (`idProjekta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `aktivnosti`
--

INSERT INTO `aktivnosti` (`idAktivnosti`, `idProjekta`, `nazivAktivnosti`, `opisAktivnosti`, `statusAktivnosti`) VALUES
('95da630d-7e06-11ec-ad7a-a45d36ce26f1', '8b9dc5b4-7ab5-11ec-a94a-a45d36ce26f1', 'Finisiranje', 'kraj projekta', 'U toku'),
('aebfe9c4-7ab5-11ec-a94a-a45d36ce26f1', '8b9dc5b4-7ab5-11ec-a94a-a45d36ce26f1', 'GPIO', 'nmp', 'Izrada'),
('d271022c-7e14-11ec-ad7a-a45d36ce26f1', 'c72c3f69-7e14-11ec-ad7a-a45d36ce26f1', 'Front end', 'napraviti izgled sajta', 'Završeno'),
('dbb230fc-7e14-11ec-ad7a-a45d36ce26f1', 'c72c3f69-7e14-11ec-ad7a-a45d36ce26f1', 'Back end', 'napraviti sajt funkcionalnim', 'U toku');

-- --------------------------------------------------------

--
-- Table structure for table `dodeljeniprojekti`
--

DROP TABLE IF EXISTS `dodeljeniprojekti`;
CREATE TABLE IF NOT EXISTS `dodeljeniprojekti` (
  `idOsobe` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `idAktivnosti` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  KEY `idOsobe` (`idOsobe`,`idAktivnosti`),
  KEY `idAktivnosti` (`idAktivnosti`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `dodeljeniprojekti`
--

INSERT INTO `dodeljeniprojekti` (`idOsobe`, `idAktivnosti`) VALUES
('2c8bb494-7961-11ec-a802-a45d36ce26f1', '95da630d-7e06-11ec-ad7a-a45d36ce26f1'),
('2c8bb494-7961-11ec-a802-a45d36ce26f1', 'aebfe9c4-7ab5-11ec-a94a-a45d36ce26f1'),
('2c8bb494-7961-11ec-a802-a45d36ce26f1', 'd271022c-7e14-11ec-ad7a-a45d36ce26f1');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

DROP TABLE IF EXISTS `komentar`;
CREATE TABLE IF NOT EXISTS `komentar` (
  `idKomentara` varchar(225) COLLATE utf8mb4_bin NOT NULL,
  `idAktivnosti` varchar(225) COLLATE utf8mb4_bin NOT NULL,
  `tekstKomentara` text COLLATE utf8mb4_bin,
  PRIMARY KEY (`idKomentara`),
  KEY `idAktivnosti` (`idAktivnosti`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`idKomentara`, `idAktivnosti`, `tekstKomentara`) VALUES
('3b8b532d-7e17-11ec-ad7a-a45d36ce26f1', 'd271022c-7e14-11ec-ad7a-a45d36ce26f1', 'Projekat je pri kraju.'),
('f55b163a-7e17-11ec-ad7a-a45d36ce26f1', 'd271022c-7e14-11ec-ad7a-a45d36ce26f1', 'Projekat je završen.');

-- --------------------------------------------------------

--
-- Table structure for table `odgovorkomentara`
--

DROP TABLE IF EXISTS `odgovorkomentara`;
CREATE TABLE IF NOT EXISTS `odgovorkomentara` (
  `idKomentara` varchar(225) COLLATE utf8mb4_bin NOT NULL,
  `tekstOdgovora` text COLLATE utf8mb4_bin,
  KEY `idKomentara` (`idKomentara`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `odgovorkomentara`
--

INSERT INTO `odgovorkomentara` (`idKomentara`, `tekstOdgovora`) VALUES
('3b8b532d-7e17-11ec-ad7a-a45d36ce26f1', 'Samo tako nastavi Miki.'),
('f55b163a-7e17-11ec-ad7a-a45d36ce26f1', 'Bravo Miki.');

-- --------------------------------------------------------

--
-- Table structure for table `osoba`
--

DROP TABLE IF EXISTS `osoba`;
CREATE TABLE IF NOT EXISTS `osoba` (
  `idOsobe` varchar(256) COLLATE utf8mb4_bin NOT NULL,
  `ime` text COLLATE utf8mb4_bin NOT NULL,
  `prezime` text COLLATE utf8mb4_bin NOT NULL,
  `rola` text COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(225) COLLATE utf8mb4_bin NOT NULL,
  `sifra` text COLLATE utf8mb4_bin,
  `verifikovan` int(11) NOT NULL,
  PRIMARY KEY (`idOsobe`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `osoba`
--

INSERT INTO `osoba` (`idOsobe`, `ime`, `prezime`, `rola`, `username`, `sifra`, `verifikovan`) VALUES
('0842ce59-7ab5-11ec-a94a-a45d36ce26f1', 'Djordje', 'Molnar', 'Administrator', 'admin', '1234', 1),
('19827cac-7961-11ec-a802-a45d36ce26f1', 'Uroš', 'Milošević', 'Menadžer', 'menadzer', '1234', 1),
('2b08608d-7e19-11ec-ad7a-a45d36ce26f1', 'Goran', 'Petrović', 'Menadžer', 'arsavitez', '1234', 1),
('2c8bb494-7961-11ec-a802-a45d36ce26f1', 'Milan', 'Zokic', 'Zaposleni', 'radnik', '1234', 1),
('5c55e212-7e19-11ec-ad7a-a45d36ce26f1', 'Milan', 'Milanović', 'Menadžer', 'mikiboj', '1234', 0);

-- --------------------------------------------------------

--
-- Table structure for table `projekat`
--

DROP TABLE IF EXISTS `projekat`;
CREATE TABLE IF NOT EXISTS `projekat` (
  `idProjekta` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `nazivProjekta` text COLLATE utf8mb4_bin NOT NULL,
  `lokacija` text COLLATE utf8mb4_bin NOT NULL,
  `skolskaSprema` text COLLATE utf8mb4_bin NOT NULL,
  `opisPosla` text COLLATE utf8mb4_bin NOT NULL,
  `benefiti` text COLLATE utf8mb4_bin NOT NULL,
  `rokKonkursa` text COLLATE utf8mb4_bin NOT NULL,
  `statusProjekta` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`idProjekta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `projekat`
--

INSERT INTO `projekat` (`idProjekta`, `nazivProjekta`, `lokacija`, `skolskaSprema`, `opisPosla`, `benefiti`, `rokKonkursa`, `statusProjekta`) VALUES
('8b9dc5b4-7ab5-11ec-a94a-a45d36ce26f1', 'MIPS', 'Kg', 'Visoka', 'radi', 'nema', '23.', 'Zavrseno'),
('c72c3f69-7e14-11ec-ad7a-a45d36ce26f1', 'PIA', 'Kragujevac', 'Visoka', 'Napraviti veb sajt', 'puno, mnogo, dosta', '26, 10h', 'U toku');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivnosti`
--
ALTER TABLE `aktivnosti`
  ADD CONSTRAINT `aktivnosti_ibfk_1` FOREIGN KEY (`idProjekta`) REFERENCES `projekat` (`idProjekta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `dodeljeniprojekti`
--
ALTER TABLE `dodeljeniprojekti`
  ADD CONSTRAINT `dodeljeniprojekti_ibfk_1` FOREIGN KEY (`idOsobe`) REFERENCES `osoba` (`idOsobe`),
  ADD CONSTRAINT `dodeljeniprojekti_ibfk_2` FOREIGN KEY (`idAktivnosti`) REFERENCES `aktivnosti` (`idAktivnosti`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`idAktivnosti`) REFERENCES `aktivnosti` (`idAktivnosti`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `odgovorkomentara`
--
ALTER TABLE `odgovorkomentara`
  ADD CONSTRAINT `odgovorkomentara_ibfk_1` FOREIGN KEY (`idKomentara`) REFERENCES `komentar` (`idKomentara`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
