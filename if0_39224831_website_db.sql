-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql312.infinityfree.com
-- Generation Time: Jun 30, 2025 at 10:43 AM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39224831_website_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderDetailsID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(255) NOT NULL,
  `Price` decimal(32,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderDetailsID`, `OrderID`, `ProductID`, `Quantity`, `Price`) VALUES
(1, 1, 33, 2, '0'),
(2, 5, 24, 1, '400'),
(3, 6, 24, 2, '800'),
(6, 9, 33, 1, '1200');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `BuyerID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `TotalPrice` decimal(32,0) NOT NULL,
  `OrderStatus` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `BuyerID`, `OrderDate`, `TotalPrice`, `OrderStatus`) VALUES
(1, 1, '2025-06-15', '0', ''),
(2, 15, '2025-06-20', '400', ''),
(3, 15, '2025-06-20', '400', ''),
(4, 1, '2025-06-20', '400', ''),
(5, 1, '2025-06-20', '400', ''),
(6, 1, '2025-06-20', '800', ''),
(9, 18, '2025-06-27', '1200', '');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `PaymentMethod` varchar(32) NOT NULL,
  `PaymentStatus` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` decimal(32,0) NOT NULL,
  `Category` varchar(64) NOT NULL,
  `StockQuantity` int(255) NOT NULL,
  `SellerID` int(11) NOT NULL,
  `DateAdded` date NOT NULL,
  `Product_IMG_DIR` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `Name`, `Description`, `Price`, `Category`, `StockQuantity`, `SellerID`, `DateAdded`, `Product_IMG_DIR`) VALUES
(1, 'ATH M50s Headphones', 'Studio Grade Headphones for all your audio needs.\r\nIn good Condition.\r\nHad for about 3 years.', '2000', 'Entertainment', 1, 6, '2025-05-23', 'pexels-garrettmorrow-1649771.jpg'),
(2, 'Ps4 Controller', 'Ps4 Controller\r\nCondition: New\r\nReason for Selling: Upgrade to ps5', '450', 'Entertainment', 1, 1, '2025-05-24', 'pexels-kaip-1082810.jpg'),
(3, 'Aviator Sun Glasses', 'Aviator Sun Glasses\r\nCondition: Like New\r\nReason for Selling: Cash\r\nAge: Had for about 3 years\r\nAdditional Info: UV Protection no Scratches slight bend in right stem', '250', 'Clothes', 1, 8, '2025-05-25', 'pexels-thebstudio-947885.jpg'),
(4, 'IPhone 8', 'IPhone 8\r\nCondition: Like New\r\nAge: 2 years\r\nReason for Selling: Upgrade', '3000', 'Technology', 1, 10, '2025-05-25', 'pexels-szaboviktor-32141312.jpg'),
(5, 'Marshal Portable Guitar Amp', 'Condition: Barley Used\r\nReason: Not Using\r\nAge: 1 Year', '2400', 'Speakers', 1, 10, '2025-05-25', 'pexels-zeleboba-1706694.jpg'),
(6, 'White and Black Xbox Controller', 'Brand New\r\nNeed the Cash', '1500', 'Gaming', 1, 1, '2025-05-25', 'pexels-fox-58267-1445238.jpg'),
(7, 'Kettle', 'Not used, in good condition', '100', 'Kitchen', 1, 3, '2025-05-25', 'pexels-cottonbro-4108671.jpg'),
(8, 'Rolex', 'Cool Watch ma bru', '10000', 'Accessories', 1, 4, '2025-05-25', 'pexels-pixabay-277390.jpg'),
(9, 'Lexar 128gb SD Card', '128GB SD Card For all your micro SD card needs', '300', 'Electronics', 1, 4, '2025-05-25', 'pexels-jibarofoto-1738641.jpg'),
(10, 'Custom Keyboard', 'Coiled Cable and Custom Keyboard\r\nAge: 2 Years\r\nReason: Not Used', '800', 'Gaming', 1, 10, '2025-06-03', 'pexels-fox-58267-5152260.jpg'),
(11, 'Bar Stool', 'Wooden Bar stool for sale\r\nAge: Brand New', '450', 'Home & Garden', 1, 1, '2025-06-04', 'pexels-athena-2180883.jpg'),
(12, '2008 Volkswagen GTI', '2008 Volkswagen GTI\r\nCondition: Great\r\nAge had: 5 Years\r\nAdditions:\r\nCustom Skirt\r\nCustom Exhausts', '200000', 'Vehicle', 1, 1, '2025-06-04', 'pexels-bradley-de-melo-742237632-19165516.jpg'),
(13, '2018 BMW 320D MSPORT Auto', '2018 BMW 320D MSPORT Auto\r\nAge: 2 Years\r\nCondition: Brand New\r\nReason: Time to Upgrade', '250000', 'Vehicle', 1, 3, '2025-06-04', 'pexels-framesbyambro-14776719.jpg'),
(14, 'NSPRESSO Coffee Machine', 'Age: 2 Years\r\nCondition: Used', '600', 'Appliances', 1, 4, '2025-06-04', 'pexels-sam-basun-2149533721-32339279.jpg'),
(15, '2017 Ford Maverick', 'Age: 2 Years\r\nCondition: Like New\r\nKM: 130 000kms', '180000', 'Vehicle', 1, 3, '2025-06-04', 'pexels-lenzatic-17157308.jpg'),
(16, 'Samson USB Cardoid Microphone', 'Samson USB Cardoid Microphone\r\nAge: 2 Years\r\nCondition: Used', '500', 'Electronics', 1, 1, '2025-06-04', 'pexels-magda-ehlers-pexels-1054713.jpg'),
(17, 'Apple Air Pods', 'Apple Air Pods\r\nComes With Red Case\r\nAge: 2 Years\r\nCondition: Brand New', '900', 'Electronics', 1, 10, '2025-06-04', 'pexels-soulful-pizza-2080276-3780681.jpg'),
(18, '2019 Toyota 4 Runner', '2019 Toyota 4 Runner\r\nAge: 3 Years\r\nCondition: Used\r\nReason: Life', '230000', 'Vehicle', 1, 3, '2025-06-04', 'pexels-introspectivedsgn-17519357.jpg'),
(19, 'Sanchez Electric Guitar', 'Sanchez Electric Guitar\r\nAge:1 Year\r\nCondition: Like New\r\nReason: Not Used', '850', 'Entertainment', 1, 1, '2025-06-04', 'pexels-markusspiske-92069.jpg'),
(20, '2009 Volkswagen TSI', '2009 Volkswagen TSI\r\nAge: 10 Years\r\nCondition: Used\r\nKMs: 240 000\r\nReason: Money\r\n', '170000', 'Vehicle', 1, 2, '2025-06-04', 'pexels-iwan-wasyl-3786626-5625482.jpg'),
(21, 'Toyota Hilux 2.4', 'Toyota Hilux 2.4 1999\r\nReason: Not Using\r\nKms: 320 000\r\nBrilliant Bakkie, Has a fully rebuilt engine, effectively halfing the Kms.', '100000', 'Vehicle', 1, 3, '2025-06-04', 'pexels-gasparzaldo-8671336.jpg'),
(22, 'Nintendo Switch', 'Nintendo Switch\r\nAge: 2 Years\r\nCondition: Brand New\r\nCustom DBrand Skin Included!', '4500', 'Gaming', 1, 1, '2025-06-05', 'pexels-pixabay-371924.jpg'),
(23, 'Custom Xbox Controller', 'Custom Designed X Box Controller\r\nAge: New\r\nCondition: Brand New\r\nReason: Switching to Ps4', '1800', 'Gaming', 1, 1, '2025-06-05', 'pexels-roman-odintsov-12718979.jpg'),
(24, 'Ceramic Pot for Catus and Small Pot Plants', 'Small Ceramic Pot for sale! Cactus not included!', '400', 'Home & Garden', 7, 1, '2025-06-05', 'pexels-whynugrohou-3101767.jpg'),
(25, 'AKG Studio Headphone', 'AKG Studio Headphone\r\nGreat for Professional Use\r\nImpedance: 80 ohm\r\n', '4800', 'Electronics', 5, 6, '2025-06-05', 'pexels-kinkate-205926 (1).jpg'),
(26, 'Aviator Blue Tint Glasses', 'Blue Tint Aviators Perfect for lookin Swag', '500', 'Clothing', 10, 8, '2025-06-05', 'pexels-mota-701877.jpg'),
(27, 'Black Sunglasses', 'Black Sunglasses\r\nUV Protection', '200', 'Clothing', 20, 8, '2025-06-05', 'pexels-lalesh-147641.jpg'),
(28, 'Sport Yellow Sunglasses', 'Sport Sunglasses Perfect For all your sport needs', '500', 'Clothing', 10, 8, '2025-06-05', 'pexels-aksakal-32122516.jpg'),
(29, 'Custom Sun Glasses', 'Custom Design Sunglasses', '2500', 'Clothing', 5, 8, '2025-06-05', 'pexels-luis-espero-273195-1034843.jpg'),
(30, 'Denim Jacket', 'High Quality Unisex Denim Jacket', '2500', 'Clothing', 10, 9, '2025-06-05', 'caio-coelho-QRN47la37gw-unsplash.jpg'),
(31, 'Sony WH-1000XM5', 'Sony WH-1000XM5 Noise Cancelling Headphones.\r\nBluetooth, fast Charging', '5400', 'Electronics', 8, 6, '2025-06-05', 'luke-peterson-lUMj2Zv5HUE-unsplash.jpg'),
(32, 'Rose Gold Apple Watch', 'Rose Gold Apple Watch\r\nPerfect for notifications on the go.', '2600', 'Electronics', 10, 10, '2025-06-05', 'pexels-alexandr-borecky-128389-393047.jpg'),
(33, 'Brown Handmade Loafer', 'Handmade Loafer with rubber grip for extra comfort!', '1200', 'Clothing', 1, 11, '2025-06-05', 'stanley-g-mathu-5_zKOE-kPkw-unsplash.jpg'),
(43, 'Blue Yeti', 'Blue Yeti For Sale\r\nCondition: Brand New\r\nAge: 3 Years\r\nReason for Selling: Cash', '1200', 'Electronics', 1, 18, '2025-06-27', 'BlueYeti.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `ReturnID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `BuyerID` int(11) NOT NULL,
  `SellerID` int(11) NOT NULL,
  `ReturnDate` date NOT NULL,
  `ReturnStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `BuyerID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Rating` int(5) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `ReviewDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `BuyerID`, `ProductID`, `Rating`, `Comment`, `ReviewDate`) VALUES
(2, 1, 31, 3, 'Testing Review System', '2025-06-06'),
(3, 1, 2, 3, 'Testing Review System', '2025-06-06'),
(8, 1, 33, 5, 'Testing Review System', '2025-06-13'),
(9, 1, 33, 2, 'Testing Review System 2', '2025-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(64) NOT NULL,
  `LastName` varchar(64) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Profile_IMG_DIR` varchar(255) NOT NULL DEFAULT 'default.png',
  `User_Level` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `FirstName`, `LastName`, `Email`, `Password`, `Profile_IMG_DIR`, `User_Level`) VALUES
(1, 'Travis', 'Musson', 'admin@email.com', '$2y$10$wMJVLcfF6RiST/U/lbKpzeo1qvLniojDJqPSuahkYXkKmbVsz6kcK', 'default.png', 1),
(2, 'Test', 'Test', 'test@test.com', '$2y$10$vvmoAj0COZwmIptaAKvCEujl/.NMeXnPCKwYeJEvy3Y5.ZVE5P2pq', 'default.png', 0),
(3, 'Bob', 'Johnson', 'bob@test.com', '$2y$10$ea70YdrKn7HZsHw38Gg5ve9slbdT7SCSFK8h9/DaujA6YuY7Pk5rS', 'default.png', 0),
(4, 'John', 'Johnson', 'test@testtest.com', '$2y$10$GJSt4.cBjGo9XlN5hM0yeOkA8MaN8ZFRQCPvXvugGIU2riv/vJt0q', 'default.png', 0),
(6, 'HifiHeadphone', 'Store', 'hifi@test.com', '$2y$10$9OFcYdR3g.N8my18xnxtRelZ36UwvrIHzyfW2LuGegF9oomofoXUG', 'pexels-karoldach-377711.jpg', 0),
(7, 'Xbox', 'Store', 'Xbox@test.com', '$2y$10$2zJWRjX4w38x10zWEDVdWOZBZKKSmgTf2ht68A8KoaQvOazU1iQry', 'pexels-roman-odintsov-12719133.jpg', 0),
(8, 'Sunnies', 'Store', 'sunnies@test.com', '$2y$10$Ri/5OE81XwAsEd/clMyTJu/i8XZh/VtDZnFVmfomKKEolOj7gsmaK', 'pexels-paggiarofrancesco-704241.jpg', 0),
(9, 'JacketsRUs', 'Store', 'Jackets@test.com', '$2y$10$luxKDlRaH69VZ1.woLh4H.eO2PMzJkWnOaLF8jMV9P5EUn58uU4wO', 'pexels-mart-production-7679798.jpg', 0),
(10, 'Gadgets', 'Store', 'gadgets@test.com', '$2y$10$WSOZOgm73evmzBdI/g3uu.XIFlIfdxKAW1O4iYYc3qI5XvW3esdgC', 'pexels-drew-williams-1285451-3568521.jpg', 0),
(11, 'HandmadeLoafer', 'Store', 'Loafer@test.com', '$2y$10$wMzVDJcptaZrBvJtu.3eYu43zFOM2gvDC4ZKzN./XPFUJ8e4nXcE.', 'pexels-pixabay-267320.jpg', 0),
(15, 'Dezz', 'Bez', 'dezbez@email.com', '$2y$10$TMfggK4G9BqP9XcIeqW6o.u1KSAX1UTYB70J/eNw.1WVmwvDOoQR6', 'default.png', 0),
(17, 'Terek', 'Terekson', 'terek@terek.com', '$2y$10$FXocNcpV.72Vmxpz7rz.HO6H19mJx5C7M.GE5sGZZWDmJ1wxvo5YK', 'default.png', 0),
(18, 'Travis', 'Musson', 'travismusson@email.com', '$2y$10$J4KyYNfzHB9mG0rEVAExquP28PD7QEGHCAX10hCbbqOosPBOxp8te', 'default.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderDetailsID`),
  ADD KEY `Order_ID_FK` (`OrderID`),
  ADD KEY `ProductID_FK` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `OrderID_FK` (`OrderID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `User_ID_FK_Product` (`SellerID`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`ReturnID`),
  ADD KEY `Product_ID_FK_Return` (`ProductID`),
  ADD KEY `Buyer_ID_FK_Return` (`BuyerID`),
  ADD KEY `Seller_ID_FK_Return` (`SellerID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `Buyer_ID_FK_Review` (`BuyerID`),
  ADD KEY `Product_ID_FK_Review` (`ProductID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `OrderDetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `ReturnID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `Order_ID_FK` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `ProductID_FK` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `OrderID_FK` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `User_ID_FK_Product` FOREIGN KEY (`SellerID`) REFERENCES `users` (`id`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `Buyer_ID_FK_Return` FOREIGN KEY (`BuyerID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `Product_ID_FK_Return` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`),
  ADD CONSTRAINT `Seller_ID_FK_Return` FOREIGN KEY (`SellerID`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `Buyer_ID_FK_Review` FOREIGN KEY (`BuyerID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `Product_ID_FK_Review` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
