-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 19 2019 г., 09:31
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
(1, 11, 1, 10.5),
(2, 11, 2, 10),
(5, 11, 3, 6),
(6, 22, 1, 10.5),
(7, 22, 2, 11),
(8, 22, 4, 12.5),
(9, 11, 0, 11.5),
(10, 22, 0, 11.5);

-- --------------------------------------------------------

--
-- Структура таблицы `tariff_types_double`
--

CREATE TABLE `tariff_types_double` (
  `id_ttd` int(50) NOT NULL,
  `id_type` int(50) NOT NULL,
  `id_tariff_one` int(50) NOT NULL,
  `id_tariff_two` int(50) NOT NULL,
  `percentage` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tariff_types_double`
--

INSERT INTO `tariff_types_double` (`id_ttd`, `id_type`, `id_tariff_one`, `id_tariff_two`, `percentage`) VALUES
(1, 11, 1, 2, 10),
(2, 22, 1, 2, 10),
(3, 22, 4, 2, 12);

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
(22, 'Готовая квартира'),
(11, 'Новостройка');

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
-- Индексы таблицы `tariff_types_double`
--
ALTER TABLE `tariff_types_double`
  ADD PRIMARY KEY (`id_ttd`);

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
-- AUTO_INCREMENT для таблицы `tariff_types_double`
--
ALTER TABLE `tariff_types_double`
  MODIFY `id_ttd` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `types`
--
ALTER TABLE `types`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
