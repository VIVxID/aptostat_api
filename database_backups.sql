-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Aptostat
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `Flag`
--

LOCK TABLES `Flag` WRITE;
/*!40000 ALTER TABLE `Flag` DISABLE KEYS */;
INSERT INTO `Flag` VALUES (1,'Warning'),(2,'Critical'),(3,'Internal'),(4,'Ignored'),(5,'Responding'),(6,'Resolved');
/*!40000 ALTER TABLE `Flag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Incident`
--

LOCK TABLES `Incident` WRITE;
/*!40000 ALTER TABLE `Incident` DISABLE KEYS */;
/*!40000 ALTER TABLE `Incident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `IncidentReport`
--

LOCK TABLES `IncidentReport` WRITE;
/*!40000 ALTER TABLE `IncidentReport` DISABLE KEYS */;
/*!40000 ALTER TABLE `IncidentReport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Message`
--

LOCK TABLES `Message` WRITE;
/*!40000 ALTER TABLE `Message` DISABLE KEYS */;
/*!40000 ALTER TABLE `Message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Report`
--

LOCK TABLES `Report` WRITE;
/*!40000 ALTER TABLE `Report` DISABLE KEYS */;
INSERT INTO `Report` VALUES (41,'2013-02-04 22:30:12','unknown','ping',2,74),(42,'2012-08-26 12:10:27','unconfirmed_down','ping',2,77),(43,'2012-08-02 00:04:32','unconfirmed_down','http',2,73),(44,'2013-03-03 21:19:30','unconfirmed_down','ping',2,68),(45,'2012-10-29 01:34:23','paused','ping',2,67),(46,'2013-03-11 00:27:05','paused','ping',2,46),(47,'2013-03-11 00:26:45','paused','http',2,46),(48,'2013-03-11 00:26:34','paused','tcp',2,46),(49,'2013-01-06 14:24:05','unconfirmed_down','ping',2,37),(50,'2013-02-21 18:10:11','unconfirmed_down','ping',2,45),(51,'2013-03-11 00:27:27','unconfirmed_down','http',2,84),(52,'2013-02-03 21:40:51','unconfirmed_down','ping',2,65),(53,'2013-02-08 04:37:21','paused','ping',2,31),(54,'0000-00-00 00:00:00','paused','http',2,31),(55,'0000-00-00 00:00:00','unconfirmed_down','http',2,27),(56,'2013-03-11 00:22:03','unconfirmed_down','httpcustom',2,119),(57,'2013-03-15 19:40:57','unconfirmed_down','http',2,80),(58,'2013-03-06 23:38:58','unconfirmed_down','http',2,13),(59,'2013-03-06 23:43:58','unconfirmed_down','http',2,29),(60,'2013-03-19 06:50:30','down','http',2,3),(61,'2013-03-19 06:55:53','down','http',2,101),(62,'2013-03-19 06:56:06','down','http',2,97),(63,'2013-03-15 19:40:40','unconfirmed_down','httpcustom',2,118),(64,'2013-03-20 11:25:24','CHECK_NRPE: Socket timeout after 20 seconds.','Processes',1,45),(65,'2013-03-20 11:31:15','CHECK_NRPE: Socket timeout after 20 seconds.','Free Space All Disks',1,45),(66,'2013-03-20 11:25:18','PING CRITICAL - Packet loss = 100%','ping',1,45),(67,'2013-03-20 11:31:17','CHECK_NRPE: Socket timeout after 20 seconds.','Free Memory',1,45),(68,'2013-03-20 11:25:15','CRITICAL - Socket timeout after 10 seconds','SSH',1,45),(69,'2013-03-20 11:25:14','CHECK_NRPE: Socket timeout after 20 seconds.','Load Average',1,45),(70,'2012-08-26 11:48:17','unconfirmed_down','http',2,83),(71,'2012-11-13 13:58:09','unconfirmed_down','ping',2,6),(72,'2013-03-06 23:39:30','unconfirmed_down','ping',2,55),(73,'2013-03-06 23:37:36','unconfirmed_down','ping',2,23),(74,'2013-03-11 00:27:27','unconfirmed_down','http',2,69),(75,'2013-03-23 22:46:17','PING WARNING - Packet loss = 50%, RTA = 42.40 ms','ping',1,33),(76,'2013-03-23 22:46:29','CHECK_NRPE: Socket timeout after 20 seconds.','Free Space All Disks',1,33),(77,'2013-02-20 06:10:27','unconfirmed_down','ping',2,50),(78,'2013-03-06 23:42:04','unconfirmed_down','ping',2,3),(79,'2012-10-25 08:35:28','unconfirmed_down','ping',2,48),(80,'2013-03-25 13:06:22','down','http',2,125),(81,'2012-11-29 01:36:07','paused','http',2,64),(82,'2012-12-05 14:12:58','unconfirmed_down','http',2,85),(83,'2013-01-06 14:25:01','unconfirmed_down','ping',2,42),(84,'2012-09-06 00:43:23','unconfirmed_down','ping',2,21),(85,'2013-02-06 10:02:39','unconfirmed_down','ping',2,76),(86,'2013-03-28 07:03:35','PING WARNING - Packet loss = 0%, RTA = 264.82 ms','ping',1,23),(87,'2013-02-16 16:22:58','unconfirmed_down','http',2,61),(88,'2013-03-28 22:03:33','down','http',2,72),(89,'2012-12-11 13:00:35','unconfirmed_down','ping',2,10),(90,'2013-03-29 10:31:37','CRITICAL - Socket timeout after 10 seconds','SSH',1,10),(91,'2013-03-19 23:34:59','unconfirmed_down','http',2,87),(92,'2013-03-29 20:14:29','PING WARNING - Packet loss = 0%, RTA = 226.93 ms','ping',1,43),(93,'2012-09-24 18:50:11','unconfirmed_down','ping',2,27);
/*!40000 ALTER TABLE `Report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ReportStatus`
--

LOCK TABLES `ReportStatus` WRITE;
/*!40000 ALTER TABLE `ReportStatus` DISABLE KEYS */;
INSERT INTO `ReportStatus` VALUES (64,'2013-03-25 17:12:02',1),(66,'2013-03-25 17:12:02',1),(68,'2013-03-25 17:12:02',1),(69,'2013-03-25 17:12:02',1),(75,'2013-03-23 22:48:03',1),(86,'2013-03-28 07:05:03',1),(92,'2013-03-29 20:18:03',1),(41,'2013-03-16 19:35:34',2),(41,'2013-03-18 10:14:03',2),(41,'2013-03-24 21:05:28',2),(41,'2013-03-24 21:06:02',2),(41,'2013-03-29 15:42:08',2),(41,'2013-03-31 21:06:03',2),(42,'2013-03-17 04:01:02',2),(43,'2013-03-17 13:04:33',2),(43,'2013-03-20 23:33:02',2),(43,'2013-03-22 07:33:02',2),(43,'2013-03-22 11:03:02',2),(43,'2013-03-23 03:03:03',2),(43,'2013-03-23 13:33:03',2),(43,'2013-03-23 21:03:02',2),(44,'2013-03-17 20:33:02',2),(44,'2013-03-21 17:46:02',2),(44,'2013-03-23 23:28:02',2),(44,'2013-03-27 14:04:03',2),(44,'2013-03-30 20:32:03',2),(45,'2013-03-17 23:10:03',2),(46,'2013-03-17 23:10:03',2),(47,'2013-03-17 23:10:03',2),(48,'2013-03-17 23:10:03',2),(49,'2013-03-18 00:32:02',2),(49,'2013-03-24 12:22:02',2),(50,'2013-03-18 04:11:02',2),(50,'2013-03-20 11:33:13',2),(50,'2013-03-25 17:11:03',2),(51,'2013-03-18 08:03:02',2),(51,'2013-03-31 15:35:02',2),(52,'2013-03-18 18:08:03',2),(53,'2013-03-18 20:54:02',2),(54,'2013-03-18 20:54:02',2),(55,'2013-03-18 21:10:02',2),(56,'2013-03-19 01:17:02',2),(56,'2013-03-22 00:06:03',2),(56,'2013-03-23 23:30:02',2),(56,'2013-03-23 23:39:03',2),(57,'2013-03-19 06:32:02',2),(57,'2013-03-22 12:36:02',2),(57,'2013-03-25 13:08:02',2),(57,'2013-03-26 20:13:03',2),(57,'2013-03-26 20:35:02',2),(58,'2013-03-19 06:39:02',2),(59,'2013-03-19 06:40:03',2),(60,'2013-03-19 06:52:02',2),(61,'2013-03-19 06:57:03',2),(61,'2013-03-25 13:08:02',2),(62,'2013-03-19 06:58:02',2),(62,'2013-03-25 13:08:02',2),(63,'2013-03-19 10:47:02',2),(64,'2013-03-20 11:33:13',2),(65,'2013-03-20 11:33:13',2),(65,'2013-03-25 17:11:03',2),(66,'2013-03-20 11:33:13',2),(66,'2013-03-25 17:11:03',2),(67,'2013-03-20 11:33:13',2),(67,'2013-03-25 17:11:03',2),(68,'2013-03-20 11:33:13',2),(68,'2013-03-25 17:11:03',2),(69,'2013-03-20 11:33:13',2),(70,'2013-03-20 14:34:02',2),(70,'2013-03-29 11:34:03',2),(71,'2013-03-21 08:57:03',2),(72,'2013-03-22 04:47:03',2),(73,'2013-03-22 04:47:03',2),(74,'2013-03-23 04:34:03',2),(76,'2013-03-23 22:48:03',2),(77,'2013-03-23 23:28:02',2),(77,'2013-03-28 14:05:10',2),(78,'2013-03-24 10:35:03',2),(78,'2013-03-31 15:34:03',2),(79,'2013-03-24 15:10:03',2),(79,'2013-03-27 10:13:02',2),(79,'2013-03-30 04:48:02',2),(80,'2013-03-25 13:08:02',2),(81,'2013-03-26 10:49:02',2),(81,'2013-03-29 15:42:08',2),(81,'2013-03-31 21:06:03',2),(82,'2013-03-26 16:06:02',2),(82,'2013-03-31 04:52:02',2),(83,'2013-03-27 10:13:02',2),(84,'2013-03-27 10:13:02',2),(85,'2013-03-27 14:36:02',2),(85,'2013-03-27 14:52:03',2),(85,'2013-03-27 15:16:03',2),(85,'2013-03-27 15:32:03',2),(85,'2013-03-27 15:48:03',2),(85,'2013-03-27 15:56:03',2),(85,'2013-03-27 16:12:02',2),(87,'2013-03-28 14:05:10',2),(88,'2013-03-28 22:05:02',2),(89,'2013-03-29 04:10:02',2),(90,'2013-03-29 10:33:03',2),(91,'2013-03-29 15:43:03',2),(93,'2013-03-31 03:56:03',2),(41,'2013-03-17 21:03:01',5),(41,'2013-03-24 21:04:01',5),(41,'2013-03-24 21:05:32',5),(41,'2013-03-29 15:35:03',5),(41,'2013-03-31 21:04:01',5),(42,'2013-03-17 04:02:03',5),(43,'2013-03-17 13:05:03',5),(43,'2013-03-20 23:34:03',5),(43,'2013-03-22 07:34:03',5),(43,'2013-03-22 11:04:03',5),(43,'2013-03-23 03:04:02',5),(43,'2013-03-23 13:34:02',5),(43,'2013-03-23 21:04:03',5),(44,'2013-03-17 20:34:03',5),(44,'2013-03-21 17:47:03',5),(44,'2013-03-23 23:29:03',5),(44,'2013-03-27 14:05:02',5),(44,'2013-03-30 20:33:02',5),(45,'2013-03-18 09:20:03',5),(46,'2013-03-18 09:20:03',5),(47,'2013-03-18 09:20:03',5),(48,'2013-03-18 09:20:03',5),(49,'2013-03-18 00:33:03',5),(49,'2013-03-24 12:23:02',5),(50,'2013-03-18 04:13:02',5),(50,'2013-03-22 18:48:03',5),(50,'2013-03-25 17:13:03',5),(51,'2013-03-18 08:08:02',5),(51,'2013-03-31 15:36:03',5),(52,'2013-03-18 18:09:02',5),(53,'2013-03-18 21:23:02',5),(54,'2013-03-18 21:24:03',5),(55,'2013-03-18 21:11:03',5),(56,'2013-03-19 01:18:03',5),(56,'2013-03-22 00:07:04',5),(56,'2013-03-23 23:31:03',5),(56,'2013-03-23 23:40:02',5),(57,'2013-03-19 06:42:03',5),(57,'2013-03-22 12:40:03',5),(57,'2013-03-25 13:10:02',5),(57,'2013-03-26 20:15:03',5),(57,'2013-03-26 20:37:02',5),(58,'2013-03-19 06:41:02',5),(59,'2013-03-19 06:42:03',5),(60,'2013-03-19 06:53:03',5),(61,'2013-03-19 06:58:02',5),(61,'2013-03-25 13:09:03',5),(62,'2013-03-19 06:59:03',5),(62,'2013-03-25 13:10:02',5),(63,'2013-03-19 10:48:04',5),(64,'2013-03-22 18:48:03',5),(64,'2013-03-25 17:13:03',5),(65,'2013-03-22 18:48:03',5),(65,'2013-03-25 17:12:02',5),(66,'2013-03-22 18:48:03',5),(66,'2013-03-25 17:13:03',5),(67,'2013-03-22 18:48:03',5),(67,'2013-03-25 17:12:02',5),(68,'2013-03-22 18:48:03',5),(68,'2013-03-25 17:13:03',5),(69,'2013-03-22 18:48:03',5),(69,'2013-03-25 17:13:03',5),(70,'2013-03-20 22:32:20',5),(70,'2013-03-29 11:35:02',5),(71,'2013-03-21 08:58:02',5),(72,'2013-03-22 04:48:02',5),(73,'2013-03-22 04:48:02',5),(74,'2013-03-23 04:35:02',5),(75,'2013-03-23 22:50:02',5),(76,'2013-03-23 22:50:02',5),(77,'2013-03-23 23:29:03',5),(77,'2013-03-28 14:06:05',5),(78,'2013-03-24 10:36:02',5),(78,'2013-03-31 15:35:02',5),(79,'2013-03-24 15:11:02',5),(79,'2013-03-27 10:14:03',5),(79,'2013-03-30 04:49:03',5),(80,'2013-03-25 13:09:03',5),(81,'2013-03-29 15:35:03',5),(81,'2013-03-31 21:04:01',5),(82,'2013-03-26 16:07:03',5),(82,'2013-03-31 04:53:03',5),(83,'2013-03-27 10:14:03',5),(84,'2013-03-27 10:14:03',5),(85,'2013-03-27 14:37:02',5),(85,'2013-03-27 14:53:02',5),(85,'2013-03-27 15:17:02',5),(85,'2013-03-27 15:33:02',5),(85,'2013-03-27 15:49:03',5),(85,'2013-03-27 15:57:02',5),(85,'2013-03-27 16:13:03',5),(86,'2013-03-28 07:06:02',5),(87,'2013-03-28 14:06:05',5),(88,'2013-03-28 22:15:03',5),(89,'2013-03-29 04:11:03',5),(90,'2013-03-29 10:34:17',5),(91,'2013-03-29 15:49:03',5),(92,'2013-03-29 20:19:02',5),(93,'2013-03-31 03:57:03',5),(42,'2013-04-02 10:11:11',6),(43,'2013-04-02 10:11:11',6),(44,'2013-04-02 10:11:11',6),(45,'2013-04-02 10:11:11',6),(46,'2013-04-02 10:11:11',6),(47,'2013-04-02 10:11:11',6),(48,'2013-04-02 10:11:11',6),(49,'2013-04-02 10:11:11',6),(50,'2013-04-02 10:11:11',6),(51,'2013-04-02 10:11:11',6),(52,'2013-04-02 10:11:11',6),(53,'2013-04-02 10:11:11',6),(54,'2013-04-02 10:11:11',6),(55,'2013-04-02 10:11:11',6),(56,'2013-04-02 10:11:11',6),(57,'2013-04-02 10:11:11',6),(58,'2013-04-02 10:11:11',6),(59,'2013-04-02 10:11:11',6),(60,'2013-04-02 10:11:11',6),(61,'2013-04-02 10:11:11',6),(62,'2013-04-02 10:11:11',6),(63,'2013-04-02 10:11:11',6),(70,'2013-04-02 10:11:11',6),(71,'2013-04-02 10:11:11',6),(72,'2013-04-02 10:11:11',6),(73,'2013-04-02 10:11:11',6),(74,'2013-04-02 10:11:11',6),(77,'2013-04-02 10:11:11',6),(78,'2013-04-02 10:11:11',6),(79,'2013-04-02 10:11:11',6),(80,'2013-04-02 10:11:11',6),(82,'2013-04-02 10:11:11',6),(83,'2013-04-02 10:11:11',6),(84,'2013-04-02 10:11:11',6),(85,'2013-04-02 10:11:11',6),(87,'2013-04-02 10:11:11',6),(88,'2013-04-02 10:11:11',6),(89,'2013-04-02 10:11:11',6),(91,'2013-04-02 10:11:11',6),(93,'2013-04-02 10:11:11',6);
/*!40000 ALTER TABLE `ReportStatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Service`
--

LOCK TABLES `Service` WRITE;
/*!40000 ALTER TABLE `Service` DISABLE KEYS */;
INSERT INTO `Service` VALUES (68,'88.87.38.193'),(66,'88.87.38.194'),(7,'access.ams.aptoma.no'),(10,'access.lon.aptoma.no'),(80,'aftenposten.advertisers.drpublish.aptoma.no'),(112,'aftonbladet-play.drlib.aptoma.no'),(118,'aftonbladet-play.meta-admin.drvideo.aptoma.no'),(125,'aftonbladet-play.videodata.drvideo.aptoma.no'),(71,'api.opscode.com'),(29,'atika.lon.aptoma.no'),(13,'blog01.lon.aptoma.no'),(85,'cdn.drvideo.aptoma.no'),(27,'custom-apps-01.ams.aptoma.no'),(83,'default.drfront.aptoma.no'),(19,'drlib-rai-prod-01.ams.aptoma.no'),(57,'drlib-rai-prod-01.lon.aptoma.no'),(4,'drlib-rai-prod-02.ams.aptoma.no'),(32,'drlib-rai-prod-02.lon.aptoma.no'),(14,'drlib-rai-staging-01.ams.aptoma.no'),(33,'drlib-rai-staging-01.lon.aptoma.no'),(34,'drlib-solr-prod-01.ams.aptoma.no'),(16,'drlib-solr-prod-01.lon.aptoma.no'),(24,'drlib-solr-staging-01.ams.aptoma.no'),(53,'drlib-solr-staging-01.lon.aptoma.no'),(3,'drm-prod-01.lon.aptoma.no'),(1,'drp-backoffice-01.ams.aptoma.no'),(35,'drp-mysql-01.ams.aptoma.no'),(9,'drp-mysql-02.ams.aptoma.no'),(8,'drp-rai-01.ams.aptoma.no'),(6,'drp-solr-01.ams.aptoma.no'),(15,'drv-admin-prod-01.ams.aptoma.no'),(58,'drv-admin-staging-01.ams.aptoma.no'),(11,'drv-meta-admin-prod-01.ams.aptoma.no'),(54,'drv-meta-staging-01.ams.aptoma.no'),(60,'drv-mongo-staging-01.ams.aptoma.no'),(39,'drv-mongodb-prod-01.ams.aptoma.no'),(22,'drv-upload-01.ams.aptoma.no'),(31,'drv-videodata-prod-01.ams.aptoma.no'),(26,'drv-videodata-prod-01.lon.aptoma.no'),(41,'drv-vtc-slave-01.a55.aptoma.no'),(18,'drv-vtc-slave-02.a55.aptoma.no'),(38,'drv-vtc-slave-05.a55.aptoma.no'),(40,'drv-vtc-slave-06.a55.aptoma.no'),(2,'drv-vtc-slave-07.a55.aptoma.no'),(51,'drv-vtc-slave-08.a55.aptoma.no'),(44,'drv-vtc-slave-09.a55.aptoma.no'),(43,'drv-vtc-slave-10.a55.aptoma.no'),(12,'drv-vtc-slave-11.a55.aptoma.no'),(50,'drv-vtc-slave-12.a55.aptoma.no'),(20,'drv-vtc-slave-13.a55.aptoma.no'),(17,'drv-vtc-slave-14.a55.aptoma.no'),(84,'drvideo.aptoma.no'),(61,'hageslange.aptoma.no'),(99,'hivolda.api.drpublish.aptoma.no'),(47,'hoff.lon.aptoma.no'),(64,'http01.aptoma.no'),(42,'irc.ams.aptoma.no'),(46,'kvm01.m323.aptoma.no'),(97,'lb-http-01.ams.aptoma.no'),(67,'lb.m323.aptoma.no'),(72,'manage.opscode.com'),(101,'monitoring.api.drpublish.aptoma.no'),(100,'monitoring.drpublish.aptoma.no'),(21,'munin.ams.aptoma.no'),(36,'munin.lon.aptoma.no'),(56,'mysqldrfront01.lon.aptoma.no'),(52,'mysqldrfront02.lon.aptoma.no'),(48,'nagios.ams.aptoma.no'),(77,'nagios.aptoma.com'),(5,'nagios.lon.aptoma.no'),(45,'nagios.sth-p.aptoma.no'),(106,'rikstoto.drvideo.aptoma.no'),(69,'sebyen.drvideo.aptoma.no'),(87,'stats.pingdom.com'),(65,'storage.drvideo.aptoma.no'),(30,'teppeslange.lon.aptoma.no'),(98,'uin.api.drpublish.aptoma.no'),(37,'varnish-01.ams.aptoma.no'),(55,'varnish-01.lon.aptoma.no'),(28,'varnish-02.ams.aptoma.no'),(23,'varnish-02.lon.aptoma.no'),(59,'voivoi.lon.aptoma.no'),(119,'vtc.drvideo.aptoma.no'),(76,'vtcs06.drvideo.aptoma.no'),(75,'vtcs07.drvideo.aptoma.no'),(74,'vtcs08.drvideo.aptoma.no'),(25,'webappdrfront01'),(73,'webappdrfront01.aptoma.com'),(49,'webappdrfront02.lon.aptoma.no');
/*!40000 ALTER TABLE `Service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Source`
--

LOCK TABLES `Source` WRITE;
/*!40000 ALTER TABLE `Source` DISABLE KEYS */;
INSERT INTO `Source` VALUES (1,'Nagios'),(2,'Pingdom');
/*!40000 ALTER TABLE `Source` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-04-02 18:19:31
