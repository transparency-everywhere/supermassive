-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 10. Okt 2014 um 19:29
-- Server Version: 5.6.12
-- PHP-Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `cms`
--
CREATE DATABASE IF NOT EXISTS `cms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cms`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_navigation_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `template` int(11) NOT NULL,
  `timestamp_created` int(11) NOT NULL,
  `timestamp_updated` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `contents`
--

INSERT INTO `contents` (`id`, `parent_navigation_id`, `title`, `keywords`, `content`, `template`, `timestamp_created`, `timestamp_updated`, `active`, `order_id`) VALUES
(1, 1, 'Start', '', 'PGgyPlRoaXMgaXMgdGhlIGZpcnN0IHBhZ2Ugb2YgeW91ciB3ZWJzaXRlLjwvaDI+Cgo8cD5UbyBjaGFuZ2UgdGhpcyBjb250ZW50IG9yIGFkZCBuZXcgb25lcyBvcGVuIHRoZSBhZG1pbiBwYW5lbC48L3A+Cg==', 1, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `filename` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `alternative_text` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  `temp` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `navigations`
--

CREATE TABLE IF NOT EXISTS `navigations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `template_navigation_id` int(11) NOT NULL,
  `file` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `navigation_links`
--

CREATE TABLE IF NOT EXISTS `navigation_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `navigation_id` int(11) NOT NULL,
  `target_type` varchar(255) NOT NULL,
  `target_id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(255) NOT NULL,
  `plugin_folder_name` varchar(255) NOT NULL,
  `link_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `salts`
--

CREATE TABLE IF NOT EXISTS `salts` (
  `type` varchar(255) NOT NULL,
  `itemId` int(11) NOT NULL,
  `receiverType` varchar(255) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `salt` text NOT NULL,
  `algo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `templates`
--

INSERT INTO `templates` (`id`, `title`) VALUES
(1, 'standard');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usergroups`
--

CREATE TABLE IF NOT EXISTS `usergroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `readUsers` tinyint(1) NOT NULL,
  `addUsers` tinyint(1) NOT NULL,
  `editUsers` tinyint(1) NOT NULL,
  `deleteUsers` tinyint(1) NOT NULL,
  `readUsergroups` tinyint(1) NOT NULL,
  `addUsergroups` tinyint(1) NOT NULL,
  `editUsergroups` tinyint(1) NOT NULL,
  `deleteUsergroups` tinyint(1) NOT NULL,
  `seeContents` tinyint(1) NOT NULL,
  `createContents` tinyint(1) NOT NULL,
  `updateContents` tinyint(1) NOT NULL,
  `deleteContents` tinyint(1) NOT NULL,
  `readWidgets` tinyint(1) NOT NULL,
  `addWidgets` tinyint(1) NOT NULL,
  `editWidgets` tinyint(1) NOT NULL,
  `deleteWidgets` tinyint(1) NOT NULL,
  `seeNavigations` tinyint(1) NOT NULL,
  `createNavigations` tinyint(1) NOT NULL,
  `updateNavigations` tinyint(1) NOT NULL,
  `deleteNavigations` tinyint(1) NOT NULL,
  `seeFiles` tinyint(1) NOT NULL,
  `uploadFiles` tinyint(1) NOT NULL,
  `deleteFiles` tinyint(1) NOT NULL,
  `seeTemplates` tinyint(1) NOT NULL,
  `installTemplates` tinyint(1) NOT NULL,
  `seePlugins` tinyint(1) NOT NULL,
  `installPlugins` tinyint(1) NOT NULL,
  `changeConfig` tinyint(1) NOT NULL,
  `changeTemplate` tinyint(1) NOT NULL,
  `changeStartPage` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `usergroups`
--

INSERT INTO `usergroups` (`id`, `title`, `readUsers`, `addUsers`, `editUsers`, `deleteUsers`, `readUsergroups`, `addUsergroups`, `editUsergroups`, `deleteUsergroups`, `seeContents`, `createContents`, `updateContents`, `deleteContents`, `readWidgets`, `addWidgets`, `editWidgets`, `deleteWidgets`, `seeNavigations`, `createNavigations`, `updateNavigations`, `deleteNavigations`, `seeFiles`, `uploadFiles`, `deleteFiles`, `seeTemplates`, `installTemplates`, `seePlugins`, `installPlugins`, `changeConfig`, `changeTemplate`, `changeStartPage`) VALUES
(1, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `usergroup` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `regdate` int(11) NOT NULL,
  `lastactivity` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `forumUsername` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`userid`, `usergroup`, `username`, `password`, `regdate`, `lastactivity`, `firstname`, `lastname`, `timezone`, `forumUsername`) VALUES
(1, 1, 'admin', 'bd86c46d93b3d3588d2f824eb2082eb86918b799', 0, 0, 'super', 'user', '', 'admin');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `widgets`
--

CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `widgets_in_contents`
--

CREATE TABLE IF NOT EXISTS `widgets_in_contents` (
  `widget_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `template_widget_area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
