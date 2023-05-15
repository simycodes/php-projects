-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2022 at 12:32 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmotors`
--

-- --------------------------------------------------------

--
-- Table structure for table `carclassification`
--

CREATE TABLE `carclassification` (
  `classificationId` int(11) NOT NULL,
  `classificationName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carclassification`
--

INSERT INTO `carclassification` (`classificationId`, `classificationName`) VALUES
(1, 'SUV'),
(2, 'Classic'),
(3, 'Sports'),
(4, 'Trucks'),
(5, 'Used'),
(7, 'Zambian');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `clientId` int(10) UNSIGNED NOT NULL,
  `clientFirstname` varchar(15) NOT NULL,
  `clientLastname` varchar(25) NOT NULL,
  `clientEmail` varchar(40) NOT NULL,
  `clientPassword` varchar(255) NOT NULL,
  `clientLevel` enum('1','2','3') NOT NULL DEFAULT '1',
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`clientId`, `clientFirstname`, `clientLastname`, `clientEmail`, `clientPassword`, `clientLevel`, `comment`) VALUES
(14, 'Paps', 'Legend', 'Paps@gmail.com', '$2y$10$Z7eNcdgNx9kuE7Uwh0giZu7fIiCY5u9il6DFIs1aqm/zhICAE5mcK', '1', NULL),
(16, 'Simon', 'Mule', 'legend@gmail.com', '$2y$10$2Vk8bkAG2jFUiBwfyhDZYuSq80ATft9mvpEdw4ww3va5cEX89Lp96', '1', NULL),
(17, 'Simon', 'Mule', 'simycodes@gmail.com', '$2y$10$ZvY8kFYqDaAxQtw472o4lOT5oVVHp2qR1Ep7G/bB5wHuUMrwAeEku', '1', NULL),
(18, 'Paul', 'Legend', 'paul@gmail.com', '$2y$10$CjidP2cB.92s7B0QhQsuP.2esScXY03E8G42Ym3FP23HPGTKwxDqe', '1', NULL),
(19, 'Dolina', 'Mule', 'dolina@gmail.com', '$2y$10$3Afr0tZ1VLE4/nNn.nIv9us7cVPArILZYmLecSYC4B7E2ZbnP.b1G', '1', NULL),
(20, 'Neil', 'Riley', 'neilriley@gmail.com', '$2y$10$.izL1DcQuK7Ln7J2rk9UsuM3RAxEUSnMAJlY1pjbYAKI4fnnqkJxa', '1', NULL),
(21, 'Admin', 'User', 'admin@cse340.net', '$2y$10$GxZPpa3QhVDZdzhMhK21.OzrLqawjMLxAfzwrY5E0zLy0v3Tf8Mre', '3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imgId` int(11) NOT NULL,
  `invId` int(11) NOT NULL,
  `imgName` varchar(100) NOT NULL,
  `imgPath` varchar(150) NOT NULL,
  `imgDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `imgPrimary` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imgId`, `invId`, `imgName`, `imgPath`, `imgDate`, `imgPrimary`) VALUES
(19, 2, 'ford-modelt.jpg', '/phpmotors/images/vehicles/ford-modelt.jpg', '2022-11-23 09:27:28', 1),
(20, 2, 'ford-modelt-tn.jpg', '/phpmotors/images/vehicles/ford-modelt-tn.jpg', '2022-11-23 09:27:28', 1),
(21, 13, 'aerocar.jpg', '/phpmotors/images/vehicles/aerocar.jpg', '2022-11-23 09:28:10', 1),
(22, 13, 'aerocar-tn.jpg', '/phpmotors/images/vehicles/aerocar-tn.jpg', '2022-11-23 09:28:10', 1),
(23, 15, 'dog.jpg', '/phpmotors/images/vehicles/dog.jpg', '2022-11-23 09:28:48', 1),
(24, 15, 'dog-tn.jpg', '/phpmotors/images/vehicles/dog-tn.jpg', '2022-11-23 09:28:48', 1),
(25, 3, 'lambo-Adve.jpg', '/phpmotors/images/vehicles/lambo-Adve.jpg', '2022-11-23 09:29:55', 1),
(26, 3, 'lambo-Adve-tn.jpg', '/phpmotors/images/vehicles/lambo-Adve-tn.jpg', '2022-11-23 09:29:55', 1),
(27, 6, 'bat.jpg', '/phpmotors/images/vehicles/bat.jpg', '2022-11-23 09:30:49', 1),
(28, 6, 'bat-tn.jpg', '/phpmotors/images/vehicles/bat-tn.jpg', '2022-11-23 09:30:49', 1),
(29, 10, 'camaro.jpg', '/phpmotors/images/vehicles/camaro.jpg', '2022-11-23 09:31:32', 1),
(30, 10, 'camaro-tn.jpg', '/phpmotors/images/vehicles/camaro-tn.jpg', '2022-11-23 09:31:32', 1),
(31, 5, 'ms.jpg', '/phpmotors/images/vehicles/ms.jpg', '2022-11-23 09:32:29', 1),
(32, 5, 'ms-tn.jpg', '/phpmotors/images/vehicles/ms-tn.jpg', '2022-11-23 09:32:29', 1),
(33, 7, 'mm.jpg', '/phpmotors/images/vehicles/mm.jpg', '2022-11-23 09:32:57', 1),
(34, 7, 'mm-tn.jpg', '/phpmotors/images/vehicles/mm-tn.jpg', '2022-11-23 09:32:57', 1),
(35, 11, 'escalade.jpg', '/phpmotors/images/vehicles/escalade.jpg', '2022-11-23 09:34:26', 1),
(36, 11, 'escalade-tn.jpg', '/phpmotors/images/vehicles/escalade-tn.jpg', '2022-11-23 09:34:26', 1),
(37, 14, 'fbi.jpg', '/phpmotors/images/vehicles/fbi.jpg', '2022-11-23 09:34:58', 1),
(38, 14, 'fbi-tn.jpg', '/phpmotors/images/vehicles/fbi-tn.jpg', '2022-11-23 09:34:58', 1),
(39, 1, 'wrangler.jpg', '/phpmotors/images/vehicles/wrangler.jpg', '2022-11-23 09:36:39', 1),
(40, 1, 'wrangler-tn.jpg', '/phpmotors/images/vehicles/wrangler-tn.jpg', '2022-11-23 09:36:39', 1),
(41, 4, 'monster.jpg', '/phpmotors/images/vehicles/monster.jpg', '2022-11-23 09:37:24', 1),
(42, 4, 'monster-tn.jpg', '/phpmotors/images/vehicles/monster-tn.jpg', '2022-11-23 09:37:24', 1),
(43, 8, 'fire-truck.jpg', '/phpmotors/images/vehicles/fire-truck.jpg', '2022-11-23 09:38:33', 1),
(44, 8, 'fire-truck-tn.jpg', '/phpmotors/images/vehicles/fire-truck-tn.jpg', '2022-11-23 09:38:33', 1),
(45, 2, 'crown-vic.jpg', '/phpmotors/images/vehicles/crown-vic.jpg', '2022-11-23 09:40:39', 0),
(46, 2, 'crown-vic-tn.jpg', '/phpmotors/images/vehicles/crown-vic-tn.jpg', '2022-11-23 09:40:39', 0),
(47, 12, 'hummer.jpg', '/phpmotors/images/vehicles/hummer.jpg', '2022-11-23 09:41:36', 1),
(48, 12, 'hummer-tn.jpg', '/phpmotors/images/vehicles/hummer-tn.jpg', '2022-11-23 09:41:36', 1),
(49, 26, 'delorean.jpg', '/phpmotors/images/vehicles/delorean.jpg', '2022-11-23 09:58:52', 1),
(50, 26, 'delorean-tn.jpg', '/phpmotors/images/vehicles/delorean-tn.jpg', '2022-11-23 09:58:52', 1),
(69, 4, 'abcdefg.jpg', '/phpmotors/images/vehicles/abcdefg.jpg', '2022-11-28 12:04:12', 0),
(70, 4, 'abcdefg-tn.jpg', '/phpmotors/images/vehicles/abcdefg-tn.jpg', '2022-11-28 12:04:12', 0),
(71, 1, 'jeep-wrangler-two.jpg', '/phpmotors/images/vehicles/jeep-wrangler-two.jpg', '2022-11-28 12:22:02', 0),
(72, 1, 'jeep-wrangler-two-tn.jpg', '/phpmotors/images/vehicles/jeep-wrangler-two-tn.jpg', '2022-11-28 12:22:02', 0),
(77, 10, 'chevy-two.jpg', '/phpmotors/images/vehicles/chevy-two.jpg', '2022-12-02 10:22:17', 0),
(78, 10, 'chevy-two-tn.jpg', '/phpmotors/images/vehicles/chevy-two-tn.jpg', '2022-12-02 10:22:17', 0),
(81, 10, 'chevy-three.jpg', '/phpmotors/images/vehicles/chevy-three.jpg', '2022-12-02 10:24:54', 0),
(82, 10, 'chevy-three-tn.jpg', '/phpmotors/images/vehicles/chevy-three-tn.jpg', '2022-12-02 10:24:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invId` int(11) NOT NULL,
  `invMake` varchar(30) NOT NULL,
  `invModel` varchar(30) NOT NULL,
  `invDescription` text NOT NULL,
  `invImage` varchar(50) NOT NULL,
  `invThumbnail` varchar(50) NOT NULL,
  `invPrice` decimal(10,0) NOT NULL,
  `invStock` smallint(6) NOT NULL,
  `invColor` varchar(20) NOT NULL,
  `classificationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invId`, `invMake`, `invModel`, `invDescription`, `invImage`, `invThumbnail`, `invPrice`, `invStock`, `invColor`, `classificationId`) VALUES
(1, 'Jeep', 'Wrangler', 'The Jeep Wrangler is small and compact with enough power to get you where you want to go. It is great for everyday driving as well as off-roading whether that be on the rocks or in the mud!', '/phpmotors/images/vehicles/jeep-wrangler.jpg', '/phpmotors/images/vehicles/jeep-wrangler-tn.jpg', '28045', 4, 'Orange', 4),
(2, 'Ford', 'Model T', 'The Ford Model T can be a bit tricky to drive. It was the first car to be put into production. You can get it in any color you want if it is black.', '/phpmotors/images/vehicles/ford-modelt.jpg', '/phpmotors/images/vehicles/ford-modelt-tn.jpg', '30000', 2, 'Black', 2),
(3, 'Lamborghini', 'Adventador', 'This V-12 engine packs a punch in this sporty car. Make sure you wear your seatbelt and obey all traffic laws.', '/phpmotors/images/vehicles/lambo-Adve.jpg', '/phpmotors/images/vehicles/lambo-Adve-tn.jpg', '417650', 1, 'Blue', 3),
(4, 'Monster', 'Truck', 'Most trucks are for working, this one is for fun. This beast comes with 60 inch tires giving you the traction needed to jump and roll in the mud.', '/phpmotors/images/vehicles/monster.jpg', '/phpmotors/images/vehicles/monster-tn.jpg', '150000', 3, 'purple', 4),
(5, 'Mechanic', 'Special', 'Not sure where this car came from. However, with a little tender loving care it will run as good a new.', '/phpmotors/images/vehicles/ms.jpg', '/phpmotors/images/vehicles/ms-tn.jpg', '100', 1, 'Rust', 1),
(6, 'Batmobile', 'Custom', 'Ever want to be a superhero? Now you can with the bat mobile. This car allows you to switch to bike mode allowing for easy maneuvering through traffic during rush hour.', '/phpmotors/images/vehicles/bat.jpg', '/phpmotors/images/vehicles/bat-tn.jpg', '65000', 1, 'Black', 3),
(7, 'Mystery', 'Machine', 'Scooby and the gang always found luck in solving their mysteries because of their 4 wheel drive Mystery Machine. This Van will help you do whatever job you are required to with a success rate of 100%.', '/phpmotors/images/vehicles/mm.jpg', '/phpmotors/images/vehicles/mm-tn.jpg', '10000', 12, 'Green', 1),
(8, 'Spartan', 'Fire Truck', 'Emergencies happen often. Be prepared with this Spartan fire truck. Comes complete with 1000 ft. of hose and a 1000-gallon tank.', '/phpmotors/images/vehicles/fire-truck.jpg', '/phpmotors/images/vehicles/fire-truck-tn.jpg', '50000', 1, 'Red', 4),
(9, 'Ford', 'Crown Victoria', 'After the police force updated their fleet these cars are now available to the public! These cars come equipped with the siren which is convenient for college students running late to class.', '/phpmotors/images/vehicles/crown-vic.jpg', '/phpmotors/images/vehicles/crown-vic-tn.jpg', '10000', 5, 'White', 5),
(10, 'Chevy', 'Camaro', 'If you want to look cool this is the car you need! This car has great performance at an affordable price. Own it today!', '/phpmotors/images/vehicles/camaro.jpg', '/phpmotors/images/vehicles/camaro-tn.jpg', '25000', 10, 'Silver', 3),
(11, 'Cadillac', 'Escalade', 'This styling car is great for any occasion from going to the beach to meeting the president. The luxurious inside makes this car a home away from home.', '/phpmotors/images/vehicles/escalade.jpg', '/phpmotors/images/vehicles/escalade-tn.jpg', '75195', 4, 'Black', 1),
(12, 'GM', 'Hummer', 'Do you have 6 kids and like to go off-roading? The Hummer gives you the spacious interiors with an engine to get you out of any muddy or rocky situation.', '/phpmotors/images/vehicles/hummer.jpg', '/phpmotors/images/vehicles/hummer-tn.jpg', '58800', 5, 'Yellow', 5),
(13, 'Aerocar International', 'Aerocar', 'Are you sick of rush hour traffic? This car converts into an airplane to get you where you are going fast. Only 6 of these were made, get this one while it lasts!', '/phpmotors/images/vehicles/aerocar.jpg', '/phpmotors/images/vehicles/aerocar-tn.jpg', '1000000', 1, 'Red', 2),
(14, 'FBI', 'Surveillance Van', 'Do you like police shows? You will feel right at home driving this van. Comes complete with surveillance equipment for an extra fee of $2,000 a month.', '/phpmotors/images/vehicles/fbi.jpg', '/phpmotors/images/vehicles/fbi-tn.jpg', '20000', 1, 'Green', 1),
(15, 'Dog', 'Car', 'Do you like dogs? Well, this car is for you straight from the 90s from Aspen, Colorado we have the original Dog Car complete with fluffy ears.', '/phpmotors/images/vehicles/dog.jpg', '/phpmotors/images/vehicles/dog-tn.jpg', '35000', 1, 'Brown', 2),
(26, 'DMC Delorean', 'Car', 'This is a very special vintage car! It is very comfortable and fast.', 'http://localhost/phpmotors/vehicles/index.php', '/phpmotors/images/vehicles/delorean-tn.jpg', '3000', 5, 'black', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` int(10) UNSIGNED NOT NULL,
  `reviewText` text NOT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `invId` int(10) NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewId`, `reviewText`, `reviewDate`, `invId`, `clientId`) VALUES
(7, 'this is a super car!!', '2022-11-30 10:23:19', 7, 14),
(9, 'great for sports and Hills!', '2022-11-30 13:09:43', 4, 20),
(15, 'Its best for dates! Amazing vehicle!', '2022-12-01 15:27:46', 1, 20),
(20, 'This is a Great Vehicle!', '2022-12-08 21:54:21', 4, 20),
(35, 'Very Confortable!', '2022-12-12 11:20:57', 12, 17),
(36, 'Very nice vehicle for a small family!', '2022-12-12 11:21:22', 11, 17),
(37, 'Great for hills and sports!', '2022-12-12 11:21:55', 4, 14),
(38, 'I am in love with thi vehicle! Everything is perfect for this one!', '2022-12-12 11:22:39', 1, 14),
(39, 'Looks amazing!', '2022-12-12 11:23:30', 2, 14),
(40, 'Good for old memories with Friends!', '2022-12-12 11:24:26', 26, 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carclassification`
--
ALTER TABLE `carclassification`
  ADD PRIMARY KEY (`classificationId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`clientId`),
  ADD UNIQUE KEY `clientEmail` (`clientEmail`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imgId`),
  ADD KEY `invId` (`invId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invId`),
  ADD KEY `classificationId` (`classificationId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `clientId` (`clientId`),
  ADD KEY `invId` (`invId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carclassification`
--
ALTER TABLE `carclassification`
  MODIFY `classificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `clientId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imgId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`classificationId`) REFERENCES `carclassification` (`classificationId`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`clientId`) REFERENCES `clients` (`clientId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
