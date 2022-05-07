CREATE TABLE `item` (
	`id` int(11) UNSIGNED NOT NULL,
	`title` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO
	`item` (`id`, `title`)
VALUES
	(1, 'Stuff'),
	(2, 'Doodads');

ALTER TABLE `item` ADD PRIMARY KEY (`id`);

ALTER TABLE
	`item`
MODIFY
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 3;

CREATE TABLE `user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`pseudo` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `category` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO
	`category`
VALUES
	(1, 'Sport'),(2, 'Véhicule'),(3, 'Personnes'),(4, 'Animaux'),(5, 'Divers');

CREATE TABLE `meme` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`date` DATETIME NOT NULL,
	`user_id` INT DEFAULT NULL,
	`image` VARCHAR(255) NOT NULL,
	`category_id` INT NOT NULL,
	PRIMARY KEY (`id`, `category_id`),
	INDEX `fk_meme_user1_idx` (`user_id` ASC) VISIBLE,
	INDEX `fk_meme_category1_idx` (`category_id` ASC) VISIBLE,
	CONSTRAINT `fk_meme_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_meme_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE `legend` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`legend` VARCHAR(255) NOT NULL,
	`meme_id` INT NOT NULL,
	PRIMARY KEY (`id`, `meme_id`),
	INDEX `fk_legend_meme_idx` (`meme_id` ASC) VISIBLE,
	CONSTRAINT `fk_legend_meme` FOREIGN KEY (`meme_id`) REFERENCES `meme` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE `vote` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`legend_id` INT NOT NULL,
	`legend_meme_id` INT NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_vote_user1_idx` (`user_id` ASC) VISIBLE,
	INDEX `fk_vote_legend1_idx` (`legend_id` ASC, `legend_meme_id` ASC) VISIBLE,
	CONSTRAINT `fk_vote_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_vote_legend1` FOREIGN KEY (`legend_id`, `legend_meme_id`) REFERENCES `legend` (`id`, `meme_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;