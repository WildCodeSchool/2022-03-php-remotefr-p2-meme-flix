-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 26 Octobre 2017 à 13:53
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `simple-mvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `item`
--

INSERT INTO `item` (`id`, `title`) VALUES
(1, 'Stuff'),
(2, 'Doodads');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- MySQL Script generated by MySQL Workbench
-- Fri Apr 22 16:54:39 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema memeflix
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema memeflix
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `memeflix` DEFAULT CHARACTER SET utf8 ;
USE `memeflix` ;

-- -----------------------------------------------------
-- Table `memeflix`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `memeflix`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pseudo` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `memeflix`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Top 10'),(2,'Nouveautés'),(3,'Sport'),(4,'Véhicule'),(5,'People'),(6,'Divers');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;
-- -----------------------------------------------------
-- Table `memeflix`.`meme`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `memeflix`.`meme` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `user_id` INT DEFAULT NULL,
  `image` VARCHAR(255) NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`id`, `category_id`),
  INDEX `fk_meme_user1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_meme_category1_idx` (`category_id` ASC) VISIBLE,
  CONSTRAINT `fk_meme_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `memeflix`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_meme_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `memeflix`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `memeflix`.`legend`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `memeflix`.`legend` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `legend` VARCHAR(255) NOT NULL,
  `meme_id` INT NOT NULL,
  PRIMARY KEY (`id`, `meme_id`),
  INDEX `fk_legend_meme_idx` (`meme_id` ASC) VISIBLE,
  CONSTRAINT `fk_legend_meme`
    FOREIGN KEY (`meme_id`)
    REFERENCES `memeflix`.`meme` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `memeflix`.`vote`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `memeflix`.`vote` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `legend_id` INT NOT NULL,
  `legend_meme_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vote_user1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_vote_legend1_idx` (`legend_id` ASC, `legend_meme_id` ASC) VISIBLE,
  CONSTRAINT `fk_vote_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `memeflix`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vote_legend1`
    FOREIGN KEY (`legend_id` , `legend_meme_id`)
    REFERENCES `memeflix`.`legend` (`id` , `meme_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


