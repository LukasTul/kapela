-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 18. čen 2024, 11:11
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `kapela`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `hodnoceni`
--

CREATE TABLE `hodnoceni` (
  `id` int(11) NOT NULL,
  `kapela_porovnani` varchar(255) NOT NULL,
  `oblibene_skladby` text NOT NULL,
  `hudebni_zanr` enum('rock','pop','jazz','elektronicka','klasicka') NOT NULL,
  `zazitek_koncert` text DEFAULT NULL,
  `hodnoceni` int(11) DEFAULT NULL CHECK (`hodnoceni` between 1 and 10),
  `doporuceni` varchar(255) DEFAULT NULL,
  `obrazek` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `hodnoceni`
--

INSERT INTO `hodnoceni` (`id`, `kapela_porovnani`, `oblibene_skladby`, `hudebni_zanr`, `zazitek_koncert`, `hodnoceni`, `doporuceni`, `obrazek`, `created_at`, `updated_at`) VALUES
(16, 'Radiohead', 'Creep', 'jazz', 'Bylo to velmi zajímavé', 10, '', 'assets/img-koment/20240430_151754.jpg', '2024-06-12 13:45:31', '2024-06-12 13:45:31'),
(17, 'Kabát', 'Malá dáma, Burlaci', 'elektronicka', 'Krásně', 9, 'přátelé,rodina,kolegové', 'assets/img-koment/20240430_151754.jpg', '2024-06-12 14:27:53', '2024-06-12 14:27:53');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `nickname`, `email`, `password`, `admin`, `created_at`, `updated_at`) VALUES
(10, 'Jan', 'Novak', 'jannovak', 'jan@novak.cz', '$2y$10$fB9CagLcRWS5fKgTQhYBAeojcyI6QbenT.cboLP1VsIQzJdD.FtXm', 1, '2024-06-12 09:48:43', '2024-06-13 12:23:51'),
(16, 'karel', 'sdfs', 'sdfsdf', 'karel@novak.cz', '$2y$10$vYrWk5u5K1mH0h0M.ChP8eE2TmhOAaijXlD00otY1CWWz4r.Fkpvu', 0, '2024-06-12 09:53:23', '2024-06-18 08:35:57'),
(24, 'jakub', 'jezek', 'jezko', 'jakub@jezek.cz', '$2y$10$EDa/RkGXHeOLNVpU.FH3UuCrNur7GyHwZgw8UKCNF2Q/6dOfjng7G', 0, '2024-06-13 14:37:31', '2024-06-13 14:37:31'),
(26, 'karolína', 'koutná', 'karolin', 'karolina@koutna.cz', '$2y$10$bcAj0Qblb/adAyRlrMoZsOb.cJ06dZw9TUCIVe2OKguAh9e9vUykm', 1, '2024-06-18 08:39:49', '2024-06-18 08:59:39');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `hodnoceni`
--
ALTER TABLE `hodnoceni`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `nicknameKey` (`nickname`),
  ADD UNIQUE KEY `emailKey` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `hodnoceni`
--
ALTER TABLE `hodnoceni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
