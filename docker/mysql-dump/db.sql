-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2021 at 01:37 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `admin_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_phone_book`
--

CREATE DATABASE bpg;

USE bpg;

CREATE TABLE IF NOT EXISTS `all_phone_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prefix` varchar(4) NOT NULL COMMENT '+40=ro\r\n+39=de',
  `number` varchar(15) NOT NULL COMMENT 'left trimmed all the leading zeroes',
  `name` varchar(80) NOT NULL COMMENT 'associate or client name',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'last update timestamp',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_phone` (`prefix`,`number`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `all_phone_book_links`
--

CREATE TABLE IF NOT EXISTS `all_phone_book_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'internal index',
  `phone_book_id` int(100) NOT NULL COMMENT 'all_phone_book.id',
  `table_id` int(11) NOT NULL COMMENT 'form_employees.employee_id',
  `table_name` varchar(100) NOT NULL COMMENT 'eg: form_employees',
  PRIMARY KEY (`link_id`),
  UNIQUE KEY `single_reference` (`phone_book_id`,`table_id`,`table_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
