-- MySQL dump 10.13  Distrib 5.5.58, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bacula_report
-- ------------------------------------------------------
-- Server version	5.5.58-0+deb7u1-log

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
-- Table structure for table `Job`
--

DROP TABLE IF EXISTS `Job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Job` (
  `JobId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Job` tinyblob NOT NULL,
  `Name` tinyblob NOT NULL,
  `Type` binary(1) NOT NULL,
  `Level` binary(1) NOT NULL,
  `ClientId` int(11) DEFAULT '0',
  `JobStatus` binary(1) NOT NULL,
  `SchedTime` datetime DEFAULT '0000-00-00 00:00:00',
  `StartTime` datetime DEFAULT '0000-00-00 00:00:00',
  `EndTime` datetime DEFAULT '0000-00-00 00:00:00',
  `RealEndTime` datetime DEFAULT '0000-00-00 00:00:00',
  `JobTDate` bigint(20) unsigned DEFAULT '0',
  `VolSessionId` int(10) unsigned DEFAULT '0',
  `VolSessionTime` int(10) unsigned DEFAULT '0',
  `JobFiles` int(10) unsigned DEFAULT '0',
  `JobBytes` bigint(20) unsigned DEFAULT '0',
  `ReadBytes` bigint(20) unsigned DEFAULT '0',
  `JobErrors` int(10) unsigned DEFAULT '0',
  `JobMissingFiles` int(10) unsigned DEFAULT '0',
  `PoolId` int(10) unsigned DEFAULT '0',
  `FileSetId` int(10) unsigned DEFAULT '0',
  `PriorJobId` int(10) unsigned DEFAULT '0',
  `PurgedFiles` tinyint(4) DEFAULT '0',
  `HasBase` tinyint(4) DEFAULT '0',
  `HasCache` tinyint(4) DEFAULT '0',
  `Reviewed` tinyint(4) DEFAULT '0',
  `Comment` blob,
  PRIMARY KEY (`JobId`),
  KEY `Name` (`Name`(128))
) ENGINE=InnoDB AUTO_INCREMENT=243015 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `client_customer_assoc`
--

DROP TABLE IF EXISTS `client_customer_assoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_customer_assoc` (
  `id_client` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `storage_id` int(11) NOT NULL DEFAULT '1',
  `day_full` enum('1','2','3','4','5','6','7') NOT NULL,
  UNIQUE KEY `id_client` (`id_client`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Association table for customer/billing group';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customer_billing`
--

DROP TABLE IF EXISTS `customer_billing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_billing` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `vol_factu` bigint(20) DEFAULT '53687091200',
  `full_billing` enum('false','true') CHARACTER SET latin1 NOT NULL DEFAULT 'false' COMMENT 'only max FULL JobBytes is aim to be billed',
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `id_grp` (`customer_id`),
  UNIQUE KEY `name` (`customer_name`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `storage`
--

DROP TABLE IF EXISTS `storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storage` (
  `storage_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `storage_name` varchar(100) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`storage_id`),
  UNIQUE KEY `storage_id` (`storage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-28 12:18:18
