-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2021 at 08:16 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_banking`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_no` varchar(50) NOT NULL,
  `c_id` int(5) NOT NULL,
  `f_id` int(5) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `account_balance` double(10,2) NOT NULL,
  `unclear_balance` double(10,2) NOT NULL,
  `account_open_date` date NOT NULL,
  `interest` double(10,2) NOT NULL,
  `account_status` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_no`, `c_id`, `f_id`, `account_type`, `account_balance`, `unclear_balance`, `account_open_date`, `interest`, `account_status`, `datetime`) VALUES
('OPB0731010001', 1, 0, 'Saving Account', 53491.00, 10000.00, '2021-04-19', 7.50, 'Active', '2021-04-19 08:58:38'),
('OPB0731010002', 2, 0, 'Saving Account', 34300.00, 0.00, '2021-04-19', 6.00, 'Active', '2021-04-19 08:58:49'),
('OPB0731010003', 1, 2, 'Fixed Deposite Account', 15000.00, 0.00, '2021-04-19', 100.00, 'Active', '2021-04-19 09:44:10'),
('OPB0731010004', 2, 2, 'Fixed Deposite Account', 10000.00, 0.00, '2021-04-19', 100.00, 'Active', '2021-04-19 12:10:49'),
('OPB0731010005', 1, 1, 'Fixed Deposite Account', 6000.00, 0.00, '2021-04-19', 5.00, 'Active', '2021-04-19 18:19:22');

-- --------------------------------------------------------

--
-- Table structure for table `account_master`
--

CREATE TABLE `account_master` (
  `id` int(5) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `min_balance` double(10,2) NOT NULL,
  `interest` double(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `datetime` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account_master`
--

INSERT INTO `account_master` (`id`, `account_type`, `prefix`, `min_balance`, `interest`, `status`, `datetime`) VALUES
(2, 'Current Account', 'CA', 2000.00, 7.50, 'Active', '2021-03-14 17:44:54'),
(3, 'Fixed Deposite Account', 'FDA', 1000.00, 7.50, 'Active', '2021-04-16 14:26:08'),
(1, 'Saving Account', 'SA', 1000.00, 6.00, 'Active', '2021-03-14 17:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `bid` int(5) NOT NULL,
  `ifsccode` varchar(10) NOT NULL,
  `bname` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetime` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`bid`, `ifsccode`, `bname`, `address`, `city`, `state`, `country`, `status`, `datetime`) VALUES
(1, 'OBP00001', 'Surat', 'SH 602, Shreeji Nagar-2, Uttran Station', 'Surat', 'Gujarat', 'India', 'Active', '2021-03-25 10:35:30'),
(2, 'OBP00002', 'Vadodara', 'Alkapuri Petrol Pump, RC Dutt Rd, opp. Alkapuri, A', 'Vadodara', 'Gujarat', 'India', 'Active', '2021-03-25 10:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `card_id` int(5) NOT NULL,
  `card_application_number` varchar(15) NOT NULL,
  `card_no` varchar(20) NOT NULL,
  `c_id` int(5) NOT NULL,
  `id` int(5) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `cvv` int(5) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetime` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`card_id`, `card_application_number`, `card_no`, `c_id`, `id`, `reason`, `startdate`, `enddate`, `cvv`, `status`, `datetime`) VALUES
(1, 'CT0000000545320', '5453200000000002', 1, 2, 'To Apply Debit Card', '2021-04-26', '2026-04-26', 918, 'Approved', '2021-04-26 22:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `card_type_master`
--

CREATE TABLE `card_type_master` (
  `id` int(5) NOT NULL,
  `card_type` varchar(20) NOT NULL,
  `prefix` varchar(20) NOT NULL,
  `min_amt` double(10,2) NOT NULL,
  `max_amt` double(10,2) NOT NULL,
  `terms` int(5) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetime` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `card_type_master`
--

INSERT INTO `card_type_master` (`id`, `card_type`, `prefix`, `min_amt`, `max_amt`, `terms`, `status`, `datetime`) VALUES
(1, 'Credit Master Card', 'CMC', 1000.00, 1000.00, 2, 'Active', '2021-04-16 13:51:47'),
(2, 'Debit Master Card', 'DMCC', 1000.00, 50000.00, 5, 'Active', '2021-04-16 13:52:42'),
(4, 'Credit RuPay Card', 'CRC', 1000.00, 1000.00, 3, 'Active', '2021-05-06 11:09:04');

-- --------------------------------------------------------

--
-- Table structure for table `customers_master`
--

CREATE TABLE `customers_master` (
  `c_id` int(5) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `idproof` varchar(50) NOT NULL,
  `h_no` int(10) NOT NULL,
  `locality` varchar(50) NOT NULL,
  `ifsccode` varchar(10) NOT NULL,
  `pincode` int(6) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `adharnumber` varchar(14) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `marital` varchar(50) NOT NULL,
  `occuption` varchar(50) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `token` varchar(15) NOT NULL,
  `pin` varchar(50) NOT NULL,
  `accountstatus` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers_master`
--

INSERT INTO `customers_master` (`c_id`, `f_name`, `l_name`, `email`, `phone`, `photo`, `idproof`, `h_no`, `locality`, `ifsccode`, `pincode`, `city`, `state`, `country`, `adharnumber`, `gender`, `birthdate`, `marital`, `occuption`, `account_type`, `password`, `token`, `pin`, `accountstatus`, `datetime`) VALUES
(1, 'Maulik', 'Kachchhi', 'maulikkachchhi2000@gmail.com', '9537706261', 'avatar04.jpg', '', 49, '49,Sataadhar Society,Behind Sarsawati School,A.K.R', 'OBP00001', 395008, 'Surat', '', '0', '393900832583', 'Male', '2000-02-08', 'Single', 'Professional', 'Saving Account', 'Mk@007', '1ad7d94f8902e81', '7890', 'active', '2021-04-18 22:16:37'),
(2, 'Raj', 'Kachadiya', 'rk@gmail.com', '8563214476', 'Photo.jpg', '', 50, 'Sardar Society', 'OBP00001', 395008, 'Surat', '', '0', '393900832581', 'Male', '2001-02-05', 'Single', 'Professional', 'Saving Account', 'raj@12345', '6179c2b109467f6', '123456', 'active', '2021-04-18 22:18:31'),
(3, 'Kishan', 'Jodhani', 'kishanjodhani20@gmail.com', '8536574123', 'DSCN00433 (2).jpg', '', 59, '49,Sataadhar Society,Behind Sarsawati School,A.K.R', 'OBP00002', 395008, 'Surat', '', '0', '393900832583', 'Male', '2000-02-08', 'Single', 'Professional', 'Saving Account', 'Kishan@123', 'ede6c8cd63eb8fc', '123456', 'Inactive', '2021-04-19 17:51:56'),
(4, 'Geet', 'Patel', 'geetpatel20@gmail.com', '7569832569', '2.jpg', '', 50, 'Lord Plazza', 'OBP00001', 395008, 'Surat', '', '0', '39850456854569', 'Male', '2001-02-05', 'Single', 'Student', 'Saving Account', 'Geet@123', '221e48520318706', '123456', 'Inactive', '2021-04-19 19:19:24');

-- --------------------------------------------------------

--
-- Table structure for table `employees_master`
--

CREATE TABLE `employees_master` (
  `id` int(10) NOT NULL,
  `ifsccode` varchar(10) NOT NULL,
  `ename` varchar(50) NOT NULL,
  `loginid` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `token` varchar(15) NOT NULL,
  `employee_type` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `datetime` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees_master`
--

INSERT INTO `employees_master` (`id`, `ifsccode`, `ename`, `loginid`, `email`, `contact`, `photo`, `pwd`, `token`, `employee_type`, `status`, `create_date`, `datetime`) VALUES
(1, 'OBP00001', 'Maulik', 'administrator', 'maulikkachchhi2000@gmail.com', '9537706261', 'avatar04.jpg', 'Mk@123', '3b2a61679ed336a', 'Admin', 'Active', '2021-05-07', '2021-05-07 09:32:02'),
(2, 'OBP00001', 'Darshak', 'Darshak', 'darshakkachchhi009@gmail.com', '9067611767', 'user1-128x128.jpg', 'Dk@123', '0311adcffd5131a', 'Staff', 'Active', '2021-05-07', '2021-05-07 09:33:44'),
(3, 'OBP00002', 'Dharmik', 'Dharmik', 'dharmikkapupara123@gmail.com', '8354469856', '', 'Dk@123', 'bc127dc9c1a443c', 'Manager', 'Active', '2021-05-07', '2021-05-07 09:34:43'),
(4, 'OBP00001', 'Yash', 'Yash', 'maulikkachchhi0208@gmail.com', '9537706261', 'avatar04.jpg', 'Yk@007', '0879ce6a6961eda', 'Staff', 'Active', '2021-05-07', '2021-05-07 09:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `fixed_deposite`
--

CREATE TABLE `fixed_deposite` (
  `f_id` int(5) NOT NULL,
  `d_type` varchar(20) NOT NULL,
  `prefix` varchar(20) NOT NULL,
  `min_amt` double(10,2) NOT NULL,
  `max_amt` double(10,2) NOT NULL,
  `interest` double(10,2) NOT NULL,
  `terms` int(5) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetime` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fixed_deposite`
--

INSERT INTO `fixed_deposite` (`f_id`, `d_type`, `prefix`, `min_amt`, `max_amt`, `interest`, `terms`, `status`, `datetime`) VALUES
(1, 'Lakhs Plan', 'LP', 5000.00, 100000.00, 5.00, 2, 'Active', '2021-03-23 10:00:30'),
(2, 'Double Plan', 'DP', 10000.00, 100000.00, 100.00, 10, 'Active', '2021-03-23 10:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int(10) NOT NULL,
  `loan_account_number` varchar(20) NOT NULL,
  `c_id` int(10) NOT NULL,
  `id` int(5) NOT NULL,
  `loan_amount` double(10,2) NOT NULL,
  `intrest` double(10,2) NOT NULL,
  `created_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetime` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loan_id`, `loan_account_number`, `c_id`, `id`, `loan_amount`, `intrest`, `created_date`, `status`, `datetime`) VALUES
(1, 'LAN0000001', 1, 3, 150000.00, 10500.00, '2021-04-19', 'Approved', '2021-04-19 16:47:45'),
(2, 'LAN0000002', 1, 4, 110000.00, 7700.00, '2021-04-19', 'Pending', '2021-04-19 18:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `loan_payment`
--

CREATE TABLE `loan_payment` (
  `payment_id` int(5) NOT NULL,
  `c_id` int(5) NOT NULL,
  `loan_account_number` varchar(20) NOT NULL,
  `loan_amt` double(10,2) NOT NULL,
  `interest` double(10,2) NOT NULL,
  `total_amt` double(10,2) NOT NULL,
  `paid` float(10,2) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `balance` double(10,2) NOT NULL,
  `paid_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan_payment`
--

INSERT INTO `loan_payment` (`payment_id`, `c_id`, `loan_account_number`, `loan_amt`, `interest`, `total_amt`, `paid`, `payment_type`, `balance`, `paid_date`) VALUES
(2, 1, 'LAN0000001', 150000.00, 7.00, 160500.00, 5000.00, 'Cash', 155500.00, '2021-04-20'),
(3, 1, 'LAN0000001', 150000.00, 7.00, 155500.00, 1000.00, 'Cash', 154500.00, '2021-04-20'),
(4, 1, 'LAN0000001', 150000.00, 7.00, 160500.00, 1000.00, 'Debit', 159500.00, '2021-04-24');

-- --------------------------------------------------------

--
-- Table structure for table `loan_type_master`
--

CREATE TABLE `loan_type_master` (
  `id` int(5) NOT NULL,
  `loan_type` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `min_amt` int(5) NOT NULL,
  `max_amt` double(10,2) NOT NULL,
  `interest` double(10,2) NOT NULL,
  `terms` int(5) NOT NULL,
  `status` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan_type_master`
--

INSERT INTO `loan_type_master` (`id`, `loan_type`, `prefix`, `min_amt`, `max_amt`, `interest`, `terms`, `status`, `datetime`) VALUES
(1, 'Home Loan', 'HL', 50000, 1000000.00, 6.50, 10, 'Inactive', '2021-03-14 17:53:39'),
(2, 'Car Loan', 'CL', 50000, 1000000.00, 8.50, 4, 'Active', '2021-03-14 17:53:55'),
(3, 'Personal Loan', 'PL', 100000, 2000000.00, 7.00, 1, 'Active', '2021-03-14 17:54:10'),
(4, 'Gold Loan', 'GL', 100000, 2000000.00, 7.00, 2, 'Active', '2021-03-14 17:54:34'),
(5, 'Payday Loan', 'PDL', 50000, 500000.00, 7.50, 3, 'Active', '2021-03-14 17:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE `mail` (
  `m_id` int(5) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(100) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `reciverid` int(10) NOT NULL,
  `admin_response` varchar(100) NOT NULL,
  `datetime` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mail`
--

INSERT INTO `mail` (`m_id`, `subject`, `message`, `account_no`, `status`, `sender_id`, `reciverid`, `admin_response`, `datetime`) VALUES
(1, 'Verify Accounts', '', 'OPB0731010001', 'Adminstrator Replied', 1, 5, 'Please Verification Documentation', '2021-04-19 17:48:47'),
(2, 'Approve Loans', 'Dear Sir/Madam \r\nAppdrove Loan', 'OPB0731010005', 'Waiting for Response', 1, 0, '', '2021-04-19 18:21:16'),
(3, 'Apply Loan', 'loan apply', 'OPB0731010005', 'Waiting for Response', 1, 0, '', '2021-04-28 12:12:27'),
(4, 'Hello Welcome To Octo Prime E-banking', '', 'OPB0731010002', 'Adminstrator Replied', 2, 5, 'Hello Welcome To Octo Prime E-banking', '2021-04-30 10:58:17');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `news` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `datetime` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `category`, `image`, `news`, `status`, `datetime`) VALUES
(2, 'Online Transaction', 'Accounts', '1.jpg', 'Online transaction processing (OLTP) is information systems that facilitate and manage transaction-oriented applications, typically for data entry and retrieval transaction processing. So online transaction is done with the help of the internet.', 'Active', '2021-04-25 21:07:19'),
(3, 'ATM Verification and pin', 'ATM Cards', 'ja.jpg', 'An automated teller machine (ATM) is an electronic banking outlet that allows customers to complete basic transactions without the aid of a branch representative or teller. Anyone with a credit card or debit card can access cash at most ATMs.', 'Active', '2021-04-25 21:55:39'),
(4, 'RBI Monetary Policy Highlights', 'Server', 'rbi-explained.jpg', 'Key highlights of RBI monetary policy as announced on 7th April 2021, are: RBI keeps Repo Rate unchanged at 4.00%. Reverse repo rate also remains unchanged at 3.35%. ... TLTRO scheme is being extended by 6 months, up to September 30, 2021 this will help i', 'Active', '2021-04-26 16:36:30'),
(5, 'Online Banking', 'Server', 'banking_digital_transformation.png', 'Online banking, also known as internet banking, web banking or home banking, is an electronic payment system that enables customers of a bank or other financial institution to conduct a range of financial transactions through the financial institution\'s w', 'Active', '2021-04-26 16:39:38'),
(6, 'Digital banking ', 'Server', '53231627-infographic-of-e-banking.jpg', 'Open A Digital Bank Account Without Ever Stepping Out Of Your Home. Open A Zero-Balance Bank Account, Open The Door To Infinite Possibilities. Never Miss A Payment. Use Our Award-Winning App. Choose Kotak. Get 811 With No Paperwork.', 'Active', '2021-04-26 16:40:42'),
(7, 'What Are the 9 Major Types of Financial Institutio', 'Server', 'Banking-Services-in-India-1.jpg', 'In today\'s financial services marketplace, a financial institution exists to provide a wide variety of deposit, lending and investment products to individuals, businesses or both. While some financial institutions focus on providing services and accounts ', 'Active', '2021-04-26 16:42:47'),
(8, 'Privacy Policy banking System', 'Select', 'images.jpg', 'The Bank has adopted the privacy policy aimed at protecting the personal information entrusted and disclosed by the customers [“the Policy”]. This policy governs the way in which the Bank collects, uses, discloses, stores, secures and disposes of personal', 'Active', '2021-04-30 09:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `registered_payee`
--

CREATE TABLE `registered_payee` (
  `registered_payee_id` int(5) NOT NULL,
  `c_id` int(5) NOT NULL,
  `registered_payee_type` varchar(20) NOT NULL,
  `payee_name` varchar(25) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `account_type` varchar(20) NOT NULL,
  `bank_name` varchar(20) NOT NULL,
  `ifsccode` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registered_payee`
--

INSERT INTO `registered_payee` (`registered_payee_id`, `c_id`, `registered_payee_type`, `payee_name`, `account_no`, `account_type`, `bank_name`, `ifsccode`, `status`) VALUES
(1, 1, 'OctoPrime E-Banking', 'Raj Kachadiya', 'OPB0731010002', 'Saving Account', 'OctoPrime E-Banking', 'OBP00001', 'Active'),
(3, 1, 'Other', 'Darshak Kachchhi', '07310100021941', 'Saving Account', 'Bank Of Baroda', 'BOB0FULPAD', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `trans_id` int(10) NOT NULL,
  `registered_payee_id` int(10) NOT NULL,
  `from_account_no` varchar(20) NOT NULL,
  `to_account_no` varchar(20) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `comission` double(10,2) NOT NULL,
  `particulars` varchar(100) NOT NULL,
  `transaction_type` varchar(20) NOT NULL,
  `trans_date_time` date NOT NULL,
  `approve_date_time` date NOT NULL,
  `payment_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`trans_id`, `registered_payee_id`, `from_account_no`, `to_account_no`, `amount`, `comission`, `particulars`, `transaction_type`, `trans_date_time`, `approve_date_time`, `payment_status`) VALUES
(6, 0, '', 'OPB0731010001', 50000.00, 0.00, 'Account opening balance', 'Credit', '2021-04-19', '2021-04-19', 'Approved'),
(7, 0, '', 'OPB0731010002', 30000.00, 0.00, 'Account opening balance', 'Credit', '2021-04-19', '2021-04-19', 'Approved'),
(9, 0, 'OPB0731010003', 'OPB0731010001', 15000.00, 0.00, 'To The Invesment Fixed Deposite Account', 'Debit', '2021-04-19', '2021-04-19', 'Active'),
(10, 0, 'OPB0731010004', 'OPB0731010002', 10000.00, 0.00, 'To The Invesment Fixed Deposite Account', 'Debit', '2021-04-19', '2021-04-19', 'Active'),
(11, 0, 'OPB0731010005', 'OPB0731010001', 6000.00, 0.00, 'To The Invesment Fixed Deposite Account', 'Debit', '2021-04-19', '2021-04-19', 'Active'),
(13, 0, '', 'OPB0731010001', 5000.00, 0.00, 'To Cash add Deposite', 'Cheque', '2021-04-19', '2021-04-19', 'Pending'),
(14, 0, '', 'OPB0731010001', 5000.00, 0.00, 'To Cash add Deposite        ', 'Cash', '2021-04-19', '2021-04-19', 'Active'),
(15, 0, '', 'OPB0731010001', 5000.00, 0.00, 'To Cheque:2001        ', 'Cheque', '2021-04-19', '2021-04-19', 'Pending'),
(16, 0, '', 'OPB0731010001', 17.00, 0.00, 'To The SMS Charge        ', 'Debit', '2021-04-20', '2021-04-20', 'Active'),
(17, 0, '', 'OPB0731010001', 120.00, 0.00, 'To The ATM Charge        ', 'Debit', '2021-04-20', '2021-04-20', 'Active'),
(18, 0, '', 'OPB0731010001', 5000.00, 0.00, 'To add Cash', 'Cash', '2021-04-20', '2021-04-20', 'Active'),
(19, 0, '', 'OPB0731010001', 17.00, 0.00, 'Sms Charge        ', 'Debit', '2021-04-20', '2021-04-20', 'Active'),
(20, 3, '07310100021941', 'OPB0731010001', 1505.00, 5.00, 'To Fund Tranfer Darshak Kachchhi', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(21, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'To Fund Transfer', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(22, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'To Fund Tranfer Account', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(23, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'Fund Transfer raj', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(24, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'To Fund Transfer Raj1', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(25, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'fund transfer raj2', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(26, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'Fund Tranfer rk', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(27, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'fund t', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(28, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'to fjun', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(29, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'fund trs', 'Credit', '2021-04-22', '2021-04-22', 'Active'),
(30, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fd', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(31, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'fd', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(32, 3, '07310100021941', 'OPB0731010001', 1005.00, 5.00, 'FD DKS', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(33, 3, '07310100021941', 'OPB0731010001', 1005.00, 5.00, 'FD Dk', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(35, 1, 'OPB0731010001', 'OPB0731010002', 200.00, 0.00, 'fds ra', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(36, 1, 'OPB0731010002', 'OPB0731010001', 200.00, 0.00, 'fds ra', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(38, 1, 'OPB0731010001', 'OPB0731010002', 100.00, 0.00, 'fds', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(39, 1, 'OPB0731010002', 'OPB0731010001', 100.00, 0.00, 'fds', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(40, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fs', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(41, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'fs', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(42, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fs', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(43, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'fs', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(44, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fds', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(45, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'fds', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(46, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fds', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(47, 1, 'OPB0731010002', 'OPB0731010001', 1000.00, 0.00, 'fds', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(50, 3, '07310100021941', 'OPB0731010001', 1005.00, 5.00, 'fds', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(53, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'd', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(54, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'd', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(55, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fds', 'Debit', '2021-04-23', '2021-04-23', 'Active'),
(56, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fds', 'Credit', '2021-04-23', '2021-04-23', 'Active'),
(57, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fs', 'Debit', '2021-04-24', '2021-04-24', 'Active'),
(58, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fs', 'Credit', '2021-04-24', '2021-04-24', 'Active'),
(59, 0, '', 'OPB0731010001', 1000.00, 0.00, 'To Paid Loan Amount', 'Debit', '2021-04-24', '2021-04-24', 'Active'),
(60, 0, '', 'OPB0731010001', 1000.00, 0.00, 'To Paid Loan Amount', 'Debit', '2021-04-24', '2021-04-24', 'Active'),
(61, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fds', 'Debit', '2021-04-27', '2021-04-27', 'Active'),
(62, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fds', 'Credit', '2021-04-27', '2021-04-27', 'Active'),
(63, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fds', 'Debit', '2021-04-28', '2021-04-28', 'Active'),
(64, 1, 'OPB0731010001', 'OPB0731010002', 1000.00, 0.00, 'fds', 'Credit', '2021-04-28', '2021-04-28', 'Active'),
(65, 0, '', 'OPB0731010001', 50.00, 0.00, 'To Sms Charge        ', 'Debit', '2021-05-03', '2021-05-03', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_no`),
  ADD KEY `accounts_ibfk_1` (`account_type`),
  ADD KEY `fkaccust` (`c_id`),
  ADD KEY `f_id` (`f_id`);

--
-- Indexes for table `account_master`
--
ALTER TABLE `account_master`
  ADD PRIMARY KEY (`account_type`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`ifsccode`),
  ADD UNIQUE KEY `bid` (`bid`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `fk_cardtype_card` (`id`),
  ADD KEY `fk_card_cust` (`c_id`);

--
-- Indexes for table `card_type_master`
--
ALTER TABLE `card_type_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_master`
--
ALTER TABLE `customers_master`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `fk_cust_branch` (`ifsccode`);

--
-- Indexes for table `employees_master`
--
ALTER TABLE `employees_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_branch` (`ifsccode`);

--
-- Indexes for table `fixed_deposite`
--
ALTER TABLE `fixed_deposite`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `fk_loan_cust` (`c_id`),
  ADD KEY `fk_loan_loan_type` (`id`);

--
-- Indexes for table `loan_payment`
--
ALTER TABLE `loan_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_loan_payment_cust` (`c_id`);

--
-- Indexes for table `loan_type_master`
--
ALTER TABLE `loan_type_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `fk_ac_mail` (`account_no`),
  ADD KEY `fk_sender_id` (`sender_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_payee`
--
ALTER TABLE `registered_payee`
  ADD PRIMARY KEY (`registered_payee_id`),
  ADD KEY `fk_cust_payee` (`c_id`),
  ADD KEY `fk_acc_no_payee` (`account_no`),
  ADD KEY `fk_account_type_payee` (`account_type`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `fk_accunts_trans` (`to_account_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_master`
--
ALTER TABLE `account_master`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `bid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `card_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `card_type_master`
--
ALTER TABLE `card_type_master`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers_master`
--
ALTER TABLE `customers_master`
  MODIFY `c_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees_master`
--
ALTER TABLE `employees_master`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fixed_deposite`
--
ALTER TABLE `fixed_deposite`
  MODIFY `f_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loan_payment`
--
ALTER TABLE `loan_payment`
  MODIFY `payment_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `loan_type_master`
--
ALTER TABLE `loan_type_master`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mail`
--
ALTER TABLE `mail`
  MODIFY `m_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `registered_payee`
--
ALTER TABLE `registered_payee`
  MODIFY `registered_payee_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `trans_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`account_type`) REFERENCES `account_master` (`account_type`),
  ADD CONSTRAINT `fkaccust` FOREIGN KEY (`c_id`) REFERENCES `customers_master` (`c_id`);

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `fk_card_cust` FOREIGN KEY (`c_id`) REFERENCES `customers_master` (`c_id`),
  ADD CONSTRAINT `fk_cardtype_card` FOREIGN KEY (`id`) REFERENCES `card_type_master` (`id`);

--
-- Constraints for table `customers_master`
--
ALTER TABLE `customers_master`
  ADD CONSTRAINT `fk_cust_branch` FOREIGN KEY (`ifsccode`) REFERENCES `branch` (`ifsccode`);

--
-- Constraints for table `employees_master`
--
ALTER TABLE `employees_master`
  ADD CONSTRAINT `fk_branch` FOREIGN KEY (`ifsccode`) REFERENCES `branch` (`ifsccode`);

--
-- Constraints for table `fixed_deposite`
--
ALTER TABLE `fixed_deposite`
  ADD CONSTRAINT `fk_type_cust` FOREIGN KEY (`f_id`) REFERENCES `accounts` (`f_id`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `fk_loan_cust` FOREIGN KEY (`c_id`) REFERENCES `customers_master` (`c_id`),
  ADD CONSTRAINT `fk_loan_loan_type` FOREIGN KEY (`id`) REFERENCES `loan_type_master` (`id`);

--
-- Constraints for table `loan_payment`
--
ALTER TABLE `loan_payment`
  ADD CONSTRAINT `fk_loan_payment_cust` FOREIGN KEY (`c_id`) REFERENCES `customers_master` (`c_id`);

--
-- Constraints for table `mail`
--
ALTER TABLE `mail`
  ADD CONSTRAINT `fk_ac_mail` FOREIGN KEY (`account_no`) REFERENCES `accounts` (`account_no`),
  ADD CONSTRAINT `fk_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `customers_master` (`c_id`);

--
-- Constraints for table `registered_payee`
--
ALTER TABLE `registered_payee`
  ADD CONSTRAINT `fk_account_type_payee` FOREIGN KEY (`account_type`) REFERENCES `accounts` (`account_type`),
  ADD CONSTRAINT `fk_cust_payee` FOREIGN KEY (`c_id`) REFERENCES `customers_master` (`c_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_accunts_trans` FOREIGN KEY (`to_account_no`) REFERENCES `accounts` (`account_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
