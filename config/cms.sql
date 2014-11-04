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
  `template_vars` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `contents`
--

INSERT INTO `contents` (`id`, `parent_navigation_id`, `title`, `keywords`, `description`, `content`, `template`, `timestamp_created`, `timestamp_updated`, `active`, `order_id`, `template_vars`) VALUES
(1, 1, 'Start', '', 'This is the first page of your website. To change this content or add new ones open the admin panel.', 'PHAgaWQ9InRpdGxlIj5GZWF0dXJlczwvcD48ZGl2IGNsYXNzPSJjbGVhcmZpeCIgaWQ9InNlcGVyYXRvciI+PGJyPjwvZGl2PjxkaXYgY2xhc3M9ImNsZWFyZml4IiBpZD0iYm94Ij48cCBpZD0iaGVhZGxpbmUiPldlbGNvbWUgdG8gdGhlIFVsYXMgdGVtcGxhdGU8L3A+PHAgaWQ9InAiPkxvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LCBjb25zZWN0ZXR1ciBhZGlwaXNjaW5nIGVsaXQuIE1hZWNlbmFzIG1ldHVzIG51bGxhLCBhIHNlZCwgZGlnbmlzc2ltIHByZXRpdW0gbnVuYy4gTmFtIGV0IGxhY3VzIG5lcXVlLiBVdCBlbmltIG1hc3NhLCBzb2RhbGVzIHRlbXBvciBjb252YWxsaXMgZXQuPC9wPjwvZGl2PjxkaXYgY2xhc3M9ImNsZWFyZml4IiBpZD0iYm94MSI+PGltZyBjbGFzcz0iaW1hZ2UiIGlkPSJpbWFnZTEiIGRhdGEtY2tlLXNhdmVkLXNyYz0idGVtcGxhdGUvVWxhcy9pbWcvaWNvbl9zdGFyLnBuZyIgc3JjPSJ0ZW1wbGF0ZS9VbGFzL2ltZy9pY29uX3N0YXIucG5nIj48cCBpZD0icDEiPkxvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LCBjb25zZXRldHVyIHNhZGlwc2NpbmcgZWxpdHIsIHNlZCBkaWFtIG5vbnVteSBlaXJtb2QgdGVtcG9yIGludmlkdW50IHV0IGxhYm9yZSBldCBkb2xvcmUgbWFnbmEgYWxpcXV5YW0gZXJhdCwgc2VkIGRpYW0gdm9sdXB0dWEuIEF0IHZlcm8gZW9zIGV0IGFjY3VzYW0gZXQganVzdG8gZHVvIGRvbG9yZXMgZXQgZWEgcmVidW0uIFN0ZXQgY2xpdGEga2FzZCBndWJlcmdyZW4sIG5vIHNlYSB0YWtpbWF0YSBzYW5jdHVzIGVzdCBMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldC48L3A+PC9kaXY+PGRpdiBjbGFzcz0iY2xlYXJmaXgiIGlkPSJib3gyIj48aW1nIGNsYXNzPSJpbWFnZSIgaWQ9ImltYWdlMiIgZGF0YS1ja2Utc2F2ZWQtc3JjPSJ0ZW1wbGF0ZS9VbGFzL2ltZy9pY29uX3N0YXIucG5nIiBzcmM9InRlbXBsYXRlL1VsYXMvaW1nL2ljb25fc3Rhci5wbmciPjxwIGlkPSJwMiI+TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNldGV0dXIgc2FkaXBzY2luZyBlbGl0ciwgc2VkIGRpYW0gbm9udW15IGVpcm1vZCB0ZW1wb3IgaW52aWR1bnQgdXQgbGFib3JlIGV0IGRvbG9yZSBtYWduYSBhbGlxdXlhbSBlcmF0LCBzZWQgZGlhbSB2b2x1cHR1YS4gQXQgdmVybyBlb3MgZXQgYWNjdXNhbSBldCBqdXN0byBkdW8gZG9sb3JlcyBldCBlYSByZWJ1bS4gU3RldCBjbGl0YSBrYXNkIGd1YmVyZ3Jlbiwgbm8gc2VhIHRha2ltYXRhIHNhbmN0dXMgZXN0IExvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LjwvcD48L2Rpdj48ZGl2IGNsYXNzPSJjbGVhcmZpeCIgaWQ9ImJveDMiPjxpbWcgY2xhc3M9ImltYWdlIiBpZD0iaW1hZ2UzIiBkYXRhLWNrZS1zYXZlZC1zcmM9InRlbXBsYXRlL1VsYXMvaW1nL2ljb25fc3Rhci5wbmciIHNyYz0idGVtcGxhdGUvVWxhcy9pbWcvaWNvbl9zdGFyLnBuZyI+PHAgaWQ9InAzIj5Mb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgY29uc2V0ZXR1ciBzYWRpcHNjaW5nIGVsaXRyLCBzZWQgZGlhbSBub251bXkgZWlybW9kIHRlbXBvciBpbnZpZHVudCB1dCBsYWJvcmUgZXQgZG9sb3JlIG1hZ25hIGFsaXF1eWFtIGVyYXQsIHNlZCBkaWFtIHZvbHVwdHVhLiBBdCB2ZXJvIGVvcyBldCBhY2N1c2FtIGV0IGp1c3RvIGR1byBkb2xvcmVzIGV0IGVhIHJlYnVtLiBTdGV0IGNsaXRhIGthc2QgZ3ViZXJncmVuLCBubyBzZWEgdGFraW1hdGEgc2FuY3R1cyBlc3QgTG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQuPC9wPjwvZGl2PjxkaXYgY2xhc3M9ImNsZWFyZml4IiBpZD0iYm94NCI+PGltZyBjbGFzcz0iaW1hZ2UiIGlkPSJpbWFnZTQiIGRhdGEtY2tlLXNhdmVkLXNyYz0idGVtcGxhdGUvVWxhcy9pbWcvaWNvbl9zdGFyLnBuZyIgc3JjPSJ0ZW1wbGF0ZS9VbGFzL2ltZy9pY29uX3N0YXIucG5nIj48cCBpZD0icDQiPkxvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LCBjb25zZXRldHVyIHNhZGlwc2NpbmcgZWxpdHIsIHNlZCBkaWFtIG5vbnVteSBlaXJtb2QgdGVtcG9yIGludmlkdW50IHV0IGxhYm9yZSBldCBkb2xvcmUgbWFnbmEgYWxpcXV5YW0gZXJhdCwgc2VkIGRpYW0gdm9sdXB0dWEuIEF0IHZlcm8gZW9zIGV0IGFjY3VzYW0gZXQganVzdG8gZHVvIGRvbG9yZXMgZXQgZWEgcmVidW0uIFN0ZXQgY2xpdGEga2FzZCBndWJlcmdyZW4sIG5vIHNlYSB0YWtpbWF0YSBzYW5jdHVzIGVzdCBMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldC48L3A+PC9kaXY+PGRpdiBjbGFzcz0iY2xlYXJmaXgiIGlkPSJib3g1Ij48YnI+PC9kaXY+', 1, 0, 0, 0, 1, '[null,"undefined","undefined","undefined","undefined"]'),
(2, 1, 'Content', '', 'This is a content', 'PHAgaWQ9InRpdGxlIj5UaGlzIGlzIGEgY29udGVudCBleGFtcGxlPC9wPjxkaXYgY2xhc3M9ImNsZWFyZml4IiBpZD0ic2VwZXJhdG9yIj48YnI+PC9kaXY+PGRpdiBjbGFzcz0iY2xlYXJmaXgiIGlkPSJib3giPjxwIGlkPSJoZWFkbGluZSI+TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQ8L3A+PHAgaWQ9InAiPkxvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LCBjb25zZWN0ZXR1ciBhZGlwaXNjaW5nIGVsaXQuIE1hZWNlbmFzIG1ldHVzIG51bGxhLCBhIHNlZCwgZGlnbmlzc2ltIHByZXRpdW0gbnVuYy4gTmFtIGV0IGxhY3VzIG5lcXVlLiBVdCBlbmltIG1hc3NhLCBzb2RhbGVzIHRlbXBvciBjb252YWxsaXMgZXQuPC9wPjwvZGl2PjxkaXYgY2xhc3M9ImNsZWFyZml4IiBpZD0iYm94MSI+PGltZyBjbGFzcz0iaW1hZ2UiIGlkPSJpbWFnZTEiIGRhdGEtY2tlLXNhdmVkLXNyYz0idGVtcGxhdGUvVWxhcy9pbWcvRm90b2xpYV8xMTQ3MzUwMl9NLmpwZyIgc3JjPSJ0ZW1wbGF0ZS9VbGFzL2ltZy9Gb3RvbGlhXzExNDczNTAyX00uanBnIj4gPGltZyBjbGFzcz0iaW1hZ2UiIGlkPSJpbWFnZTIiIGRhdGEtY2tlLXNhdmVkLXNyYz0idGVtcGxhdGUvVWxhcy9pbWcvRm90b2xpYV8xNjIzODUwNl9NLmpwZyIgc3JjPSJ0ZW1wbGF0ZS9VbGFzL2ltZy9Gb3RvbGlhXzE2MjM4NTA2X00uanBnIj48L2Rpdj48cCBpZD0icDEiPjxzcGFuIGlkPSJ0ZXh0c3BhbiI+TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNldGV0dXIgc2FkaXBzY2luZyBlbGl0ciwgc2VkIGRpYW0gbm9udW15IGVpcm1vZCB0ZW1wb3IgaW52aWR1bnQgdXQgbGFib3JlIGV0IGRvbG9yZSBtYWduYSBhbGlxdXlhbSBlcmF0LCBzZWQgZGlhbSB2b2x1cHR1YS4gQXQgdmVybyBlb3MgZXQgYWNjdXNhbSBldCBqdXN0byBkdW8gZG9sb3JlcyBldCBlYSByZWJ1bS4gU3RldCBjbGl0YSBrYXNkIGd1YmVyZ3Jlbiwgbm8gc2VhIHRha2ltYXRhIHNhbmN0dXMgZXN0IExvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LiBMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgY29uc2V0ZXR1ciBzYWRpcHNjaW5nIGVsaXRyLCBzZWQgZGlhbSBub251bXkgZWlybW9kIHRlbXBvciBpbnZpZHVudCB1dCBsYWJvcmUgZXQgZG9sb3JlIG1hZ25hIGFsaXF1eWFtIGVyYXQsIHNlZCBkaWFtIHZvbHVwdHVhLjwvc3Bhbj48YnI+PGJyPjxzcGFuIGlkPSJ0ZXh0c3BhbjEiPkxvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LCBjb25zZXRldHVyIHNhZGlwc2NpbmcgZWxpdHIsIHNlZCBkaWFtIG5vbnVteSBlaXJtb2QgdGVtcG9yIGludmlkdW50IHV0IGxhYm9yZSBldCBkb2xvcmUgbWFnbmEgYWxpcXV5YW0gZXJhdCwgc2VkIGRpYW0gdm9sdXB0dWEuJm5ic3A7PC9zcGFuPjxicj48YnI+PHNwYW4gaWQ9InRleHRzcGFuMiI+TG9yZW0gaXBzdW0gZG9sb3Igc2l0IGFtZXQsIGNvbnNldGV0dXIgc2FkaXBzY2luZyBlbGl0ciwgc2VkIGRpYW0gbm9udW15IGVpcm1vZCB0ZW1wb3IgaW52aWR1bnQgdXQgbGFib3JlIGV0IGRvbG9yZSBtYWduYSBhbGlxdXlhbSBlcmF0LCBzZWQgZGlhbSB2b2x1cHR1YS4gQXQgdmVybyBlb3MgZXQgYWNjdXNhbSBldCBqdXN0byBkdW8gZG9sb3JlcyBldCBlYSByZWJ1bS4gU3RldCBjbGl0YSBrYXNkIGd1YmVyZ3Jlbiwgbm8gc2VhIHRha2ltYXRhIHNhbmN0dXMgZXN0IExvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LiBMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgY29uc2V0ZXR1ciBzYWRpcHNjaW5nIGVsaXRyLCBzZWQgZGlhbSBub251bXkgZWlybW9kIHRlbXBvciBpbnZpZHVudCB1dCBsYWJvcmUgZXQgZG9sb3JlIG1hZ25hIGFsaXF1eWFtIGVyYXQsIHNlZCBkaWFtIHZvbHVwdHVhLjwvc3Bhbj48L3A+PGRpdiBjbGFzcz0iY2xlYXJmaXgiIGlkPSJTRVBFUkFUT1IiPjxicj48L2Rpdj4=', 1, 0, 0, 0, 2, '[null,"Ulas","A template for the supermassive cms","CREATE A BEAUTIFUL RESPONSIVE WEBSITE AT THE SPEED OF LIGHT","Ulas ist a free responsive html 5 template that comes with supermassive cms.Discover the many ways to customize ulas to create the website of your dreams!"]'),
(3, 2, 'License', '', 'The supermassive CMS is open-sourced software licensed under theÂ Creative Commons Attribution 4.0 In', 'PHA+VGhlIHN1cGVybWFzc2l2ZSBDTVMgaXMgb3Blbi1zb3VyY2VkIHNvZnR3YXJlIGxpY2Vuc2VkIHVuZGVyIHRoZSZuYnNwO0NyZWF0aXZlIENvbW1vbnMgQXR0cmlidXRpb24gNC4wIEludGVybmF0aW9uYWwgUHVibGljIExpY2Vuc2UuPC9wPg==', 1, 0, 0, 0, 3, '[null,"Ulas","A template for the supermassive cms","CREATE A BEAUTIFUL RESPONSIVE WEBSITE AT THE SPEED OF LIGHT","Ulas ist a free responsive html 5 template that comes with supermassive cms.Discover the many ways to customize ulas to create the website of your dreams!"]');

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
INSERT INTO `navigation_links` (`id`, `navigation_id`, `target_type`, `target_id`, `caption`, `order_id`) VALUES
(1, 2, 'content', 1, 'Start', 1),
(2, 2, 'content', 2, 'Content', 2);

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
(1, 'Ulas');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


INSERT INTO `widgets` (`id`, `title`, `type`, `content`) VALUES
(1, 'Text Widget', 'HTML', 'TEXT WIDGET<br><br>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.');
INSERT INTO `widgets` (`id`, `title`, `type`, `content`) VALUES
(2, 'License', 'HTML', 'Copyright 2014 &#x2b;&#x2b;&#x2b; ulas template powered by supermassive cms &#x2b;&#x2b;&#x2b; Login<br />image credits&#x3a; ULAS J1120&#x2b;0641, author ESO&#x2f;M. Kornmesser, source www.eso.org&#x2f;public&#x2f;images&#x2f;eso1122a');


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `widgets_in_contents`
--

CREATE TABLE IF NOT EXISTS `widgets_in_contents` (
  `widget_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `template_widget_area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `widgets_in_contents` (`widget_id`, `content_id`, `template_widget_area_id`) VALUES
(2, 1, 4),
(2, 2, 4),
(1, 1, 2),
(1, 1, 3),
(1, 2, 2);
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
