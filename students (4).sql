-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 01:27 PM
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
-- Database: `students`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_subjects`
--

CREATE TABLE `failed_subjects` (
  `Failed_Subject_ID` int(11) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Subject_Name` varchar(100) DEFAULT NULL,
  `Subject_Code` varchar(20) DEFAULT NULL,
  `amountEthers` double DEFAULT NULL,
  `paid` varchar(3) DEFAULT 'no',
  `txn_id` int(11) DEFAULT NULL,
  `amountRupees` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `failed_subjects`
--

INSERT INTO `failed_subjects` (`Failed_Subject_ID`, `Student_ID`, `Subject_Name`, `Subject_Code`, `amountEthers`, `paid`, `txn_id`, `amountRupees`) VALUES
(28, 27, 'oof', '2548', 0.000001, 'yes', 42, 1),
(29, 27, 'wns', '951', 0.000002, 'no', NULL, 2),
(30, 28, 'oof', '2548', 0.000001, 'yes', 41, 1000),
(31, 29, 'SEP', '123', 0.000001, 'yes', 47, 10),
(32, 29, 'OOP', '5364', 0.000001, 'yes', 45, 1000),
(33, 29, 'WNS', '8968', 0.000001, 'no', NULL, 1000),
(34, 29, 'AWP', '8931', 0.000001, 'no', NULL, 1000),
(35, 29, 'IOT', '8926', 0.000001, 'no', NULL, 1000),
(36, 29, 'FLAT', '2549', 0.000001, 'no', NULL, 1000),
(37, 30, 'OOP', '5364', 0.000001, 'yes', 48, 1000),
(38, 30, 'WNS', '8968', 0.000001, 'no', NULL, 1000),
(39, 30, 'AWP', '8931', 0.000001, 'no', NULL, 1000),
(40, 30, 'IOT', '8926', 0.000001, 'no', NULL, 1000),
(41, 27, 'OOP', '5364', 0.000001, 'no', NULL, 1000),
(42, 27, 'AWP', '8931', 0.000001, 'no', NULL, 1000),
(43, 31, 'OOP', '5364', 0.000001, 'no', NULL, 1000),
(44, 31, 'AEP', '8931', 0.000001, 'no', NULL, 1000),
(45, 31, 'IOT', '8926', 0.000001, 'no', NULL, 1000),
(46, 31, 'FLAT', '2549', 0.000001, 'no', NULL, 1000),
(47, 32, 'oops', 'cutm1009', 0.000001, 'no', NULL, 100);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Student_ID` int(11) NOT NULL,
  `Registration_Number` varchar(50) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `branch` varchar(10) NOT NULL,
  `course` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Student_ID`, `Registration_Number`, `Name`, `branch`, `course`) VALUES
(27, '1', 'a', 'CSE', 'BTECH'),
(28, '2', 'b', 'CSE', 'BTECH'),
(29, '12345', 'Arjun', 'CIC', 'Btech'),
(30, '211114', 'Rajesh', 'BSC', 'Radiology'),
(31, '215936', 'Kaartik', 'CSE', 'BTECH'),
(32, '100011', 'harshi', 'cic', 'btech');

-- --------------------------------------------------------

--
-- Table structure for table `student_credentials`
--

CREATE TABLE `student_credentials` (
  `Credential_ID` int(11) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Registration_Number` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_credentials`
--

INSERT INTO `student_credentials` (`Credential_ID`, `Student_ID`, `Registration_Number`, `Password`) VALUES
(13, 27, '1', 'a'),
(14, 28, '2', 'a'),
(15, 29, '12345', 'qwerty'),
(16, 30, '211114', 'qwerty'),
(17, 31, '215936', 'qwerty');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `Transaction_ID` binary(66) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Payment_Type` varchar(50) DEFAULT NULL,
  `txn_amount` double DEFAULT NULL,
  `txn_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`Transaction_ID`, `Student_ID`, `Payment_Type`, `txn_amount`, `txn_id`) VALUES
(0x7061795f4f48317274383251445652543964000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 27, 'Rupees', 1, 39),
(0x7061795f4f4834436a6137796a6d667a6651000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 28, 'Rupees', 1000, 40),
(0x307863653236663837613461626232323632313636626531643665633231366334616332623436643631333532623139313431343535306531396434623962386132, 28, 'Ethers', 0.000001, 41),
(0x7061795f4f48374f4c4670616b3977365041000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 27, 'Rupees', 1, 42),
(0x7061795f4f484e446a68534e34774c576852000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 29, 'Rupees', 1000, 43),
(0x7061795f4f484e48566477506c514f613457000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 29, 'Rupees', 1000, 44),
(0x7061795f4f484e4c6c4456556f7276336f75000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 29, 'Rupees', 1000, 45),
(0x307861373631656130613332643331346534623363376562323963663239323263363166343931646163666638373666366633346539316135663931663135386139, 29, 'Ethers', 0.000001, 46),
(0x7061795f4f484e696d4256645a5750417865000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 29, 'Rupees', 10, 47),
(0x307836613166653564373364363963333034653037643332633962636561323233326431343534653830323137666637306234666235373939313165353131396630, 30, 'Ethers', 0.000001, 48);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_subjects`
--
ALTER TABLE `failed_subjects`
  ADD PRIMARY KEY (`Failed_Subject_ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `txn_id` (`txn_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Student_ID`),
  ADD UNIQUE KEY `Registration_Number` (`Registration_Number`);

--
-- Indexes for table `student_credentials`
--
ALTER TABLE `student_credentials`
  ADD PRIMARY KEY (`Credential_ID`),
  ADD UNIQUE KEY `Registration_Number` (`Registration_Number`),
  ADD KEY `Student_ID` (`Student_ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`txn_id`),
  ADD KEY `Student_ID` (`Student_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_subjects`
--
ALTER TABLE `failed_subjects`
  MODIFY `Failed_Subject_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Student_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `student_credentials`
--
ALTER TABLE `student_credentials`
  MODIFY `Credential_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `txn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `failed_subjects`
--
ALTER TABLE `failed_subjects`
  ADD CONSTRAINT `failed_subjects_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`Student_ID`),
  ADD CONSTRAINT `failed_subjects_ibfk_2` FOREIGN KEY (`txn_id`) REFERENCES `transactions` (`txn_id`);

--
-- Constraints for table `student_credentials`
--
ALTER TABLE `student_credentials`
  ADD CONSTRAINT `student_credentials_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`Student_ID`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`Student_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
