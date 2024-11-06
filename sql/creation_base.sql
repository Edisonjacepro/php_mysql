-- Création de la BDD
CREATE DATABASE IF NOT EXISTS `db_name`;
USE `db_name`;

-- Création de la table entitys
CREATE TABLE IF NOT EXISTS `entities` (
    `entity_id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(128) NOT NULL,
    `entity` TEXT NOT NULL,
    `author` varchar(255) NOT NULL,
    `is_enabled` BOOLEAN NOT NULL,
    PRIMARY KEY (`entity_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Création de la table users
CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `full_name` varchar(64) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `age` INT NOT NULL,
    PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

delete from `users`;
insert into `users` (`age`, `email`, `full_name`, `password`, `user_id`) values (32, 'edison@exemple.com', 'Edison Jaçe', 'devine', 1);


delete from `entities`;
insert into `entities` (`author`, `is_enabled`, `entity`, `entity_id`, `title`) values ('test@exemple.com', 1, "La description de l'entité", 3, 'Entité 1');
