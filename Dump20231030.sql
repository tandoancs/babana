-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: babana
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account` (
  `account_id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int DEFAULT NULL,
  `username` varchar(55) DEFAULT NULL,
  `password` varchar(55) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `address` varchar(55) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `status` varchar(95) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `area` (
  `area_id` int unsigned NOT NULL AUTO_INCREMENT,
  `area_name` varchar(55) DEFAULT NULL,
  `status` varchar(95) DEFAULT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'Gác',NULL),(2,'Ngoài',NULL),(3,'Về',NULL);
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bill` (
  `bill_id` int unsigned NOT NULL AUTO_INCREMENT,
  `date_check_in` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_check_out` timestamp NULL DEFAULT NULL,
  `count_orders` int DEFAULT NULL,
  `sum_orders` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `status` varchar(95) DEFAULT NULL,
  `money_received` int DEFAULT NULL,
  `money_refund` int DEFAULT NULL,
  `table_id` int DEFAULT NULL,
  `promotion_id` int DEFAULT NULL,
  `note` varchar(155) DEFAULT NULL,
  `printed` int DEFAULT '0',
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill`
--

LOCK TABLES `bill` WRITE;
/*!40000 ALTER TABLE `bill` DISABLE KEYS */;
INSERT INTO `bill` VALUES (21,'2023-10-19 04:33:13','2023-10-19 04:34:02',1,4,60000,'Done',100000,40000,1,0,'',2),(22,'2023-10-19 04:33:29','2023-10-19 04:35:31',2,3,45000,'Done',50000,5000,2,0,'',1),(23,'2023-10-19 04:33:44','2023-10-19 04:36:44',1,4,60000,'Done',70000,10000,3,0,'',1),(24,'2023-10-19 04:35:20','2023-10-19 04:38:40',2,3,45000,'Done',50000,5000,4,0,'',2),(25,'2023-10-19 04:38:07','2023-10-19 04:39:03',1,3,45000,'Done',50000,5000,7,0,'',2),(26,'2023-10-19 04:38:29','2023-10-19 12:47:18',1,2,30000,'Done',50000,20000,8,0,'',1),(27,'2023-10-19 04:47:19','2023-10-19 04:47:37',1,6,90000,'Done',100000,10000,21,0,'',1),(28,'2023-10-19 12:47:05','2023-10-19 12:47:32',1,20,300000,'Done',300000,0,1,0,'',1),(29,'2023-10-20 12:07:48','2023-10-20 13:12:59',3,5,75000,'Done',100000,25000,1,0,'',1),(30,'2023-10-20 13:17:00','2023-10-23 11:44:14',1,2,30000,'Done',30000,0,21,0,'',1),(31,'2023-10-20 13:19:02','2023-10-23 11:44:28',2,4,60000,'Done',60000,0,21,0,'',1),(32,'2023-10-23 01:47:27',NULL,1,2,30000,'In-progress',NULL,NULL,1,0,'',1);
/*!40000 ALTER TABLE `bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_detail`
--

DROP TABLE IF EXISTS `bill_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bill_detail` (
  `bill_detail_id` int unsigned NOT NULL AUTO_INCREMENT,
  `count` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `status` varchar(95) DEFAULT NULL,
  `bill_detail_total` int DEFAULT NULL,
  `size_unit_code` varchar(45) DEFAULT NULL,
  `bill_detail_description` varchar(125) DEFAULT NULL,
  `bill_id` int DEFAULT NULL,
  `food_id` int DEFAULT NULL,
  `note` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`bill_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_detail`
--

LOCK TABLES `bill_detail` WRITE;
/*!40000 ALTER TABLE `bill_detail` DISABLE KEYS */;
INSERT INTO `bill_detail` VALUES (28,3,15000,'1',45000,'1:M','Trà sữa trân châu đường đen (Vừa)',20,2,''),(30,4,15000,'1',60000,'1:M','Trà sữa truyền thống (Vừa)',21,1,''),(31,2,15000,'1',30000,'1:M','Trà sữa trân châu đường đen (Vừa)',22,2,''),(32,1,15000,'1',15000,'1:M','Trà sữa kem (Vừa)',22,3,''),(33,4,15000,'1',60000,'1:M','Trà sữa Matcha (Vừa)',23,4,''),(34,2,15000,'1',30000,'1:M','Trà sữa trân châu đường đen (Vừa)',24,2,''),(35,1,15000,'1',15000,'1:M','Trà sữa kem (Vừa)',24,3,''),(36,3,15000,'1',45000,'1:M','Trà sữa truyền thống (Vừa)',25,1,''),(37,2,15000,'1',30000,'1:M','Trà sữa trân châu đường đen (Vừa)',26,2,''),(38,6,15000,'1',90000,'1:M','Trà sữa truyền thống (Vừa)',27,1,''),(39,20,15000,'1',300000,'1:M','Trà sữa truyền thống (Vừa)',28,1,''),(40,1,15000,'1',15000,'1:M','Trà sữa truyền thống (Vừa)',29,1,''),(41,2,15000,'1',30000,'1:M','Trà sữa trân châu đường đen (Vừa)',29,2,''),(42,2,15000,'1',30000,'1:M','Trà sữa kem (Vừa)',29,3,''),(43,2,15000,'1',30000,'1:M','Trà sữa Matcha (Vừa)',30,4,''),(44,2,15000,'1',30000,'1:M','Trà sữa kem (Vừa)',31,3,''),(45,2,15000,'1',30000,'1:M','Trà sữa trân châu đường đen (Vừa)',31,2,''),(46,2,15000,'1',30000,'1:M','Trà sữa truyền thống (Vừa)',32,1,'');
/*!40000 ALTER TABLE `bill_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalog`
--

DROP TABLE IF EXISTS `catalog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalog` (
  `catalog_id` int unsigned NOT NULL AUTO_INCREMENT,
  `catalog_group` varchar(45) DEFAULT NULL,
  `catalog_name` varchar(55) DEFAULT NULL,
  `description` varchar(95) DEFAULT NULL,
  PRIMARY KEY (`catalog_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalog`
--

LOCK TABLES `catalog` WRITE;
/*!40000 ALTER TABLE `catalog` DISABLE KEYS */;
INSERT INTO `catalog` VALUES (1,'Menu Món nước','Trà Sữa','Menu Món nước - Trà Sữa'),(2,'Menu Món nước','Trà','Menu Món nước - Trà'),(3,'Menu Món nước','Nước Ép','Menu Món nước - Nước Ép'),(4,'Menu Món nước','Sinh Tố','Menu Món nước - Sinh Tố'),(5,'Menu Món nước','Cà Phê','Menu Món nước - Cà Phê'),(6,'Menu Món nước','Món Đặc Biệt','Menu Món nước - Món Đặc Biệt'),(7,'Menu Món nước','Topping','Menu Món nước - Topping'),(8,'Menu Món ăn','Món Ăn Siêu Ngon','Menu Món ăn - Món Ăn Siêu Ngon'),(9,'Menu Món ăn','Món Ăn Vặt Siêu Hot','Menu Món ăn - Món Ăn Vặt Siêu Hot'),(10,'Menu Món ăn','Món Ngọt Siêu Ngon','Menu Món ăn - Món Ngọt Siêu Ngon'),(11,'Menu Món nước','Khác','Menu Món nước - Khác');
/*!40000 ALTER TABLE `catalog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food`
--

DROP TABLE IF EXISTS `food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `food` (
  `food_id` int unsigned NOT NULL AUTO_INCREMENT,
  `food_name` varchar(195) DEFAULT NULL,
  `description` varchar(195) DEFAULT NULL,
  `status` varchar(95) DEFAULT NULL,
  `catalog_id` int DEFAULT NULL,
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food`
--

LOCK TABLES `food` WRITE;
/*!40000 ALTER TABLE `food` DISABLE KEYS */;
INSERT INTO `food` VALUES (1,'Trà sữa truyền thống','Trà sữa truyền thống','1',1),(2,'Trà sữa trân châu đường đen','Trà sữa trân châu đường đen','1',1),(3,'Trà sữa kem','Trà sữa kem','1',1),(4,'Trà sữa Matcha','Trà sữa Matcha','1',1),(5,'Trà sữa Socola','Trà sữa Socola','1',1),(6,'Trà sữa Freeze','Trà sữa Freeze','1',1),(7,'Trà sữa dâu','Trà sữa dâu','1',1),(8,'Trà sữa truyền thống full topping','Trà sữa truyền thống full topping','1',1),(9,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội','Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội','1',2),(10,'Trà Đào / Trà Đào Cam Sả','Trà Đào / Trà Đào Cam Sả','1',2),(11,'Trà Bưởi/ Trà Bưởi Cam Chanh','Trà Bưởi/ Trà Bưởi Cam Chanh','1',2),(12,'Trà vải','Trà vải','1',2),(13,'Trà Ổi hồng truyền thống','Trà Ổi hồng truyền thống','1',2),(14,'Trà Dâu truyền thống','Trà Dâu truyền thống','1',2),(15,'Trà chanh Sả gừng Mật Ong','Trà chanh Sả gừng Mật Ong','1',2),(16,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa','Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa','1',2),(17,'Trà Hoa 7 vị','Trà Hoa 7 vị','1',2),(18,'Trà Lipton Thảo Mộc 9 vị','Trà Lipton Thảo Mộc 9 vị','1',2),(19,'Nước Ép Cam','Nước Ép Cam','1',3),(20,'Chanh Dây Mix Cam','Chanh Dây Mix Cam','1',3),(21,'Chanh Dây Mix Tắc','Chanh Dây Mix Tắc','1',3),(22,'Nước Ép Ổi','Nước Ép Ổi','1',3),(23,'Nước Ép Thơm','Nước Ép Thơm','1',3),(24,'Nước Ép Dưa Hấu','Nước Ép Dưa Hấu','1',3),(25,'Nước Ép Táo','Nước Ép Táo','1',3),(26,'Nước Ép Cà Rốt','Nước Ép Cà Rốt','1',3),(27,'Sinh Tố Bơ','Sinh Tố Bơ','1',4),(28,'Sinh Tố Dâu','Sinh Tố Dâu','1',4),(29,'Sinh Tố Dừa','Sinh Tố Dừa','1',4),(30,'Sinh Tố Đu Đủ','Sinh Tố Đu Đủ','1',4),(31,'Sinh Tố Xoài','Sinh Tố Xoài','1',4),(32,'Sinh Tố Mãng Cầu','Sinh Tố Mãng Cầu','1',4),(33,'Sinh Tố Cà Chua','Sinh Tố Cà Chua','1',4),(34,'Sinh Tố Saboche','Sinh Tố Saboche','1',4),(35,'Cà Phê Đá','Cà Phê Đá','1',5),(36,'Cà Phê Sữa Đá','Cà Phê Sữa Đá','1',5),(37,'Cà phê Sương sáo','Cà phê Sương sáo','1',5),(38,'Cà phê Sữa Tươi','Cà phê Sữa Tươi','1',5),(39,'Trà Bí Đao Hạt Chia','Trà Bí Đao Hạt Chia','1',6),(40,'Nước Nha Đam Nhà Trồng','Nước Nha Đam Nhà Trồng','1',6),(41,'Nước ngọt (Coca, Pepsi, 7up, Sting)','Nước ngọt (Coca, Pepsi, 7up, Sting)','1',11),(42,'Trà sữa truyền thống','Trà sữa truyền thống','1',1),(43,'Trà sữa trân châu đường đen','Trà sữa trân châu đường đen','1',1),(44,'Trà sữa kem','Trà sữa kem','1',1),(45,'Trà sữa Matcha','Trà sữa Matcha','1',1),(46,'Trà sữa Socola','Trà sữa Socola','1',1),(47,'Trà sữa Freeze','Trà sữa Freeze','1',1),(48,'Trà sữa dâu','Trà sữa dâu','1',1),(49,'Trà sữa truyền thống full topping','Trà sữa truyền thống full topping','1',1),(50,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội','Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội','1',2),(51,'Trà Đào / Trà Đào Cam Sả','Trà Đào / Trà Đào Cam Sả','1',2),(52,'Trà Bưởi/ Trà Bưởi Cam Chanh','Trà Bưởi/ Trà Bưởi Cam Chanh','1',2),(53,'Trà vải','Trà vải','1',2),(54,'Trà Ổi hồng truyền thống','Trà Ổi hồng truyền thống','1',2),(55,'Trà Dâu truyền thống','Trà Dâu truyền thống','1',2),(56,'Trà chanh Sả gừng Mật Ong','Trà chanh Sả gừng Mật Ong','1',2),(57,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa','Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa','1',2),(58,'Trà Hoa 7 vị','Trà Hoa 7 vị','1',2),(59,'Trà Lipton Thảo Mộc 9 vị','Trà Lipton Thảo Mộc 9 vị','1',2),(60,'Nước Ép Cam','Nước Ép Cam','1',3),(61,'Chanh Dây Mix Cam','Chanh Dây Mix Cam','1',3),(62,'Chanh Dây Mix Tắc','Chanh Dây Mix Tắc','1',3),(63,'Nước Ép Ổi','Nước Ép Ổi','1',3),(64,'Nước Ép Thơm','Nước Ép Thơm','1',3),(65,'Nước Ép Dưa Hấu','Nước Ép Dưa Hấu','1',3),(66,'Nước Ép Táo','Nước Ép Táo','1',3),(67,'Nước Ép Cà Rốt','Nước Ép Cà Rốt','1',3),(68,'Sinh Tố Bơ','Sinh Tố Bơ','1',4),(69,'Sinh Tố Dâu','Sinh Tố Dâu','1',4),(70,'Sinh Tố Dừa','Sinh Tố Dừa','1',4),(71,'Sinh Tố Đu Đủ','Sinh Tố Đu Đủ','1',4),(72,'Sinh Tố Xoài','Sinh Tố Xoài','1',4),(73,'Sinh Tố Mãng Cầu','Sinh Tố Mãng Cầu','1',4),(74,'Sinh Tố Cà Chua','Sinh Tố Cà Chua','1',4),(75,'Sinh Tố Saboche','Sinh Tố Saboche','1',4),(76,'Cà Phê Đá','Cà Phê Đá','1',5),(77,'Cà Phê Sữa Đá','Cà Phê Sữa Đá','1',5),(78,'Cà phê Sương sáo','Cà phê Sương sáo','1',5),(79,'Cà phê Sữa Tươi','Cà phê Sữa Tươi','1',5),(80,'Trà Bí Đao Hạt Chia','Trà Bí Đao Hạt Chia','1',6),(81,'Nước Nha Đam Nhà Trồng','Nước Nha Đam Nhà Trồng','1',6),(82,'Nước ngọt (Coca, Pepsi, 7up, Sting)','Nước ngọt (Coca, Pepsi, 7up, Sting)','1',11),(83,'Trà sữa truyền thống','Trà sữa truyền thống','1',1),(84,'Trà sữa trân châu đường đen','Trà sữa trân châu đường đen','1',1),(85,'Trà sữa kem','Trà sữa kem','1',1),(86,'Trà sữa Matcha','Trà sữa Matcha','1',1),(87,'Trà sữa Socola','Trà sữa Socola','1',1),(88,'Trà sữa Freeze','Trà sữa Freeze','1',1),(89,'Trà sữa dâu','Trà sữa dâu','1',1),(90,'Trà sữa truyền thống full topping','Trà sữa truyền thống full topping','1',1),(91,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội','Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội','1',2),(92,'Trà Đào / Trà Đào Cam Sả','Trà Đào / Trà Đào Cam Sả','1',2),(93,'Trà Bưởi/ Trà Bưởi Cam Chanh','Trà Bưởi/ Trà Bưởi Cam Chanh','1',2),(94,'Trà vải','Trà vải','1',2),(95,'Trà Ổi hồng truyền thống','Trà Ổi hồng truyền thống','1',2),(96,'Trà Dâu truyền thống','Trà Dâu truyền thống','1',2),(97,'Trà chanh Sả gừng Mật Ong','Trà chanh Sả gừng Mật Ong','1',2),(98,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa','Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa','1',2),(99,'Trà Hoa 7 vị','Trà Hoa 7 vị','1',2),(100,'Trà Lipton Thảo Mộc 9 vị','Trà Lipton Thảo Mộc 9 vị','1',2),(101,'Nước Ép Cam','Nước Ép Cam','1',3),(102,'Chanh Dây Mix Cam','Chanh Dây Mix Cam','1',3),(103,'Chanh Dây Mix Tắc','Chanh Dây Mix Tắc','1',3),(104,'Nước Ép Ổi','Nước Ép Ổi','1',3),(105,'Nước Ép Thơm','Nước Ép Thơm','1',3),(106,'Nước Ép Dưa Hấu','Nước Ép Dưa Hấu','1',3),(107,'Nước Ép Táo','Nước Ép Táo','1',3),(108,'Nước Ép Cà Rốt','Nước Ép Cà Rốt','1',3),(109,'Sinh Tố Bơ','Sinh Tố Bơ','1',4),(110,'Sinh Tố Dâu','Sinh Tố Dâu','1',4),(111,'Sinh Tố Dừa','Sinh Tố Dừa','1',4),(112,'Sinh Tố Đu Đủ','Sinh Tố Đu Đủ','1',4),(113,'Sinh Tố Xoài','Sinh Tố Xoài','1',4),(114,'Sinh Tố Mãng Cầu','Sinh Tố Mãng Cầu','1',4),(115,'Sinh Tố Cà Chua','Sinh Tố Cà Chua','1',4),(116,'Sinh Tố Saboche','Sinh Tố Saboche','1',4),(117,'Cà Phê Đá','Cà Phê Đá','1',5),(118,'Cà Phê Sữa Đá','Cà Phê Sữa Đá','1',5),(119,'Cà phê Sương sáo','Cà phê Sương sáo','1',5),(120,'Cà phê Sữa Tươi','Cà phê Sữa Tươi','1',5),(121,'Trà Bí Đao Hạt Chia','Trà Bí Đao Hạt Chia','1',6),(122,'Nước Nha Đam Nhà Trồng','Nước Nha Đam Nhà Trồng','1',6),(123,'Nước ngọt (Coca, Pepsi, 7up, Sting)','Nước ngọt (Coca, Pepsi, 7up, Sting)','1',11),(124,'Bánh Plan dành cho trà sữa','Bánh Plan dành cho trà sữa','1',7),(125,'Pudding','Pudding','1',7),(126,'Trân châu đen','Trân châu đen','1',7),(127,'Trân châu trắng','Trân châu trắng','1',7),(128,'Trân châu phomai','Trân châu phomai','1',7),(129,'Sương sáo','Sương sáo','1',7),(130,'Kem','Kem','1',7),(131,'Mì Cay Kim Chi Thập Cẩm','Mì Cay Kim Chi Thập Cẩm','1',8),(132,'Mì Cay Kim Chi Bò','Mì Cay Kim Chi Bò','1',8),(133,'Mì cay kim chi cá viên xúc xích','Mì cay kim chi cá viên xúc xích','1',8),(134,'Mì Cay Kim Chi Cá viên','Mì Cay Kim Chi Cá viên','1',8),(135,'Mì Cay Kim Chi Đùi Gà','Mì Cay Kim Chi Đùi Gà','1',8),(136,'Mì Cay Kim Chi Hải Sản','Mì Cay Kim Chi Hải Sản','1',8),(137,'Bánh Canh Hẹ Thố','Bánh Canh Hẹ Thố','1',8),(138,'Bò Kho Bánh Mì','Bò Kho Bánh Mì','1',8),(139,'Cơm Gà chiên Mắm Thố','Cơm Gà chiên Mắm Thố','1',8),(140,'Cơm Sườn Thố','Cơm Sườn Thố','1',8),(141,'Khoai tây lắc phô mai/ lắc xí muội','Khoai tây lắc phô mai/ lắc xí muội','1',9),(142,'Khoai lang lắc phô mai/ lắc xí muội','Khoai lang lắc phô mai/ lắc xí muội','1',9),(143,'Cá viên/ Tôm viên/Bò viên/Phô mai que/Thanh cua/ Dồi sụn (phần)','Cá viên/ Tôm viên/Bò viên/Phô mai que/Thanh cua/ Dồi sụn (phần)','1',9),(144,'Hotdog/ 1 cây','Hotdog/ 1 cây','1',9),(145,'Đậu hủ Basa chà bông','Đậu hủ Basa chà bông','1',9),(146,'Thập cầm xiên que ( phần)','Thập cầm xiên que ( phần)','1',9),(147,'Chân Gà Xã Tắc','Chân Gà Xã Tắc','1',9),(148,'Đùi gà rán (1 đùi)','Đùi gà rán (1 đùi)','1',9),(149,'Cơm Cháy Chà Bông Mỡ Hành (phần)','Cơm Cháy Chà Bông Mỡ Hành (phần)','1',9),(150,'Bánh Tokoyaki','Bánh Tokoyaki','1',9),(151,'Bò cuộn nấm kim châm (phần)','Bò cuộn nấm kim châm (phần)','1',9),(152,'Ba chỉ nướng (phần)','Ba chỉ nướng (phần)','1',9),(153,'Bánh plan','Bánh plan','1',10),(154,'Rau câu','Rau câu','1',10);
/*!40000 ALTER TABLE `food` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food_size`
--

DROP TABLE IF EXISTS `food_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `food_size` (
  `food_size_id` int unsigned NOT NULL AUTO_INCREMENT,
  `price` int DEFAULT NULL,
  `promotion_price` int DEFAULT NULL,
  `description` varchar(195) DEFAULT NULL,
  `food_id` int unsigned DEFAULT NULL,
  `size_unit_code` varchar(5) DEFAULT NULL,
  `promotion_price_deadline` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`food_size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food_size`
--

LOCK TABLES `food_size` WRITE;
/*!40000 ALTER TABLE `food_size` DISABLE KEYS */;
INSERT INTO `food_size` VALUES (1,12000,0,'Trà sữa truyền thống (Vừa)',1,'1:M','0000-00-00 00:00:00'),(2,16000,0,'Trà sữa truyền thống (Lớn)',1,'1:L','0000-00-00 00:00:00'),(3,15000,0,'Trà sữa trân châu đường đen (Vừa)',2,'1:M','0000-00-00 00:00:00'),(4,19000,0,'Trà sữa trân châu đường đen (Lớn)',2,'1:L','0000-00-00 00:00:00'),(5,15000,0,'Trà sữa kem (Vừa)',3,'1:M','0000-00-00 00:00:00'),(6,19000,0,'Trà sữa kem (Lớn)',3,'1:L','0000-00-00 00:00:00'),(7,15000,0,'Trà sữa Matcha (Vừa)',4,'1:M','0000-00-00 00:00:00'),(8,19000,0,'Trà sữa Matcha (Lớn)',4,'1:L','0000-00-00 00:00:00'),(9,15000,0,'Trà sữa Socola (Vừa)',5,'1:M','0000-00-00 00:00:00'),(10,19000,0,'Trà sữa Socola (Lớn)',5,'1:L','0000-00-00 00:00:00'),(11,15000,0,'Trà sữa Freeze (Vừa)',6,'1:M','0000-00-00 00:00:00'),(12,19000,0,'Trà sữa Freeze (Lớn)',6,'1:L','0000-00-00 00:00:00'),(13,15000,0,'Trà sữa dâu (Vừa)',7,'1:M','0000-00-00 00:00:00'),(14,19000,0,'Trà sữa dâu (Lớn)',7,'1:L','0000-00-00 00:00:00'),(15,19000,0,'Trà sữa truyền thống full topping (Vừa)',8,'1:M','0000-00-00 00:00:00'),(16,23000,0,'Trà sữa truyền thống full topping (Lớn)',8,'1:L','0000-00-00 00:00:00'),(17,8000,0,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội (Vừa)',9,'1:M','0000-00-00 00:00:00'),(18,12000,0,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội (Lớn)',9,'1:L','0000-00-00 00:00:00'),(19,10000,0,'Trà Đào / Trà Đào Cam Sả (Vừa)',10,'1:M','0000-00-00 00:00:00'),(20,14000,0,'Trà Đào / Trà Đào Cam Sả (Lớn)',10,'1:L','0000-00-00 00:00:00'),(21,15000,0,'Trà Bưởi/ Trà Bưởi Cam Chanh (Vừa)',11,'1:M','0000-00-00 00:00:00'),(22,19000,0,'Trà Bưởi/ Trà Bưởi Cam Chanh (Lớn)',11,'1:L','0000-00-00 00:00:00'),(23,15000,0,'Trà vải (Vừa)',12,'1:M','0000-00-00 00:00:00'),(24,19000,0,'Trà vải (Lớn)',12,'1:L','0000-00-00 00:00:00'),(25,15000,0,'Trà Ổi hồng truyền thống (Vừa)',13,'1:M','0000-00-00 00:00:00'),(26,19000,0,'Trà Ổi hồng truyền thống (Lớn)',13,'1:L','0000-00-00 00:00:00'),(27,15000,0,'Trà Dâu truyền thống (Vừa)',14,'1:M','0000-00-00 00:00:00'),(28,19000,0,'Trà Dâu truyền thống (Lớn)',14,'1:L','0000-00-00 00:00:00'),(29,18000,0,'Trà chanh Sả gừng Mật Ong (Vừa)',15,'1:M','0000-00-00 00:00:00'),(30,22000,0,'Trà chanh Sả gừng Mật Ong (Lớn)',15,'1:L','0000-00-00 00:00:00'),(31,18000,0,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa (Vừa)',16,'1:M','0000-00-00 00:00:00'),(32,22000,0,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa (Lớn)',16,'1:L','0000-00-00 00:00:00'),(33,18000,0,'Trà Hoa 7 vị (Vừa)',17,'1:M','0000-00-00 00:00:00'),(34,22000,0,'Trà Hoa 7 vị (Lớn)',17,'1:L','0000-00-00 00:00:00'),(35,18000,0,'Trà Lipton Thảo Mộc 9 vị (Vừa)',18,'1:M','0000-00-00 00:00:00'),(36,22000,0,'Trà Lipton Thảo Mộc 9 vị (Lớn)',18,'1:L','0000-00-00 00:00:00'),(37,8000,0,'Nước Ép Cam (Vừa)',19,'1:M','0000-00-00 00:00:00'),(38,12000,0,'Nước Ép Cam (Lớn)',19,'1:L','0000-00-00 00:00:00'),(39,15000,0,'Chanh Dây Mix Cam (Vừa)',20,'1:M','0000-00-00 00:00:00'),(40,19000,0,'Chanh Dây Mix Cam (Lớn)',20,'1:L','0000-00-00 00:00:00'),(41,15000,0,'Chanh Dây Mix Tắc (Vừa)',21,'1:M','0000-00-00 00:00:00'),(42,19000,0,'Chanh Dây Mix Tắc (Lớn)',21,'1:L','0000-00-00 00:00:00'),(43,15000,0,'Nước Ép Ổi (Vừa)',22,'1:M','0000-00-00 00:00:00'),(44,19000,0,'Nước Ép Ổi (Lớn)',22,'1:L','0000-00-00 00:00:00'),(45,15000,0,'Nước Ép Thơm (Vừa)',23,'1:M','0000-00-00 00:00:00'),(46,19000,0,'Nước Ép Thơm (Lớn)',23,'1:L','0000-00-00 00:00:00'),(47,15000,0,'Nước Ép Dưa Hấu (Vừa)',24,'1:M','0000-00-00 00:00:00'),(48,19000,0,'Nước Ép Dưa Hấu (Lớn)',24,'1:L','0000-00-00 00:00:00'),(49,15000,0,'Nước Ép Táo (Vừa)',25,'1:M','0000-00-00 00:00:00'),(50,19000,0,'Nước Ép Táo (Lớn)',25,'1:L','0000-00-00 00:00:00'),(51,15000,0,'Nước Ép Cà Rốt (Vừa)',26,'1:M','0000-00-00 00:00:00'),(52,19000,0,'Nước Ép Cà Rốt (Lớn)',26,'1:L','0000-00-00 00:00:00'),(53,15000,0,'Sinh Tố Bơ (Vừa)',27,'1:M','0000-00-00 00:00:00'),(54,19000,0,'Sinh Tố Bơ (Lớn)',27,'1:L','0000-00-00 00:00:00'),(55,15000,0,'Sinh Tố Dâu (Vừa)',28,'1:M','0000-00-00 00:00:00'),(56,19000,0,'Sinh Tố Dâu (Lớn)',28,'1:L','0000-00-00 00:00:00'),(57,15000,0,'Sinh Tố Dừa (Vừa)',29,'1:M','0000-00-00 00:00:00'),(58,19000,0,'Sinh Tố Dừa (Lớn)',29,'1:L','0000-00-00 00:00:00'),(59,15000,0,'Sinh Tố Đu Đủ (Vừa)',30,'1:M','0000-00-00 00:00:00'),(60,19000,0,'Sinh Tố Đu Đủ (Lớn)',30,'1:L','0000-00-00 00:00:00'),(61,15000,0,'Sinh Tố Xoài (Vừa)',31,'1:M','0000-00-00 00:00:00'),(62,19000,0,'Sinh Tố Xoài (Lớn)',31,'1:L','0000-00-00 00:00:00'),(63,15000,0,'Sinh Tố Mãng Cầu (Vừa)',32,'1:M','0000-00-00 00:00:00'),(64,19000,0,'Sinh Tố Mãng Cầu (Lớn)',32,'1:L','0000-00-00 00:00:00'),(65,15000,0,'Sinh Tố Cà Chua (Vừa)',33,'1:M','0000-00-00 00:00:00'),(66,19000,0,'Sinh Tố Cà Chua (Lớn)',33,'1:L','0000-00-00 00:00:00'),(67,15000,0,'Sinh Tố Saboche (Vừa)',34,'1:M','0000-00-00 00:00:00'),(68,19000,0,'Sinh Tố Saboche (Lớn)',34,'1:L','0000-00-00 00:00:00'),(69,9000,0,'Cà Phê Đá (Vừa)',35,'1:M','0000-00-00 00:00:00'),(70,13000,0,'Cà Phê Đá (Lớn)',35,'1:L','0000-00-00 00:00:00'),(71,12000,0,'Cà Phê Sữa Đá (Vừa)',36,'1:M','0000-00-00 00:00:00'),(72,16000,0,'Cà Phê Sữa Đá (Lớn)',36,'1:L','0000-00-00 00:00:00'),(73,14000,0,'Cà phê Sương sáo (Vừa)',37,'1:M','0000-00-00 00:00:00'),(74,18000,0,'Cà phê Sương sáo (Lớn)',37,'1:L','0000-00-00 00:00:00'),(75,14000,0,'Cà phê Sữa Tươi (Vừa)',38,'1:M','0000-00-00 00:00:00'),(76,18000,0,'Cà phê Sữa Tươi (Lớn)',38,'1:L','0000-00-00 00:00:00'),(77,15000,0,'Trà Bí Đao Hạt Chia (Vừa)',39,'1:M','0000-00-00 00:00:00'),(78,19000,0,'Trà Bí Đao Hạt Chia (Lớn)',39,'1:L','0000-00-00 00:00:00'),(79,8000,0,'Nước Nha Đam Nhà Trồng (Vừa)',40,'1:M','0000-00-00 00:00:00'),(80,12000,0,'Nước Nha Đam Nhà Trồng (Lớn)',40,'1:L','0000-00-00 00:00:00'),(81,12000,0,'Trà sữa truyền thống (Vừa)',42,'1:M','0000-00-00 00:00:00'),(82,16000,0,'Trà sữa truyền thống (Lớn)',42,'1:L','0000-00-00 00:00:00'),(83,15000,0,'Trà sữa trân châu đường đen (Vừa)',43,'1:M','0000-00-00 00:00:00'),(84,19000,0,'Trà sữa trân châu đường đen (Lớn)',43,'1:L','0000-00-00 00:00:00'),(85,15000,0,'Trà sữa kem (Vừa)',44,'1:M','0000-00-00 00:00:00'),(86,19000,0,'Trà sữa kem (Lớn)',44,'1:L','0000-00-00 00:00:00'),(87,15000,0,'Trà sữa Matcha (Vừa)',45,'1:M','0000-00-00 00:00:00'),(88,19000,0,'Trà sữa Matcha (Lớn)',45,'1:L','0000-00-00 00:00:00'),(89,15000,0,'Trà sữa Socola (Vừa)',46,'1:M','0000-00-00 00:00:00'),(90,19000,0,'Trà sữa Socola (Lớn)',46,'1:L','0000-00-00 00:00:00'),(91,15000,0,'Trà sữa Freeze (Vừa)',47,'1:M','0000-00-00 00:00:00'),(92,19000,0,'Trà sữa Freeze (Lớn)',47,'1:L','0000-00-00 00:00:00'),(93,15000,0,'Trà sữa dâu (Vừa)',48,'1:M','0000-00-00 00:00:00'),(94,19000,0,'Trà sữa dâu (Lớn)',48,'1:L','0000-00-00 00:00:00'),(95,19000,0,'Trà sữa truyền thống full topping (Vừa)',49,'1:M','0000-00-00 00:00:00'),(96,23000,0,'Trà sữa truyền thống full topping (Lớn)',49,'1:L','0000-00-00 00:00:00'),(97,8000,0,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội (Vừa)',50,'1:M','0000-00-00 00:00:00'),(98,12000,0,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội (Lớn)',50,'1:L','0000-00-00 00:00:00'),(99,10000,0,'Trà Đào / Trà Đào Cam Sả (Vừa)',51,'1:M','0000-00-00 00:00:00'),(100,14000,0,'Trà Đào / Trà Đào Cam Sả (Lớn)',51,'1:L','0000-00-00 00:00:00'),(101,15000,0,'Trà Bưởi/ Trà Bưởi Cam Chanh (Vừa)',52,'1:M','0000-00-00 00:00:00'),(102,19000,0,'Trà Bưởi/ Trà Bưởi Cam Chanh (Lớn)',52,'1:L','0000-00-00 00:00:00'),(103,15000,0,'Trà vải (Vừa)',53,'1:M','0000-00-00 00:00:00'),(104,19000,0,'Trà vải (Lớn)',53,'1:L','0000-00-00 00:00:00'),(105,15000,0,'Trà Ổi hồng truyền thống (Vừa)',54,'1:M','0000-00-00 00:00:00'),(106,19000,0,'Trà Ổi hồng truyền thống (Lớn)',54,'1:L','0000-00-00 00:00:00'),(107,15000,0,'Trà Dâu truyền thống (Vừa)',55,'1:M','0000-00-00 00:00:00'),(108,19000,0,'Trà Dâu truyền thống (Lớn)',55,'1:L','0000-00-00 00:00:00'),(109,18000,0,'Trà chanh Sả gừng Mật Ong (Vừa)',56,'1:M','0000-00-00 00:00:00'),(110,22000,0,'Trà chanh Sả gừng Mật Ong (Lớn)',56,'1:L','0000-00-00 00:00:00'),(111,18000,0,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa (Vừa)',57,'1:M','0000-00-00 00:00:00'),(112,22000,0,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa (Lớn)',57,'1:L','0000-00-00 00:00:00'),(113,18000,0,'Trà Hoa 7 vị (Vừa)',58,'1:M','0000-00-00 00:00:00'),(114,22000,0,'Trà Hoa 7 vị (Lớn)',58,'1:L','0000-00-00 00:00:00'),(115,18000,0,'Trà Lipton Thảo Mộc 9 vị (Vừa)',59,'1:M','0000-00-00 00:00:00'),(116,22000,0,'Trà Lipton Thảo Mộc 9 vị (Lớn)',59,'1:L','0000-00-00 00:00:00'),(117,8000,0,'Nước Ép Cam (Vừa)',60,'1:M','0000-00-00 00:00:00'),(118,12000,0,'Nước Ép Cam (Lớn)',60,'1:L','0000-00-00 00:00:00'),(119,15000,0,'Chanh Dây Mix Cam (Vừa)',61,'1:M','0000-00-00 00:00:00'),(120,19000,0,'Chanh Dây Mix Cam (Lớn)',61,'1:L','0000-00-00 00:00:00'),(121,15000,0,'Chanh Dây Mix Tắc (Vừa)',62,'1:M','0000-00-00 00:00:00'),(122,19000,0,'Chanh Dây Mix Tắc (Lớn)',62,'1:L','0000-00-00 00:00:00'),(123,15000,0,'Nước Ép Ổi (Vừa)',63,'1:M','0000-00-00 00:00:00'),(124,19000,0,'Nước Ép Ổi (Lớn)',63,'1:L','0000-00-00 00:00:00'),(125,15000,0,'Nước Ép Thơm (Vừa)',64,'1:M','0000-00-00 00:00:00'),(126,19000,0,'Nước Ép Thơm (Lớn)',64,'1:L','0000-00-00 00:00:00'),(127,15000,0,'Nước Ép Dưa Hấu (Vừa)',65,'1:M','0000-00-00 00:00:00'),(128,19000,0,'Nước Ép Dưa Hấu (Lớn)',65,'1:L','0000-00-00 00:00:00'),(129,15000,0,'Nước Ép Táo (Vừa)',66,'1:M','0000-00-00 00:00:00'),(130,19000,0,'Nước Ép Táo (Lớn)',66,'1:L','0000-00-00 00:00:00'),(131,15000,0,'Nước Ép Cà Rốt (Vừa)',67,'1:M','0000-00-00 00:00:00'),(132,19000,0,'Nước Ép Cà Rốt (Lớn)',67,'1:L','0000-00-00 00:00:00'),(133,15000,0,'Sinh Tố Bơ (Vừa)',68,'1:M','0000-00-00 00:00:00'),(134,19000,0,'Sinh Tố Bơ (Lớn)',68,'1:L','0000-00-00 00:00:00'),(135,15000,0,'Sinh Tố Dâu (Vừa)',69,'1:M','0000-00-00 00:00:00'),(136,19000,0,'Sinh Tố Dâu (Lớn)',69,'1:L','0000-00-00 00:00:00'),(137,15000,0,'Sinh Tố Dừa (Vừa)',70,'1:M','0000-00-00 00:00:00'),(138,19000,0,'Sinh Tố Dừa (Lớn)',70,'1:L','0000-00-00 00:00:00'),(139,15000,0,'Sinh Tố Đu Đủ (Vừa)',71,'1:M','0000-00-00 00:00:00'),(140,19000,0,'Sinh Tố Đu Đủ (Lớn)',71,'1:L','0000-00-00 00:00:00'),(141,15000,0,'Sinh Tố Xoài (Vừa)',72,'1:M','0000-00-00 00:00:00'),(142,19000,0,'Sinh Tố Xoài (Lớn)',72,'1:L','0000-00-00 00:00:00'),(143,15000,0,'Sinh Tố Mãng Cầu (Vừa)',73,'1:M','0000-00-00 00:00:00'),(144,19000,0,'Sinh Tố Mãng Cầu (Lớn)',73,'1:L','0000-00-00 00:00:00'),(145,15000,0,'Sinh Tố Cà Chua (Vừa)',74,'1:M','0000-00-00 00:00:00'),(146,19000,0,'Sinh Tố Cà Chua (Lớn)',74,'1:L','0000-00-00 00:00:00'),(147,15000,0,'Sinh Tố Saboche (Vừa)',75,'1:M','0000-00-00 00:00:00'),(148,19000,0,'Sinh Tố Saboche (Lớn)',75,'1:L','0000-00-00 00:00:00'),(149,9000,0,'Cà Phê Đá (Vừa)',76,'1:M','0000-00-00 00:00:00'),(150,13000,0,'Cà Phê Đá (Lớn)',76,'1:L','0000-00-00 00:00:00'),(151,12000,0,'Cà Phê Sữa Đá (Vừa)',77,'1:M','0000-00-00 00:00:00'),(152,16000,0,'Cà Phê Sữa Đá (Lớn)',77,'1:L','0000-00-00 00:00:00'),(153,14000,0,'Cà phê Sương sáo (Vừa)',78,'1:M','0000-00-00 00:00:00'),(154,18000,0,'Cà phê Sương sáo (Lớn)',78,'1:L','0000-00-00 00:00:00'),(155,14000,0,'Cà phê Sữa Tươi (Vừa)',79,'1:M','0000-00-00 00:00:00'),(156,18000,0,'Cà phê Sữa Tươi (Lớn)',79,'1:L','0000-00-00 00:00:00'),(157,15000,0,'Trà Bí Đao Hạt Chia (Vừa)',80,'1:M','0000-00-00 00:00:00'),(158,19000,0,'Trà Bí Đao Hạt Chia (Lớn)',80,'1:L','0000-00-00 00:00:00'),(159,8000,0,'Nước Nha Đam Nhà Trồng (Vừa)',81,'1:M','0000-00-00 00:00:00'),(160,12000,0,'Nước Nha Đam Nhà Trồng (Lớn)',81,'1:L','0000-00-00 00:00:00'),(161,12000,0,'Trà sữa truyền thống (Vừa)',83,'1:M','0000-00-00 00:00:00'),(162,16000,0,'Trà sữa truyền thống (Lớn)',83,'1:L','0000-00-00 00:00:00'),(163,15000,0,'Trà sữa trân châu đường đen (Vừa)',84,'1:M','0000-00-00 00:00:00'),(164,19000,0,'Trà sữa trân châu đường đen (Lớn)',84,'1:L','0000-00-00 00:00:00'),(165,15000,0,'Trà sữa kem (Vừa)',85,'1:M','0000-00-00 00:00:00'),(166,19000,0,'Trà sữa kem (Lớn)',85,'1:L','0000-00-00 00:00:00'),(167,15000,0,'Trà sữa Matcha (Vừa)',86,'1:M','0000-00-00 00:00:00'),(168,19000,0,'Trà sữa Matcha (Lớn)',86,'1:L','0000-00-00 00:00:00'),(169,15000,0,'Trà sữa Socola (Vừa)',87,'1:M','0000-00-00 00:00:00'),(170,19000,0,'Trà sữa Socola (Lớn)',87,'1:L','0000-00-00 00:00:00'),(171,15000,0,'Trà sữa Freeze (Vừa)',88,'1:M','0000-00-00 00:00:00'),(172,19000,0,'Trà sữa Freeze (Lớn)',88,'1:L','0000-00-00 00:00:00'),(173,15000,0,'Trà sữa dâu (Vừa)',89,'1:M','0000-00-00 00:00:00'),(174,19000,0,'Trà sữa dâu (Lớn)',89,'1:L','0000-00-00 00:00:00'),(175,19000,0,'Trà sữa truyền thống full topping (Vừa)',90,'1:M','0000-00-00 00:00:00'),(176,23000,0,'Trà sữa truyền thống full topping (Lớn)',90,'1:L','0000-00-00 00:00:00'),(177,8000,0,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội (Vừa)',91,'1:M','0000-00-00 00:00:00'),(178,12000,0,'Trà Tắc/Trà Tắc Sả/ Trà Tắc Cam Sả/  Xí Muội (Lớn)',91,'1:L','0000-00-00 00:00:00'),(179,10000,0,'Trà Đào / Trà Đào Cam Sả (Vừa)',92,'1:M','0000-00-00 00:00:00'),(180,14000,0,'Trà Đào / Trà Đào Cam Sả (Lớn)',92,'1:L','0000-00-00 00:00:00'),(181,15000,0,'Trà Bưởi/ Trà Bưởi Cam Chanh (Vừa)',93,'1:M','0000-00-00 00:00:00'),(182,19000,0,'Trà Bưởi/ Trà Bưởi Cam Chanh (Lớn)',93,'1:L','0000-00-00 00:00:00'),(183,15000,0,'Trà vải (Vừa)',94,'1:M','0000-00-00 00:00:00'),(184,19000,0,'Trà vải (Lớn)',94,'1:L','0000-00-00 00:00:00'),(185,15000,0,'Trà Ổi hồng truyền thống (Vừa)',95,'1:M','0000-00-00 00:00:00'),(186,19000,0,'Trà Ổi hồng truyền thống (Lớn)',95,'1:L','0000-00-00 00:00:00'),(187,15000,0,'Trà Dâu truyền thống (Vừa)',96,'1:M','0000-00-00 00:00:00'),(188,19000,0,'Trà Dâu truyền thống (Lớn)',96,'1:L','0000-00-00 00:00:00'),(189,18000,0,'Trà chanh Sả gừng Mật Ong (Vừa)',97,'1:M','0000-00-00 00:00:00'),(190,22000,0,'Trà chanh Sả gừng Mật Ong (Lớn)',97,'1:L','0000-00-00 00:00:00'),(191,18000,0,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa (Vừa)',98,'1:M','0000-00-00 00:00:00'),(192,22000,0,'Trà chanh Hoa Hồng/ Chanh sả Hồng Hoa (Lớn)',98,'1:L','0000-00-00 00:00:00'),(193,18000,0,'Trà Hoa 7 vị (Vừa)',99,'1:M','0000-00-00 00:00:00'),(194,22000,0,'Trà Hoa 7 vị (Lớn)',99,'1:L','0000-00-00 00:00:00'),(195,18000,0,'Trà Lipton Thảo Mộc 9 vị (Vừa)',100,'1:M','0000-00-00 00:00:00'),(196,22000,0,'Trà Lipton Thảo Mộc 9 vị (Lớn)',100,'1:L','0000-00-00 00:00:00'),(197,8000,0,'Nước Ép Cam (Vừa)',101,'1:M','0000-00-00 00:00:00'),(198,12000,0,'Nước Ép Cam (Lớn)',101,'1:L','0000-00-00 00:00:00'),(199,15000,0,'Chanh Dây Mix Cam (Vừa)',102,'1:M','0000-00-00 00:00:00'),(200,19000,0,'Chanh Dây Mix Cam (Lớn)',102,'1:L','0000-00-00 00:00:00'),(201,15000,0,'Chanh Dây Mix Tắc (Vừa)',103,'1:M','0000-00-00 00:00:00'),(202,19000,0,'Chanh Dây Mix Tắc (Lớn)',103,'1:L','0000-00-00 00:00:00'),(203,15000,0,'Nước Ép Ổi (Vừa)',104,'1:M','0000-00-00 00:00:00'),(204,19000,0,'Nước Ép Ổi (Lớn)',104,'1:L','0000-00-00 00:00:00'),(205,15000,0,'Nước Ép Thơm (Vừa)',105,'1:M','0000-00-00 00:00:00'),(206,19000,0,'Nước Ép Thơm (Lớn)',105,'1:L','0000-00-00 00:00:00'),(207,15000,0,'Nước Ép Dưa Hấu (Vừa)',106,'1:M','0000-00-00 00:00:00'),(208,19000,0,'Nước Ép Dưa Hấu (Lớn)',106,'1:L','0000-00-00 00:00:00'),(209,15000,0,'Nước Ép Táo (Vừa)',107,'1:M','0000-00-00 00:00:00'),(210,19000,0,'Nước Ép Táo (Lớn)',107,'1:L','0000-00-00 00:00:00'),(211,15000,0,'Nước Ép Cà Rốt (Vừa)',108,'1:M','0000-00-00 00:00:00'),(212,19000,0,'Nước Ép Cà Rốt (Lớn)',108,'1:L','0000-00-00 00:00:00'),(213,15000,0,'Sinh Tố Bơ (Vừa)',109,'1:M','0000-00-00 00:00:00'),(214,19000,0,'Sinh Tố Bơ (Lớn)',109,'1:L','0000-00-00 00:00:00'),(215,15000,0,'Sinh Tố Dâu (Vừa)',110,'1:M','0000-00-00 00:00:00'),(216,19000,0,'Sinh Tố Dâu (Lớn)',110,'1:L','0000-00-00 00:00:00'),(217,15000,0,'Sinh Tố Dừa (Vừa)',111,'1:M','0000-00-00 00:00:00'),(218,19000,0,'Sinh Tố Dừa (Lớn)',111,'1:L','0000-00-00 00:00:00'),(219,15000,0,'Sinh Tố Đu Đủ (Vừa)',112,'1:M','0000-00-00 00:00:00'),(220,19000,0,'Sinh Tố Đu Đủ (Lớn)',112,'1:L','0000-00-00 00:00:00'),(221,15000,0,'Sinh Tố Xoài (Vừa)',113,'1:M','0000-00-00 00:00:00'),(222,19000,0,'Sinh Tố Xoài (Lớn)',113,'1:L','0000-00-00 00:00:00'),(223,15000,0,'Sinh Tố Mãng Cầu (Vừa)',114,'1:M','0000-00-00 00:00:00'),(224,19000,0,'Sinh Tố Mãng Cầu (Lớn)',114,'1:L','0000-00-00 00:00:00'),(225,15000,0,'Sinh Tố Cà Chua (Vừa)',115,'1:M','0000-00-00 00:00:00'),(226,19000,0,'Sinh Tố Cà Chua (Lớn)',115,'1:L','0000-00-00 00:00:00'),(227,15000,0,'Sinh Tố Saboche (Vừa)',116,'1:M','0000-00-00 00:00:00'),(228,19000,0,'Sinh Tố Saboche (Lớn)',116,'1:L','0000-00-00 00:00:00'),(229,9000,0,'Cà Phê Đá (Vừa)',117,'1:M','0000-00-00 00:00:00'),(230,13000,0,'Cà Phê Đá (Lớn)',117,'1:L','0000-00-00 00:00:00'),(231,12000,0,'Cà Phê Sữa Đá (Vừa)',118,'1:M','0000-00-00 00:00:00'),(232,16000,0,'Cà Phê Sữa Đá (Lớn)',118,'1:L','0000-00-00 00:00:00'),(233,14000,0,'Cà phê Sương sáo (Vừa)',119,'1:M','0000-00-00 00:00:00'),(234,18000,0,'Cà phê Sương sáo (Lớn)',119,'1:L','0000-00-00 00:00:00'),(235,14000,0,'Cà phê Sữa Tươi (Vừa)',120,'1:M','0000-00-00 00:00:00'),(236,18000,0,'Cà phê Sữa Tươi (Lớn)',120,'1:L','0000-00-00 00:00:00'),(237,15000,0,'Trà Bí Đao Hạt Chia (Vừa)',121,'1:M','0000-00-00 00:00:00'),(238,19000,0,'Trà Bí Đao Hạt Chia (Lớn)',121,'1:L','0000-00-00 00:00:00'),(239,8000,0,'Nước Nha Đam Nhà Trồng (Vừa)',122,'1:M','0000-00-00 00:00:00'),(240,12000,0,'Nước Nha Đam Nhà Trồng (Lớn)',122,'1:L','0000-00-00 00:00:00'),(241,12000,0,'Nước ngọt (Coca, Pepsi, 7up, Sting) (Lớn)',123,'8:L','0000-00-00 00:00:00'),(242,5000,0,'Bánh Plan dành cho trà sữa (Lớn)',124,'4:L','0000-00-00 00:00:00'),(243,5000,0,'Pudding (Lớn)',125,'4:L','0000-00-00 00:00:00'),(244,5000,0,'Trân châu đen (Lớn)',126,'4:L','0000-00-00 00:00:00'),(245,5000,0,'Trân châu trắng (Lớn)',127,'4:L','0000-00-00 00:00:00'),(246,5000,0,'Trân châu phomai (Lớn)',128,'4:L','0000-00-00 00:00:00'),(247,5000,0,'Sương sáo (Lớn)',129,'4:L','0000-00-00 00:00:00'),(248,5000,0,'Kem (Lớn)',130,'4:L','0000-00-00 00:00:00'),(249,35000,0,'Mì Cay Kim Chi Thập Cẩm (Lớn)',131,'4:L','0000-00-00 00:00:00'),(250,30000,0,'Mì Cay Kim Chi Bò (Lớn)',132,'4:L','0000-00-00 00:00:00'),(251,25000,0,'Mì cay kim chi cá viên xúc xích (Lớn)',133,'4:L','0000-00-00 00:00:00'),(252,25000,0,'Mì Cay Kim Chi Cá viên (Lớn)',134,'4:L','0000-00-00 00:00:00'),(253,30000,0,'Mì Cay Kim Chi Đùi Gà (Lớn)',135,'4:L','0000-00-00 00:00:00'),(254,30000,0,'Mì Cay Kim Chi Hải Sản (Lớn)',136,'4:L','0000-00-00 00:00:00'),(255,20000,0,'Bánh Canh Hẹ Thố (Lớn)',137,'4:L','0000-00-00 00:00:00'),(256,25000,0,'Bò Kho Bánh Mì (Lớn)',138,'4:L','0000-00-00 00:00:00'),(257,25000,0,'Cơm Gà chiên Mắm Thố (Lớn)',139,'4:L','0000-00-00 00:00:00'),(258,25000,0,'Cơm Sườn Thố (Lớn)',140,'4:L','0000-00-00 00:00:00'),(259,15000,0,'Khoai tây lắc phô mai/ lắc xí muội (Lớn)',141,'4:L','0000-00-00 00:00:00'),(260,15000,0,'Khoai lang lắc phô mai/ lắc xí muội (Lớn)',142,'4:L','0000-00-00 00:00:00'),(261,20000,0,'Cá viên/ Tôm viên/Bò viên/Phô mai que/Thanh cua/ Dồi sụn (phần) (Lớn)',143,'4:L','0000-00-00 00:00:00'),(262,15000,0,'Hotdog/ 1 cây (Lớn)',144,'4:L','0000-00-00 00:00:00'),(263,25000,0,'Đậu hủ Basa chà bông (Lớn)',145,'4:L','0000-00-00 00:00:00'),(264,49000,0,'Thập cầm xiên que ( phần) (Lớn)',146,'4:L','0000-00-00 00:00:00'),(265,20000,0,'Chân Gà Xã Tắc (Lớn)',147,'4:L','0000-00-00 00:00:00'),(266,20000,0,'Đùi gà rán (1 đùi) (Lớn)',148,'4:L','0000-00-00 00:00:00'),(267,20000,0,'Cơm Cháy Chà Bông Mỡ Hành (phần) (Lớn)',149,'4:L','0000-00-00 00:00:00'),(268,20000,0,'Bánh Tokoyaki (Lớn)',150,'4:L','0000-00-00 00:00:00'),(269,29000,0,'Bò cuộn nấm kim châm (phần) (Lớn)',151,'4:L','0000-00-00 00:00:00'),(270,29000,0,'Ba chỉ nướng (phần) (Lớn)',152,'4:L','0000-00-00 00:00:00'),(271,10000,0,'Bánh plan (Lớn)',153,'4:L','0000-00-00 00:00:00'),(272,10000,0,'Rau câu (Lớn)',154,'4:L','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `food_size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotion` (
  `promotion_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `promotion_type` varchar(45) DEFAULT NULL,
  `promotion_code` varchar(45) DEFAULT NULL,
  `promotion_condition` varchar(45) DEFAULT NULL,
  `parameter` float DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `description` varchar(95) DEFAULT NULL,
  `calculate_by` varchar(45) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion`
--

LOCK TABLES `promotion` WRITE;
/*!40000 ALTER TABLE `promotion` DISABLE KEYS */;
INSERT INTO `promotion` VALUES (1,'DONGGIA','KHAITRUONG','0',10000,'2023-08-31 23:00:00','2023-09-10 15:00:00','Khai trương đồng giá món nước 10000','=',0,'2023-09-14 04:20:04'),(2,'GIAMGIA','DON_TU_40000','40000',20,'2023-09-10 23:00:00','2023-09-21 15:00:00','Giảm giá hóa đơn từ 40,000 đồng','%',0,'2023-09-14 04:20:04');
/*!40000 ALTER TABLE `promotion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `role_id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `size`
--

DROP TABLE IF EXISTS `size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `size` (
  `size` varchar(45) NOT NULL,
  `description` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`size`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `size`
--

LOCK TABLES `size` WRITE;
/*!40000 ALTER TABLE `size` DISABLE KEYS */;
INSERT INTO `size` VALUES ('L','Size Lớn'),('M','Size Vừa');
/*!40000 ALTER TABLE `size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `size_unit`
--

DROP TABLE IF EXISTS `size_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `size_unit` (
  `unit_id` int NOT NULL,
  `size` varchar(45) NOT NULL,
  `size_unit_code` varchar(5) NOT NULL,
  `description` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`size_unit_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `size_unit`
--

LOCK TABLES `size_unit` WRITE;
/*!40000 ALTER TABLE `size_unit` DISABLE KEYS */;
INSERT INTO `size_unit` VALUES (1,'L','1:L','Ly size L'),(1,'M','1:M','Ly size M'),(3,'L','3:L','Tô size L'),(3,'M','3:M','Tô size M'),(4,'L','4:L','Phần size L'),(4,'M','4:M','Phần size M'),(5,'L','5:L','Hộp size L'),(5,'M','5:M','Hộp size M'),(7,'L','7:L','Chai size L'),(7,'M','7:M','Chai size M'),(8,'L','8:L','Lon size L'),(8,'M','8:M','Lon size M');
/*!40000 ALTER TABLE `size_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_order`
--

DROP TABLE IF EXISTS `table_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_order` (
  `table_id` int unsigned NOT NULL AUTO_INCREMENT,
  `table_order_name` varchar(55) DEFAULT NULL,
  `area_id` int DEFAULT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_order`
--

LOCK TABLES `table_order` WRITE;
/*!40000 ALTER TABLE `table_order` DISABLE KEYS */;
INSERT INTO `table_order` VALUES (1,'Số 01',1),(2,'Số 02',1),(3,'Số 03',1),(4,'Số 04',1),(5,'Số 05',1),(6,'Số 06',1),(7,'Số 07',1),(8,'Số 08',1),(9,'Số 09',1),(10,'Số 10',1),(11,'Số 11',2),(12,'Số 12',2),(13,'Số 13',2),(14,'Số 14',2),(15,'Số 15',2),(16,'Số 16',2),(17,'Số 17',2),(18,'Số 18',2),(19,'Số 19',2),(20,'Số 20',2),(21,'Mang về',3);
/*!40000 ALTER TABLE `table_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans`
--

DROP TABLE IF EXISTS `trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans` (
  `trans_id` int unsigned NOT NULL AUTO_INCREMENT,
  `trans_type` varchar(55) DEFAULT NULL,
  `trans_name` varchar(55) DEFAULT NULL,
  `trans_form` varchar(85) DEFAULT NULL,
  `money` int DEFAULT NULL,
  `status` int DEFAULT '1',
  `description` varchar(155) DEFAULT NULL,
  `trans_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans`
--

LOCK TABLES `trans` WRITE;
/*!40000 ALTER TABLE `trans` DISABLE KEYS */;
INSERT INTO `trans` VALUES (1,'Thu','Cà phê bịch','1__Tiền mặt',200000,1,'','2023-10-17 02:22:09'),(2,'Chi','Tiền mua thịt','1__Tiền mặt',230000,1,'','2023-10-19 02:22:09'),(4,'Thu','Đồ ăn cơm, bánh canh','1__Tiền mặt',1700000,1,'','2023-10-19 04:39:50'),(5,'Thu','Bán cơm sườn','1__Tiền mặt',215000,1,'','2023-10-19 04:42:01'),(6,'Chi','Mua ly nhỏ','1__Tiền mặt',550000,1,'','2023-10-19 12:35:32');
/*!40000 ALTER TABLE `trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unit` (
  `unit_id` int unsigned NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(55) DEFAULT NULL,
  `description` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES (1,'Ly','Sản phẩm bán ly'),(3,'Tô','Sản phẩm bán tô'),(4,'Phần','Sản phẩm bán phần ăn'),(5,'Hộp','Sản phẩm bán hộp mang đi'),(7,'Chai','Sản phẩm bán chai'),(8,'Lon','Sản phẩm bán Lon');
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-30 20:17:24
