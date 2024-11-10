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
  `account_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_ACCOUNT_ID_ACCOUNT` (`account_id`) USING BTREE,
  CONSTRAINT `FK_ACCOUNT_ID_ACCOUNT` FOREIGN KEY (`account_id`) REFERENCES `Accounts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);
