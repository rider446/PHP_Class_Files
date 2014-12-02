-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2014 at 02:51 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wp_storedemo2`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ProdName` varchar(50) NOT NULL,
  `ProdCode` varchar(50) NOT NULL,
  `ProdDescription` text NOT NULL,
  `ProdInventory` int(7) NOT NULL,
  `ProdPrice` float(8,2) NOT NULL,
  `ProdCatagory` varchar(50) NOT NULL,
  `ProdImage` varchar(100) NOT NULL,
  `ProdID` int(7) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ProdID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProdName`, `ProdCode`, `ProdDescription`, `ProdInventory`, `ProdPrice`, `ProdCatagory`, `ProdImage`, `ProdID`) VALUES
('Amercian Legend', 'A00001', 'Legend Cub, Open Cowl, J-3 Style, Continental Engine\r\nThe open cowl Legend Cub has a classic J3 Cub look with exposed cylinders and "eyebrow" baffles. The Continental Motors O-200 engine delivers 100 horsepower and resonates the authentic sound of period Cubs. Standard equipment includes: classic wood prop, traditional yellow paint with black lightning bolt, vinyl seats with cloth inserts, basic panel (altimeter, airspeed, inclinometer, tachometer, oil pressure, oil temperature, voltmeter), 406 MHz ELT, 6.00 x 6 tires.', 3, 125000.00, 'Aircraft', 'legend.jpg', 1),
('Kitfox Super7', 'A00002', 'The S7 Super Sport is for serious pilots that demand performance, comfort, utility, flexibility and most of all safety.  With a useful load of up to 800 pounds, 27 gallon fuel capacity, 150 pound cargo capacity and STOL performance it’s just waiting to take you where most planes can only dream about, it’s no wonder that it’s known as a Jeep with wings. Having a wide cockpit, folding wings, able to convert from tailwheel to nose wheel in a matter of hours makes the Super Sport extremely versatile\r\n\r\nLarger, faster and able to lift more that any other Kitfox, the Super Sport is the top of the Kitfox line.  The Super Sport is completely different than any of the preceding Kitfox’s and shares no common primary structure.  It can be equipped with Rotax turbo power, Continental, Lycoming and even the Rotec 7 Cylinder Radial engines.  With nice cruising speeds, great high altitude performance and long range, the Series 7 Super Sport is in a class by itself.  The over all performance of the Series 7 is unmatched by any other experimental or certified airplane.  \r\n\r\nThe Series 7 Super Sport Aircraft to fits into the Light Sport Aircraft rules with a lot of margin for safety built in.  The Series 7 Super Sport was originally designed and tested to maximum gross weight capabilities of 1550 lbs max gross at +5.7 G''s and -3.8 G''s ultimate loads.  With the Kitfox''s light empty weight it allows the Super Sport to be operated at the lower 1320 lbs or 1430 lbs and still carry up to 150 lbs of baggage and 2 adults.', 2, 110000.00, 'Aircraft', 'kitfox.jpg', 2),
('750 Cruzer', 'A00003', 'The new Zenith CH 750 CRUZER is an economical all-metal two-seat cross-country cruiser that you can easily and quickly build yourself, and fly with your Sport Pilot license.\r\nThe CH 750 CRUZER is the <i>on-airport</i> version of the popular STOL CH 750 off-airport light sport utility kit plane, famous for its roomy cabin with comfortable side-by-side seating and easy cabin access from both sides.  While influenced by its well-known STOL predecessors (the STOL CH 701 <i>Sky Jeep</i>, the STOL CH 750 and four-seat CH 801 sport utility aircraft), the CH 750 Cruzer is an all-new design optimized as an economical cross-country cruiser for typical (airport) operations.  ', 2, 80000.00, 'Aircraft', 'cruzer.jpg', 3),
('Sonex', 'A00004', 'SONEX is a basic and economical all metal two place monoplane. Designed to meet the needs of the European and Domestic sport aircraft markets, it can incorporate various light weight contemporary engines of 80 to 120 hp (engine package weight of less than 200 lbs.), and is perfectly suited to the new US Sport Pilot/LSA regulations. The three recommended powerplants include the 2180cc Volkswagon, 2200 Jabiru, and 3300 Jabiru. Outstanding performance is achieved through its clean aerodynamic shape and simple, light weight construction.', 3, 60000.00, 'Aircraft', 'sonex.jpg', 4),
('ULPower ', 'E00001', 'ULPower engines, represented in North America by UL Power North America LLC, have been developed specifically for use in light aircraft and are manufactured to the highest standards with fully electronic ignition and multi-point fuel injection (FADEC) system as standard equipment, with several lightweight models ranging in power from 97 - 130 hp, making them an excellent choice to power the two-seat Zenith kit aircraft models.', 4, 40000.00, 'Engine', 'ulpower.jpg', 6),
('Jabiru', 'E00002', 'Some engine highlights:\r\n\r\nEngine TBO: The engine has a published TBO of 2,000 hours.\r\n\r\nThe case & internal parts are machined from solid steel bar or aluminum billet. The oil sump is only cast part.\r\n\r\nIgnition: Dual separate magnetos with redundant distributors & plugs. No points! No battery power required for operation. Spark plugs are NGK and commonly available.\r\n\r\nAll engines include: Starter, Exhaust System, Alternator, Regulator, Starter Solenoid, Cooling Ducts, Prop Guides, Oil Cooler Kit, Engine mount Bushings and mounting hardware.\r\n\r\nWarranty: One year from delivery. Delayed warranty start available on request .\r\n\r\nThe complete firewall-forward packages, developed and supported by Jabiru USA, include everything you need to install the engine in your aircraft.  The complete firewall-forward package is available directly through Zenith Aircraft Company, and can be shipped with the airframe kit or at a later date.', 2, 30000.00, 'Engine', 'jab.jpg', 7),
('Continental ', 'E00003', 'Teledyne Continental Motors is now producing a lightweight version of the O-200 engine specifically for light sport aircraft.  The new American-made engine boasts of a "199 Pounds Dry Weight"\r\n\r\nAlternatively, the O-200-A engine is available, as are numerous older (used) Continental engine installations.\r\n\r\nOther engine features include: Lightweight crankshaft, CAD modeled engine design, spin-on oil filter, lightweight cylinder design, precision balance crankshaft, lightweight alternator, balanced connecting rods, lightweight valve covers, balanced pistons, lightweight high torque starter, dual magneto ignition, lightweight camshaft, Continental new engine warranty and Continental service and spare parts availability.\r\n\r\nContinental has been producing aircraft engines for since the 1930s.  The company originally built the A40 engine, a 38-hp 4 cylinder horizontally-opposed air-cooled engine used in the Piper Cub. The original engine evolved into various models over the years, including the A65, A75, C75, C85 and C90, and finally evolved into the O-200 engine used in the popular Cessna 150.  Over the years, thousands of small Continentals have been produced (Continental was producing more than 10,000 engines per year in the late seventies).  Today, the O-200 engine is still available factory-new from Continental, and used ones are available from many sources. \r\n\r\nContinental engines provide a history of performance and reliability, with available worldwide parts and service support. Many kit builders have installed used and/or overhauled Continental engines. There is a large market for used Continental aircraft engines, with numerous sources for used engines, parts and after-market upgrades and enhancements.  If using a older Continental engine, we recommend that the engine be upgraded with a lighter (and more modern) electrical system.', 1, 40000.00, 'Engine', 'continental.jpg', 8),
('Rotax ', 'E00004', 'Rotax 912 iS Aircraft Engine \r\nNon - Certified Version.  \r\nClick here for a detailed specification page on the Rotax 912iS (pdf doc)\r\n\r\nTake - off Performance: 73.6 KW (100 HP) @ 5800 RPM (Max. 5 min.)\r\nFuel consumption at 75% continuous power: 4.5 gph\r\nEngine TBO (Time Between Overhaul): 2,000 hours\r\nBased on the proven concept of the Rotax 912 S/ ULS engine the new 912 iS engine offers all well known advantages of the Rotax 4-stroke engine series complemented by additional features, e.g. engine management system. The complete package presents the latest technology in the aircraft engine industry and will enhance the flying and ownership experience of pilots.\r\n\r\n4-cylinder\r\n4-stroke liquid/air-cooled engine with opposed cylinders\r\nDry sump forced lubrication with separate oil tank\r\nRedundant electric fuel injection\r\nEngine management system\r\nElectric starter\r\nPropeller speed reduction unit\r\nAir intake system', 3, 30000.00, 'Engine', 'rotax.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` int(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `password`, `salt`, `email`) VALUES
(1, '', '', 'bubba1', 'f051414a79e744342d74eb48bd67923df1c331702f4ba1e29e662261b735a38e', 1911, 'a@a.com'),
(2, 'Bubba2', 'Bubbbb2', 'bubba2', '8ce44ff277fbef771bdbb778b36982df373f1feee17939120abad47313d015a6', 20751, 'aaaa@aa.com'),
(3, 'Bob', 'Jones', 'bbbbbb1', '9e461252369710090ad96f9aeb30d3bcdaacb99df2503b3a8d0aa6202dbdf9fd', 2147483647, 'b@b.com'),
(4, 'bbb2', 'bbb2', 'bbbbbb2', '2d0fe7f5d984702ef656926b4a1d6b9e8918c04767182f9c52bea76caa639aff', 48, 'b2@b2.com'),
(5, 'b3', 'b3', 'bbbbbb3', '8eed729d7aa1f5cc7f7a4832fbd7b7ec21e4bd3d7734fac6c3dfa35ee2fd690e', 100, 'b3@b3.com'),
(6, 'J', 'Smith1', 'jsmith1', '8eed729d7aa1f5cc7f7a4832fbd7b7ec21e4bd3d7734fac6c3dfa35ee2fd690e', 100, 'j@js1.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
