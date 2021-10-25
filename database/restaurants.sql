-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: restaurants
-- ------------------------------------------------------
-- Server version	10.4.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `restaurants`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `restaurants` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `restaurants`;

--
-- Table structure for table `food`
--

DROP TABLE IF EXISTS `food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `food` (
  `foodID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `restaurantID` int(11) NOT NULL,
  `foodName` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `foodDescription` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`foodID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food`
--

LOCK TABLES `food` WRITE;
/*!40000 ALTER TABLE `food` DISABLE KEYS */;
INSERT INTO `food` VALUES (1,1,'Big Mac ®','Der legendäre Doppeldecker. Unverändert fein seit 1976. Genuss hoch zwei: Erlebe Schweizer Rindfleisch, knackigen Salat und zarten Schmelzkäse in einem Brötchen aus IP-Suisse-Mehl. Verfeinert mit der geheimnisvollen Big Mac Sauce. Bist du dem Geschmack gewachsen?',7),(2,1,'Double Cheeseburger','Der Klassiker lässt dich doppelt dahinschmelzen. Der Käseklassiker im Doppel: Schweizer Rindfleisch, zarter Schmelzkäse, Zwiebeln, Essiggurken, Ketchup und Senf in einem Brötchen aus IP-Suisse-Mehl.',5),(3,1,'Homestyle Honey Mustard Veggie','Unglaublich Veggie. So gut kann Veggie sein: Zwischen dem feinen Brioche-Brötchen findest du das crispy Veggie-Schnitzel von Valess. Perfektioniert mit süss-würziger Honig-Senf Sauce, leckerem Emmentaler Käse, herzhaften Zwiebeln und knackigem Salat.',9),(4,2,'Crazy Cheese BBQ','Uuuaaah! Doppelt flame-grilled Beef, Cheddar Cheese, würzige BBQ Bull’s Eye Sauce, Cheddar Sauce, Röstzwiebeln und knuspriger Bacon: Der Crazy Cheese BBQ Beef bringt deine Geschmacksnerven zum Durchdrehen.',15),(5,2,'BK KING FRIES®','BK KING FRIES® aus frischen Kartoffeln, goldbraun und knusprig.',7),(6,2,'Mozzarella Single Beef','Amore auf den ersten Biss: Hol dir jetzt unseren neuen Mozzarella Lover mit bestem flame-grilled Beef, knusprigem Mozzarella-Patty und cremiger Pesto-Sauce.',13.95),(7,3,'Iced Pumpkin Cream Latte','Der Iced Pumpkin Cream Latte vereint Pumpkin Spice-Sauce mit süssem Schlagrahm und Starbucks Blonde® Espresso Shots auf Eis.',8.4),(8,3,'Croissant Roll - Bacon &amp; Egg','Frühstücks-Sandwich mit Spiegelei, Cheddarkäse und Speck (DE), warm',7.5),(9,3,'Ham &amp; Cheese Croissant','Belegt mit Schinken (CH) &amp; Käse',6.5);
/*!40000 ALTER TABLE `food` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `orderID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(20) NOT NULL,
  `orderDate` datetime NOT NULL,
  `orderText` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `orderPrice` double NOT NULL,
  `orderAddress` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurants` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `delivery-from` int(11) NOT NULL,
  `delivery-until` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (1,'McDonald\'s®','Burgers • American • Fast Food','Centralbahnstrasse 9, 4051','https://www.mcdonalds.com/ch/de-ch.html',15,25),(2,'Burger King','American • Fast Food • Burgers','Steinenvorstadt 51, 4051','https://www.burger-king.ch/',35,45),(3,'Starbucks','Coffee• Rest• Meet','Centralbahnpl. 14, Basel, BS 4051','https://www.starbucks.ch/en',15,25);
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','User','Adminuser','$2y$10$BZcoCz/fqlt56JsHcG1v.ehP04gShlZPunu36scCBMFhzfZ0zXlcu','admin@admin.ch',NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-25 13:40:01
GRANT USAGE ON *.* TO `admin`@`localhost` IDENTIFIED BY PASSWORD '*4ACFE3202A5FF5CF467898FC58AAB1D615029441';

GRANT SELECT, INSERT, UPDATE, DELETE ON `restaurants`.* TO `admin`@`localhost`;
