-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`T_Compte`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`T_Compte` (
  `pk_compte` INT GENERATED ALWAYS AS () VIRTUAL,
  `nom_utilisateur` VARCHAR(40) NOT NULL,
  `mot_de_passe` VARCHAR(40) NOT NULL,
  `est_admin` BIT(0) NOT NULL,
  PRIMARY KEY (`pk_compte`),
  UNIQUE INDEX `nom_utilisateur_UNIQUE` (`nom_utilisateur` ASC),
  UNIQUE INDEX `pk_compte_UNIQUE` (`pk_compte` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`T_Panier`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`T_Panier` (
  `pk_panier` INT NOT NULL AUTO_INCREMENT,
  `est_valide` BIT(0) NOT NULL,
  `fk_panier` INT NOT NULL,
  PRIMARY KEY (`pk_panier`),
  UNIQUE INDEX `pk_panier_UNIQUE` (`pk_panier` ASC),
  INDEX `fk_panier_idx` (`fk_panier` ASC),
  CONSTRAINT `fk_panier`
    FOREIGN KEY (`fk_panier`)
    REFERENCES `mydb`.`T_Compte` (`pk_compte`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`T_Boisson`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`T_Boisson` (
  `pk_boisson` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(70) NOT NULL,
  `prix` DOUBLE NOT NULL,
  `quantite` INT NOT NULL DEFAULT 0,
  `informations` TEXT(10000) NOT NULL,
  `ingredients` TEXT(2000) NULL DEFAULT NULL,
  `producteur` VARCHAR(100) NULL DEFAULT NULL,
  `region` VARCHAR(40) NULL DEFAULT NULL,
  `estEnSolde` BIT(0) NOT NULL,
  `T_Boissoncol` VARCHAR(45) NULL,
  PRIMARY KEY (`pk_boisson`),
  UNIQUE INDEX `idT_Boisson_UNIQUE` (`pk_boisson` ASC),
  UNIQUE INDEX `nom_UNIQUE` (`nom` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`T_Assortiment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`T_Assortiment` (
  `pk_assortiment` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`pk_assortiment`),
  UNIQUE INDEX `pk_assortiment_UNIQUE` (`pk_assortiment` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`T_Code_reduction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`T_Code_reduction` (
  `pk_code_reduction` INT NOT NULL AUTO_INCREMENT,
  `valeur` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`pk_code_reduction`),
  UNIQUE INDEX `pk_code_reduction_UNIQUE` (`pk_code_reduction` ASC),
  UNIQUE INDEX `valeur_UNIQUE` (`valeur` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`TR_Boisson_Assortiment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`TR_Boisson_Assortiment` (
  `fk_boisson` INT NOT NULL,
  `fk_assortiment` INT NOT NULL,
  INDEX `fk_boisson_idx` (`fk_boisson` ASC),
  INDEX `fk_assortiment_idx` (`fk_assortiment` ASC),
  CONSTRAINT `fk_boisson`
    FOREIGN KEY (`fk_boisson`)
    REFERENCES `mydb`.`T_Boisson` (`pk_boisson`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_assortiment`
    FOREIGN KEY (`fk_assortiment`)
    REFERENCES `mydb`.`T_Assortiment` (`pk_assortiment`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`TR_Panier_Boisson`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`TR_Panier_Boisson` (
  `fk_panier` INT NOT NULL,
  `fk_boisson` INT NOT NULL,
  INDEX `fk_panier_idx` (`fk_panier` ASC),
  INDEX `fk_boisson_idx` (`fk_boisson` ASC),
  CONSTRAINT `fk_panier`
    FOREIGN KEY (`fk_panier`)
    REFERENCES `mydb`.`T_Panier` (`pk_panier`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_boisson`
    FOREIGN KEY (`fk_boisson`)
    REFERENCES `mydb`.`T_Boisson` (`pk_boisson`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
