-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 12:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `business-accounts-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_business_book`
--

CREATE TABLE `tbl_business_book` (
  `id` int(11) NOT NULL,
  `business_book_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_business_book`
--

INSERT INTO `tbl_business_book` (`id`, `business_book_name`) VALUES
(1, 'AZAD-FAMILY-BUSINESS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ledger_books`
--

CREATE TABLE `tbl_ledger_books` (
  `id` int(11) NOT NULL,
  `ledger_book_name` text NOT NULL,
  `tbl_business_book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_ledger_books`
--

INSERT INTO `tbl_ledger_books` (`id`, `ledger_book_name`, `tbl_business_book_id`) VALUES
(1, 'DAILY-STATEMENT-SQSA', 1),
(2, 'DAILY-STATEMENT-H.K.TRADING', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ledger_book_transections`
--

CREATE TABLE `tbl_ledger_book_transections` (
  `id` int(11) NOT NULL,
  `date` text NOT NULL,
  `time` text NOT NULL,
  `description` text NOT NULL,
  `party_name` text NOT NULL,
  `accounts_head` text NOT NULL,
  `entry_by` text NOT NULL,
  `cash_in` int(11) NOT NULL,
  `cash_out` int(11) NOT NULL,
  `tbl_ledger_books_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_ledger_book_transections`
--

INSERT INTO `tbl_ledger_book_transections` (`id`, `date`, `time`, `description`, `party_name`, `accounts_head`, `entry_by`, `cash_in`, `cash_out`, `tbl_ledger_books_id`) VALUES
(1, '06-Feb-25', '2:30 PM', 'নগদ জমা- আবুল কালাম আজাদ', '', 'CASH-DEPOSIT', 'Sea-Queen-Shipping-Agencies', 50000, 0, 1),
(2, '15-Jun-25', '11:25 AM', 'খোকন স্যার- নগদ অগ্রিম জমা', '', '', 'Anisur Rahman', 0, 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transection_accounts_head`
--

CREATE TABLE `tbl_transection_accounts_head` (
  `id` int(11) NOT NULL,
  `accounts_head_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_business_book`
--
ALTER TABLE `tbl_business_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ledger_books`
--
ALTER TABLE `tbl_ledger_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ledger_book_transections`
--
ALTER TABLE `tbl_ledger_book_transections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transection_accounts_head`
--
ALTER TABLE `tbl_transection_accounts_head`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_business_book`
--
ALTER TABLE `tbl_business_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_ledger_books`
--
ALTER TABLE `tbl_ledger_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_ledger_book_transections`
--
ALTER TABLE `tbl_ledger_book_transections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `tbl_transection_accounts_head`
--
ALTER TABLE `tbl_transection_accounts_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
