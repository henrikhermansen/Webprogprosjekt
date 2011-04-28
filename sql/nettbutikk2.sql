-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2011 at 03:05 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `web_prosjekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `webprosjekt_admin`
--

CREATE TABLE IF NOT EXISTS `webprosjekt_admin` (
  `Brukernavn` varchar(45) NOT NULL,
  `Passord` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Brukernavn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `webprosjekt_kategori`
--

CREATE TABLE IF NOT EXISTS `webprosjekt_kategori` (
  `KatNr` smallint(6) NOT NULL AUTO_INCREMENT,
  `Navn` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`KatNr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `webprosjekt_kunde`
--

CREATE TABLE IF NOT EXISTS `webprosjekt_kunde` (
  `KNr` int(11) NOT NULL AUTO_INCREMENT,
  `Fornavn` varchar(45) DEFAULT NULL,
  `Etternavn` varchar(45) DEFAULT NULL,
  `Adresse` varchar(45) DEFAULT NULL,
  `PostNr` char(4) DEFAULT NULL,
  `Telefonnr` int(8) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`KNr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `webprosjekt_ordre`
--

CREATE TABLE IF NOT EXISTS `webprosjekt_ordre` (
  `OrdreNr` int(11) NOT NULL AUTO_INCREMENT,
  `KNr` int(11) NOT NULL,
  `OrdreDato` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`OrdreNr`,`KNr`),
  KEY `fk_Ordre_Kunde1` (`KNr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `webprosjekt_ordrelinje`
--

CREATE TABLE IF NOT EXISTS `webprosjekt_ordrelinje` (
  `OrdreNr` int(11) NOT NULL,
  `VNr` int(11) NOT NULL,
  `Antall` int(11) DEFAULT NULL,
  PRIMARY KEY (`OrdreNr`,`VNr`),
  KEY `fk_VNr` (`VNr`),
  KEY `fk_OrdreNr` (`OrdreNr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `webprosjekt_vare`
--

CREATE TABLE IF NOT EXISTS `webprosjekt_vare` (
  `VNr` int(11) NOT NULL AUTO_INCREMENT,
  `Pris` decimal(10,2) DEFAULT NULL,
  `Antall` int(11) DEFAULT NULL,
  `KatNr` smallint(6) NOT NULL,
  PRIMARY KEY (`VNr`,`KatNr`),
  KEY `fk_Vare_Kategori1` (`KatNr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `webprosjekt_ordre`
--
ALTER TABLE `webprosjekt_ordre`
  ADD CONSTRAINT `fk_Ordre_Kunde1` FOREIGN KEY (`KNr`) REFERENCES `webprosjekt_kunde` (`KNr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `webprosjekt_ordrelinje`
--
ALTER TABLE `webprosjekt_ordrelinje`
  ADD CONSTRAINT `fk_OrdreNr` FOREIGN KEY (`OrdreNr`) REFERENCES `webprosjekt_ordre` (`OrdreNr`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_VNr` FOREIGN KEY (`VNr`) REFERENCES `webprosjekt_vare` (`VNr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `webprosjekt_vare`
--
ALTER TABLE `webprosjekt_vare`
  ADD CONSTRAINT `fk_Vare_Kategori1` FOREIGN KEY (`KatNr`) REFERENCES `webprosjekt_kategori` (`KatNr`) ON DELETE NO ACTION ON UPDATE NO ACTION;
