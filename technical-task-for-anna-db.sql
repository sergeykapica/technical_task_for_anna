-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 11 2019 г., 11:35
-- Версия сервера: 10.3.16-MariaDB
-- Версия PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `id11900086_technical_task_for_anna`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users_list`
--

CREATE TABLE `users_list` (
  `ID` int(10) NOT NULL,
  `USER_LOGIN` varchar(100) NOT NULL,
  `USER_NAME` varchar(100) NOT NULL,
  `USER_LAST_NAME` varchar(100) NOT NULL,
  `USER_BIRTHDATE` varchar(10) NOT NULL,
  `USER_COUNTRY` varchar(100) NOT NULL,
  `USER_CITY` varchar(100) NOT NULL,
  `USER_PASSWORD` varchar(100) NOT NULL,
  `USER_EMAIL` varchar(100) NOT NULL,
  `USER_ABOUT_DESCRIPTION` varchar(2000) NOT NULL,
  `USER_PHOTO` varchar(500) DEFAULT NULL,
  `USER_DATE` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users_list`
--

INSERT INTO `users_list` (`ID`, `USER_LOGIN`, `USER_NAME`, `USER_LAST_NAME`, `USER_BIRTHDATE`, `USER_COUNTRY`, `USER_CITY`, `USER_PASSWORD`, `USER_EMAIL`, `USER_ABOUT_DESCRIPTION`, `USER_PHOTO`, `USER_DATE`) VALUES
(5, 'sergeykapica', 'Sergey', 'Kapica', '07/07/1967', 'Россия', 'Москва', '5bf552786205f215d16c57f5c45f3cec', 'kermesovich1@gmail.com', 'Good people', 'x_35c30da31576063630.jpg', 1576063651);

-- --------------------------------------------------------

--
-- Структура таблицы `users_settings`
--

CREATE TABLE `users_settings` (
  `ID` int(10) NOT NULL,
  `USER_BIRTHDATE` int(1) NOT NULL DEFAULT 1,
  `USER_COUNTRY` int(1) NOT NULL DEFAULT 1,
  `USER_CITY` int(1) NOT NULL DEFAULT 1,
  `USER_EMAIL` int(1) NOT NULL DEFAULT 1,
  `USER_ABOUT_DESCRIPTION` int(1) NOT NULL DEFAULT 1,
  `USER_DATE` int(1) DEFAULT 1,
  `USER_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users_settings`
--

INSERT INTO `users_settings` (`ID`, `USER_BIRTHDATE`, `USER_COUNTRY`, `USER_CITY`, `USER_EMAIL`, `USER_ABOUT_DESCRIPTION`, `USER_DATE`, `USER_ID`) VALUES
(5, 1, 1, 1, 1, 1, 1, 5);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users_list`
--
ALTER TABLE `users_list`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER_PASSWORD` (`USER_PASSWORD`,`USER_EMAIL`);

--
-- Индексы таблицы `users_settings`
--
ALTER TABLE `users_settings`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users_list`
--
ALTER TABLE `users_list`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users_settings`
--
ALTER TABLE `users_settings`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
