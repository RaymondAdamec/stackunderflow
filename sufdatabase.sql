-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 18. Dez 2023 um 13:28
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `sufdatabase`
--
CREATE DATABASE IF NOT EXISTS `sufdatabase` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sufdatabase`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `text` longtext NOT NULL,
  `fk_id_user_id` int(11) DEFAULT NULL,
  `fk_id_questions_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `answers`
--

INSERT INTO `answers` (`id`, `title`, `created_at`, `text`, `fk_id_user_id`, `fk_id_questions_id`) VALUES
(1, 'test', '2023-12-14 11:17:55', 'test', 5, 2),
(2, 'test', '2023-12-04 12:08:27', 'test', 2, 4),
(3, 'answer1', '2023-12-13 15:22:00', 'tzhtghjgh', 1, 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `text` longtext NOT NULL,
  `image` varchar(100) NOT NULL,
  `is_checked` tinyint(1) NOT NULL,
  `fk_id_user_id` int(11) DEFAULT NULL,
  `got_any_answer` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `questions`
--

INSERT INTO `questions` (`id`, `title`, `created_at`, `text`, `image`, `is_checked`, `fk_id_user_id`, `got_any_answer`) VALUES
(2, 'test', '2023-11-07 11:27:45', 'test', 'test', 0, 2, 1),
(4, 'test 2', '2023-12-10 11:27:45', 'test', 'test', 0, 2, 1),
(10, 'Qnew2', '2023-12-14 15:22:11', 'wrghzhghn', 'dvdghfgh', 1, 2, 0),
(11, 'TestQuestionTags', '2023-12-18 11:06:49', 'Tags are important', '123123', 1, 3, 0),
(12, 'BryanQeustion', '2023-12-18 11:08:27', '123', '123', 0, 3, 0),
(13, 'MondayTag Question', '2023-12-18 13:26:28', 'Monday', 'Monday', 1, 3, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ratings_answers`
--

CREATE TABLE `ratings_answers` (
  `id` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  `fk_id_answers_id` int(11) DEFAULT NULL,
  `fk_id_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `ratings_answers`
--

INSERT INTO `ratings_answers` (`id`, `votes`, `fk_id_answers_id`, `fk_id_user_id`) VALUES
(1, -1, 3, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ratings_questions`
--

CREATE TABLE `ratings_questions` (
  `id` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  `fk_id_question_id` int(11) DEFAULT NULL,
  `fk_id_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `ratings_questions`
--

INSERT INTO `ratings_questions` (`id`, `votes`, `fk_id_question_id`, `fk_id_user_id`) VALUES
(1, 1, 10, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `tags`
--

INSERT INTO `tags` (`id`, `title`, `description`) VALUES
(1, 'HTML', 'HTML is super easy'),
(2, 'PHP', 'PHP is quite difficult'),
(3, 'Symfony', 'Symfony is sometimes confusing');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags_questions`
--

CREATE TABLE `tags_questions` (
  `tags_id` int(11) NOT NULL,
  `questions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `tags_questions`
--

INSERT INTO `tags_questions` (`tags_id`, `questions_id`) VALUES
(1, 11),
(1, 12),
(1, 13),
(2, 13),
(3, 11),
(3, 12),
(3, 13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `git_hub_profile` varchar(255) NOT NULL,
  `is_banned` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `picture`, `git_hub_profile`, `is_banned`) VALUES
(1, 'first@test.com', '[]', '$2y$13$iYRjBfQ6l.SVtoHDYtwJj.uC26W.Q9aHUCTLwc/dsJBmB0PleJ3JK', '', '', '', '', 1),
(2, 'second@test.com', '[]', '$2y$13$9yts9ihvYno9N.S8LSfZTeORg3QIJajCnxgFPaHD4RlNJyu77DE6i', '', '', '', '', 0),
(3, 'third@test.com', '[]', '$2y$13$IzjDb5ctLnDlWv6HKHO6tuItVBIksSZaUPYsCJmnG0zKaumLHVKzC', '', '', '', '', 0),
(4, 'forth@test.com', '[]', '$2y$13$pR3VnihvOKKzXfymBLC9/u8Uy6kqh2ZNIBcEppm541NhJ4YSjnoF2', '', '', '', '', 0),
(5, 'fifth@test.com', '[]', '$2y$13$6ZB83KUs3ZUMEGYMiMlWRunoWj7B2rQ3/iAdIOsS/GqUNUqJ6XdCa', 'John', 'Doe', '', '', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_50D0C606899DB076` (`fk_id_user_id`),
  ADD KEY `IDX_50D0C60646D31589` (`fk_id_questions_id`);

--
-- Indizes für die Tabelle `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indizes für die Tabelle `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8ADC54D5899DB076` (`fk_id_user_id`);

--
-- Indizes für die Tabelle `ratings_answers`
--
ALTER TABLE `ratings_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1E60E33BB87FEEDB` (`fk_id_answers_id`),
  ADD KEY `IDX_1E60E33B899DB076` (`fk_id_user_id`);

--
-- Indizes für die Tabelle `ratings_questions`
--
ALTER TABLE `ratings_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AB30869C733BD2A1` (`fk_id_question_id`),
  ADD KEY `IDX_AB30869C899DB076` (`fk_id_user_id`);

--
-- Indizes für die Tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tags_questions`
--
ALTER TABLE `tags_questions`
  ADD PRIMARY KEY (`tags_id`,`questions_id`),
  ADD KEY `IDX_EEDD6A898D7B4FB4` (`tags_id`),
  ADD KEY `IDX_EEDD6A89BCB134CE` (`questions_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `ratings_answers`
--
ALTER TABLE `ratings_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `ratings_questions`
--
ALTER TABLE `ratings_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `FK_50D0C60646D31589` FOREIGN KEY (`fk_id_questions_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `FK_50D0C606899DB076` FOREIGN KEY (`fk_id_user_id`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_8ADC54D5899DB076` FOREIGN KEY (`fk_id_user_id`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `ratings_answers`
--
ALTER TABLE `ratings_answers`
  ADD CONSTRAINT `FK_1E60E33B899DB076` FOREIGN KEY (`fk_id_user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_1E60E33BB87FEEDB` FOREIGN KEY (`fk_id_answers_id`) REFERENCES `answers` (`id`);

--
-- Constraints der Tabelle `ratings_questions`
--
ALTER TABLE `ratings_questions`
  ADD CONSTRAINT `FK_AB30869C733BD2A1` FOREIGN KEY (`fk_id_question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `FK_AB30869C899DB076` FOREIGN KEY (`fk_id_user_id`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `tags_questions`
--
ALTER TABLE `tags_questions`
  ADD CONSTRAINT `FK_EEDD6A898D7B4FB4` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EEDD6A89BCB134CE` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
