-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.31 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win64
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных shop2
CREATE DATABASE IF NOT EXISTS `shop2` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shop2`;


-- Дамп структуры для таблица shop2.order
CREATE TABLE IF NOT EXISTS `order` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(3) unsigned NOT NULL,
  `date` date NOT NULL,
  `sum` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `FK_order_user` (`user_id`),
  CONSTRAINT `FK_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop2.order: ~13 rows (приблизительно)
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` (`id`, `user_id`, `date`, `sum`) VALUES
	(28, 3, '2016-12-21', 3740.00),
	(29, 3, '2016-12-18', 1568.00),
	(30, 4, '2016-12-22', 3780.00),
	(31, 5, '2016-12-21', 3000.00),
	(32, 16, '2016-12-15', 734.00),
	(33, 15, '2016-11-08', 8000.00),
	(34, 16, '2016-11-21', 16200.00),
	(35, 10, '2016-10-27', 5810.00),
	(36, 2, '2016-12-13', 14808.00),
	(37, 5, '2016-12-13', 470.00),
	(38, 16, '2016-12-11', 470.00),
	(39, 16, '2016-12-22', 2100.00),
	(40, 2, '2016-12-21', 5716.00);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;


-- Дамп структуры для таблица shop2.order_item
CREATE TABLE IF NOT EXISTS `order_item` (
  `order_id` smallint(5) unsigned NOT NULL,
  `product_sku` varchar(50) NOT NULL,
  `quantity` tinyint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`product_sku`,`order_id`),
  KEY `Индекс 2` (`order_id`),
  CONSTRAINT `FK__order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK__product` FOREIGN KEY (`product_sku`) REFERENCES `product` (`SKU`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop2.order_item: ~24 rows (приблизительно)
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` (`order_id`, `product_sku`, `quantity`) VALUES
	(33, '10EEE', 2),
	(34, '10EEE', 4),
	(35, '56678', 3),
	(37, '56678', 1),
	(38, '56678', 1),
	(39, '56678', 2),
	(29, '78999', 1),
	(31, '78999', 2),
	(32, '888tt', 1),
	(36, 'IOPER', 12),
	(40, 'IOPER', 4),
	(28, 'R76EE', 3),
	(30, 'R76EE', 1),
	(39, 'R76EE', 2),
	(40, 'R76EE', 1),
	(29, 'sqser', 2),
	(32, 'sqser', 6),
	(28, 'TTT45', 4),
	(34, 'TTT45', 2),
	(37, 'TTT45', 2),
	(38, 'TTT45', 2),
	(28, 'UU12', 1),
	(30, 'UU12', 3),
	(35, 'UU12', 5);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;


-- Дамп структуры для таблица shop2.product
CREATE TABLE IF NOT EXISTS `product` (
  `SKU` varchar(50) NOT NULL,
  `name` char(250) NOT NULL,
  `description` text NOT NULL,
  `img` char(100) NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `total` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`SKU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop2.product: ~10 rows (приблизительно)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`SKU`, `name`, `description`, `img`, `price`, `total`) VALUES
	('10EEE', 'daikin', 'conditioner', '9.jpg', 4000.00, 10),
	('56678', 'ToshibaPr', 'projector', '5.jpg', 270.00, 7),
	('78999', 'iphone', 'tel', '8.jpg', 1500.00, 500),
	('888tt', 'GShock', 'GShock', '3.jpg', 530.00, 18),
	('IOPER', 'Samsung', 'microwave', '7.jpg', 1234.00, 8),
	('QQ345', 'Mikasa', 'volleyball', '10.jpg', 1500.00, 250),
	('R76EE', 'Asus230', 'Notebook Asus230', '4.jpg', 780.00, 18),
	('sqser', 'Panasonic', 'player111', '6.jpg', 34.00, 33),
	('TTT45', 'Casio Simple', 'Casio Very Simple', '2.jpg', 100.00, 13),
	('UU12', 'Casio COOL', 'Casio Super COOL', '1.jpg', 1000.00, 7);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- Дамп структуры для таблица shop2.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `description` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop2.role: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `name`, `description`) VALUES
	(2, 'Simple user', '0%'),
	(5, 'Admin', 'level god'),
	(6, 'Advanced user', '10%'),
	(7, 'Super user', '20%');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;


-- Дамп структуры для процедура shop2.update_order
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_order`()
begin
update `order`, 
(select `order_item`.order_id, 
sum(`order_item`.quantity * `product`.price) `summa`
from `order_item`, `product`
where `order_item`.product_sku = `product`.SKU
group by `order_item`.order_id) itogo
set `sum` = `itogo`.`summa`
where `order`.`id` = `itogo`.`order_id`;
end//
DELIMITER ;


-- Дамп структуры для таблица shop2.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `skills` set('PHP','CSS','Javascript','Java','HTML','Web-design') NOT NULL DEFAULT 'HTML',
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `year` tinyint(2) unsigned DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_user_role` (`role_id`),
  CONSTRAINT `FK_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop2.user: ~27 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `is_active`, `skills`, `role_id`, `year`, `photo`) VALUES
	(2, 'fgh1', 'Petrov1', 'petrov1@gmail.com', '11111', '1', 'PHP,CSS,Javascript,Java,HTML,Web-design', 2, 121, 'upload\\my-foto.jpg'),
	(3, 'Andrey', 'Andreev', 'andrey@gmail.com', '555656', '1', 'PHP', 2, 12, NULL),
	(4, 'Denis', 'Denisov', 'denis@gmail.com', '232323', '1', 'HTML,Web-design', 2, 22, NULL),
	(5, 'Alex', 'Alexeev', 'alex@gmail.com', '343434', '1', 'Web-design', 7, 34, NULL),
	(10, 'Ivanp1', 'Ivanov1', 'ivanov1@gmail.com', '1111', '0', 'PHP,CSS,Javascript,Web-design', 6, 30, NULL),
	(12, 'Ivanov', 'ivanov@gmail.com', 'ivanov@yandex.com', '1', '0', 'CSS,Javascript', 6, 11, NULL),
	(15, 'Kirillov1', 'kirillov1@gmail.com', 'kirillov1@yandex.com', '1', '1', 'PHP,CSS', 7, 34, NULL),
	(16, 'Sidor', 'Sidorov', 'sidorov@gmail.com', '232323', '1', 'HTML', 2, 15, NULL),
	(17, NULL, NULL, 'fedorov@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1', 'HTML', 2, NULL, NULL),
	(18, NULL, NULL, 'garik@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1', 'HTML', 2, NULL, NULL),
	(82, NULL, NULL, 'aa@aa.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 5, NULL, NULL),
	(83, NULL, NULL, 'tt@tt.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(84, NULL, NULL, 'dd@dd.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(85, NULL, NULL, 'ff@ff.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(86, NULL, NULL, 'ddd@dd.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(87, NULL, NULL, 'cc@vv.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(88, NULL, NULL, 'cv@df.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(89, NULL, NULL, 'cvb@fg.d', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(90, NULL, NULL, 'dfg@gh.y', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(91, NULL, NULL, 'asd@df.rt', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(92, NULL, NULL, 'df@rty.y', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(93, NULL, NULL, 'gh@df.r', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(94, NULL, NULL, 'fg@rty.io', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(95, NULL, NULL, 'jk@il.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL),
	(96, 'dfg', 'dg', 'sd@rt.ty', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 6, 56, 'upload\\my-foto.jpg'),
	(97, NULL, NULL, 'dghgh@ff.cn', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'Web-design', 2, NULL, NULL),
	(98, NULL, NULL, 'sdfg@dfg.ty', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1', 'HTML', 2, NULL, NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
