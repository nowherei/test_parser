-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `parentId` int(4) NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id`, `parentId`, `name`) VALUES
(1,	0,	'Мобильные телефоны'),
(2,	1,	'Apple'),
(3,	1,	'Xiaomi'),
(4,	0,	'Планшеты'),
(5,	4,	'Samsung'),
(6,	4,	'LG');

DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `available` varchar(10) NOT NULL,
  `url` varchar(128) NOT NULL,
  `price` varchar(10) NOT NULL,
  `optprice` varchar(10) NOT NULL,
  `categoryId` int(4) NOT NULL,
  `picture` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `articul` varchar(10) NOT NULL,
  `vendor` varchar(128) NOT NULL,
  `description` varchar(256) NOT NULL,
  `extprops_season` varchar(128) NOT NULL,
  `extprops_name` varchar(128) NOT NULL,
  `statusAction` varchar(10) NOT NULL,
  `statusNew` varchar(10) NOT NULL,
  `statusTop` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `offers` (`id`, `available`, `url`, `price`, `optprice`, `categoryId`, `picture`, `name`, `articul`, `vendor`, `description`, `extprops_season`, `extprops_name`, `statusAction`, `statusNew`, `statusTop`) VALUES
(1,	'true',	'http://www.shop.com/detail.php?ID=1',	'3000',	'2000',	2,	'http://www.shop.com/jpeg',	'Apple Iphone 7',	'1123123',	'APPLE',	'Описание товара',	'Красный',	'Iphone 7',	'true',	'false',	'false'),
(2,	'true',	'http://www.shop.com/detail.php?ID=2',	'5000',	'4000',	3,	'http://www.shop.com/jpeg',	'Xiaomi Phone',	'x912',	'Xiaomi',	'Описание xiaomi',	'Черный',	'A56',	'true',	'true',	'false'),
(3,	'true',	'http://www.shop.com/detail.php?ID=3',	'50000',	'14000',	5,	'http://www.shop.com/jpeg',	'Samsung Tablet',	'st1912',	'Samsung',	'Описание samsung',	'Серый',	'Планшет Samsung',	'true',	'true',	'true'),
(4,	'true',	'http://www.shop.com/detail.php?ID=4',	'3400',	'400',	6,	'http://www.shop.com/jpeg',	'LG tablet',	'lg4412',	'LG',	'Описание lg',	'Синий',	'A526',	'true',	'false',	'true');

-- 2018-10-07 20:36:10
