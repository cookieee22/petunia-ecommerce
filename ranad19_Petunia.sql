-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2025 at 02:58 PM
-- Server version: 5.7.44
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `benavip1_Petunia`
--

-- --------------------------------------------------------

--
-- Table structure for table `ABOUT`
--

CREATE TABLE `ABOUT` (
  `ABOUT_ID` int(11) NOT NULL,
  `ABOUT_DESCRIPTION` text,
  `IMAGE` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ABOUT`
--

INSERT INTO `ABOUT` (`ABOUT_ID`, `ABOUT_DESCRIPTION`, `IMAGE`) VALUES
(1, 'This site takes its cue from the petunia, a\nflower known not just for its beauty, but its \nadaptability.\n\nPetunias are remarkable. Originally native to South\n America, they have found their way into gardens\nacross the globe,thriving in hanging baskets,\nwindow boxes, and wild corners alike. That\nversatility is something I value deeply: the\nability to grow, shift, and create wherever\nyou are planted.\n\nHere, you will find work that reflects that same\napproach: flexible, expressive, and grounded in thoughtful\ndesign. Whether it is storytelling, visual art, or creative\nstrategy, my goal is to make things that connect with\npeople in meaningful, lasting ways.', 'about1.jpg'),
(2, 'Petunias may seem delicate, but they are known for their\nresilience, thriving in all kinds of conditions and bringing\nbeauty to even the toughest landscapes. That is the spirit\nbehind this site: a place where creativity grows, ideas\nflourish, and every detail is designed with intention.\n\nWhether you are here to explore design, find inspiration,\nor just enjoy something beautifully made, welcome. We\nbelieve in thoughtful work, vibrant expression, and\nfinding joy in small details, much like the many hues\nof a single petal.\n\nThanks for stopping by! Let us make something bloom together!', 'about2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `DEPARTMENT`
--

CREATE TABLE `DEPARTMENT` (
  `DEPARTMENT_ID` int(11) NOT NULL,
  `MANAGER_ID` int(11) DEFAULT NULL,
  `DEPARTMENT_NAME` varchar(100) DEFAULT NULL,
  `LOCATION` varchar(100) DEFAULT NULL,
  `PHONE_NUM` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `DEPARTMENT`
--

INSERT INTO `DEPARTMENT` (`DEPARTMENT_ID`, `MANAGER_ID`, `DEPARTMENT_NAME`, `LOCATION`, `PHONE_NUM`) VALUES
(1, 1, 'Human Resources', 'Jersey City', '201-555-0222'),
(2, 2, 'Product Management', 'Newark', '973-555-0100'),
(3, 3, 'Information Technology', 'Paterson', '862-555-0240');

-- --------------------------------------------------------

--
-- Table structure for table `EMPLOYEE`
--

CREATE TABLE `EMPLOYEE` (
  `EMPLOYEE_ID` int(11) NOT NULL,
  `MANAGER_ID` int(11) DEFAULT NULL,
  `FIRST_NAME` varchar(50) DEFAULT NULL,
  `LAST_NAME` varchar(50) DEFAULT NULL,
  `MIDDLE_INT` char(1) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `PHONE_NUM` varchar(20) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `POSITION` varchar(100) DEFAULT NULL,
  `DEPARTMENT_ID` int(11) DEFAULT NULL,
  `SSN` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EMPLOYEE`
--

INSERT INTO `EMPLOYEE` (`EMPLOYEE_ID`, `MANAGER_ID`, `FIRST_NAME`, `LAST_NAME`, `MIDDLE_INT`, `EMAIL`, `PHONE_NUM`, `ADDRESS`, `POSITION`, `DEPARTMENT_ID`, `SSN`) VALUES
(1, NULL, 'Joe', 'Nobody', 'L', 'joenobody@petunia.com', '973-555-1000', '1000 Speedwell Ave, Morristown, NJ', 'HR Manager', 1, '123-45-6789'),
(2, NULL, 'Jane', 'Kim', 'S', 'janekim@petunia.com', '201-555-1001', '456 Washington Blvd, Jersey City, NJ', 'Product Manager', 2, '234-56-7890'),
(3, NULL, 'Jim', 'Kornette', 'C', 'jimkornette@petunia.com', '862-555-1002', '123 Broad St, Newark, NJ', 'IT Manager', 3, '345-67-8901'),
(4, 1, 'John', 'Doe', 'A', 'john.doe1@petunia.com', '908-555-2001', '546 Federal St, Camden, NJ', 'HR Specialist', 1, '456-78-9012'),
(5, 1, 'Alice', 'Green', 'B', 'alice.green@petunia.com', '908-555-2002', '321 Elmora Ave, Elizabeth, NJ', 'HR Assistant', 1, '567-89-0123'),
(6, 2, 'Mark', 'Johnson', 'C', 'mark.johnson@petunia.com', '908-555-2003', '654 Oak Tree Rd, Edison, NJ', 'Project Lead I', 2, '678-90-1234'),
(7, 2, 'Samantha', 'Lee', 'D', 'samantha.lee@petunia.com', '908-555-2004', '789 Grove St, Jersey City, NJ', 'Product Lead II', 2, '789-01-2345'),
(8, 3, 'Carlos', 'Miller', 'E', 'carlos.miller@petunia.com', '908-555-2005', '546 Federal St, Camden, NJ', 'IT Support Specialist', 3, '890-12-3456'),
(9, 3, 'Tom', 'Taylor', 'G', 'tom.taylor@petunia.com', '908-555-2007', '987 State St, Trenton, NJ', 'IT Support Assistant', 3, '012-34-5678'),
(31, 1, 'Adam', 'oasdasndgjsjaf', 'm', 'ad@mont', '973-999-999', 'mad', 'HR Manager', 1, NULL),
(32, 2, 'adam_admin', 'o', 'm', 'ad@mont2', '213-441-451', 'asdasd', 'Product Manager\n', 2, NULL),
(33, 3, 'adam_test', 'test', 'm', 'ad@mont3', '213', 'asdadsa', 'IT Manager', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `PRODUCTS`
--

CREATE TABLE `PRODUCTS` (
  `PRODUCT_ID` int(11) NOT NULL,
  `EMPLOYEE_ID` int(11) DEFAULT NULL,
  `PRODUCT_NAME` varchar(100) DEFAULT NULL,
  `CATEGORY` varchar(100) DEFAULT NULL,
  `DESCRIPTION` text,
  `PRICE` decimal(10,2) DEFAULT NULL,
  `INVENTORY_COUNT` int(11) DEFAULT NULL,
  `IMAGES` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PRODUCTS`
--

INSERT INTO `PRODUCTS` (`PRODUCT_ID`, `EMPLOYEE_ID`, `PRODUCT_NAME`, `CATEGORY`, `DESCRIPTION`, `PRICE`, `INVENTORY_COUNT`, `IMAGES`) VALUES
(1, 6, 'T-shirt with petunia design', 'Shirts', 'Soft cotton T-shirt featuring a petunia design.', 19.99, 50, 'shirt3.jpg'),
(2, 6, 'Button-up shirt with all-over petunia print', 'Shirts', 'Formal button-up shirt with full petunia print.', 29.99, 25, 'shirt1.jpg'),
(3, 6, 'Embroidered petunia pocket tee', 'Shirts', 'Casual tee with embroidered petunia on pocket.', 24.99, 40, 'shirt2.jpg'),
(4, 6, 'Oversized graphic tee with petunia garden artwork', 'Shirts', 'Oversized tee featuring garden-style artwork.', 21.99, 24, 'shirt5.jpg'),
(5, 6, 'Tie-dye shirt in petunia-inspired colors', 'Shirts', 'Colorful tie-dye shirt inspired by petunia colors.', 22.99, 35, 'shirt4.jpg'),
(6, 6, 'Baseball cap with embroidered petunia flower', 'Hats', 'Classic cap with a floral embroidery.', 17.99, 40, 'hat1.jpg'),
(7, 6, 'Snapback hat with a floral petunia pattern', 'Hats', 'Floral snapback hat with vibrant design.', 18.99, 30, 'hat3.jpg'),
(8, 6, 'Dad hat with a minimalist petunia logo', 'Hats', 'Laid-back dad hat with clean logo design.', 16.99, 35, 'hat2.jpg'),
(9, 6, 'Wide-brim sun hat with petunia flower accents', 'Hats', 'Stylish wide-brimmed hat for sun protection.', 25.99, 20, 'hat5.jpg'),
(10, 6, 'Trucker hat with a vintage petunia garden print', 'Hats', 'Mesh trucker hat with retro floral design.', 19.99, 28, 'hat4.jpg'),
(11, 6, 'Crew Neck sweater with a large petunia floral print', 'Sweaters', 'Warm sweater featuring large floral graphics.', 34.99, 18, 'sweater1.jpg'),
(12, 6, 'Knit sweater with embroidered petunia flowers', 'Sweaters', 'Knitted material with delicate embroidery.', 39.99, 21, 'sweater2.jpg'),
(13, 6, 'Hoodie with a pastel petunia pattern', 'Sweaters', 'Comfy hoodie with soft pastel colors.', 36.99, 25, 'sweater3.jpg'),
(14, 6, 'Oversized pullover with a vintage petunia design', 'Sweaters', 'Oversized fit with retro design vibe.', 33.99, 15, 'sweater4.jpg'),
(15, 6, 'Cable-knit sweater in soft petunia-inspired colors', 'Sweaters', 'Classic cable-knit in floral colors.', 37.99, 20, 'sweater5.jpg'),
(16, 7, 'Cuffed beanie with a small embroidered petunia', 'Beanies', 'Simple beanie with a touch of flower.', 14.99, 30, 'beanie1.jpg'),
(17, 7, 'Knit beanie with an all-over petunia print', 'Beanies', 'Printed beanie with floral detail.', 15.99, 25, 'beanie3.jpg'),
(18, 7, 'Slouchy beanie in petunia-inspired colors', 'Beanies', 'Casual slouch style with floral tones.', 13.99, 28, 'beanie5.jpg'),
(19, 7, 'Pom-pom beanie with a petunia patch', 'Beanies', 'Playful style with flower patch.', 16.99, 24, 'beanie4.jpg'),
(20, 7, 'Fleece-lined beanie with a floral petunia design', 'Beanies', 'Extra cozy fleece-lined floral beanie.', 17.99, 20, 'beanie2.jpg'),
(21, 7, 'Mixed petunia seed packet', 'Seeds/Flowers', 'Contains purple, pink, and white petunia seeds.', 4.99, 100, 'mixed_seeds.jpg'),
(22, 7, 'Hanging basket with blooming petunia flowers', 'Seeds/Flowers', 'Fully bloomed basket ready to display.', 14.99, 18, 'hanging.jpg'),
(23, 7, 'Dwarf petunia plant for small gardens', 'Seeds/Flowers', 'Compact plant for limited spaces.', 6.99, 40, 'plant.jpg'),
(24, 7, 'Rare color petunia seeds', 'Seeds/Flowers', 'Includes blue and black variety seeds.', 7.99, 30, 'rare_seeds.jpg'),
(25, 7, 'Organic petunia seed starter kit', 'Seeds/Flowers', 'Eco-friendly kit to grow petunias at home.', 12.99, 22, 'starter_kit.jpg'),
(26, 7, 'Fleece blanket with a petunia floral print', 'Blankets', 'Soft fleece with vibrant floral art.', 27.99, 15, 'blanket1.jpg'),
(27, 7, 'Woven throw blanket with an artistic petunia design', 'Blankets', 'Stylish throw with detailed design.', 29.99, 18, 'blanket5.jpg'),
(28, 7, 'Sherpa blanket with embroidered petunias', 'Blankets', 'Super cozy sherpa with embroidery.', 32.99, 12, 'blanket3.jpg'),
(29, 7, 'Patchwork quilt featuring petunia-inspired patterns', 'Blankets', 'Quilt made with custom patterns.', 39.99, 10, 'blanket2.jpg'),
(30, 7, 'Silk blanket with a delicate petunia motif', 'Blankets', 'Lightweight luxury silk blanket.', 44.99, 8, 'blanket4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `RECEIPT`
--

CREATE TABLE `RECEIPT` (
  `RECEIPT_ID` int(11) NOT NULL,
  `SESSION_ID` int(11) DEFAULT NULL,
  `ISSUED_AT` datetime DEFAULT NULL,
  `TOTAL_PAID` decimal(10,2) DEFAULT NULL,
  `PAYMENT_METHOD` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RECEIPT`
--

INSERT INTO `RECEIPT` (`RECEIPT_ID`, `SESSION_ID`, `ISSUED_AT`, `TOTAL_PAID`, `PAYMENT_METHOD`) VALUES
(27, 39, '2025-04-30 22:54:56', 49.90, NULL),
(28, 39, '2025-04-30 22:59:10', 39.99, NULL),
(29, 40, '2025-05-01 00:24:22', 19.99, NULL),
(30, 40, '2025-05-01 10:07:10', 132.94, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `RECEIPT_ITEMS`
--

CREATE TABLE `RECEIPT_ITEMS` (
  `RECEIPT_ITEM_ID` int(11) NOT NULL,
  `RECEIPT_ID` int(11) DEFAULT NULL,
  `PRODUCT_NAME` varchar(255) DEFAULT NULL,
  `PRICE` decimal(10,2) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `SUBTOTAL` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RECEIPT_ITEMS`
--

INSERT INTO `RECEIPT_ITEMS` (`RECEIPT_ITEM_ID`, `RECEIPT_ID`, `PRODUCT_NAME`, `PRICE`, `QUANTITY`, `SUBTOTAL`) VALUES
(1, 22, 'T-shirt with petunia design', 19.99, 1, 19.99),
(2, 23, 'Embroidered petunia pocket tee', 24.99, 1, 24.99),
(3, 24, 'Sherpa blanket with embroidered petunias', 32.99, 1, 32.99),
(4, 25, 'Knit beanie with an all-over petunia print', 15.99, 1, 15.99),
(5, 26, 'Rare color petunia seeds', 7.99, 1, 7.99),
(6, 27, 'Mixed petunia seed packet', 4.99, 10, 49.90),
(7, 28, 'Patchwork quilt featuring petunia-inspired patterns', 39.99, 1, 39.99),
(8, 29, 'T-shirt with petunia design', 19.99, 1, 19.99),
(9, 30, 'Snapback hat with a floral petunia pattern', 18.99, 1, 18.99),
(10, 30, 'T-shirt with petunia design', 19.99, 3, 59.97),
(11, 30, 'Hoodie with a pastel petunia pattern', 36.99, 1, 36.99),
(12, 30, 'Pom-pom beanie with a petunia patch', 16.99, 1, 16.99);

-- --------------------------------------------------------

--
-- Table structure for table `SESSION`
--

CREATE TABLE `SESSION` (
  `SESSION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `EMPLOYEE_ID` int(11) DEFAULT NULL,
  `ORDERED_AT` datetime DEFAULT NULL,
  `TOTAL_AMOUNT` decimal(10,2) DEFAULT NULL,
  `ORDER_STATUS` varchar(50) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SESSION`
--

INSERT INTO `SESSION` (`SESSION_ID`, `USER_ID`, `EMPLOYEE_ID`, `ORDERED_AT`, `TOTAL_AMOUNT`, `ORDER_STATUS`, `CREATED_AT`) VALUES
(32, 27, 5, '2025-04-30 17:33:24', 0.00, 'active', '2025-04-29 20:21:23'),
(33, 28, 8, NULL, 0.00, 'active', '2025-04-29 21:08:21'),
(34, 29, 4, NULL, 0.00, 'active', '2025-04-29 21:39:22'),
(35, 30, 6, '2025-04-30 21:30:31', 49.98, 'active', '2025-04-30 12:12:47'),
(36, 31, 4, NULL, 0.00, 'active', '2025-04-30 14:38:09'),
(37, 32, 6, NULL, 0.00, 'active', '2025-04-30 18:30:40'),
(38, 33, 4, NULL, 0.00, 'active', '2025-04-30 21:24:08'),
(39, 34, 7, '2025-04-30 22:30:28', 39.99, 'active', '2025-04-30 21:43:13'),
(40, 35, 4, NULL, 132.94, 'active', '2025-04-30 23:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `SESSION_ITEMS`
--

CREATE TABLE `SESSION_ITEMS` (
  `PRODUCT_ID` int(11) NOT NULL,
  `SESSION_ID` int(11) NOT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `PRICE` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SESSION_ITEMS`
--

INSERT INTO `SESSION_ITEMS` (`PRODUCT_ID`, `SESSION_ID`, `QUANTITY`, `PRICE`) VALUES
(1, 35, 1, 19.99),
(2, 34, 1, 29.99),
(2, 35, 1, 29.99);

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `USER_ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(50) DEFAULT NULL,
  `LAST_NAME` varchar(50) DEFAULT NULL,
  `MIDDLE_INT` char(1) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `PHONE_NUM` varchar(20) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `ROLE_TYPE` varchar(50) DEFAULT NULL,
  `ACCOUNT_CREATION` datetime DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `SESSION_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`USER_ID`, `FIRST_NAME`, `LAST_NAME`, `MIDDLE_INT`, `EMAIL`, `PHONE_NUM`, `ADDRESS`, `ROLE_TYPE`, `ACCOUNT_CREATION`, `PASSWORD`, `SESSION_ID`) VALUES
(1, 'Joe', 'Nobody', 'L', 'joenobody@petunia.com', '973-555-1000', '1000 Speedwell Ave, Morristown, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(2, 'Jane', 'Kim', 'S', 'janekim@petunia.com', '201-555-1001', '456 Washington Blvd, Jersey City, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(3, 'Jim', 'Kornette', 'C', 'jimkornette@petunia.com', '862-555-1002', '123 Broad St, Newark, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(4, 'John', 'Doe', 'A', 'john.doe1@petunia.com', '908-555-2001', '546 Federal St, Camden, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(5, 'Alice', 'Green', 'B', 'alice.green@petunia.com', '908-555-2002', '321 Elmora Ave, Elizabeth, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(6, 'Mark', 'Johnson', 'C', 'mark.johnson@petunia.com', '908-555-2003', '654 Oak Tree Rd, Edison, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(7, 'Samantha', 'Lee', 'D', 'samantha.lee@petunia.com', '908-555-2004', '789 Grove St, Jersey City, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(8, 'Carlos', 'Miller', 'E', 'carlos.miller@petunia.com', '908-555-2005', '546 Federal St, Camden, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(9, 'Tom', 'Taylor', 'G', 'tom.taylor@petunia.com', '908-555-2007', '987 State St, Trenton, NJ', 'Employee', '2025-04-28 10:52:58', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', NULL),
(27, '2', '2', NULL, '2@z', '222-222-222', '2', 'Customer', '2025-04-29 20:21:23', '$2y$10$Hmni38gyNNv8yfg/UhAh8.afUOuPphzIU3cLq22eJF0VNRjrrTSb.', 32),
(28, '2', '2', NULL, '1@z', '1', '1', 'Customer', '2025-04-29 21:08:21', '$2y$10$udvUreD6iAJ0RLr96e7UhudmGlxFHKVeB5Z7Lb2GOjo1bTL84ARTS', 33),
(29, '2', '2', NULL, '2@2', '2', '2', 'Customer', '2025-04-29 21:39:22', '$2y$10$flQO5rhWuY6goSjTZALK9uWjbyg2I4JaIULt3dGkQo9aFGocPetoO', 34),
(31, 'Adam', 'oasdasndgjsjaf', 'm', 'ad@mont', '973-999-999', 'mad', 'Employee', '2025-04-30 14:38:09', '$2y$10$BMBbETkcMxUTBLQVTBbIxeDpZMP7lrFurkqZdKWE5YV3SJpyvzDr.', 36),
(32, 'adam_admin', 'o', 'm', 'ad@mont2', '213-441-451', 'asdasd', 'Employee', '2025-04-30 18:30:40', '$2y$10$zMNMMxHqtNtSKafoNXI1Ee.wQobbsWBx8DcrRzcwn/yiULwmopvAG', 37),
(33, 'adam_test', 'test', 'm', 'ad@mont3', '213', 'asdadsa', 'Employee', '2025-04-30 21:24:08', '$2y$10$5adOcf9XY1ZVyZB1M4yNquM68MjCMLp1Ag2Myb4xEQKXyjJB52p/K', 38),
(34, 'test1', 'D', NULL, '1231@p', '123', '123', 'Customer', '2025-04-30 21:43:13', '$2y$10$OwPVgpNDE76R2AWJ5tV/sOgaokdLy2XA.e7GUa4olzJrVOUCmQnr6', 39),
(35, 'sample', 'sample', NULL, 'sample@sample', '1', 'sample', 'Customer', '2025-04-30 23:18:08', '$2y$10$sSH4yfvzjeRFTVFP5FximurWCa/PFPefR0QApKdrB1AtxWaNC0WMC', 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ABOUT`
--
ALTER TABLE `ABOUT`
  ADD PRIMARY KEY (`ABOUT_ID`);

--
-- Indexes for table `DEPARTMENT`
--
ALTER TABLE `DEPARTMENT`
  ADD PRIMARY KEY (`DEPARTMENT_ID`);

--
-- Indexes for table `EMPLOYEE`
--
ALTER TABLE `EMPLOYEE`
  ADD PRIMARY KEY (`EMPLOYEE_ID`),
  ADD KEY `MANAGER_ID` (`MANAGER_ID`),
  ADD KEY `DEPARTMENT_ID` (`DEPARTMENT_ID`);

--
-- Indexes for table `PRODUCTS`
--
ALTER TABLE `PRODUCTS`
  ADD PRIMARY KEY (`PRODUCT_ID`),
  ADD KEY `EMPLOYEE_ID` (`EMPLOYEE_ID`);

--
-- Indexes for table `RECEIPT`
--
ALTER TABLE `RECEIPT`
  ADD PRIMARY KEY (`RECEIPT_ID`),
  ADD KEY `SESSION_ID` (`SESSION_ID`);

--
-- Indexes for table `RECEIPT_ITEMS`
--
ALTER TABLE `RECEIPT_ITEMS`
  ADD PRIMARY KEY (`RECEIPT_ITEM_ID`);

--
-- Indexes for table `SESSION`
--
ALTER TABLE `SESSION`
  ADD PRIMARY KEY (`SESSION_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `EMPLOYEE_ID` (`EMPLOYEE_ID`);

--
-- Indexes for table `SESSION_ITEMS`
--
ALTER TABLE `SESSION_ITEMS`
  ADD PRIMARY KEY (`PRODUCT_ID`,`SESSION_ID`),
  ADD KEY `SESSION_ID` (`SESSION_ID`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`USER_ID`),
  ADD KEY `fk_user_session` (`SESSION_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DEPARTMENT`
--
ALTER TABLE `DEPARTMENT`
  MODIFY `DEPARTMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `EMPLOYEE`
--
ALTER TABLE `EMPLOYEE`
  MODIFY `EMPLOYEE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `PRODUCTS`
--
ALTER TABLE `PRODUCTS`
  MODIFY `PRODUCT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `RECEIPT`
--
ALTER TABLE `RECEIPT`
  MODIFY `RECEIPT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `RECEIPT_ITEMS`
--
ALTER TABLE `RECEIPT_ITEMS`
  MODIFY `RECEIPT_ITEM_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `SESSION`
--
ALTER TABLE `SESSION`
  MODIFY `SESSION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `USER`
--
ALTER TABLE `USER`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `USER`
--
ALTER TABLE `USER`
  ADD CONSTRAINT `fk_user_session` FOREIGN KEY (`SESSION_ID`) REFERENCES `SESSION` (`SESSION_ID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
