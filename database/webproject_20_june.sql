-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2026 at 04:39 PM
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
-- Database: `webproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_status`
--

CREATE TABLE `admin_status` (
  `as_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin_status`
--

INSERT INTO `admin_status` (`as_id`, `status`) VALUES
(1, 'approve'),
(2, 'reject'),
(3, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE `approval` (
  `a_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`a_id`, `status`) VALUES
(1, 'approved'),
(2, 'rejected'),
(3, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `c_name`) VALUES
(1, 'Development Boards'),
(2, 'Sensors'),
(3, 'Power Supplies'),
(4, 'Transformers'),
(5, 'Bulbs'),
(6, 'Motors'),
(7, 'Development Boards'),
(8, 'Sensors'),
(9, 'Power Supplies'),
(10, 'Transformers'),
(11, 'Bulbs'),
(12, 'Motors'),
(13, 'Displays'),
(14, 'Batteries'),
(15, 'Measurement Tools'),
(16, 'Connectors'),
(17, 'Modules'),
(18, 'Arduino Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `d_id` int(11) NOT NULL,
  `district` varchar(45) DEFAULT NULL,
  `province_pr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`d_id`, `district`, `province_pr_id`) VALUES
(1, 'colobmo', 1),
(2, 'gampaha', 1),
(3, 'kaluthara', 1),
(4, 'jaffna', 2),
(5, 'kilinochchi', 2),
(6, 'mullathivu', 2),
(7, 'mannar', 2),
(8, 'vavuniya', 2),
(9, 'thrinkomalee', 3),
(10, 'battikaloa', 3),
(11, 'ampara', 3),
(12, 'galle', 4),
(13, 'matara', 4),
(14, 'hambantota', 4),
(15, 'badulla', 5),
(16, 'monaragala', 5),
(17, 'kegalle', 6),
(18, 'rathnapura', 6),
(19, 'kandy', 7),
(20, 'matale', 7),
(21, 'nuwaraeliya', 7),
(22, 'anuradhapura', 8),
(23, 'polonnaruwa', 8),
(24, 'kurunegala', 9),
(25, 'puttalama', 9);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gender_id`, `gender`) VALUES
(1, 'MALE'),
(2, 'FEMALE');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `inv_id` int(11) NOT NULL,
  `path` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`inv_id`, `path`, `date`, `amount`, `type`) VALUES
(1, '../invoices/invoice_1781983736.pdf', '2026-06-20', 8000, 1),
(2, '../invoices/invoice_1781984773.pdf', '2026-06-20', 6000, 1),
(3, '../invoices/invoice_1781984861.pdf', '2026-06-20', 10000, 1),
(4, '../invoices/invoice_1781985151.pdf', '2026-06-20', 6000, 1),
(5, '../invoices/invoice_1781985506.pdf', '2026-06-20', 16000, 1),
(6, '../invoices/invoice_1781986038.pdf', '2026-06-20', 4000, 1),
(7, '../invoices/invoice_1781986182.pdf', '2026-06-20', 0, 1),
(8, '../invoices/invoice_1781986191.pdf', '2026-06-20', 0, 1),
(9, '../invoices/invoice_1781986454.pdf', '2026-06-20', 6000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_type`
--

CREATE TABLE `invoice_type` (
  `id` int(11) NOT NULL,
  `type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `invoice_type`
--

INSERT INTO `invoice_type` (`id`, `type`) VALUES
(1, 'selling'),
(2, 'purchasing');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `message` longtext DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `seen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `message`, `time`, `sender`, `receiver`, `seen`) VALUES
(1, 'You have new order. Time: 2026-06-20 21:52:31', '2026-06-20 21:52:31', 1, 3, 1),
(2, 'You have new order. Time: 2026-06-20 21:58:26', '2026-06-20 21:58:26', 1, 3, 1),
(3, 'You have new order. Time: 2026-06-20 22:07:18', '2026-06-20 22:07:18', 1, 3, 1),
(6, 'New order received', '2026-06-20 22:14:14', 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(45) DEFAULT NULL,
  `price` double DEFAULT 0,
  `category` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `price`, `category`, `seller_id`, `qty`) VALUES
(1, '344', NULL, 0, NULL, 0),
(2, 'BUCK CONVERTER', 250, 0, NULL, NULL),
(3, '12V 5A SMPS', 1500, 3, NULL, NULL),
(4, '12V 10A SMPS', 2000, 3, NULL, 10),
(5, '12V 20A SMPS', 2500, 3, NULL, NULL),
(6, 'Arduino UNO', 1100, 1, NULL, NULL),
(7, 'Arduino UNO R3', 1100, 1, 3, NULL),
(8, 'Arduino Mega 2560', 2200, 1, 3, NULL),
(9, 'NodeMCU ESP8266', 950, 1, 3, NULL),
(10, 'ESP32 Dev Board', 1800, 1, 3, NULL),
(11, 'HC-SR04 Ultrasonic Sensor', 350, 2, 3, NULL),
(12, 'DHT11 Temperature Sensor', 250, 2, 3, NULL),
(13, 'IR Obstacle Sensor', 300, 2, 3, NULL),
(14, 'MQ-2 Gas Sensor', 450, 2, 3, NULL),
(15, '12V 5A SMPS', 1500, 3, 3, NULL),
(16, '12V 10A SMPS', 2000, 3, 3, 7),
(17, '24V 5A Power Supply', 2800, 3, 3, NULL),
(18, '220V to 12V Transformer', 1800, 4, 3, NULL),
(19, '220V to 24V Transformer', 2200, 4, 3, NULL),
(20, 'LED Bulb 5W', 350, 5, 3, NULL),
(21, 'LED Bulb 12W', 550, 5, 3, NULL),
(22, 'N20 Gear Motor', 700, 6, 3, NULL),
(23, '775 DC Motor', 1200, 6, 3, NULL),
(24, '16x2 LCD Display', 400, 7, 3, NULL),
(25, '18650 Battery', 750, 8, 3, NULL),
(26, 'Digital Multimeter DT830D', 1500, 9, 3, NULL),
(27, 'LM2596 Buck Converter', 250, 11, 3, NULL),
(28, 'L298N Motor Driver', 450, 11, 3, NULL),
(29, 'Servo Motor SG90', 550, 6, 3, NULL),
(30, 'Jumper Wire Set', 300, 12, 3, NULL),
(31, 'Breadboard 830 Points', 400, 12, 3, NULL),
(32, 'Relay Module 2 Channel', 450, 11, 3, NULL),
(33, 'DS3231 RTC Module', 350, 11, 3, NULL),
(34, 'MAX7219 LED Matrix Module', 600, 11, 3, NULL),
(35, 'OLED Display 0.96\"', 950, 7, 3, NULL),
(36, 'INA219 Current Sensor', 500, 2, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_has_seller`
--

CREATE TABLE `product_has_seller` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `admin_status_as_id` int(11) NOT NULL,
  `seller_status_s_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `path` varchar(100) DEFAULT NULL,
  `product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `path`, `product`) VALUES
(1, '../assests/images/products/OIP.webp', 16);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `pr_id` int(11) NOT NULL,
  `province` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`pr_id`, `province`) VALUES
(1, 'western'),
(2, 'Northern'),
(3, 'eastern'),
(4, 'south'),
(5, 'Uwa'),
(6, 'Sabaragamuwa'),
(7, 'central'),
(8, 'North Central'),
(9, 'North Western');

-- --------------------------------------------------------

--
-- Table structure for table `seller_status`
--

CREATE TABLE `seller_status` (
  `s_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `seller_status`
--

INSERT INTO `seller_status` (`s_id`, `status`) VALUES
(1, 'show'),
(2, 'hide'),
(3, 'deleted');

-- --------------------------------------------------------

--
-- Table structure for table `selling`
--

CREATE TABLE `selling` (
  `s_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `invoice` int(11) NOT NULL,
  `order_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `selling`
--

INSERT INTO `selling` (`s_id`, `user`, `product`, `quantity`, `date`, `amount`, `invoice`, `order_status`) VALUES
(1, 15, 16, 3, '2026-06-20', 6000, 2, 1),
(2, 15, 16, 3, '2026-06-20', 6000, 4, 1),
(3, 15, 16, 8, '2026-06-20', 16000, 5, 1),
(4, 15, 16, 2, '2026-06-20', 4000, 6, 1),
(5, 15, 1, 5, '2026-06-20', 0, 7, 1),
(6, 15, 1, 5, '2026-06-20', 0, 8, 1),
(7, 15, 16, 3, '2026-06-20', 6000, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `selling_status`
--

CREATE TABLE `selling_status` (
  `status_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `selling_status`
--

INSERT INTO `selling_status` (`status_id`, `status`) VALUES
(1, 'pending'),
(2, 'shipped');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `gender` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `district` int(11) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `zip_code` char(5) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `approval` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `contact_no`, `gender`, `user_type`, `district`, `address`, `zip_code`, `image_id`, `approval`, `status`) VALUES
(1, 'admin', '1234', 'admin@gmail.com', '2122', 1, 1, 0, NULL, NULL, 0, 1, 'ACTIVE'),
(2, 'customer', '1234', 'cus@gmail.com', '2122', 1, 3, 0, NULL, NULL, 0, 1, 'ACTIVE'),
(3, 'seller', '1234', 'seller@gmail.com', '2122', 1, 2, 0, NULL, NULL, 0, 1, 'ACTIVE'),
(6, 'induranga', '112', 'induranga21297@gmail.com', '0789677660', 1, 3, 17, '111', '10017', NULL, 1, 'ACTIVE'),
(7, 'saman', '1234', 'saman@gmail.com', '0785466987', 1, 3, 12, 'no.21', '10014', NULL, 1, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`type_id`, `type`) VALUES
(1, 'admin'),
(2, 'seller'),
(3, 'buyer');

-- --------------------------------------------------------

--
-- Table structure for table `viewstt`
--

CREATE TABLE `viewstt` (
  `id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `viewstt`
--

INSERT INTO `viewstt` (`id`, `status`) VALUES
(1, 'unseen'),
(2, 'seen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_status`
--
ALTER TABLE `admin_status`
  ADD PRIMARY KEY (`as_id`);

--
-- Indexes for table `approval`
--
ALTER TABLE `approval`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`d_id`),
  ADD KEY `fk_district_province1_idx` (`province_pr_id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `fk_invoice_invoice_type1_idx` (`type`);

--
-- Indexes for table `invoice_type`
--
ALTER TABLE `invoice_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_message_user_idx` (`sender`),
  ADD KEY `fk_message_user1_idx` (`receiver`),
  ADD KEY `fk_message_viewstt1_idx` (`seen`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `fk_product_category_idx` (`category`);

--
-- Indexes for table `product_has_seller`
--
ALTER TABLE `product_has_seller`
  ADD PRIMARY KEY (`product_id`,`user_id`),
  ADD KEY `fk_product_has_user_user2_idx` (`user_id`),
  ADD KEY `fk_product_has_user_product2_idx` (`product_id`),
  ADD KEY `fk_product_has_seller_admin_status1_idx` (`admin_status_as_id`),
  ADD KEY `fk_product_has_seller_seller_status1_idx` (`seller_status_s_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_image_product1_idx` (`product`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`pr_id`);

--
-- Indexes for table `seller_status`
--
ALTER TABLE `seller_status`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `selling`
--
ALTER TABLE `selling`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `fk_product_has_user_user1_idx` (`user`),
  ADD KEY `fk_product_has_user_product1_idx` (`product`),
  ADD KEY `fk_selling_invoice1_idx` (`invoice`),
  ADD KEY `fk_selling_selling_status1_idx` (`order_status`);

--
-- Indexes for table `selling_status`
--
ALTER TABLE `selling_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_user_gender1_idx` (`gender`),
  ADD KEY `fk_user_user_type1_idx` (`user_type`),
  ADD KEY `fk_user_district1_idx` (`district`),
  ADD KEY `fk_user_user_image1_idx` (`image_id`),
  ADD KEY `fk_user_approval1_idx` (`approval`);

--
-- Indexes for table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `viewstt`
--
ALTER TABLE `viewstt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_status`
--
ALTER TABLE `admin_status`
  MODIFY `as_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `approval`
--
ALTER TABLE `approval`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seller_status`
--
ALTER TABLE `seller_status`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `selling`
--
ALTER TABLE `selling`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `selling_status`
--
ALTER TABLE `selling_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `viewstt`
--
ALTER TABLE `viewstt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_pr_id`) REFERENCES `province` (`pr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_invoice_invoice_type1` FOREIGN KEY (`type`) REFERENCES `invoice_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_user` FOREIGN KEY (`sender`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_message_user1` FOREIGN KEY (`receiver`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_message_viewstt1` FOREIGN KEY (`seen`) REFERENCES `viewstt` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category`) REFERENCES `category` (`c_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_has_seller`
--
ALTER TABLE `product_has_seller`
  ADD CONSTRAINT `fk_product_has_seller_admin_status1` FOREIGN KEY (`admin_status_as_id`) REFERENCES `admin_status` (`as_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_has_seller_seller_status1` FOREIGN KEY (`seller_status_s_id`) REFERENCES `seller_status` (`s_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_has_user_product2` FOREIGN KEY (`product_id`) REFERENCES `product` (`p_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_has_user_user2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `fk_product_image_product1` FOREIGN KEY (`product`) REFERENCES `product` (`p_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `selling`
--
ALTER TABLE `selling`
  ADD CONSTRAINT `fk_product_has_user_product1` FOREIGN KEY (`product`) REFERENCES `product` (`p_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_has_user_user1` FOREIGN KEY (`user`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_selling_invoice1` FOREIGN KEY (`invoice`) REFERENCES `invoice` (`inv_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_selling_selling_status1` FOREIGN KEY (`order_status`) REFERENCES `selling_status` (`status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_approval1` FOREIGN KEY (`approval`) REFERENCES `approval` (`a_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_district1` FOREIGN KEY (`district`) REFERENCES `district` (`d_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_gender1` FOREIGN KEY (`gender`) REFERENCES `gender` (`gender_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_user_image1` FOREIGN KEY (`image_id`) REFERENCES `user_image` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_user_type1` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
