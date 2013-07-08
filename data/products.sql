-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 18 2013 г., 13:51
-- Версия сервера: 5.5.25
-- Версия PHP: 5.4.16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `kohana`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cms_products`
--

CREATE TABLE IF NOT EXISTS `cms_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `slug` varchar(210) NOT NULL,
  `sky` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) unsigned DEFAULT '0.00',
  `purchase_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `in_stock` smallint(11) unsigned DEFAULT '0',
  `active` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `cms_products`
--

INSERT INTO `cms_products` (`id`, `name`, `slug`, `sky`, `price`, `purchase_price`, `in_stock`, `active`) VALUES
(1, 'Первый товар', 'tovar1', 't1', '151.50', '110.00', 10, 1),
(2, 'Второй товар', 'tovar2', 't2', '100.00', '90.00', 3, 0),
(3, 'Третий товар', 'tovar3', NULL, '400.00', '350.93', 0, 1),
(4, 'Еще какой-то товар', 'eshe_tovar', 't_123', '30.00', '20.00', 10, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
