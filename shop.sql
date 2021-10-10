-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2021 at 09:19 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cats`
--

CREATE TABLE `cats` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `visibility` tinyint(11) NOT NULL DEFAULT 0,
  `Allow_com` tinyint(11) NOT NULL DEFAULT 0,
  `Allow_ads` tinyint(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cats`
--

INSERT INTO `cats` (`ID`, `name`, `Description`, `ordering`, `parent`, `visibility`, `Allow_com`, `Allow_ads`) VALUES
(11, 'games', '', NULL, 0, 0, 0, 0),
(12, 'Clothes', '', 0, 0, 0, 0, 0),
(13, 'computers', '', 0, 0, 0, 0, 0),
(14, 'Hand Mades', '', 0, 0, 0, 0, 0),
(15, 'prop', 'almaln slnscnc snclsn', NULL, 0, 0, 0, 0),
(16, 'last', '', 0, 13, 0, 0, 1),
(17, 'par', 'acalm a,cnaln', 0, 12, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `com_date` date NOT NULL,
  `com_item` int(11) NOT NULL,
  `com_mem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `comment`, `status`, `com_date`, `com_item`, `com_mem`) VALUES
(8, 'greet jop', 0, '2021-01-20', 19, 90),
(9, 'very good', 0, '2021-01-26', 19, 41),
(10, 'shao shao', 0, '2021-01-03', 19, 90),
(11, 'sncsnovnasovn', 0, '2021-01-27', 19, 39),
(12, 'svkAAAAAAAAAAAA', 0, '2021-01-27', 19, 42),
(15, 'that\'s so nice bro', 0, '2021-01-12', 25, 91),
(16, 'hello,what is the price', 0, '2021-01-06', 25, 91),
(17, 'my last one', 0, '2021-01-17', 26, 91);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ID` int(11) NOT NULL,
  `Name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `Disc` text CHARACTER SET utf8 NOT NULL,
  `Price` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Add_Date` date NOT NULL,
  `Country` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Status` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Cat_id` int(11) NOT NULL,
  `Member_id` int(11) NOT NULL,
  `Aprove` tinyint(4) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ID`, `Name`, `Disc`, `Price`, `Add_Date`, `Country`, `Image`, `Status`, `Rating`, `Cat_id`, `Member_id`, `Aprove`, `tags`) VALUES
(19, 'pes', '', '10$', '2021-01-05', 'egy', '', '', 0, 11, 90, 1, ''),
(21, 'desk', 'this is agreat elementt i csn\'t do without it', '100$', '0000-00-00', '', '', '', 0, 13, 39, 1, ''),
(22, 'shirt', '', '10', '2021-01-06', 'egypt', '', '1', 0, 12, 41, 1, 'clothes,new,tags'),
(25, 'laptop', 'graet device with great qulities thanks', '20$', '0000-00-00', '', '', '', 0, 13, 41, 1, ''),
(26, 'play station', 'graet device with great qulities thanks', '200$', '0000-00-00', '', '', '', 0, 13, 90, 1, ''),
(28, 'Sreen', 'graet device with great qulities thanks', '22$', '0000-00-00', '', '', '', 0, 13, 39, 1, ''),
(29, 'pc', 'clsj sfnsnfolsn snfslnf', '100$', '2021-01-06', '', '', '', 0, 13, 91, 1, ''),
(32, 'mobile drive', 'we cannot stay here more bro lett&#39;s go go', '200', '2021-01-21', 'china', '', '3', 0, 13, 91, 1, ''),
(34, 'ROOM', 'we cannot stay here more bro lett&#39;s go go', '20', '2021-01-21', 'roma', '', '4', 0, 14, 91, 1, ''),
(35, 'my item', 'new vari items', '100', '2021-01-22', 'egypt', '', '1', 0, 13, 91, 0, ''),
(36, 'myit', 'laoajx acnalnc qwww nna ad', '200$', '2021-01-26', 'nise', '', '1', 0, 14, 1, 1, 'new,fash,brop'),
(37, 'lastIt', 'ancan nscan ca', '2000', '2021-01-26', 'egypt', '', '1', 0, 12, 41, 1, 'AH,Ab,ac,fash');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'to identfy user',
  `Username` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'user name to login',
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identfy user group',
  `trustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approveal',
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `password`, `Email`, `FullName`, `avatar`, `GroupID`, `trustStatus`, `RegStatus`, `Date`) VALUES
(1, 'Ahmed', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 'Ah@gmail', 'AhmedAshraf', '', 1, 1, 1, '2019-10-10'),
(39, 'mahmod', '0ddb5877c896f43e8734e10b001e7f1eb92889cd', 'AH@gmail', 'vhvhjv', '', 0, 0, 1, '2021-01-12'),
(41, 'Rady ', '48058e0c99bf7d689ce71c360699a14ce2f99774', 'RE@gmail', 'RADYBASHA', '', 0, 0, 1, '2021-01-11'),
(42, 'Yahia', '78988010b890ce6f4d2136481f392787ec6d6106', 'YA@gam', 'TAHIAHA', '', 0, 0, 1, '2021-01-11'),
(90, 'reem', '6aaca847bf1fcdbcd1acab43d665c7c037737b49', 'RE@gmail', 'reemALi', '', 0, 0, 1, '2021-01-16'),
(91, 'reda', '4170ac2a2782a1516fe9e13d7322ae482c1bd594', 're@gm', 'aacad', '', 0, 0, 1, '2021-01-19'),
(92, 'omar', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'om@M', 'wdwfe', '', 0, 0, 1, '2021-01-19'),
(93, 'turk', '011c945f30ce2cbafc452f39840f025693339c42', 'AE@gmail.com', '', '', 0, 0, 0, '2021-01-21'),
(94, 'mina', '17ba0791499db908433b80f37c5fbc89b870084b', 'mina@gmail.com', '', '', 0, 0, 0, '2021-01-21'),
(95, 'yom', '49ee430289566e15b82f8a09adf41d9e59ee5842', 'Anx@aaasA', 'ama;xxm', '499_user-310807_1280.png', 0, 0, 1, '2021-01-28'),
(96, 'Ahmesaxd', 'cac464f90d9c04a30a43a4d6368758a07c41fa11', 'Ah@aaax', 'scsc;cns;nc;nsncn', '312_Sleep Away.mp3', 0, 0, 1, '2021-01-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `items_co` (`com_item`),
  ADD KEY `mem_co` (`com_mem`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `items_ibfk_1` (`Member_id`),
  ADD KEY `items_ibfk_2` (`Cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identfy user', AUTO_INCREMENT=97;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_co` FOREIGN KEY (`com_item`) REFERENCES `items` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mem_co` FOREIGN KEY (`com_mem`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Member_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Cat_id`) REFERENCES `cats` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
