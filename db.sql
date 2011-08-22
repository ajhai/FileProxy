-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 22, 2011 at 07:44 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `fileProxy`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `beta`
--

CREATE TABLE IF NOT EXISTS `beta` (
  `email` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `requested_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `domain_id` int(2) NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(255) NOT NULL,
  `volume` int(30) NOT NULL,
  PRIMARY KEY (`domain_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `fid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hash` varchar(32) NOT NULL,
  `jhash` varchar(32) NOT NULL,
  PRIMARY KEY (`fid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `downstats`
--

CREATE TABLE IF NOT EXISTS `downstats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(30) NOT NULL,
  `uid` int(11) NOT NULL,
  `volume` int(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain_name` (`domain_name`,`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `downloaded` tinyint(1) NOT NULL DEFAULT '0',
  `size` int(20) NOT NULL,
  `final_fname` varchar(32) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `hno` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE IF NOT EXISTS `support` (
  `sip` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `sub` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `solved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sip`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uname` int(10) NOT NULL AUTO_INCREMENT,
  `password` varchar(32) NOT NULL,
  `created_on` datetime NOT NULL,
  `expires_on` datetime NOT NULL,
  `data_left` int(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `volume` int(30) NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
