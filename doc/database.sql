SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `zadanietestowe`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cmspages`
--

DROP TABLE IF EXISTS `cmspages`;
CREATE TABLE IF NOT EXISTS `cmspages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `content` text,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL,
  `bannertext` text,
  `image` varchar(255) DEFAULT NULL,
  `imagebig` varchar(255) DEFAULT NULL,
  `loggedonly` tinyint(1) DEFAULT NULL,
  `menu` tinyint(1) DEFAULT NULL,
  `footer` tinyint(1) NOT NULL,
  `homepage` tinyint(1) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `contactform` tinyint(1) DEFAULT '0',
  `sections` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cmspages`
--

INSERT INTO `cmspages` (`id`, `title`, `url`, `content`, `created`, `modified`, `bannertext`, `image`, `imagebig`, `loggedonly`, `menu`, `footer`, `homepage`, `position`, `contactform`, `sections`) VALUES
(9, 'Strona główna', 'strona-glowna', '', '2018-03-05 14:16:28', '2020-11-05 09:00:04', '<h1>Zadanie testowe</h1>', '', '', 0, 0, 0, 1, 0, 0, ''),
(10, 'Regulamin', 'regulamin', '', '2018-03-05 14:20:02', '2020-02-06 09:35:31', '', NULL, NULL, 0, 0, 1, 0, 1, 0, NULL),
(11, 'Kontakt', 'kontakt', '<h1 style=\"text-align: center; \">Formularz kontaktowy</h1>', '2018-03-06 09:15:56', '2019-12-13 08:58:26', '', NULL, NULL, 0, 1, 1, 0, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cmspages_pagegroups`
--

DROP TABLE IF EXISTS `cmspages_pagegroups`;
CREATE TABLE IF NOT EXISTS `cmspages_pagegroups` (
  `cmspage_id` int(11) NOT NULL,
  `pagegroup_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_cmspages_has_pagegroups_pagegroups1_idx` (`pagegroup_id`),
  KEY `fk_cmspages_has_pagegroups_cmspages1_idx` (`cmspage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pagegroups`
--

DROP TABLE IF EXISTS `pagegroups`;
CREATE TABLE IF NOT EXISTS `pagegroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `menu` tinyint(1) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text,
  `pdfgenerator` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `pagegroups`
--

INSERT INTO `pagegroups` (`id`, `name`, `menu`, `position`, `url`, `description`, `pdfgenerator`) VALUES
(1, 'Nachsendung von nötigen Unterlagen zur Steuererklärung', 1, 1, 'nachsendung-von-notigen-unterlagen-zur-steuererklarung', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus.&nbsp;<br></p>', 1),
(2, 'Pomoce do rozliczeń', 1, 2, 'pomoce-do-rozliczen', NULL, NULL),
(4, 'Test 2', 1, 4, 'test-2', '', NULL),
(5, 'test', 1, 4, 'test', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(65) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`id`, `name`, `symbol`, `created`, `modified`, `type`) VALUES
(1, 'admin', 'admin', '2017-10-16 12:45:54', '2017-10-16 12:45:54', 0),
(2, 'user', 'user', '2017-10-16 12:45:54', '2017-10-16 12:45:54', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `telefon` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '2',
  `type` varchar(255) NOT NULL,
  `born` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email` (`email`),
  KEY `fk_users_roles1_idx` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `telefon`, `email`, `company`, `nip`, `password`, `status`, `created`, `modified`, `role_id`, `type`, `born`) VALUES
(1, 'zadanie', 'testowe', 'zadanie testowe', '777888999', 'demo1234@example.com', '', '', 'f8a841dd0b644f4989f45f579fb175043f4d8f8e', 1, '2017-04-04 10:43:08', '2020-11-05 08:27:55', 1, 'prywatne', '2018-02-02'),
(97, 'user', 'demo', 'user demo', '777888999', 'demouser@example.com', '', '', 'f8a841dd0b644f4989f45f579fb175043f4d8f8e', 1, '2020-11-05 08:30:02', '2020-11-05 08:33:01', 2, 'prywatne', '1989-08-29');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `cmspages_pagegroups`
--
ALTER TABLE `cmspages_pagegroups`
  ADD CONSTRAINT `fk_cmspages_has_pagegroups_cmspages1` FOREIGN KEY (`cmspage_id`) REFERENCES `cmspages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cmspages_has_pagegroups_pagegroups1` FOREIGN KEY (`pagegroup_id`) REFERENCES `pagegroups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
