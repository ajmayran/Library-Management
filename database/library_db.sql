-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 11:57 AM
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
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `username`, `password`, `contact`) VALUES
(1, 'AJ', 'Mayran', 'admin', '$2y$10$26B3kIuMGjf5njP9NIp.NeHXvQQ0NKKNy.l6VZ8gAytNlnZZKUEaa', 'clickerz09@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `year`, `publisher_id`, `isbn`, `subject_id`) VALUES
(1, 'Mathematics 10', '', 2024, 3, '978-971-23-4567-8', 4),
(2, 'Math: A Practical Approach', '', 2024, 1, '978-971-10-1234-5', 4),
(3, 'Algebra 10', '', 2024, 2, '978-971-27-8901-2', 4),
(4, 'Geometry 10', '', 2024, 3, '978-971-23-4568-5', 4),
(5, 'Statistics and Probability', '', 2024, 1, '978-971-10-1236-9', 4),
(6, 'Mathematics in the Modern World', '', 2024, 2, '978-971-27-8902-9', 4),
(7, 'Basic Mathematics', '', 2024, 3, '978-971-23-4569-2', 4),
(8, 'Mathematical Reasoning', '', 2024, 1, '978-971-10-1237-6', 4),
(9, 'Advanced Algebra', '', 2024, 2, '978-971-27-8903-6', 4),
(10, 'Mathematics for the New Normal', '', 2024, 3, '978-971-23-4570-8', 4),
(11, 'Trigonometry 10', '', 2024, 1, '978-971-10-1238-3', 4),
(12, 'Calculus Basics', '', 2024, 2, '978-971-27-8904-3', 4),
(13, 'Math for Everyday Life', '', 2024, 3, '978-971-23-4571-5', 4),
(14, 'Problem Solving in Math', '', 2024, 1, '978-971-10-1239-0', 4),
(15, 'Math Workbook 10', '', 2024, 2, '978-971-27-8905-0', 4),
(16, 'Mathematics: Concepts and Applications', '', 2024, 3, '978-971-23-4572-2', 4),
(17, 'Fundamentals of Mathematics', '', 2024, 1, '978-971-10-1240-6', 4),
(18, 'Mathematics in Action', '', 2024, 2, '978-971-27-8906-7', 4),
(19, 'Exploring Mathematics', '', 2024, 3, '978-971-23-4573-9', 4),
(20, 'Math Skills for High School', '', 2024, 1, '978-971-10-1241-3', 4),
(21, 'Science 10', '', 2024, 1, '978-971-10-1242-0', 3),
(22, 'Physics for Beginners', '', 2024, 3, '978-971-23-4574-6', 3),
(23, 'Chemistry 10', '', 2024, 2, '978-971-27-8907-4', 3),
(24, 'Biology for High School', '', 2024, 1, '978-971-10-1243-7', 3),
(25, 'Earth Science 10', '', 2024, 3, '978-971-23-4575-3', 3),
(26, 'Environmental Science', '', 2024, 2, '978-971-27-8908-1', 3),
(27, 'Chemistry in Everyday Life', '', 2024, 1, '978-971-10-1244-4', 3),
(28, 'Fundamentals of Biology', '', 2024, 3, '978-971-23-4576-0', 3),
(29, 'Physics in Action', '', 2024, 2, '978-971-27-8909-8', 3),
(30, 'Scientific Investigation', '', 2024, 1, '978-971-10-1245-1', 3),
(31, 'Science Workbook 10', '', 2024, 3, '978-971-23-4577-7', 3),
(32, 'Principles of Chemistry', '', 2024, 2, '978-971-27-8910-4', 3),
(33, 'Biology: The Study of Life', '', 2024, 1, '978-971-10-1246-8', 3),
(34, 'Physics Essentials', '', 2024, 3, '978-971-23-4578-4', 3),
(35, 'Chemistry for High School', '', 2024, 2, '978-971-27-8911-1', 3),
(36, 'Introduction to Earth Science', '', 2024, 1, '978-971-10-1247-5', 3),
(37, 'Life Science 10', '', 2024, 3, '978-971-23-4579-1', 3),
(38, 'Physics Fundamentals', '', 2024, 2, '978-971-27-8912-8', 3),
(39, 'Exploring Chemistry', '', 2024, 1, '978-971-10-1248-2', 3),
(40, 'Understanding Biology', '', 2024, 3, '978-971-23-4580-7', 3),
(41, 'English 10', '', 2024, 2, '978-971-27-8913-5', 1),
(42, 'Reading and Writing Skills', '', 2024, 1, '978-971-10-1249-9', 1),
(43, 'Literature: A Diverse World', '', 2024, 3, '978-971-23-4581-4', 1),
(44, 'English Grammar and Composition', '', 2024, 2, '978-971-27-8914-2', 1),
(45, 'Developing Writing Skills', '', 2024, 1, '978-971-10-1250-5', 1),
(46, 'Effective Communication', '', 2024, 3, '978-971-23-4582-1', 1),
(47, 'Short Stories for Young Adults', '', 2024, 2, '978-971-27-8915-9', 1),
(48, 'English for Academic and Professional Purposes', '', 2024, 1, '978-971-10-1251-2', 1),
(49, 'Poetry Anthology', '', 2024, 3, '978-971-23-4583-8', 1),
(50, 'Public Speaking and Presentation', '', 2024, 2, '978-971-27-8916-6', 1),
(51, 'Critical Reading Strategies', '', 2024, 1, '978-971-10-1252-9', 1),
(52, 'Introduction to Literature', '', 2024, 3, '978-971-23-4584-5', 1),
(53, 'Creative Writing', '', 2024, 2, '978-971-27-8917-3', 1),
(54, 'English Vocabulary Builder', '', 2024, 1, '978-971-10-1253-6', 1),
(55, 'Comprehension Skills for High School', '', 2024, 3, '978-971-23-4585-2', 1),
(56, 'Literary Analysis', '', 2024, 2, '978-971-27-8918-0', 1),
(57, 'English Idioms and Expressions', '', 2024, 1, '978-971-10-1254-3', 1),
(58, 'Writing Research Papers', '', 2024, 3, '978-971-23-4586-9', 1),
(59, 'Advanced English Grammar', '', 2024, 2, '978-971-27-8919-7', 1),
(60, 'Exploring English Literature', '', 2024, 1, '978-971-10-1255-0', 1),
(61, 'Araling Panlipunan 10', '', 2024, 3, '978-971-23-4587-6', 5),
(62, 'Kasaysayan ng Daigdig', '', 2024, 1, '978-971-10-1256-7', 5),
(63, 'Pilipinas: Bansa at Lipunan', '', 2024, 2, '978-971-27-8920-3', 5),
(64, 'Civic Education', '', 2024, 3, '978-971-23-4588-3', 5),
(65, 'History of the Philippines', '', 2024, 1, '978-971-10-1257-4', 5),
(66, 'Government and Politics', '', 2024, 2, '978-971-27-8921-0', 5),
(67, 'Sociology and Culture', '', 2024, 3, '978-971-23-4589-0', 5),
(68, 'Economics for Students', '', 2024, 1, '978-971-10-1258-1', 5),
(69, 'Global Studies', '', 2024, 2, '978-971-27-8922-7', 5),
(70, 'Philippine Geography', '', 2024, 3, '978-971-23-4590-7', 5),
(71, 'Culture and Society', '', 2024, 1, '978-971-10-1259-8', 5),
(72, 'Contemporary Issues in the Philippines', '', 2024, 2, '978-971-27-8923-4', 5),
(73, 'Introduction to Philippine History', '', 2024, 3, '978-971-23-4591-4', 5),
(74, 'Environmental Studies', '', 2024, 1, '978-971-10-1260-4', 5),
(75, 'Democracy and Governance', '', 2024, 2, '978-971-27-8924-1', 5),
(76, 'Philippine Government', '', 2024, 3, '978-971-23-4592-1', 5),
(77, 'Culture and Heritage', '', 2024, 1, '978-971-10-1261-1', 5),
(78, 'Politics and Society', '', 2024, 2, '978-971-27-8925-8', 5),
(79, 'Filipino Identity', '', 2024, 3, '978-971-23-4593-8', 5),
(80, 'Philippine Society and Culture', '', 2024, 1, '978-971-10-1262-8', 5),
(81, 'Filipino 10', '', 2024, 1, '978-971-10-1263-5', 2),
(82, 'Balarila ng Wikang Filipino', '', 2024, 3, '978-971-23-4594-5', 2),
(83, 'Panitikan Kasaysayan at Kahalagahan', '', 2024, 2, '978-971-27-8926-5', 2),
(84, 'Kritikal na Pagbasa at Pagsusuri', '', 2024, 1, '978-971-10-1264-2', 2),
(85, 'Sining ng Pagsasalita', '', 2024, 3, '978-971-23-4595-2', 2),
(86, 'Tula at Panitikan', '', 2024, 2, '978-971-27-8927-2', 2),
(87, 'Kuwento ng Bayan', '', 2024, 1, '978-971-10-1265-9', 2),
(88, 'Wikang Filipino sa Araw-araw', '', 2024, 3, '978-971-23-4596-9', 2),
(89, 'Filipino sa Makabagong Mundo', '', 2024, 2, '978-971-27-8928-9', 2),
(90, 'Mga Akdang Pampanitikan', '', 2024, 1, '978-971-10-1266-6', 2),
(91, 'Balagtasan Isang Sining', '', 2024, 3, '978-971-23-4597-6', 2),
(92, 'Mga Pagsasalin sa Filipino', '', 2024, 2, '978-971-27-8929-6', 2),
(93, 'Wika at Kultura', '', 2024, 1, '978-971-10-1267-3', 2),
(94, 'Filipino sa Ibat Ibang Antas', '', 2024, 3, '978-971-23-4598-3', 2),
(95, 'Pagsusuri ng Ibat Ibang Teksto', '', 2024, 2, '978-971-27-8930-2', 2),
(96, 'Pagsasagawa ng Pananaliksik', '', 2024, 1, '978-971-10-1268-0', 2),
(97, 'Sining ng Pagsusulat', '', 2024, 3, '978-971-23-4599-0', 2),
(98, 'Kahalagahan ng Wika', '', 2024, 2, '978-971-27-8931-9', 2),
(99, 'Mga Kuwentong Bayan', '', 2024, 1, '978-971-10-1269-7', 2),
(100, 'Pambansang Wika at Kulturang Pilipino', '', 2024, 3, '978-971-23-4600-4', 2),
(101, 'MAPEH 10', '', 2024, 1, '978-971-10-1270-3', 6),
(102, 'Fundamentals of Music', '', 2024, 3, '978-971-23-4601-1', 6),
(103, 'Art Appreciation', '', 2024, 2, '978-971-27-8932-6', 6),
(104, 'Physical Education: Activities and Sports', '', 2024, 1, '978-971-10-1271-0', 6),
(105, 'Health and Wellness', '', 2024, 3, '978-971-23-4602-8', 6),
(106, 'Dance: An Art Form', '', 2024, 2, '978-971-27-8933-3', 6),
(107, 'Visual Arts 10', '', 2024, 1, '978-971-10-1272-7', 6),
(108, 'Music in Our Lives', '', 2024, 3, '978-971-23-4603-5', 6),
(109, 'Health Education', '', 2024, 2, '978-971-27-8934-0', 6),
(110, 'PE Activities for High School', '', 2024, 1, '978-971-10-1273-4', 6),
(111, 'Arts and Crafts', '', 2024, 3, '978-971-23-4604-2', 6),
(112, 'Exploring Music', '', 2024, 2, '978-971-27-8935-7', 6),
(113, 'Physical Fitness', '', 2024, 1, '978-971-10-1274-1', 6),
(114, 'Understanding Dance', '', 2024, 3, '978-971-23-4605-9', 6),
(115, 'Music and Movement', '', 2024, 2, '978-971-27-8936-4', 6),
(116, 'Arts Education', '', 2024, 1, '978-971-10-1275-8', 6),
(117, 'Sports and Recreation', '', 2024, 3, '978-971-23-4606-6', 6),
(118, 'Cultural Arts', '', 2024, 2, '978-971-27-8937-1', 6),
(119, 'Health and Nutrition', '', 2024, 1, '978-971-10-1276-5', 6),
(120, 'Fitness for Life', '', 2024, 3, '978-971-23-4607-3', 2),
(121, 'Religion 10', '', 2024, 2, '978-971-27-8938-8', 7),
(122, 'Understanding the Bible', '', 2024, 1, '978-971-10-1277-2', 7),
(123, 'Faith and Values Education', '', 2024, 3, '978-971-23-4608-0', 7),
(124, 'Teachings of Jesus', '', 2024, 2, '978-971-27-8939-5', 7),
(125, 'Moral and Spiritual Values', '', 2024, 1, '978-971-10-1278-9', 7),
(126, 'Philippine Religions', '', 2024, 3, '978-971-23-4609-7', 7),
(127, 'Living a Faithful Life', '', 2024, 2, '978-971-27-8940-1', 7),
(128, 'The Role of Religion in Society', '', 2024, 1, '978-971-10-1279-6', 7),
(129, 'Introduction to World Religions', '', 2024, 3, '978-971-23-4610-3', 7),
(130, 'Christian Living', '', 2024, 2, '978-971-27-8941-8', 7),
(131, 'Understanding Faith', '', 2024, 1, '978-971-10-1280-2', 7),
(132, 'Religious Practices in the Philippines', '', 2024, 3, '978-971-23-4611-0', 7),
(133, 'Ethics and Morality', '', 2024, 2, '978-971-27-8942-5', 7),
(134, 'Exploring Catholicism', '', 2024, 1, '978-971-10-1281-9', 7),
(135, 'Faith in Action', '', 2024, 3, '978-971-23-4612-7', 7),
(136, 'Introduction to Theology', '', 2024, 2, '978-971-27-8943-2', 7),
(137, 'The Bible in Daily Life', '', 2024, 1, '978-971-10-1282-6', 7),
(138, 'Spiritual Development', '', 2024, 3, '978-971-23-4613-4', 7),
(139, 'Interfaith Dialogue', '', 2024, 3, '978-971-27-8944-9', 7),
(140, 'Faith and Community', '', 2024, 1, '978-971-10-1283-3', 7);

-- --------------------------------------------------------

--
-- Table structure for table `book_request`
--

CREATE TABLE `book_request` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date_requested` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Denied','') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrowing_transaction`
--

CREATE TABLE `borrowing_transaction` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('Borrowed','Returned','Overdue','') NOT NULL DEFAULT 'Borrowed',
  `borrow_date` datetime NOT NULL DEFAULT current_timestamp(),
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL,
  `publisher_name` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id`, `publisher_name`, `updated_at`) VALUES
(1, 'Phoenix Publishing House', '2024-12-08 14:48:38'),
(2, 'Vibal Group', '2024-12-08 14:48:38'),
(3, 'Rex Book Store', '2024-12-08 14:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `section_name`, `updated_at`) VALUES
(1, 'Rose', '2024-12-07 16:29:46'),
(2, 'Sampaguita', '2024-12-07 16:29:46'),
(3, 'Lily', '2024-12-07 16:29:46'),
(4, 'Sunflower', '2024-12-07 16:29:46'),
(5, 'Diamond', '2024-12-07 16:29:46'),
(6, 'Opal', '2024-12-07 16:29:46'),
(7, 'Ruby', '2024-12-07 16:29:46'),
(8, 'Emerald', '2024-12-07 16:29:46'),
(9, 'Saturn', '2024-12-07 16:29:46'),
(10, 'Venus', '2024-12-07 16:29:46'),
(11, 'Jupiter', '2024-12-07 16:33:01'),
(12, 'Mars', '2024-12-07 16:33:01'),
(13, 'Rizal', '2024-12-07 16:33:01'),
(14, 'Mabini', '2024-12-07 16:33:01'),
(15, 'Bonifacio', '2024-12-07 16:33:01'),
(16, 'Aquino', '2024-12-07 16:33:01'),
(17, 'Aguinaldo', '2024-12-07 16:33:01'),
(18, 'Del Pilar', '2024-12-07 16:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `LRN` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `grade_lvl` varchar(255) NOT NULL,
  `section_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `LRN`, `first_name`, `last_name`, `grade_lvl`, `section_id`, `password`) VALUES
(1, '1234-5678-9012', 'Sharmaine', 'Ambula', 'Grade 7', 1, '$2y$10$moa0Z9FS7B2t9Ds9P/rYbeKoslQiMDeE/wwsm4ZhJe/JQ6tmhmXGq');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subject_name`, `updated_at`) VALUES
(1, 'English', '2024-12-08 14:45:51'),
(2, 'Filipino', '2024-12-08 14:45:51'),
(3, 'Science', '2024-12-08 14:45:51'),
(4, 'Mathematics', '2024-12-08 14:45:51'),
(5, 'Araling Panlipuan', '2024-12-08 14:45:51'),
(6, 'MAPEH', '2024-12-08 14:45:51'),
(7, 'Religion', '2024-12-08 14:45:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_book_publisher` (`publisher_id`),
  ADD KEY `fk_book_subject` (`subject_id`);

--
-- Indexes for table `book_request`
--
ALTER TABLE `book_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_book_request` (`book_id`),
  ADD KEY `fk_student_request` (`student_id`);

--
-- Indexes for table `borrowing_transaction`
--
ALTER TABLE `borrowing_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_book_borrow` (`book_id`),
  ADD KEY `fk_student_borrow` (`student_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `LRN` (`LRN`),
  ADD KEY `fk_student_section` (`section_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `book_request`
--
ALTER TABLE `book_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowing_transaction`
--
ALTER TABLE `borrowing_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_book_publisher` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`),
  ADD CONSTRAINT `fk_book_subject` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`);

--
-- Constraints for table `book_request`
--
ALTER TABLE `book_request`
  ADD CONSTRAINT `fk_book_request` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_student_request` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `borrowing_transaction`
--
ALTER TABLE `borrowing_transaction`
  ADD CONSTRAINT `fk_book_borrow` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_student_borrow` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_student_section` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
