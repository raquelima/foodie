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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food`
--

LOCK TABLES `food` WRITE;
/*!40000 ALTER TABLE `food` DISABLE KEYS */;
INSERT INTO `food` VALUES (1,1,'Big Mac ®','Der legendäre Doppeldecker. Unverändert fein seit 1976. Genuss hoch zwei: Erlebe Schweizer Rindfleisch, knackigen Salat und zarten Schmelzkäse in einem Brötchen aus IP-Suisse-Mehl. Verfeinert mit der geheimnisvollen Big Mac Sauce. Bist du dem Geschmack gewachsen?',7),(2,1,'Double Cheeseburger','Der Klassiker lässt dich doppelt dahinschmelzen. Der Käseklassiker im Doppel: Schweizer Rindfleisch, zarter Schmelzkäse, Zwiebeln, Essiggurken, Ketchup und Senf in einem Brötchen aus IP-Suisse-Mehl.',5),(3,1,'Homestyle Honey Mustard Veggie','Unglaublich Veggie. So gut kann Veggie sein: Zwischen dem feinen Brioche-Brötchen findest du das crispy Veggie-Schnitzel von Valess. Perfektioniert mit süss-würziger Honig-Senf Sauce, leckerem Emmentaler Käse, herzhaften Zwiebeln und knackigem Salat.',9),(4,2,'Crazy Cheese BBQ','Uuuaaah! Doppelt flame-grilled Beef, Cheddar Cheese, würzige BBQ Bull’s Eye Sauce, Cheddar Sauce, Röstzwiebeln und knuspriger Bacon: Der Crazy Cheese BBQ Beef bringt deine Geschmacksnerven zum Durchdrehen.',15),(5,2,'BK KING FRIES®','BK KING FRIES® aus frischen Kartoffeln, goldbraun und knusprig.',7),(6,2,'Mozzarella Single Beef','Amore auf den ersten Biss: Hol dir jetzt unseren neuen Mozzarella Lover mit bestem flame-grilled Beef, knusprigem Mozzarella-Patty und cremiger Pesto-Sauce.',13.95),(7,3,'Iced Pumpkin Cream Latte','Der Iced Pumpkin Cream Latte vereint Pumpkin Spice-Sauce mit süssem Schlagrahm und Starbucks Blonde® Espresso Shots auf Eis.',8.4),(8,3,'Croissant Roll - Bacon &amp; Egg','Frühstücks-Sandwich mit Spiegelei, Cheddarkäse und Speck (DE), warm',7.5),(9,3,'Ham &amp; Cheese Croissant','Belegt mit Schinken (CH) &amp; Käse',6.5),(13,6,'Chicken Teriyaki Sandwich 30cm','Hähnchenscheiben in Teriyaki-Sauce, Brot, Zutaten und Sauce Ihrer Wahl.',16.9),(14,6,'Chicken Fajita Sandwich 30cm','Würzige mexikanische Hühnchenscheiben, Brot, Zutaten und Sauce nach Wahl.',16.9),(15,6,'Steak &amp; Cheese Sandwich 30cm','Rindfleisch &amp; Käse',16.9),(16,6,'Tuna Sandwich 30cm','Thunfisch, Brot, Zutaten und Sauce nach Wahl.',14.3),(17,6,'Italian BMT 30cm','Putenschinken, Kochschinken, Brot, Zutaten und Sauce nach Wahl.',15.5),(18,6,'Chicken Teriyaki Sandwich 30cm','Hähnchenscheiben in Teriyaki-Sauce, Brot, Zutaten und Sauce Ihrer Wahl.',16.9),(19,7,'Dirty Harry - Bacon Cheese Burger','Beef | swiss bacon | cheddar | lettuce | tomato | onions | BBQ sauce | mayo | brioche bun All our Burgers are served medium. If you have special wishes, please leave a note.',18),(20,7,'Manhatten - Cheese Burger','Beef | cheddar | lettuce | tomato | onions | pickles | ketchup | mayo | mustard | brioche bun All our Burgers are served medium. If you have special wishes, please leave a note.',16),(21,7,'Cripsy Chicken Slices','100% Swiss Chicken',10),(22,7,'Easy Rider - Crispy Chicken Burger','Crispy chicken | swiss bacon | cheddar | lettuce | tomato | cocktailsauce | brioche bun',19),(23,7,'Sweet Potato Fries','Sweet Potato Fries',7),(24,7,'Dracula - Beetroot Tofu Cheese Burger','Beetroot patty | tofu bacon | vegan cheddar | lettuce | tomato | onions | ketchup | vegan mayo | pita bun',14),(25,8,'Crunchy Prawn Roll','Frittierte Crevetten, Mayonnaise, Avocado und Crunchy Tempura',4.5),(26,8,'Rainbow Roll Lachs','Lachs und Avocado',5),(27,8,'Scotman\'s Rainbow','Lachs, Cream Cheese, Scotman‘s Sauce, gerösteter Sesam',5),(28,8,'Edamame (vegan)','Warme japanische Sojabohnen, leicht gesalzen',6.5),(29,8,'Salmon Loves Mango','Lachs, Mango und Avocado',5),(30,8,'Fujiyama Small (vegan)','Miso Suppe, Tofu, Ramennoodles, Sojasprossen, Shiitake-Pilze, Gemüse, frischer Ingwer.',10.5),(31,9,'Bun Bo Zitronengras Rind / Lemongrass Beef','Gemischte Reisnudeln mit Salat, Kräutern, Gemüse, Erdnuss, Zitronengras Rind',21),(32,9,'Bun Bo Knuspriges Poulet','Gemischte Reisnudeln mit Kräutern, Gemüse, Poulet &amp; Avocado',21),(33,9,'Pho Bo Classic','Klassische Nudelsuppe mit Reisnudeln, Kräutern, Sojasprosse, Zwiebeln, Rind',22),(34,9,'Fried Noodles Rind / Beef','Gebratene Reisnudeln mit Gemüse &amp; Rind',22),(35,9,'Sommer Ente &amp; Mango','Frische Reispapierrolle mit Reisnudeln, Minze, Gurke, Mango &amp; Ente',6),(36,9,'Bao Crevetten Avocado','Gedämpfte Buns mit Salat, Gemüse, Avocado, Crevetten',6),(37,10,'Fries','Fries',7.5),(38,10,'Cheesefries','mit Käsesauce',9.5),(39,10,'Hamburger','Hausbrot, Beef-Patty, Ketchup &amp; Mayonnaise, Essiggurke, Salat, Rote Zwiebeln und Tomaten',16.9),(40,10,'Mousse al Cioccolato','Mousse al Cioccolato',8.5),(41,10,'Cheeseburger','Hausbrot, Beef-Patty, Ketchup &amp; Mayonnaise, Essiggurke, Salat, Rote Zwiebeln, Tomaten und Cheddar',17.9),(42,10,'Chilli-Cheeseburger','Hausbrot, Beef-Patty, Chillisauce &amp; Mayonnaise, Essiggurke, Salat, Rote Zwiebeln, Tomaten Cheddar und Jalapeños',18.2),(43,10,'Tofuburger','Hausbrot, Bio Tofu-Patty, Mango Curry Sauce, Essiggurke, Salat, Rote Zwiebeln und Tomaten',15.9),(44,11,'MENU SMOKEY BIG CHEESE AND BACON','Schweizer Rindfleisch , Käse, Speck, BBQ Sauce, Rote Zwiebelconfit, Bataviasalat. Serviert mit Pommes Frites, einem Softdrink und Toppings nach Wahl',22.9),(45,11,'MENU BIG CHEESE','Schweizer Rindfleisch , Käse, Ketchup, Rote Zwiebelconfit, Bataviasalat. Serviert mit Pommes Frites, einem Softdrink und Toppings nach Wahl',20.9),(46,11,'MENU SMOKIN\' HOLY COWBOY','Rindfleisch, extra Fleisch, Cheddar, Speck, Cajun Mayo, Ketchup, BBQ Sauce, rote Zwiebelconfit, Bataviasalat. Serviert mit Pommes Frites, einem Softdrink und Toppings nach Wahl',27.9),(47,11,'MENU BACON AVOCADO BEEF','Schweizer Rindfleisch , Speck, Avocado Mash, Ketchup, Rote Zwiebelconfit, Bataviasalat. Serviert mit Pommes Frites, einem Softdrink und Toppings nach Wahl',22.9),(48,11,'SMOKEY BIG CHEESE AND BACON','SMOKEY BIG CHEESE AND BACON',17.9),(49,11,'MENU THE VEGGIE','Holy Cow! Veggie Burger, Lime&amp;Basil Mayo, HolyCow! Spicy Apple Chutney, Bataviasalat, Rucolasalat. Serviert mit Pommes Frites, einem Softdrink und Toppings nach Wahl',21.9),(50,11,'MENU SKINNY SUMO','RINDFLEISCH MIT TERIYAKI UND INGWER HOLY COW! QUINOA MIT WASABI MAYO, GESCHNITTENER WEISSKOHL UND KAROTTEN, FRÜHLINGSZWIEBELN, BATAVIA, RUCOLA, SPINATBLÄTTER, FRISCHE KRÄUTER .. Serviert mit Pommes Frites, einem Softdrink und Toppings nach Wahl',21.9),(51,11,'Ice Tea Pfirsich','Thé froid pêche suisse',3.9),(52,11,'Ice Tea Zitrone','Thé froid citron suisse',3.9),(53,1,'Big Tasty Single','Neue Grösse: der Big Tasty™ Single. Den gleichen leckeren Geschmack wie der Big Tasty, nur in einem kleineren Format. Freu dich auf saftiges Schweizer Rindfleisch, frische Tomaten, knackigen Salat und zarten Schmelzkäse. Selbstverständlich mit der typisch rauchigen Sauce in einem warmen Brötchen aus IP-Suisse-Mehl.',8.6),(54,1,'Homestyle Crispy Chicken Spicy BBQ','Hier schmeckst du das Feuer aus BBQ. Ein knuspriges Chicken-Patty, knackiger Salat, saftige Zwiebel und eine lecker-scharfe BBQ-Sauce machen diesen Burger einfach perfekt.',9.9),(55,2,'X-TRA Long Chili Cheese','Flame-grilled Beef aus der Schweiz, Cheddar Cheese, feurige Chili Cheese Sauce und scharfe Jalapeños.',10.9),(56,2,'Mozzarella Chicken','Knusprig, zart und molto bene: Der Mozzarella Lover Chicken verführt deinen Gaumen mit bestem Poulet, frischen Tomaten, Eisbergsalat und cremiger Pesto-Sauce. Dazu ein knuspriges Mozzarella-Patty: Reinbeissen und dahinschmelzen.',14.9),(57,2,'Crazy Cheese BBQ Chicken','Nach so viel Geschmack ist einfach jeder verrückt: Knusprig-zartes Chicken, Cheddar Cheese, würzige BBQ Bull’s Eye Sauce, Cheddar Sauce, Röstzwiebeln und knuspriger Bacon. Wie lange kannst du widerstehen?',13.9),(58,2,'Double Whopper®','Zwei Lagen flame-grilled Beef aus der Schweiz, Tomaten und Zwiebeln, Salat, Mayonnaise, Ketchup und Gurken.',13.9);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (1,'McDonald\'s®','Burgers • American • Fast Food','Centralbahnstrasse 9, 4051','https://www.mcdonalds.com/ch/de-ch.html',15,25),(2,'Burger King','American • Fast Food • Burgers','Steinenvorstadt 51, 4051','https://www.burger-king.ch/',35,45),(3,'Starbucks','Coffee• Rest• Meet','Centralbahnpl. 14, Basel, BS 4051','https://www.starbucks.ch/en',15,25),(6,'Subway®','Sandwich • American','Centralbahnpl. 6, Basel, Basel-Stadt 4051','https://www.subway.com/de-CH/',15,25),(7,'Union Diner','Burgers • American • Hawaiian • Exclusive to Eats','Güterstrasse 105, 4053 Basel, Schweiz, BS 4053','https://uniondiner.ch/de',20,30),(8,'Negishi Sushi Bar','$$ • Sushi • Asian • Asian Fusion • Japanese','Stadthausgasse 10, Basel, BS 4001','https://www.negishi.ch/de/home',35,45),(9,'V\'oodles Vietnamese Street Food','$$ • Asian • Vietnamese • Bubble Tea • Healthy','Freie Strasse 89, Basel, Basel-City 4051 ','https://voodlesbasel.ch/',20,30),(10,'Burgermeister','$$ • Burgers • Fast Food • Exclusive to Eats','55 Aeschenvorstadt, Basel, EMEA 4051','https://www.burger-meister.ch/',25,35),(11,'Holy Cow!','Burgers • American','Steinenvorstadt 30, Basel, BS 4051','https://www.holycow.ch/de/restaurantsde/holy-cow-basel/',20,30);
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
INSERT INTO `users` VALUES (1,'Admin','User','Adminuser','$2y$10$63U8yoeqcnwUCqnYI1xoCuxXvKeHn8j624MelMt3QQhVTYXJF0gIm','admin@admin.ch',NULL,NULL,NULL,NULL,1);
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

-- Dump completed on 2021-10-25 15:49:49

GRANT USAGE ON *.* TO `admin`@`localhost` IDENTIFIED BY PASSWORD '*4ACFE3202A5FF5CF467898FC58AAB1D615029441';

GRANT SELECT, INSERT, UPDATE, DELETE ON `restaurants`.* TO `admin`@`localhost`;
FLUSH PRIVILEGES;