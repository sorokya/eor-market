CREATE DATABASE IF NOT EXISTS `eomarket`;
USE `eomarket`;

CREATE TABLE IF NOT EXISTS `Accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `verify_code` varchar(5) NOT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`) USING BTREE
);

CREATE TABLE IF NOT EXISTS `Offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_ACCOUNT_ID_ACCOUNT` (`created_by`) USING BTREE,
  CONSTRAINT `FK_ACCOUNT_ID_ACCOUNT` FOREIGN KEY (`created_by`) REFERENCES `Accounts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE TABLE `Sales` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`item_id` INT(11) NOT NULL,
	`amount` INT(11) NOT NULL,
  `total` INT(11) NOT NULL,
	`buyer` VARCHAR(12) NOT NULL,
  `verified` TINYINT(1) NOT NULL DEFAULT 0,
  `notified` TINYINT(1) NOT NULL DEFAULT 0,
	`created_by` INT(11) NOT NULL,
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
	`updated_at` DATETIME NULL DEFAULT NULL,
	`deleted` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `FK_Sales_CreatedBy_Accounts` (`created_by`) USING BTREE,
	CONSTRAINT `FK_Sales_CreatedBy_Accounts` FOREIGN KEY (`created_by`) REFERENCES `Accounts` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
);
