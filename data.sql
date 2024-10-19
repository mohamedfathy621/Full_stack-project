-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	5.6.26-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `_prisma_migrations`
--

DROP TABLE IF EXISTS `_prisma_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `_prisma_migrations` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checksum` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `finished_at` datetime(3) DEFAULT NULL,
  `migration_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logs` text COLLATE utf8mb4_unicode_ci,
  `rolled_back_at` datetime(3) DEFAULT NULL,
  `started_at` datetime(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
  `applied_steps_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_prisma_migrations`
--

LOCK TABLES `_prisma_migrations` WRITE;
/*!40000 ALTER TABLE `_prisma_migrations` DISABLE KEYS */;
INSERT INTO `_prisma_migrations` VALUES ('37550a6e-e3bb-46e3-8fdb-60e524a0e258','e709e058d1c2cbbf9f0f74325a18c7b0e22bb47645879896d9e52633a8cce862','2024-07-20 16:14:37.977','20240719154317_try_5',NULL,NULL,'2024-07-20 16:14:37.587',1);
/*!40000 ALTER TABLE `_prisma_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute`
--

DROP TABLE IF EXISTS `attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `displayValue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributeSetId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Attribute_attributeSetId_fkey` (`attributeSetId`),
  CONSTRAINT `Attribute_attributeSetId_fkey` FOREIGN KEY (`attributeSetId`) REFERENCES `attributeset` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute`
--

LOCK TABLES `attribute` WRITE;
/*!40000 ALTER TABLE `attribute` DISABLE KEYS */;
INSERT INTO `attribute` VALUES ('apple-imac-2021Capacity_256GB','256GB','256GB','apple-imac-2021_0'),('apple-imac-2021Capacity_512GB','512GB','512GB','apple-imac-2021_0'),('apple-imac-2021Touch ID in keyboard_No','No','No','apple-imac-2021_2'),('apple-imac-2021Touch ID in keyboard_Yes','Yes','Yes','apple-imac-2021_2'),('apple-imac-2021With USB 3 ports_No','No','No','apple-imac-2021_1'),('apple-imac-2021With USB 3 ports_Yes','Yes','Yes','apple-imac-2021_1'),('apple-iphone-12-proCapacity_1T','1T','1T','apple-iphone-12-pro_0'),('apple-iphone-12-proCapacity_512G','512G','512G','apple-iphone-12-pro_0'),('apple-iphone-12-proColor_Black','Black','#000000','apple-iphone-12-pro_1'),('apple-iphone-12-proColor_Blue','Blue','#030BFF','apple-iphone-12-pro_1'),('apple-iphone-12-proColor_Cyan','Cyan','#03FFF7','apple-iphone-12-pro_1'),('apple-iphone-12-proColor_Green','Green','#44FF03','apple-iphone-12-pro_1'),('apple-iphone-12-proColor_White','White','#FFFFFF','apple-iphone-12-pro_1'),('huarache-x-stussy-leSize_40','40','40','huarache-x-stussy-le_0'),('huarache-x-stussy-leSize_41','41','41','huarache-x-stussy-le_0'),('huarache-x-stussy-leSize_42','42','42','huarache-x-stussy-le_0'),('huarache-x-stussy-leSize_43','43','43','huarache-x-stussy-le_0'),('jacket-canada-gooseeSize_Extra Large','Extra Large','XL','jacket-canada-goosee_0'),('jacket-canada-gooseeSize_Large','Large','L','jacket-canada-goosee_0'),('jacket-canada-gooseeSize_Medium','Medium','M','jacket-canada-goosee_0'),('jacket-canada-gooseeSize_Small','Small','S','jacket-canada-goosee_0'),('ps-5Capacity_1T','1T','1T','ps-5_1'),('ps-5Capacity_512G','512G','512G','ps-5_1'),('ps-5Color_Black','Black','#000000','ps-5_0'),('ps-5Color_Blue','Blue','#030BFF','ps-5_0'),('ps-5Color_Cyan','Cyan','#03FFF7','ps-5_0'),('ps-5Color_Green','Green','#44FF03','ps-5_0'),('ps-5Color_White','White','#FFFFFF','ps-5_0'),('xbox-series-sCapacity_1T','1T','1T','xbox-series-s_1'),('xbox-series-sCapacity_512G','512G','512G','xbox-series-s_1'),('xbox-series-sColor_Black','Black','#000000','xbox-series-s_0'),('xbox-series-sColor_Blue','Blue','#030BFF','xbox-series-s_0'),('xbox-series-sColor_Cyan','Cyan','#03FFF7','xbox-series-s_0'),('xbox-series-sColor_Green','Green','#44FF03','xbox-series-s_0'),('xbox-series-sColor_White','White','#FFFFFF','xbox-series-s_0');
/*!40000 ALTER TABLE `attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attributeset`
--

DROP TABLE IF EXISTS `attributeset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributeset` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `AttributeSet_productId_fkey` (`productId`),
  CONSTRAINT `AttributeSet_productId_fkey` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attributeset`
--

LOCK TABLES `attributeset` WRITE;
/*!40000 ALTER TABLE `attributeset` DISABLE KEYS */;
INSERT INTO `attributeset` VALUES ('apple-imac-2021_0','Capacity','text','apple-imac-2021'),('apple-imac-2021_1','With USB 3 ports','text','apple-imac-2021'),('apple-imac-2021_2','Touch ID in keyboard','text','apple-imac-2021'),('apple-iphone-12-pro_0','Capacity','text','apple-iphone-12-pro'),('apple-iphone-12-pro_1','Color','swatch','apple-iphone-12-pro'),('huarache-x-stussy-le_0','Size','text','huarache-x-stussy-le'),('jacket-canada-goosee_0','Size','text','jacket-canada-goosee'),('ps-5_0','Color','swatch','ps-5'),('ps-5_1','Capacity','text','ps-5'),('xbox-series-s_0','Color','swatch','xbox-series-s'),('xbox-series-s_1','Capacity','text','xbox-series-s');
/*!40000 ALTER TABLE `attributeset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Category_name_key` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'all'),(2,'clothes'),(3,'tech');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (10,'USD','$'),(11,'USD','$'),(12,'USD','$'),(13,'USD','$'),(14,'USD','$'),(15,'USD','$'),(16,'USD','$'),(17,'USD','$');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Gallery_productId_fkey` (`productId`),
  CONSTRAINT `Gallery_productId_fkey` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` VALUES (39,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087','huarache-x-stussy-le'),(40,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087','huarache-x-stussy-le'),(41,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087','huarache-x-stussy-le'),(42,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087','huarache-x-stussy-le'),(43,'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087','huarache-x-stussy-le'),(44,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016105/product-image/2409L_61.jpg','jacket-canada-goosee'),(45,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016107/product-image/2409L_61_a.jpg','jacket-canada-goosee'),(46,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016108/product-image/2409L_61_b.jpg','jacket-canada-goosee'),(47,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016109/product-image/2409L_61_c.jpg','jacket-canada-goosee'),(48,'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016110/product-image/2409L_61_d.jpg','jacket-canada-goosee'),(49,'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058169/product-image/2409L_61_o.png','jacket-canada-goosee'),(50,'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058159/product-image/2409L_61_p.png','jacket-canada-goosee'),(51,'https://images-na.ssl-images-amazon.com/images/I/510VSJ9mWDL._SL1262_.jpg','ps-5'),(52,'https://images-na.ssl-images-amazon.com/images/I/610%2B69ZsKCL._SL1500_.jpg','ps-5'),(53,'https://images-na.ssl-images-amazon.com/images/I/51iPoFwQT3L._SL1230_.jpg','ps-5'),(54,'https://images-na.ssl-images-amazon.com/images/I/61qbqFcvoNL._SL1500_.jpg','ps-5'),(55,'https://images-na.ssl-images-amazon.com/images/I/51HCjA3rqYL._SL1230_.jpg','ps-5'),(56,'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg','xbox-series-s'),(57,'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg','xbox-series-s'),(58,'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg','xbox-series-s'),(59,'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg','xbox-series-s'),(60,'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg','xbox-series-s'),(61,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/imac-24-blue-selection-hero-202104?wid=904&hei=840&fmt=jpeg&qlt=80&.v=1617492405000','apple-imac-2021'),(62,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-12-pro-family-hero?wid=940&amp;hei=1112&amp;fmt=jpeg&amp;qlt=80&amp;.v=1604021663000','apple-iphone-12-pro'),(63,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000','apple-airpods-pro'),(64,'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/airtag-double-select-202104?wid=445&hei=370&fmt=jpeg&qlt=95&.v=1617761672000','apple-airtag');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `quantatiy` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options_set` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (3,20.99,'Tag1','Option1','ORD_66f33e85ee0cd'),(5,30.5,'Tag2','Option2','ORD_66f33e85ee0cd'),(1,120.57,'AirTag','','ORD_66f3452425c37'),(1,1688.03,'iMac 2021','Capacity256GB!!With USB 3 portsNo!!Touch ID in keyboardNo','ORD_66f3452425c37'),(1,144.69,'Nike Air Huarache Le','Size40','ORD_66f3452425c37'),(1,1688.03,'iMac 2021','Capacity256GB!!With USB 3 portsNo!!Touch ID in keyboardNo','ORD_66f34ac9dbac0'),(1,1688.03,'iMac 2021','Capacity512GB!!With USB 3 portsNo!!Touch ID in keyboardYes','ORD_66f34b8f1c2d7'),(1,120.57,'AirTag','','ORD_66f35b58d7bf3'),(3,1000.76,'iPhone 12 Pro','Capacity1T!!ColorBlack','ORD_66f35b58d7bf3'),(1,1688.03,'iMac 2021','Capacity256GB!!With USB 3 portsNo!!Touch ID in keyboardNo','ORD_66f35c95c33c5'),(1,120.57,'AirTag','','ORD_66f35c95c33c5'),(1,1000.76,'iPhone 12 Pro','Capacity1T!!ColorBlack','ORD_66f35c95c33c5'),(1,1688.03,'iMac 2021','Capacity256GB!!With USB 3 portsNo!!Touch ID in keyboardNo','ORD_670941cf3d6ef'),(1,1688.03,'iMac 2021','Capacity512GB!!With USB 3 portsYes!!Touch ID in keyboardNo','ORD_670941cf3d6ef');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price`
--

DROP TABLE IF EXISTS `price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL,
  `currencyId` int(11) NOT NULL,
  `productId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Price_currencyId_fkey` (`currencyId`),
  KEY `Price_productId_fkey` (`productId`),
  CONSTRAINT `Price_currencyId_fkey` FOREIGN KEY (`currencyId`) REFERENCES `currency` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `Price_productId_fkey` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price`
--

LOCK TABLES `price` WRITE;
/*!40000 ALTER TABLE `price` DISABLE KEYS */;
INSERT INTO `price` VALUES (10,144.69,10,'huarache-x-stussy-le'),(11,518.47,11,'jacket-canada-goosee'),(12,844.02,12,'ps-5'),(13,333.99,13,'xbox-series-s'),(14,1688.03,14,'apple-imac-2021'),(15,1000.76,15,'apple-iphone-12-pro'),(16,300.23,16,'apple-airpods-pro'),(17,120.57,17,'apple-airtag');
/*!40000 ALTER TABLE `price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `productId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inStock` tinyint(1) NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`productId`),
  KEY `Product_categoryId_fkey` (`categoryId`),
  CONSTRAINT `Product_categoryId_fkey` FOREIGN KEY (`categoryId`) REFERENCES `category` (`name`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES ('apple-airpods-pro','AirPods Pro',0,'\n<h3>Magic like you’ve never heard</h3>\n<p>AirPods Pro have been designed to deliver Active Noise Cancellation for immersive sound, Transparency mode so you can hear your surroundings, and a ','tech','Apple'),('apple-airtag','AirTag',1,'\n<h1>Lose your knack for losing things.</h1>\n<p>AirTag is an easy way to keep track of your stuff. Attach one to your keys, slip another one in your backpack. And just like that, they’re on y','tech','Apple'),('apple-imac-2021','iMac 2021',1,'The new iMac!','tech','Apple'),('apple-iphone-12-pro','iPhone 12 Pro',1,'This is iPhone 12. Nothing else to say.','tech','Apple'),('huarache-x-stussy-le','Nike Air Huarache Le',1,'<p>Great sneakers for everyday use!</p>','clothes','Nike x Stussy'),('jacket-canada-goosee','Jacket',1,'<p>Awesome winter jacket</p>','clothes','Canada Goose'),('ps-5','PlayStation 5',1,'<p>A good gaming console. Plays games of PS4! Enjoy if you can buy it mwahahahaha</p>','tech','Sony'),('xbox-series-s','Xbox Series S 512GB',0,'\n<div>\n    <ul>\n        <li><span>Hardware-beschleunigtes Raytracing macht dein Spiel noch realistischer</span></li>\n        <li><span>Spiele Games mit bis zu 120 Bilder pro Sekunde</span></l','tech','Microsoft');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-19 21:13:34
