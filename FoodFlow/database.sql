-- Active: 1793190245439@@127.0.0.1@3306@foodflow
DROP SCHEMA IF EXISTS `FOODFLOW`;
CREATE SCHEMA `FOODFLOW`;
USE `FOODFLOW`;

# =========================================================
# USER TABLE
# =========================================================
CREATE TABLE `USER` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password` VARCHAR(30) NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# =========================================================
# REQUEST TABLE
# =========================================================
CREATE TABLE `REQUEST` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `id_user` INT NOT NULL,
  `date_request` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(20) NOT NULL DEFAULT 'Pending',

  PRIMARY KEY (`id`),

  FOREIGN KEY (`id_user`)
    REFERENCES `USER` (`id`)
) ENGINE=InnoDB;

# =========================================================
# PRODUCT TABLE
# =========================================================
CREATE TABLE `PRODUCT` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `id_request` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `flavor` TEXT NOT NULL,
  `size` VARCHAR(30) NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,

  PRIMARY KEY(`id`),

  FOREIGN KEY (`id_request`)
    REFERENCES `REQUEST` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

# =========================================================
# PREPARE TABLE
# =========================================================
CREATE TABLE `PREPARE` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `id_product` INT NOT NULL,

  PRIMARY KEY(`id`),

  FOREIGN KEY (`id_product`)
    REFERENCES `PRODUCT` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

# =========================================================
# DELIVER TABLE
# =========================================================
CREATE TABLE `DELIVER` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `id_user` INT NOT NULL,
  `id_request` INT NOT NULL,

  PRIMARY KEY (`id`),

  FOREIGN KEY (`id_user`)
    REFERENCES `USER` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,

  FOREIGN KEY (`id_request`)
    REFERENCES `REQUEST` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;