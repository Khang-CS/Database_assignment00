-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2022 at 05:13 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `Account_ID` int(11) NOT NULL,
  `FName` varchar(255) NOT NULL,
  `LName` varchar(255) NOT NULL,
  `TelephoneNum` varchar(15) DEFAULT NULL,
  `Start_date` datetime DEFAULT current_timestamp(),
  `Address` varchar(255) DEFAULT NULL,
  `Birthday` date NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ROLE_NO` int(11) NOT NULL,
  `Deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`Account_ID`, `FName`, `LName`, `TelephoneNum`, `Start_date`, `Address`, `Birthday`, `Email`, `Password`, `ROLE_NO`, `Deleted`) VALUES
(18, 'khang', 'nguyen', '0904473064', '2022-12-02 13:42:36', '323, Pham Van Chieu, P14, Go Vap, TPHCM', '2002-02-07', '123@gmail.com', '1f2f7b6c22218522f8cb879939b5ed37', 4, 0),
(19, 'Khang', 'Nguyen Huu', '0913704202', '2022-12-02 13:47:20', '323, Pham Văn Chiêu', '2002-02-07', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0),
(22, 'Tuan', 'Vu', '0913704201', '2022-12-02 14:33:55', '323, Ly ThuonG kiet', '1999-09-07', 'staff@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 0),
(24, 'Hien ', 'Thuc', '0981112866', '2022-12-02 15:09:26', '300, Le Dai Hãn', '1996-02-09', 'normal_staff@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1),
(26, 'Mạnh', 'Toan', '0998876678', '2022-12-04 03:52:27', '66, Lê tèo, hcm', '1990-02-07', '456@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 4, 0),
(28, 'Tung', 'Duong', '0117773889', '2022-12-04 22:18:05', 'Quan 1, Ho Chi Minh', '1999-02-08', 'tung@gmail.com', '1b8d23600288e0277850eea3d7ec13ca', 4, 0),
(29, 'Long', 'Le', '090567771', '2022-12-04 22:44:12', '441, No Trang Long, HCMC', '1999-02-07', 'normal_staff2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `Author_ID` int(11) NOT NULL,
  `Fullname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`Author_ID`, `Fullname`) VALUES
(4, 'J.K Rowling'),
(5, 'Paulo Coelho'),
(6, 'Jimmy Gordon'),
(7, 'Maria Hill'),
(8, 'Kendall Jenner'),
(9, 'Cristiano Ronaldo'),
(12, 'John Vince'),
(13, 'David Blank'),
(14, 'Alex Kandro'),
(17, 'Kim Kardashian West'),
(18, 'David Jones');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `Product_ID` int(11) NOT NULL,
  `Publish_year` year(4) NOT NULL,
  `Quantity_in_store` int(11) NOT NULL,
  `CATEG_ID` int(11) NOT NULL
) ;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`Product_ID`, `Publish_year`, `Quantity_in_store`, `CATEG_ID`) VALUES
(13, 2001, 300, 6),
(15, 2011, 286, 6),
(16, 2017, 2, 6),
(17, 2015, 2, 6),
(18, 2011, 300, 6),
(19, 2010, 300, 7),
(24, 2022, 300, 17),
(27, 2022, 300, 16);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Name`) VALUES
(6, 'Fiction'),
(7, 'Religions'),
(16, 'Education'),
(17, 'Biography');

-- --------------------------------------------------------

--
-- Table structure for table `discount_code`
--

CREATE TABLE `discount_code` (
  `Code_ID` int(11) NOT NULL,
  `Discount` decimal(3,2) DEFAULT NULL CHECK (`Discount` >= 0 and `Discount` <= 1),
  `Expiration_date` date NOT NULL,
  `Name` varchar(255) DEFAULT 'Ma giam gia',
  `ACC_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `magazine_seri`
--

CREATE TABLE `magazine_seri` (
  `Product_ID` int(11) NOT NULL,
  `Duration` int(11) NOT NULL
) ;

--
-- Dumping data for table `magazine_seri`
--

INSERT INTO `magazine_seri` (`Product_ID`, `Duration`) VALUES
(21, 3),
(22, 3),
(23, 7),
(29, 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_ID` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Total_amount` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `CODE_ID` int(11) DEFAULT NULL,
  `ACC_ID` int(11) NOT NULL,
  `METHOD_ID` int(11) NOT NULL,
  `Note` varchar(255) DEFAULT NULL,
  `pay_date` datetime DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_ID`, `Status`, `Total_amount`, `Address`, `CODE_ID`, `ACC_ID`, `METHOD_ID`, `Note`, `pay_date`) VALUES
(22, 'Delivering', 7, '323, Pham Van Chieu, P14, Go Vap, TPHCM', NULL, 18, 1, 'cảm ơn', '2022-12-04 01:52:19');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `Detail_ID` int(11) NOT NULL,
  `Price` int(11) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `Total_cost` int(11) DEFAULT NULL,
  `ORDERID` int(11) NOT NULL,
  `PID` int(11) NOT NULL
) ;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`Detail_ID`, `Price`, `Quantity`, `Total_cost`, `ORDERID`, `PID`) VALUES
(6, 3, 1, 3, 22, 18),
(7, 4, 1, 4, 22, 22);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Thumbnail` varchar(255) DEFAULT NULL,
  `Name` varchar(255) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Discount_price` int(11) DEFAULT NULL,
  `Publisher` varchar(255) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Deleted` int(11) DEFAULT 0
) ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Thumbnail`, `Name`, `Product_ID`, `Price`, `Discount_price`, `Publisher`, `Description`, `Deleted`) VALUES
('harry.jpg', 'Harry Potter And The Cursed Child', 13, 21, 9, 'Warner Bros', 'The first preview of the play took place a few days ago and the response was ECSTATIC – it had the audience spellbound, with a standing ovation at the end.', 0),
('9781408855935.jpeg', 'Harry Potter and the Order of the Phoenix', 15, 30, 20, 'Warner Bros', 'Another good book from JK Rowling', 0),
('9781408865453.jpg', 'Harry Potter And The Deathly Hallows', 16, 21, 0, 'Macmillan Publishers', 'Deathly Voldemort is coming', 0),
('9780722532935_1.jpg', 'The Alchemist', 17, 15, 0, 'HarperCollins Publishers', 'A global phenomenon, The Alchemist has been read and loved by over 62 million readers', 0),
('38313371._SY475_.jpg', 'The Witch Of Portobello', 18, 10, 3, 'Macmillan Publisher', 'Dream is endless, Paulo Coelho imagination is endless.', 0),
('image_128701_thanh_ly.jpg', 'The Valkyries', 19, 20, 10, 'Macmillan Publisher', 'The Valkyries of God', 0),
('INC_Cover_AndreaHenricks.jpg', 'INCLUSION', 21, 2, 0, 'PlayBoy', 'good Magazine', 0),
('lex (1).jpg', 'Vogue', 22, 10, 4, 'Vogue', 'good Magazine for woman', 0),
('A1iiLPi1rL-785x1024.jpg', 'Vogue 3', 23, 2, 1, 'Vogue', 'Another Magazine by Kendall Jenner', 0),
('51orT80mDAL._AC_SY780_.jpg', 'Cristiano Ronaldo: The Biography', 24, 25, 10, 'Amazon', 'The Greatest Of All Times', 0),
('61kr0x9ubYL.jpg', 'Foundation Mathematics for Computer Science: A Visual Approach', 27, 32, 30, 'Springer', 'Fundamentals of Computer ', 0),
('1781913_13105328_3560017.jpg', 'JONES', 29, 4, 3, 'Vogue', 'Kim Story ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `ACCID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Content` varchar(255) DEFAULT NULL,
  `Rating` int(11) NOT NULL,
  `Image` varchar(255) DEFAULT NULL
) ;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Created_date`, `ACCID`, `Product_ID`, `Content`, `Rating`, `Image`) VALUES
('2022-12-04 03:33:11', 18, 13, 'SÁCH HAY', 2, 'harry.jpg'),
('2022-12-04 03:34:08', 18, 13, 'Sách hay lắm', 3, 'harry.jpg'),
('2022-12-04 03:52:52', 26, 13, 'Sách dở ẹc', 1, 'harry.jpg'),
('2022-12-04 10:46:57', 18, 15, 'Sách hay nhưng phục vụ không tốt', 4, '9781408855935.jpeg'),
('2022-12-04 11:38:28', 18, 15, 'Sách dở ẹc', 3, '2022-01-14_22-20-27.png'),
('2022-12-04 11:39:22', 18, 15, 'bìa sách mỏng dễ rách', 2, '2022-04-06_02-53-43.png'),
('2022-12-04 18:24:50', 18, 18, 'sách ko hay lắm', 3, '2022-05-05_04-28-00.png'),
('2022-12-04 20:47:52', 18, 27, 'Greatest book of the year', 5, 'IMG_0553.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `Role_ID` int(11) NOT NULL,
  `Role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`Role_ID`, `Role_name`) VALUES
(1, 'quanly'),
(2, 'nhanvienthuong'),
(3, 'nhanvienkho'),
(4, 'khachhang');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE `shipping_method` (
  `Method_ID` int(11) NOT NULL,
  `Fee` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`Method_ID`, `Fee`, `Name`) VALUES
(1, 20, 'Giao hàng tiết kiệm'),
(2, 25, 'Giao hàng nhanh'),
(3, 30, 'Hỏa tốc');

-- --------------------------------------------------------

--
-- Table structure for table `writee`
--

CREATE TABLE `writee` (
  `AUTHOR_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `writee`
--

INSERT INTO `writee` (`AUTHOR_ID`, `PRODUCT_ID`) VALUES
(4, 13),
(4, 15),
(4, 16),
(5, 17),
(5, 18),
(5, 19),
(7, 21),
(7, 23),
(8, 22),
(9, 24),
(12, 27),
(13, 27),
(14, 27),
(17, 29),
(18, 29);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`Account_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `ROLE_NO` (`ROLE_NO`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`Author_ID`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `CATEG_ID` (`CATEG_ID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `discount_code`
--
ALTER TABLE `discount_code`
  ADD PRIMARY KEY (`Code_ID`),
  ADD KEY `ACC_ID` (`ACC_ID`);

--
-- Indexes for table `magazine_seri`
--
ALTER TABLE `magazine_seri`
  ADD PRIMARY KEY (`Product_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `CODE_ID` (`CODE_ID`),
  ADD KEY `ACC_ID` (`ACC_ID`),
  ADD KEY `METHOD_ID` (`METHOD_ID`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`Detail_ID`),
  ADD KEY `ORDERID` (`ORDERID`),
  ADD KEY `PID` (`PID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`Created_date`,`ACCID`),
  ADD KEY `ACCID` (`ACCID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`Role_ID`);

--
-- Indexes for table `shipping_method`
--
ALTER TABLE `shipping_method`
  ADD PRIMARY KEY (`Method_ID`);

--
-- Indexes for table `writee`
--
ALTER TABLE `writee`
  ADD PRIMARY KEY (`AUTHOR_ID`,`PRODUCT_ID`),
  ADD KEY `PRODUCT_ID` (`PRODUCT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `Account_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `Author_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `discount_code`
--
ALTER TABLE `discount_code`
  MODIFY `Code_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `Detail_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `shipping_method`
--
ALTER TABLE `shipping_method`
  MODIFY `Method_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`ROLE_NO`) REFERENCES `role` (`Role_ID`);

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`CATEG_ID`) REFERENCES `category` (`Category_ID`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `discount_code`
--
ALTER TABLE `discount_code`
  ADD CONSTRAINT `discount_code_ibfk_1` FOREIGN KEY (`ACC_ID`) REFERENCES `account` (`Account_ID`);

--
-- Constraints for table `magazine_seri`
--
ALTER TABLE `magazine_seri`
  ADD CONSTRAINT `magazine_seri_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CODE_ID`) REFERENCES `discount_code` (`Code_ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ACC_ID`) REFERENCES `account` (`Account_ID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`METHOD_ID`) REFERENCES `shipping_method` (`Method_ID`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`ORDERID`) REFERENCES `orders` (`Order_ID`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`PID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`ACCID`) REFERENCES `account` (`Account_ID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `writee`
--
ALTER TABLE `writee`
  ADD CONSTRAINT `writee_ibfk_1` FOREIGN KEY (`AUTHOR_ID`) REFERENCES `author` (`Author_ID`),
  ADD CONSTRAINT `writee_ibfk_2` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product` (`Product_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
