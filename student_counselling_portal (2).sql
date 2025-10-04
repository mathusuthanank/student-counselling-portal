-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 05:19 PM
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
-- Database: `student_counselling_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `counseling_sessions`
--

CREATE TABLE `counseling_sessions` (
  `id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `mentee_id` int(11) NOT NULL,
  `session_date` date NOT NULL,
  `session_time` time NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counseling_sessions`
--

INSERT INTO `counseling_sessions` (`id`, `mentor_id`, `mentee_id`, `session_date`, `session_time`, `notes`, `status`) VALUES
(51, 36, 40, '2025-03-21', '01:51:00', 'Had a doubts on career growth', 'scheduled'),
(53, 36, 52, '2025-03-22', '14:42:00', 'Review about semester perfomance', 'scheduled'),
(54, 36, 52, '2025-03-22', '15:48:00', 'Review about attendance percentage', 'scheduled'),
(56, 36, 52, '2025-03-22', '15:00:00', 'had review on semester details', 'scheduled'),
(57, 36, 52, '2025-03-28', '03:33:00', 'had a doubts on careers ', 'not scheduled'),
(59, 36, 52, '2025-04-07', '03:20:00', 'Career growth', 'scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `leave_type` enum('casual','medical','on_duty') NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','approved_by_tutor','rejected_by_tutor','approved_by_admin','rejected_by_admin') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `student_id`, `leave_type`, `from_date`, `to_date`, `description`, `status`, `created_at`) VALUES
(18, 52, 'on_duty', '2025-03-21', '2025-03-22', 'other college events', 'approved_by_admin', '2025-03-20 15:22:47'),
(19, 40, 'casual', '2025-03-21', '2025-03-22', 'brother marriage', 'rejected_by_tutor', '2025-03-20 15:42:35'),
(20, 40, 'medical', '2025-03-19', '2025-03-20', 'fever', 'approved_by_admin', '2025-03-20 15:46:03'),
(21, 52, 'on_duty', '2025-03-26', '2025-03-22', 'on regarding attending of Tancet exam', 'approved_by_admin', '2025-03-21 04:14:02'),
(24, 52, 'casual', '2025-03-22', '2025-03-22', 'leave for family function', 'approved_by_admin', '2025-03-21 09:25:57'),
(26, 52, 'on_duty', '2025-04-07', '2025-04-08', 'To participate in Abc institution event', 'rejected_by_admin', '2025-04-06 10:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`) VALUES
(139, 36, 'New counseling session scheduled with Arun on 2025-03-21 at 01:51. <a href=\"respond_session.php?session_id=51&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=51&action=reject\">Reject</a>', '2025-03-20 15:22:06'),
(140, 36, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=18&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=18&action=reject\">Reject</a>', '2025-03-20 15:22:47'),
(141, 1, 'Leave request approved by tutor. <a href=\"respond_leave_request.php?leave_id=18&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=18&action=reject\">Reject</a>', '2025-03-20 15:22:54'),
(142, 52, 'Your leave request has been approved by the tutor.', '2025-03-20 15:22:54'),
(143, 52, 'Your leave request has been approved by the admin.', '2025-03-20 15:23:14'),
(144, 36, 'New counseling session scheduled with kavin on 2025-03-13 at 02:04. <a href=\"respond_session.php?session_id=52&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=52&action=reject\">Reject</a>', '2025-03-20 15:34:24'),
(145, 37, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=19&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=19&action=reject\">Reject</a>', '2025-03-20 15:42:35'),
(146, 40, 'Your leave request has been rejected by the tutor.', '2025-03-20 15:43:56'),
(147, 37, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=20&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=20&action=reject\">Reject</a>', '2025-03-20 15:46:03'),
(148, 1, 'Leave request approved by tutor. <a href=\"respond_leave_request.php?leave_id=20&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=20&action=reject\">Reject</a>', '2025-03-20 15:46:13'),
(149, 40, 'Your leave request has been approved by the tutor.', '2025-03-20 15:46:13'),
(150, 40, 'Your leave request has been approved by the admin.', '2025-03-20 15:46:21'),
(151, 36, 'New counseling session scheduled with kavin on 2025-03-22 at 14:42. <a href=\"respond_session.php?session_id=53&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=53&action=reject\">Reject</a>', '2025-03-21 04:13:03'),
(152, 36, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=21&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=21&action=reject\">Reject</a>', '2025-03-21 04:14:02'),
(153, 1, 'Leave request approved by tutor. <a href=\"respond_leave_request.php?leave_id=21&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=21&action=reject\">Reject</a>', '2025-03-21 04:14:16'),
(154, 52, 'Your leave request has been approved by the tutor.', '2025-03-21 04:14:16'),
(155, 52, 'Your leave request has been approved by the admin.', '2025-03-21 04:14:35'),
(156, 36, 'New counseling session scheduled with kavin on 2025-03-22 at 15:48. <a href=\"respond_session.php?session_id=54&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=54&action=reject\">Reject</a>', '2025-03-21 05:19:12'),
(157, 36, 'New counseling session scheduled with kavin on 2025-03-21 at 16:59. <a href=\"respond_session.php?session_id=55&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=55&action=reject\">Reject</a>', '2025-03-21 05:30:12'),
(158, 36, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=22&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=22&action=reject\">Reject</a>', '2025-03-21 05:32:11'),
(159, 1, 'Leave request approved by tutor. <a href=\"respond_leave_request.php?leave_id=22&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=22&action=reject\">Reject</a>', '2025-03-21 05:32:37'),
(160, 52, 'Your leave request has been approved by the tutor.', '2025-03-21 05:32:37'),
(161, 52, 'Your leave request has been approved by the admin.', '2025-03-21 05:33:09'),
(162, 52, '', '2025-03-21 05:58:44'),
(163, 52, '', '2025-03-21 05:58:55'),
(164, 36, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=23&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=23&action=reject\">Reject</a>', '2025-03-21 06:00:36'),
(165, 1, 'Leave request approved by tutor. <a href=\"respond_leave_request.php?leave_id=23&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=23&action=reject\">Reject</a>', '2025-03-21 06:00:43'),
(166, 52, 'Your leave request has been approved by the tutor.', '2025-03-21 06:00:43'),
(167, 52, 'Your leave request has been approved by the admin.', '2025-03-21 06:00:53'),
(168, 36, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=24&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=24&action=reject\">Reject</a>', '2025-03-21 09:25:57'),
(169, 1, 'Leave request approved by tutor. <a href=\"respond_leave_request.php?leave_id=24&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=24&action=reject\">Reject</a>', '2025-03-21 09:26:14'),
(170, 52, 'Your leave request has been approved by the tutor.', '2025-03-21 09:26:14'),
(171, 52, 'Your leave request has been approved by the admin.', '2025-03-21 09:26:28'),
(172, 36, 'New counseling session scheduled with kavin on 2025-03-22 at 15:00. <a href=\"respond_session.php?session_id=56&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=56&action=reject\">Reject</a>', '2025-03-21 09:28:46'),
(173, 36, 'New counseling session scheduled with kavin on 2025-03-28 at 03:33. <a href=\"respond_session.php?session_id=57&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=57&action=reject\">Reject</a>', '2025-03-27 17:04:04'),
(174, 36, 'New counseling session scheduled with kavin on 2025-04-16 at 21:58. <a href=\"respond_session.php?session_id=58&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=58&action=reject\">Reject</a>', '2025-04-03 14:29:27'),
(175, 36, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=25&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=25&action=reject\">Reject</a>', '2025-04-03 14:31:50'),
(176, 52, 'Your leave request has been rejected by the tutor.', '2025-04-03 14:32:09'),
(177, 36, 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=26&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=26&action=reject\">Reject</a>', '2025-04-06 10:44:55'),
(178, 36, 'New counseling session scheduled with kavin on 2025-04-07 at 03:20. <a href=\"respond_session.php?session_id=59&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=59&action=reject\">Reject</a>', '2025-04-06 10:54:29'),
(179, 1, 'Leave request approved by tutor. <a href=\"respond_leave_request.php?leave_id=26&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=26&action=reject\">Reject</a>', '2025-04-06 11:51:47'),
(180, 52, 'Your leave request has been approved by the tutor.', '2025-04-06 11:51:47'),
(181, 52, 'Your leave request has been rejected by the admin.', '2025-04-23 15:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_student_allocation`
--

CREATE TABLE `staff_student_allocation` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `role` enum('mentor-mentee','tutor-student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_student_allocation`
--

INSERT INTO `staff_student_allocation` (`id`, `staff_id`, `student_id`, `role`) VALUES
(73, 37, 40, 'tutor-student'),
(74, 37, 41, 'tutor-student'),
(77, 36, 42, 'tutor-student'),
(78, 36, 43, 'tutor-student'),
(87, 36, 52, 'tutor-student'),
(89, 36, 52, 'mentor-mentee'),
(90, 36, 40, 'mentor-mentee'),
(91, 36, 40, 'tutor-student');

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `rollno` varchar(50) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `whatsapp_no` varchar(15) DEFAULT NULL,
  `email_official` varchar(255) NOT NULL,
  `email_personal` varchar(255) DEFAULT NULL,
  `programme_name` varchar(255) NOT NULL DEFAULT 'BSc Computer Technology',
  `medium_instruction` varchar(50) DEFAULT NULL,
  `year_enrollment` year(4) NOT NULL,
  `batch` varchar(50) NOT NULL,
  `native_state` varchar(255) DEFAULT NULL,
  `scholarship_details` text DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_contact` varchar(15) DEFAULT NULL,
  `father_occupation` text DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_contact` varchar(15) DEFAULT NULL,
  `mother_occupation` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `communication_address` text DEFAULT NULL,
  `local_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`id`, `name`, `gender`, `rollno`, `mobile_no`, `whatsapp_no`, `email_official`, `email_personal`, `programme_name`, `medium_instruction`, `year_enrollment`, `batch`, `native_state`, `scholarship_details`, `father_name`, `father_contact`, `father_occupation`, `mother_name`, `mother_contact`, `mother_occupation`, `permanent_address`, `communication_address`, `local_address`) VALUES
(19, 'Dany', 'male', '221CT004', '6382413743', '6382413743', 'dany@gmail.com', 'dany@gmail.com', 'BSc Computer Technology', 'HSE', '2022', '2022 to 2025', 'erode', 'nil', 'sudhes', '9876543210', 'actor', 'Roshini', '6546546166', 'housewife', '1/1,erode,tamilnadu', '1/1,erode,tamilnadu', '1/1,erode,tamilnadu'),
(20, 'kavin', 'male', '221CT011', '7894561230', '7894561230', 'kavin@gmail.com', 'kavin@gmail.com', 'BSc Computer Technology', 'HSE', '2022', '2022 to 2025', 'tamil nadu', 'nil', 'sudhes', '54649841566', 'labour', 'priya', '6546546166', 'housewife', 'Tirupur', 'Coimbatore', 'Tirupur');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','staff','student') NOT NULL,
  `rollno` varchar(50) DEFAULT NULL,
  `programme_name` text NOT NULL DEFAULT 'BSc Computer Technology'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_type`, `rollno`, `programme_name`) VALUES
(1, 'MathuSuthanan', 'mathusuthanankr2004@gmail.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFUpy6qJ1u1Gm/5f2d5b5J5b5b5b5b5b', 'admin', NULL, 'BSc Computer Technology'),
(36, 'Sam', 'sam@gmail.com', '$2y$10$bxEcwG4fTOvKAHH8atniMuYvDpiRsd3t03oR7sPY/H5QphsYT1l0i', 'staff', NULL, 'BSc Computer Technology'),
(37, 'Ragul', 'ragul@gmail.com', '$2y$10$bJ5Xv2IJa2bddX5V44xOZuT3k8vuzVWuCjplr/0M2TJwdG25zgYoO', 'staff', NULL, 'BSc Computer Technology'),
(38, 'Rathi', 'rathi@gmail.com', '$2y$10$jJxLtfjeiNrwqcymq/LrU.qdr5bkqqa.wTtPBqU9c1JJ1T0OTBcO2', 'staff', NULL, 'BSc Computer Technology'),
(39, 'Sobana', 'sobana@gmail.com', '$2y$10$1wVrjYlV/AZwAhD83TSReeMtbGMCI929ahJI/S9R4JeKY1tcPdbIG', 'staff', NULL, 'BSc Computer Technology'),
(40, 'Arun', 'arun@gmail.com', '$2y$10$yE5/bJDufZqFUJjy3gX5G.KtAJ6FhNerHeYz/F.bo7Dc05u1hwt0i', 'student', '221CT001', 'BSc Computer Technology'),
(41, 'Bala', 'bala@gmail.com', '$2y$10$ATFN5BXe8Fud6ZFnquB6LuRvjM/WdeEQBwthzeIY/SWil1QDN6cFS', 'student', '221CT002', 'BSc Computer Technology'),
(42, 'Cibi', 'cibi@gmail.com', '$2y$10$ufPgiK9/BTyIR8QS1qsZzePkGvRAef7Cw0HbcNp4nhiWqrLjcfsqu', 'student', '221CT003', 'BSc Computer Technology'),
(43, 'Dany', 'dany@gmail.com', '$2y$10$XfypH8etHIc9xw7eecF4xub.9oTctzI0OSMak/gLg9.tbsGiDzaam', 'student', '221CT004', 'BSc Computer Technology'),
(44, 'Elisa', 'elisa@gmail.com', '$2y$10$39JF/sqTFbDtg8ZLeUPzeOn281bixrDfNtUExd0qYHHwAHzdPCusq', 'student', '221CT005', 'BSc Computer Technology'),
(45, 'Fahadh', 'fahadh@gmail.com', '$2y$10$AtKW1QwN0u5o690xc1WWz.62xViTw9BS6vid6a4sdcDTI44lub.iS', 'student', '221CT006', 'BSc Computer Technology'),
(46, 'Guna', 'guna@gmail.com', '$2y$10$iPkqBUmj0azMXDDFTqs2bu31.jp.F6iacfGCP1/2ehXOAm477WzJa', 'student', '221CT007', 'BSc Computer Technology'),
(47, 'Hari', 'hari@gmail.com', '$2y$10$qSLVi18t1p1MJxbvsQo8rO6Prtiy73S1fP1XyFj9Ye2nOwLhEK6k6', 'student', '221CT008', 'BSc Computer Technology'),
(48, 'Indhu', 'indhu@gmail.com', '$2y$10$S5tzDlhoU20Omdyd6Lz0ROyjucJzkd.ddY12utDwomyIobsIvWKam', 'student', '221CT009', 'BSc Computer Technology'),
(49, 'Jagan', 'jagan@gmail.com', '$2y$10$GfJf8KhPs/lgXB9Zqi4NoePvNO3PSRNO8q79vwclU33/MZRMVQByC', 'student', '221CT010', 'BSc Computer Technology'),
(52, 'kavin', 'kavin@gmail.com', '$2y$10$scyxrLFlLlk4rjUrh9EIE.gkEnK9D9Njau5caihqWh0rtTSAGgXWe', 'student', '221CT011', 'BSc Computer Technology'),
(53, 'Sree', 'sree@gmail.com', '$2y$10$qBt3143DBHoESWog1kjttueSNjTSwR5TCHCOtjPSa9k2sPbpOp.vq', 'staff', NULL, 'BSc Computer Technology');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `counseling_sessions`
--
ALTER TABLE `counseling_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentor_id` (`mentor_id`),
  ADD KEY `mentee_id` (`mentee_id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staff_student_allocation`
--
ALTER TABLE `staff_student_allocation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `counseling_sessions`
--
ALTER TABLE `counseling_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_student_allocation`
--
ALTER TABLE `staff_student_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `counseling_sessions`
--
ALTER TABLE `counseling_sessions`
  ADD CONSTRAINT `counseling_sessions_ibfk_1` FOREIGN KEY (`mentor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `counseling_sessions_ibfk_2` FOREIGN KEY (`mentee_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD CONSTRAINT `leave_applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `staff_student_allocation`
--
ALTER TABLE `staff_student_allocation`
  ADD CONSTRAINT `staff_student_allocation_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `staff_student_allocation_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
