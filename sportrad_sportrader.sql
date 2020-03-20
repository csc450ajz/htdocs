-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2020 at 08:00 PM
-- Server version: 10.3.22-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportrad_sportrader`
--
CREATE DATABASE IF NOT EXISTS `sportrad_sportrader` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sportrad_sportrader`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `createAccount` (IN `newEmail` VARCHAR(100), IN `newFName` VARCHAR(100), IN `newLName` VARCHAR(100), IN `newType` VARCHAR(20), IN `newPassword` VARCHAR(255), IN `newBalance` FLOAT, IN `newStreet` VARCHAR(100), IN `newState` VARCHAR(2), IN `newZip` INT(20), IN `newCity` VARCHAR(100))  NO SQL
BEGIN
	INSERT INTO Address(addressStreet, addressState, addressZip, addressCity) VALUES (newStreet, newState, newZip, newCity);
	INSERT INTO User(userEmail, userFName, userLName, userType, userPassword, addressId, userBalance) 
    VALUES(newEmail, newFName, newLName, newType, newPassword, (SELECT addressId from Address WHERE Address.addressStreet = newStreet AND Address.addressZip = newZip LIMIT 1), newBalance);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCartItems` (IN `email` VARCHAR(100))  BEGIN	
	SELECT * FROM CartItems WHERE CartItems.userEmail = email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getFeaturedProducts` ()  BEGIN
	SELECT * FROM Product LIMIT 4;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductInfo` (IN `requestId` INT(20))  BEGIN
	SELECT * FROM Product WHERE Product.productId = requestId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductReview` (IN `requestId` INT(20))  NO SQL
    COMMENT 'Gets review for a specific product.'
BEGIN
	SELECT * FROM ProductReview WHERE ProductReview.productId = requestId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCartItem` (IN `cartProductId` INT(20), IN `cartUserEmail` VARCHAR(100))  BEGIN
	INSERT INTO CartItems (productId, userEmail) VALUES (cartProductId, cartUserEmail);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Address`
--

CREATE TABLE `Address` (
  `addressID` int(20) NOT NULL,
  `addressStreet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addressState` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addressZip` int(20) NOT NULL,
  `addressCity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Address`
--

INSERT INTO `Address` (`addressID`, `addressStreet`, `addressState`, `addressZip`, `addressCity`) VALUES
(1, '123 Brooklynn Blvd', 'NY', 123456, ''),
(2, '456 House Blvd', 'WI', 45678, ''),
(3, '5674 First Ave', 'IA', 35292, ''),
(4, '9124 Fourth Ave', 'KS', 12419, ''),
(9, 'Ryan Street', 'NY', 55555, 'Top Hat Falls'),
(10, 'MyHouse', 'NY', 88888, 'Valley Hill'),
(11, 'MyHouse', 'NY', 88888, 'Finland');

-- --------------------------------------------------------

--
-- Table structure for table `Brand`
--

CREATE TABLE `Brand` (
  `brandId` int(20) NOT NULL,
  `brandName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brandStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Brand`
--

INSERT INTO `Brand` (`brandId`, `brandName`, `brandStatus`) VALUES
(1, 'Nike', 'active'),
(2, 'Adidas', 'active'),
(3, 'Spalding', 'active'),
(4, 'Ogio', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `CartItems`
--

CREATE TABLE `CartItems` (
  `userEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productId` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `CartItems`
--

INSERT INTO `CartItems` (`userEmail`, `productId`) VALUES
('admin@admin.com', 3),
('bob@gmail.com', 3),
('RyanStick@sporTrader.com', 3),
('RyanStick@sporTrader.com', 4),
('RyanStick@sporTrader.com', 5),
('sally@gmail.com', 4),
('TopHat@TopHat.com', 3),
('TopHat@TopHat.com', 4),
('TopHat@TopHat.com', 5);

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `categoryId` int(20) NOT NULL,
  `categoryName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genderId` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryId`, `categoryName`, `categoryStatus`, `genderId`) VALUES
(3, 'Footwear', 'active', NULL),
(4, 'Equipment', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Gender`
--

CREATE TABLE `Gender` (
  `genderId` int(20) NOT NULL,
  `genderType` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Gender`
--

INSERT INTO `Gender` (`genderId`, `genderType`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Both');

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `messageId` int(20) NOT NULL,
  `senderEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipientEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageText` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageTime` date NOT NULL,
  `messageStatus` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `orderId` int(20) NOT NULL,
  `userEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderTotal` float NOT NULL,
  `orderDate` date NOT NULL,
  `orderDiscount` float NOT NULL,
  `orderShipAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productId` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`orderId`, `userEmail`, `orderTotal`, `orderDate`, `orderDiscount`, `orderShipAddress`, `productId`) VALUES
(1, 'test@test.com', 50, '2020-03-13', 0, '123 SomeStreet, New York, NY 11223', 4);

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `productId` int(20) NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productDesc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productPrice` float NOT NULL,
  `productCondition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productSize` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productColor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brandId` int(20) NOT NULL,
  `categoryID` int(20) NOT NULL,
  `productDiscount` float NOT NULL,
  `userEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productViews` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`productId`, `productName`, `productDesc`, `productPrice`, `productCondition`, `productSize`, `productColor`, `productStatus`, `brandId`, `categoryID`, `productDiscount`, `userEmail`, `productViews`) VALUES
(3, 'Spalding Basketball', 'This basketball is in great condition, only used twice.', 25, 'Like New', '29.5\"', 'orange', 'active', 3, 4, 0, 'bob@gmail.com', 20),
(4, 'Nike Free Run 5.0', 'This pair of running shoes is in great shape! New without tags.', 55, 'New', '11.5', 'Blue', 'active', 1, 3, 0.1, 'joe@gmail.com', 15),
(5, 'Men\'s Adidas Black Sweatshirt', 'Lightly worn Adidas Originals sweatshirt.', 15, 'Used - Good', 'Men\'s Large', 'Black', 'active', 2, 4, 0, 'sally@gmail.com', 5),
(8, 'Ogio Golf Bag', 'Great condition golf bag, ready for the upcoming season!', 120.59, 'Used - Like New', '45\" x 15\"', 'Black', 'active', 4, 4, 0, 'TopHat@TopHat.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ProductImage`
--

CREATE TABLE `ProductImage` (
  `imageID` int(20) NOT NULL,
  `isPrimary` tinyint(1) NOT NULL,
  `imagePath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productId` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProductReview`
--

CREATE TABLE `ProductReview` (
  `reviewId` int(20) NOT NULL,
  `userEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productId` int(20) NOT NULL,
  `reviewRating` int(11) NOT NULL,
  `reviewContent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ProductReview`
--

INSERT INTO `ProductReview` (`reviewId`, `userEmail`, `productId`, `reviewRating`, `reviewContent`, `reviewDate`) VALUES
(1, 'sally@gmail.com', 3, 4, 'I had a basketball like this and it was great! I wish I had bought two more', '2020-03-15');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userFName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userLName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userType` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userPassword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addressID` int(20) NOT NULL,
  `userBalance` float NOT NULL,
  `userPhotoPath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userEmail`, `userFName`, `userLName`, `userType`, `userPassword`, `addressID`, `userBalance`, `userPhotoPath`) VALUES
('admin@admin.com', 'Admin', 'Admin', 'admin', 'admin', 1, 0, ''),
('bob@gmail.com', 'Bob', 'Johnson', 'client', 'password', 4, 200, 'path_to_photo'),
('joe@gmail.com', 'Joe', 'Smith', 'client', 'password', 2, 200, 'path_to_photo'),
('RyanStick@sporTrader.com', 'Ryan', 'Stick', 'client', 'password123', 9, 50, NULL),
('sally@gmail.com', 'Sally', 'User', 'client', 'password', 3, 200, 'path_to_photo'),
('test@test.com', 'Test', 'User', 'client', 'password', 1, 200, 'path_to_photo'),
('TopHat@TopHat.com', 'Top', 'Hat', 'client', 'password', 10, 50, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Address`
--
ALTER TABLE `Address`
  ADD PRIMARY KEY (`addressID`);

--
-- Indexes for table `Brand`
--
ALTER TABLE `Brand`
  ADD PRIMARY KEY (`brandId`);

--
-- Indexes for table `CartItems`
--
ALTER TABLE `CartItems`
  ADD PRIMARY KEY (`userEmail`,`productId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`categoryId`),
  ADD KEY `genderId` (`genderId`);

--
-- Indexes for table `Gender`
--
ALTER TABLE `Gender`
  ADD PRIMARY KEY (`genderId`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `senderEmail` (`senderEmail`),
  ADD KEY `recipientEmail` (`recipientEmail`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `userEmail` (`userEmail`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`productId`),
  ADD UNIQUE KEY `brandId` (`brandId`),
  ADD UNIQUE KEY `userEmail` (`userEmail`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `ProductImage`
--
ALTER TABLE `ProductImage`
  ADD PRIMARY KEY (`imageID`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `ProductReview`
--
ALTER TABLE `ProductReview`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `userEmail` (`userEmail`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userEmail`),
  ADD KEY `FOREIGN` (`addressID`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Address`
--
ALTER TABLE `Address`
  MODIFY `addressID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Brand`
--
ALTER TABLE `Brand`
  MODIFY `brandId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `categoryId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Gender`
--
ALTER TABLE `Gender`
  MODIFY `genderId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `messageId` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `orderId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `productId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ProductImage`
--
ALTER TABLE `ProductImage`
  MODIFY `imageID` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProductReview`
--
ALTER TABLE `ProductReview`
  MODIFY `reviewId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CartItems`
--
ALTER TABLE `CartItems`
  ADD CONSTRAINT `CartItems_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CartItems_ibfk_2` FOREIGN KEY (`userEmail`) REFERENCES `User` (`userEmail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Category`
--
ALTER TABLE `Category`
  ADD CONSTRAINT `Category_ibfk_1` FOREIGN KEY (`genderId`) REFERENCES `Gender` (`genderId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`userEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Orders_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `Product` (`productID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `Product_ibfk_1` FOREIGN KEY (`brandId`) REFERENCES `Brand` (`brandId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Product_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Product_ibfk_3` FOREIGN KEY (`userEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `ProductImage`
--
ALTER TABLE `ProductImage`
  ADD CONSTRAINT `ProductImage_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `Product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProductReview`
--
ALTER TABLE `ProductReview`
  ADD CONSTRAINT `ProductReview_ibfk_1` FOREIGN KEY (`userEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductReview_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `Product` (`productID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`addressID`) REFERENCES `Address` (`addressID`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
