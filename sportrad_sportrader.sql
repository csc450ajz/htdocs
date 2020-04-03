-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 03, 2020 at 12:21 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sportrad_sportrader`
--
CREATE DATABASE IF NOT EXISTS `sportrad_sportrader` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sportrad_sportrader`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addProduct` (IN `productName` VARCHAR(255), IN `productDesc` VARCHAR(255), IN `productPrice` FLOAT, IN `productCondition` VARCHAR(255), IN `productSize` VARCHAR(255), IN `productStatus` VARCHAR(100), IN `categoryId` INT(20), IN `productBrand` VARCHAR(100), IN `genderId` INT(20), IN `productDiscount` FLOAT, IN `userEmail` VARCHAR(100), IN `productColor` VARCHAR(100))  NO SQL
BEGIN
	INSERT INTO Product (Product.productName, Product.productDesc, Product.productPrice, Product.productCondition, Product.productSize, Product.productStatus, Product.categoryID, Product.productBrand, Product.genderId, Product.productDiscount, Product.userEmail, Product.productColor) VALUES (productName, productDesc, productPrice, productCondition, productSize, productStatus, categoryId, productBrand, genderId, productDiscount, userEmail, productColor);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createAccount` (IN `newEmail` VARCHAR(100), IN `newFName` VARCHAR(100), IN `newLName` VARCHAR(100), IN `newType` VARCHAR(20), IN `newPassword` VARCHAR(255), IN `newBalance` FLOAT, IN `newStreet` VARCHAR(100), IN `newState` VARCHAR(2), IN `newZip` INT(20), IN `newCity` VARCHAR(100))  BEGIN
	INSERT INTO Address(addressStreet, addressState, addressZip, addressCity) VALUES (newStreet, newState, newZip, newCity);
	INSERT INTO User(userEmail, userFName, userLName, userType, userPassword, addressId, userBalance) 
    VALUES(newEmail, newFName, newLName, newType, newPassword, (SELECT addressId from Address WHERE Address.addressStreet = newStreet AND Address.addressZip = newZip LIMIT 1), newBalance);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteProduct` (IN `itemId` INT(20))  BEGIN
	DELETE FROM Product WHERE productId = itemId;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductReview` (IN `requestId` INT(20))  BEGIN
	SELECT * FROM ProductReview WHERE ProductReview.productId = requestId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductsBySeller` (IN `sellerEmail` VARCHAR(100))  BEGIN
	SELECT * FROM Product WHERE Product.userEmail = sellerEmail;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getPurchasedItems` (IN `email` VARCHAR(100))  BEGIN	
	SELECT * FROM Orders WHERE Orders.buyerEmail= email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSellingItems` (IN `email` VARCHAR(100))  BEGIN	
	SELECT * FROM Product WHERE Product.userEmail= email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSoldItems` (IN `email` VARCHAR(100))  BEGIN	
	SELECT * FROM Orders WHERE Orders.sellerEmail= email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCartItem` (IN `cartProductId` INT(20), IN `cartUserEmail` VARCHAR(100))  BEGIN
	INSERT INTO CartItems (productId, userEmail) VALUES (cartProductId, cartUserEmail);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `performTransaction` (IN `buyerEmail` VARCHAR(255), IN `sellerEmail` VARCHAR(100), IN `productId` INT(20), IN `orderTotal` FLOAT, IN `orderDiscount` FLOAT, IN `orderShipAddress` VARCHAR(255))  BEGIN 
	DELETE FROM CartItems WHERE CartItems.productId = productId; 
    INSERT INTO Orders (Orders.buyerEmail, Orders.sellerEmail, Orders.productId, Orders.orderTotal, Orders.orderDiscount, Orders.orderShipAddress) VALUES (buyerEmail, sellerEmail, productId, orderTotal, orderDiscount, orderShipAddress); 
    UPDATE Product SET Product.productStatus = "sold" WHERE Product.productId = productId; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProduct` (IN `productName` VARCHAR(255), IN `productDesc` VARCHAR(255), IN `productPrice` FLOAT, IN `productCondition` VARCHAR(255), IN `productSize` VARCHAR(255), IN `productColor` VARCHAR(255), IN `productStatus` VARCHAR(255), IN `productBrand` VARCHAR(100), IN `categoryId` INT(20), IN `genderId` INT(20), IN `productDiscount` FLOAT, IN `userEmail` VARCHAR(100), IN `productId` INT(20))  BEGIN
	UPDATE Product SET Product.productName = productName, Product.productDesc = productDesc, Product.productPrice = productPrice, Product.productCondition = productCondition, Product.productSize = productSize, Product.productColor = productColor, Product.productStatus = productStatus, Product.productBrand = productBrand, Product.categoryID = categoryId, Product.genderId = genderId, Product.productDiscount = productDiscount, Product.userEmail = userEmail WHERE Product.productId = productId;
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
-- Table structure for table `AdminMessages`
--

CREATE TABLE `AdminMessages` (
  `messageId` int(20) NOT NULL,
  `clientEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issueId` int(20) NOT NULL,
  `messageText` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('test@test.com', 3),
('RyanStick@sporTrader.com', 4),
('sally@gmail.com', 4),
('RyanStick@sporTrader.com', 5),
('RyanStick@sporTrader.com', 8);

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `categoryId` int(20) NOT NULL,
  `categoryName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryId`, `categoryName`, `categoryStatus`) VALUES
(3, 'Footwear', 'active'),
(4, 'Equipment', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `ChatMessages`
--

CREATE TABLE `ChatMessages` (
  `messageId` int(20) NOT NULL,
  `userEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chatId` int(20) NOT NULL,
  `messageText` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageSentTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Men'),
(2, 'Women'),
(3, 'Both');

-- --------------------------------------------------------

--
-- Table structure for table `Issue`
--

CREATE TABLE `Issue` (
  `issueId` int(20) NOT NULL,
  `clientEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issueType` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issueText` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issueDateSubmitted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `orderId` int(20) NOT NULL,
  `buyerEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sellerEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productId` int(20) NOT NULL,
  `orderTotal` float NOT NULL,
  `orderDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `orderDiscount` float NOT NULL,
  `orderShipAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`orderId`, `buyerEmail`, `sellerEmail`, `productId`, `orderTotal`, `orderDate`, `orderDiscount`, `orderShipAddress`) VALUES
(1, 'test@test.com', '', 4, 50, '2020-03-13 04:00:00', 0, '123 SomeStreet, New York, NY 11223');

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
  `categoryID` int(20) NOT NULL,
  `productDiscount` float NOT NULL DEFAULT '0',
  `userEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productViews` int(11) NOT NULL DEFAULT '0',
  `genderId` int(20) DEFAULT NULL,
  `productBrand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`productId`, `productName`, `productDesc`, `productPrice`, `productCondition`, `productSize`, `productColor`, `productStatus`, `categoryID`, `productDiscount`, `userEmail`, `productViews`, `genderId`, `productBrand`) VALUES
(3, 'Spalding Basketball', 'This basketball is in great condition, only used twice.', 25, 'Like New', '29.5\"', 'orange', 'active', 4, 0, 'bob@gmail.com', 20, NULL, NULL),
(4, 'Nike Free Run 5.0', 'This pair of running shoes is in great shape! New without tags.', 55, 'New', '11.5', 'Blue', 'active', 3, 0.1, 'joe@gmail.com', 15, NULL, NULL),
(5, 'Men\'s Adidas Black Sweatshirt', 'Lightly worn Adidas Originals sweatshirt.', 15, 'Used - Good', 'Men\'s Large', 'Black', 'active', 4, 0, 'sally@gmail.com', 5, 1, NULL),
(8, 'Ogio Golf Bag', 'Great condition golf bag, ready for the upcoming season!', 120.59, 'Used - Like New', '45\" x 15\"', 'Black', 'active', 4, 0, 'TopHat@TopHat.com', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ProductChat`
--

CREATE TABLE `ProductChat` (
  `chatId` int(20) NOT NULL,
  `buyerEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sellerEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productId` int(20) NOT NULL,
  `chatStartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `recentSender` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `AdminMessages`
--
ALTER TABLE `AdminMessages`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `clientEmail` (`clientEmail`),
  ADD KEY `issueId` (`issueId`);

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
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `ChatMessages`
--
ALTER TABLE `ChatMessages`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `userEmail` (`userEmail`),
  ADD KEY `chatId` (`chatId`);

--
-- Indexes for table `Gender`
--
ALTER TABLE `Gender`
  ADD PRIMARY KEY (`genderId`);

--
-- Indexes for table `Issue`
--
ALTER TABLE `Issue`
  ADD PRIMARY KEY (`issueId`),
  ADD KEY `clientEmail` (`clientEmail`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `productId` (`productId`),
  ADD KEY `buyerEmail` (`buyerEmail`) USING BTREE,
  ADD KEY `sellerEmail` (`sellerEmail`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `categoryID` (`categoryID`),
  ADD KEY `genderId` (`genderId`),
  ADD KEY `userEmail` (`userEmail`) USING BTREE;

--
-- Indexes for table `ProductChat`
--
ALTER TABLE `ProductChat`
  ADD PRIMARY KEY (`chatId`),
  ADD KEY `buyerEmail` (`buyerEmail`),
  ADD KEY `sellerEmail` (`sellerEmail`),
  ADD KEY `productId` (`productId`),
  ADD KEY `recentSender` (`recentSender`);

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
-- AUTO_INCREMENT for table `AdminMessages`
--
ALTER TABLE `AdminMessages`
  MODIFY `messageId` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `categoryId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ChatMessages`
--
ALTER TABLE `ChatMessages`
  MODIFY `messageId` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Gender`
--
ALTER TABLE `Gender`
  MODIFY `genderId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Issue`
--
ALTER TABLE `Issue`
  MODIFY `issueId` int(20) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `ProductChat`
--
ALTER TABLE `ProductChat`
  MODIFY `chatId` int(20) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `AdminMessages`
--
ALTER TABLE `AdminMessages`
  ADD CONSTRAINT `AdminMessages_ibfk_1` FOREIGN KEY (`clientEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `AdminMessages_ibfk_2` FOREIGN KEY (`issueId`) REFERENCES `Issue` (`issueId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `CartItems`
--
ALTER TABLE `CartItems`
  ADD CONSTRAINT `CartItems_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CartItems_ibfk_2` FOREIGN KEY (`userEmail`) REFERENCES `User` (`userEmail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ChatMessages`
--
ALTER TABLE `ChatMessages`
  ADD CONSTRAINT `ChatMessages_ibfk_1` FOREIGN KEY (`userEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ChatMessages_ibfk_2` FOREIGN KEY (`chatId`) REFERENCES `ProductChat` (`chatId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Issue`
--
ALTER TABLE `Issue`
  ADD CONSTRAINT `Issue_ibfk_1` FOREIGN KEY (`clientEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`buyerEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Orders_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Orders_ibfk_3` FOREIGN KEY (`buyerEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `Product_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Product_ibfk_4` FOREIGN KEY (`genderId`) REFERENCES `Gender` (`genderId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`userEmail`) REFERENCES `User` (`userEmail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProductChat`
--
ALTER TABLE `ProductChat`
  ADD CONSTRAINT `ProductChat_ibfk_1` FOREIGN KEY (`buyerEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductChat_ibfk_2` FOREIGN KEY (`sellerEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductChat_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductChat_ibfk_4` FOREIGN KEY (`recentSender`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `ProductImage`
--
ALTER TABLE `ProductImage`
  ADD CONSTRAINT `ProductImage_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProductReview`
--
ALTER TABLE `ProductReview`
  ADD CONSTRAINT `ProductReview_ibfk_1` FOREIGN KEY (`userEmail`) REFERENCES `User` (`userEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductReview_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`addressID`) REFERENCES `Address` (`addressID`) ON DELETE NO ACTION ON UPDATE CASCADE;
