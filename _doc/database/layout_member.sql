-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. April 2011 um 17:38
-- Server Version: 5.1.37
-- PHP-Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `conduct`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `place_id` int(11) DEFAULT '0',
  `prename` varchar(255) CHARACTER SET latin1 NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `address` varchar(255) CHARACTER SET latin1 NOT NULL,
  `zip` int(6) DEFAULT NULL,
  `location` varchar(255) CHARACTER SET latin1 NOT NULL,
  `birthday` date NOT NULL,
  `lastmodified` int(11) NOT NULL,
  `draft` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search` (`prename`,`name`,`address`,`location`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=65 ;
