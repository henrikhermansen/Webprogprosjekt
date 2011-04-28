SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Kunde`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Kunde` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Kunde` (
  `KNr` INT NOT NULL AUTO_INCREMENT ,
  `Fornavn` VARCHAR(45) NULL ,
  `Etternavn` VARCHAR(45) NULL ,
  `Adresse` VARCHAR(45) NULL ,
  `PostNr` CHAR(4) NULL ,
  `Telefonnr` INT(8) NULL ,
  `Email` VARCHAR(45) NULL ,
  PRIMARY KEY (`KNr`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ordre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Ordre` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Ordre` (
  `OrdreNr` INT NOT NULL AUTO_INCREMENT ,
  `KNr` INT NOT NULL ,
  `OrdreDato` DATE NULL ,
  PRIMARY KEY (`OrdreNr`, `KNr`) ,
  INDEX `fk_Ordre_Kunde1` (`KNr` ASC) ,
  CONSTRAINT `fk_Ordre_Kunde1`
    FOREIGN KEY (`KNr` )
    REFERENCES `mydb`.`Kunde` (`KNr` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Kategori`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Kategori` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Kategori` (
  `KatNr` SMALLINT NOT NULL AUTO_INCREMENT ,
  `Navn` VARCHAR(30) NULL ,
  PRIMARY KEY (`KatNr`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Vare`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Vare` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Vare` (
  `VNr` INT NOT NULL AUTO_INCREMENT ,
  `Pris` DECIMAL(10,2) NULL ,
  `Antall` INT NULL ,
  `KatNr` SMALLINT NOT NULL ,
  PRIMARY KEY (`VNr`, `KatNr`) ,
  INDEX `fk_Vare_Kategori1` (`KatNr` ASC) ,
  CONSTRAINT `fk_Vare_Kategori1`
    FOREIGN KEY (`KatNr` )
    REFERENCES `mydb`.`Kategori` (`KatNr` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ordrelinje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Ordrelinje` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Ordrelinje` (
  `OrdreNr` INT NOT NULL ,
  `VNr` INT NOT NULL ,
  `Antall` INT NULL ,
  PRIMARY KEY (`OrdreNr`, `VNr`) ,
  INDEX `fk_VNr` (`VNr` ASC) ,
  INDEX `fk_OrdreNr` (`OrdreNr` ASC) ,
  CONSTRAINT `fk_OrdreNr`
    FOREIGN KEY (`OrdreNr` )
    REFERENCES `mydb`.`Ordre` (`OrdreNr` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_VNr`
    FOREIGN KEY (`VNr` )
    REFERENCES `mydb`.`Vare` (`VNr` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Admin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Admin` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Admin` (
  `Brukernavn` VARCHAR(45) NOT NULL ,
  `Passord` VARCHAR(45) NULL ,
  PRIMARY KEY (`Brukernavn`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
