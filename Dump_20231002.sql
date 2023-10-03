-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: babana
-- ------------------------------------------------------
-- Server version	8.0.33

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'Trên Gác',NULL),(2,'Phía Ngoài',NULL),(3,'Mang về',NULL);
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
  `date_check_in` varchar(55) DEFAULT NULL,
  `date_check_out` varchar(55) DEFAULT NULL,
  `count_orders` int DEFAULT NULL,
  `sum_orders` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `status` varchar(95) DEFAULT NULL,
  `table_id` int DEFAULT NULL,
  `promotion_id` int DEFAULT NULL,
  `note` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill`
--

LOCK TABLES `bill` WRITE;
/*!40000 ALTER TABLE `bill` DISABLE KEYS */;
INSERT INTO `bill` VALUES (1,'2023-08-30 12:10:00','2023-08-30 14:10:00',NULL,NULL,145000,'In-progress',1,NULL,'TS truyền thống: Ít đường;TS trân châu đường đen: Đường nhiều'),(2,'2023-09:01 07:14:00','2023-09:01 08:15:00',NULL,NULL,45000,'In-progress',2,NULL,'TS trân châu đường đen: Bình thường;TS truyền thống: Thêm đường;TS Matcha: Nhiều đá'),(6,'2023-10-02 11:52:23',NULL,2,5,76,'In-progress',3,0,''),(7,'2023-10-02 11:52:59',NULL,1,4,64,'In-progress',4,0,''),(8,'2023-10-02 11:55:10',NULL,1,4,76000,'In-progress',5,0,''),(9,'2023-10-02 14:01:52',NULL,1,1,19000,'In-progress',6,0,''),(10,'2023-10-02 14:32:16',NULL,1,1,19000,'In-progress',21,0,''),(11,'2023-10-02 14:32:43',NULL,1,1,15000,'In-progress',9,0,''),(12,'2023-10-02 14:33:58',NULL,1,1,15000,'In-progress',10,0,''),(13,'2023-10-02 14:34:25',NULL,1,1,15000,'In-progress',11,0,''),(14,'2023-10-02 14:34:46',NULL,1,1,15000,'In-progress',14,0,'');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_detail`
--

LOCK TABLES `bill_detail` WRITE;
/*!40000 ALTER TABLE `bill_detail` DISABLE KEYS */;
INSERT INTO `bill_detail` VALUES (1,2,15000,'1',NULL,'1:M',NULL,1,1,'Ít đường'),(2,1,15000,'1',NULL,'1:M',NULL,1,2,'Đường nhiều'),(4,1,15000,'1',NULL,'1:M',NULL,2,2,'Bình thường'),(5,1,15000,'1',NULL,'1:M',NULL,2,1,'Thêm đường'),(6,1,15000,'1',NULL,'1:M',NULL,2,4,'Nhiều đá'),(7,1,12000,'1',12000,'1:M','',6,1,NULL),(8,4,16000,'1',64000,'1:M','',6,2,NULL),(9,4,16000,'1',64000,'1:M','',7,2,NULL),(10,4,19000,'1',76000,'1:M','',8,4,NULL),(11,1,19000,'1',19000,'1:L','',9,1,NULL),(12,1,19000,'1',19000,'1:L','',10,1,NULL),(13,1,15000,'1',15000,'1:M','',11,1,NULL),(14,1,15000,'1',15000,'1:M','',12,3,NULL),(15,1,15000,'1',15000,'1:M','',13,4,NULL),(16,1,15000,'1',15000,'1:M','',14,2,NULL);
/*!40000 ALTER TABLE `bill_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogy`
--

DROP TABLE IF EXISTS `catalogy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalogy` (
  `catalogy_id` int unsigned NOT NULL AUTO_INCREMENT,
  `catalogy_name` varchar(55) DEFAULT NULL,
  `description` varchar(95) DEFAULT NULL,
  PRIMARY KEY (`catalogy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogy`
--

LOCK TABLES `catalogy` WRITE;
/*!40000 ALTER TABLE `catalogy` DISABLE KEYS */;
INSERT INTO `catalogy` VALUES (1,'Thức uống','Tất cả các loại thức uống'),(2,'Món ăn','Tất cả các loại món ăn');
/*!40000 ALTER TABLE `catalogy` ENABLE KEYS */;
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
  `catalogy_id` int DEFAULT NULL,
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
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
INSERT INTO `food_size` VALUES (1,15000,NULL,'Trà sữa truyền thống (M)',1,'1:M'),(2,15000,NULL,'Trà sữa trân châu đường đen (M)',2,'1:M'),(3,15000,NULL,'Trà sữa kem (M)',3,'1:M'),(4,15000,NULL,'Trà sữa Matcha (M)',4,'1:M'),(5,19000,NULL,'Trà sữa truyền thống (Vừa)',1,'1:L');
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
  `status` varchar(45) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion`
--

LOCK TABLES `promotion` WRITE;
/*!40000 ALTER TABLE `promotion` DISABLE KEYS */;
INSERT INTO `promotion` VALUES (1,'DONGGIA','KHAITRUONG','0',10000,'2023-08-31 23:00:00','2023-09-10 15:00:00','Khai trương đồng giá món nước 10000','=','none','2023-09-14 04:20:04'),(2,'GIAMGIA','MUA_TU_40000','40000',20,'2023-09-10 23:00:00','2023-09-21 15:00:00','Giảm giá hóa đơn từ 40,000 đồng','%','processing','2023-09-14 04:20:04');
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
  `size` varchar(45) NOT NULL,
  `unit_id` int NOT NULL,
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
INSERT INTO `size_unit` VALUES ('L',1,'1:L','Ly size L'),('M',1,'1:M','Ly size M'),('M',3,'3:M','Tô'),('M',4,'4:M','Phần'),('M',5,'5:M','Hộp');
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
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

-- Dump completed on 2023-10-02 16:02:42
