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



CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pseudo` VARCHAR(30) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;



CREATE TABLE `image` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `file` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;



CREATE TABLE `category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;



CREATE TABLE `meme` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `user_id` INT NOT NULL,
  `image_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`id`, `image_id`, `category_id`),
  INDEX `fk_meme_user_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_meme_image_idx` (`image_id` ASC) VISIBLE,
  INDEX `fk_meme_category_idx` (`category_id` ASC) VISIBLE,
  CONSTRAINT `fk_meme_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`),
   CONSTRAINT `fk_meme_image`
    FOREIGN KEY (`image_id`)
    REFERENCES `image` (`id`),
   CONSTRAINT `fk_meme_category`
    FOREIGN KEY (`category_id`)
    REFERENCES `category` (`id`))
ENGINE = InnoDB;



CREATE TABLE `legend` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `legend` VARCHAR(255) NOT NULL,
  `meme_id` INT NOT NULL,
  PRIMARY KEY (`id`, `meme_id`),
  INDEX `fk_legend_meme_idx` (`meme_id` ASC) VISIBLE,
  CONSTRAINT `fk_legend_meme`
    FOREIGN KEY (`meme_id`)
    REFERENCES `meme` (`id`))
ENGINE = InnoDB;



CREATE TABLE `vote` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `legend_id` INT NOT NULL,
  `legend_meme_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vote_user_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_vote_legend_idx` (`legend_id` ASC, `legend_meme_id` ASC) VISIBLE,
  CONSTRAINT `fk_vote_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`),
  CONSTRAINT `fk_vote_legend1`
    FOREIGN KEY (`legend_id` , `legend_meme_id`)
    REFERENCES `legend` (`id` , `meme_id`))
ENGINE = InnoDB;
