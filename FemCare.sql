-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 12, 2025 at 07:31 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `FemCare`
--

-- --------------------------------------------------------

--
-- Table structure for table `cycle_entries`
--

CREATE TABLE `cycle_entries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `flow_intensity` int(11) DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `moods` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `cycle_length` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cycle_entries`
--

INSERT INTO `cycle_entries` (`id`, `user_id`, `start_date`, `end_date`, `flow_intensity`, `symptoms`, `moods`, `notes`, `cycle_length`, `created_at`) VALUES
(4, 1, '2025-01-11', '2025-01-17', 3, '[\"Headache\"]', '[]', '', NULL, '2025-01-12 14:02:26'),
(6, 1, '2025-01-05', '2025-01-15', 3, '[]', '[\"Happy\"]', '', 6, '2025-01-12 14:02:45'),
(7, 1, '2025-01-12', '2025-01-20', 3, '\"\"', '[\"Happy\"]', '', 20, '2025-01-12 17:20:02'),
(8, 3, '2025-01-12', '2025-01-16', 3, '[\"Cramps\"]', '[\"Happy\"]', '', NULL, '2025-01-12 18:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `sympton`
--

CREATE TABLE `sympton` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `flow_intensity` varchar(50) DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `moods` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `date_of_birth`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Hirusha', 'Dilshan', 'hirushadilshan255@gmail.com', '0776534536', '2003-10-16', '$2y$10$0SmoKvMHiPPVjiCwvwRm.uILW7hv6/0nPBbKjd3R5ZE2HIVOgKDbe', '2025-01-09 07:31:32', '2025-01-09 07:31:32'),
(2, 'Dilshan', 'Perera', 'hirushashroff1234@gmail.com', '077765655', '2025-01-04', '$2y$10$PWx/e9PARmJw1g8MWuaXu.kK1YDcCydKyirYsuDo6oQUK1XAHkmrG', '2025-01-09 07:42:50', '2025-01-09 07:42:50'),
(3, 'Wethmi', 'Wijethilaka', 'wethmi@gmail.com', '0775434563', '2003-06-02', '$2y$10$4nzHizUlq4j73tWARM4Z5.bR0il756r.HG2TcpTWSj4KWeBrU8E3C', '2025-01-09 08:05:07', '2025-01-09 08:05:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cycle_entries`
--
ALTER TABLE `cycle_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sympton`
--
ALTER TABLE `sympton`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cycle_entries`
--
ALTER TABLE `cycle_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sympton`
--
ALTER TABLE `sympton`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cycle_entries`
--
ALTER TABLE `cycle_entries`
  ADD CONSTRAINT `cycle_entries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sympton`
--
ALTER TABLE `sympton`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
