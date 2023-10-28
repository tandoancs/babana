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
INSERT INTO `bill` VALUES (21,'2023-10-19 04:33:13','2023-10-19 04:34:02',1,4,60000,'Done',100000,40000,1,0,'',2),(22,'2023-10-19 04:33:29','2023-10-19 04:35:31',2,3,45000,'Done',50000,5000,2,0,'',1),(23,'2023-10-19 04:33:44','2023-10-19 04:36:44',1,4,60000,'Done',70000,10000,3,0,'',1),(24,'2023-10-19 04:35:20','2023-10-19 04:38:40',2,3,45000,'Done',50000,5000,4,0,'',2),(25,'2023-10-19 04:38:07','2023-10-19 04:39:03',1,3,45000,'Done',50000,5000,7,0,'',2),(26,'2023-10-19 04:38:29','2023-10-19 12:47:18',1,2,30000,'Done',50000,20000,8,0,'',1),(27,'2023-10-19 04:47:19','2023-10-19 04:47:37',1,6,90000,'Done',100000,10000,21,0,'',1),(28,'2023-10-19 12:47:05','2023-10-19 12:47:32',1,20,300000,'Done',300000,0,1,0,'',1),(29,'2023-10-20 12:07:48','2023-10-20 13:12:59',3,5,75000,'Done',100000,25000,1,0,'',1),(30,'2023-10-20 13:17:00','2023-10-23 11:44:14',1,2,30000,'Done',30000,0,21,0,'',1),(31,'2023-10-20 13:19:02','2023-10-23 11:44:28',2,4,60000,'Done',60000,0,21,0,'',1),(32,'2023-10-23 01:47:27',NULL,1,2,30000,'In-progress',NULL,NULL,1,0,'',0);
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
  `catalog_name` varchar(55) DEFAULT NULL,
  `description` varchar(95) DEFAULT NULL,
  PRIMARY KEY (`catalog_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalog`
--

LOCK TABLES `catalog` WRITE;
/*!40000 ALTER TABLE `catalog` DISABLE KEYS */;
INSERT INTO `catalog` VALUES (1,'Thức uống','Tất cả các loại thức uống'),(2,'Món ăn','Tất cả các loại món ăn');
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
  `food_name` varchar(95) DEFAULT NULL,
  `description` varchar(95) DEFAULT NULL,
  `status` varchar(95) DEFAULT NULL,
  `catalog_id` int DEFAULT NULL,
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food`
--

LOCK TABLES `food` WRITE;
/*!40000 ALTER TABLE `food` DISABLE KEYS */;
INSERT INTO `food` VALUES (1,'Trà sữa truyền thống','Trà sữa truyền thống','1',1),(2,'Trà sữa trân châu đường đen','Trà sữa trân châu đường đen','1',1),(3,'Trà sữa kem','Trà sữa kem','1',1),(4,'Trà sữa Matcha','Trà sữa Matcha','1',1);
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
  `description` varchar(95) DEFAULT NULL,
  `food_id` int unsigned DEFAULT NULL,
  `size_unit_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`food_size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food_size`
--

LOCK TABLES `food_size` WRITE;
/*!40000 ALTER TABLE `food_size` DISABLE KEYS */;
INSERT INTO `food_size` VALUES (1,15000,NULL,'Trà sữa truyền thống (Vừa)',1,'1:M'),(2,15000,NULL,'Trà sữa trân châu đường đen (Vừa)',2,'1:M'),(3,15000,NULL,'Trà sữa kem (Vừa)',3,'1:M'),(4,15000,NULL,'Trà sữa Matcha (Vừa)',4,'1:M'),(5,19000,NULL,'Trà sữa truyền thống (Lớn)',1,'1:L');
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
INSERT INTO `size_unit` VALUES (1,'L','1:L','Ly size L'),(1,'M','1:M','Ly size M'),(3,'L','3:L','Tô size L'),(3,'M','3:M','Tô size M'),(4,'L','4:L','Phần size L'),(4,'M','4:M','Phần size M'),(5,'L','5:L','Hộp size L'),(5,'M','5:M','Hộp size M');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES (1,'Ly','Sản phẩm bán ly'),(3,'Tô','Sản phẩm bán tô'),(4,'Phần','Sản phẩm bán phần ăn'),(5,'Hộp','Sản phẩm bán hộp mang đi');
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

-- Dump completed on 2023-10-28 22:37:30
