-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.2
-- Время создания: Май 24 2024 г., 02:58
-- Версия сервера: 8.2.0
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `register-bg`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `login` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `name`, `photo`, `description`) VALUES
(1, 'MySQL123', '$2y$10$N1PXxOST0GRC0NFGAvgYCu.Bb3hPifzlrwHJjdJ4RIZDfuGKshs/W', 'Anastasiia', 'uploads/IMG_20230806_220510.jpg', NULL),
(2, 'SASASA', '$2y$10$4s1ytu87JbUrSW/v7z8j2ubPXy5PJW/0c3ojHaLcm7gt/XecY5pZK', 'SASA', NULL, NULL),
(3, 'aytsunnn', '$2y$10$EN53uNfTXXA6dqGwTbggO.u5bkMZcu3/7oC0L/3xc3XpeD0KiH6Qy', 'Настя', NULL, 'KJKJKJ'),
(4, 'gogogo', '$2y$10$pvDHNT2zk1agXk1HVM0B4OmjryjHzb3DxehnoqlJr0VtDMjX8j2/y', 'Figma', NULL, NULL),
(5, 'Falaleev', '$2y$10$.nGKRIogf2H9siFQYT1Qv.hFN14JjUg4.5zq5am9HbWuZfT6KxFjm', 'Михаил', NULL, 'Я люблю эту жииииизнь');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
