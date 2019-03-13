-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 13 2019 г., 12:16
-- Версия сервера: 5.6.37
-- Версия PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `RARUS_CALC`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tariffs`
--

CREATE TABLE `tariffs` (
  `id_tariff` int(11) NOT NULL,
  `tariff_name` varchar(50) DEFAULT NULL,
  `tariff` varchar(50) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tariffs`
--

INSERT INTO `tariffs` (`id_tariff`, `tariff_name`, `tariff`) VALUES
(1, 'card', 'Есть зарплатная карта Банка'),
(2, 'low_cat', 'Льготная категория'),
(3, 'fam_gov', 'Семейная ипотека с гос. поддержкой'),
(4, 'min_doc', 'Минимум документов');

-- --------------------------------------------------------

--
-- Структура таблицы `tariff_types`
--

CREATE TABLE `tariff_types` (
  `id_tt` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `id_tariff` int(11) NOT NULL,
  `percentage` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tariff_types`
--

INSERT INTO `tariff_types` (`id_tt`, `id_type`, `id_tariff`, `percentage`) VALUES
(1, 1, 1, 10.5),
(2, 1, 2, 10),
(5, 1, 3, 6),
(6, 2, 1, 10.5),
(7, 2, 2, 12.5),
(8, 2, 4, 11),
(9, 1, 0, 11.5),
(10, 2, 0, 11.5),
(13, 3, 0, 11.5);

-- --------------------------------------------------------

--
-- Структура таблицы `types`
--

CREATE TABLE `types` (
  `id_type` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `types`
--

INSERT INTO `types` (`id_type`, `type`) VALUES
(3, 'Военный (участник НИС)'),
(2, 'Готовая квартира'),
(1, 'Новостройка');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tariffs`
--
ALTER TABLE `tariffs`
  ADD PRIMARY KEY (`id_tariff`),
  ADD UNIQUE KEY `tariff_name` (`tariff_name`);

--
-- Индексы таблицы `tariff_types`
--
ALTER TABLE `tariff_types`
  ADD PRIMARY KEY (`id_tt`);

--
-- Индексы таблицы `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id_type`),
  ADD UNIQUE KEY `type` (`type`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tariffs`
--
ALTER TABLE `tariffs`
  MODIFY `id_tariff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `tariff_types`
--
ALTER TABLE `tariff_types`
  MODIFY `id_tt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `types`
--
ALTER TABLE `types`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
