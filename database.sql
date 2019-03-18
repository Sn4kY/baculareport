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
INSERT INTO `Job` (`JobId`, `Job`, `Name`, `Type`, `Level`, `ClientId`, `JobStatus`, `SchedTime`, `StartTime`, `EndTime`, `RealEndTime`, `JobTDate`, `VolSessionId`, `VolSessionTime`, `JobFiles`, `JobBytes`, `ReadBytes`, `JobErrors`, `JobMissingFiles`, `PoolId`, `FileSetId`, `PriorJobId`, `PurgedFiles`, `HasBase`, `HasCache`, `Reviewed`, `Comment`) VALUES
(325528, 0x64656d6f736572766572312e323031382d31302d32375f30302e31312e32365f3334, 0x64656d6f73657276657231, 'B', 'F', 401, 'T', '2018-10-27 00:11:26', '2018-10-27 03:35:17', '2018-10-27 03:35:17', '2018-10-27 03:35:17', 1540604117, 5449, 1539332291, 0, 0, 0, 1, 0, 7, 429, 0, 0, 0, 0, 0, ''),
(325563, 0x64656d6f736572766572312e323031382d31302d32385f30302e31312e32365f3334, 0x64656d6f73657276657231, 'B', 'D', 401, 'T', '2018-10-27 00:11:32', '2018-10-27 04:12:39', '2018-10-27 04:12:39', '2018-10-27 04:12:39', 1540606359, 5521, 1539332291, 0, 0, 0, 0, 0, 7, 480, 0, 0, 0, 0, 0, ''),
(325867, 0x64656d6f736572766572312e323031382d31302d32395f30302e31312e32365f3334, 0x64656d6f73657276657231, 'B', 'D', 401, 'T', '2018-10-28 00:11:04', '2018-10-28 06:58:34', '2018-10-28 06:58:35', '2018-10-28 06:58:35', 1540706315, 5781, 1539332291, 0, 0, 0, 0, 0, 7, 387, 0, 0, 0, 0, 0, ''),
(325900, 0x64656d6f736572766572312e323031382d31302d33305f30302e31312e32365f3334, 0x64656d6f73657276657231, 'B', 'D', 401, 'T', '2018-10-28 00:11:06', '2018-10-28 07:54:32', '2018-10-28 07:54:33', '2018-10-28 07:54:33', 1540709673, 5815, 1539332291, 0, 0, 0, 0, 0, 7, 429, 0, 0, 0, 0, 0, ''),
(325937, 0x64656d6f736572766572312e323031382d31302d33315f30302e31312e32365f3334, 0x64656d6f73657276657231, 'B', 'D', 401, 'T', '2018-10-28 00:11:09', '2018-10-28 09:51:11', '2018-10-28 09:51:14', '2018-10-28 09:51:14', 1540716674, 5864, 1539332291, 0, 0, 0, 0, 0, 7, 480, 0, 0, 0, 0, 0, ''),
(326038, 0x64656d6f736572766572322e323031382d31302d32375f30302e31312e32365f3334, 0x64656d6f73657276657232, 'B', 'F', 402, 'T', '2018-10-29 00:11:00', '2018-10-29 03:00:43', '2018-10-29 03:00:44', '2018-10-29 03:00:44', 1540778444, 6049, 1539332291, 0, 0, 0, 0, 0, 7, 186, 0, 0, 0, 0, 0, ''),
(326104, 0x64656d6f736572766572322e323031382d31302d32385f30302e31312e32365f3334, 0x64656d6f73657276657232, 'B', 'D', 402, 'T', '2018-10-29 00:11:06', '2018-10-29 04:12:14', '2018-10-29 04:12:38', '2018-10-29 04:12:38', 1540782758, 6076, 1539332291, 0, 0, 0, 0, 0, 7, 213, 0, 0, 0, 0, 0, ''),
(326214, 0x64656d6f736572766572322e323031382d31302d32395f30302e31312e32365f3334, 0x64656d6f73657276657232, 'B', 'D', 402, 'T', '2018-10-29 00:11:18', '2018-10-29 04:59:35', '2018-10-29 05:00:24', '2018-10-29 05:00:24', 1540785624, 6113, 1539332291, 0, 0, 0, 0, 0, 7, 329, 0, 0, 0, 0, 0, ''),
(326215, 0x64656d6f736572766572322e323031382d31302d33305f30302e31312e32365f3334, 0x64656d6f73657276657232, 'B', 'D', 402, 'T', '2018-10-29 00:11:19', '2018-10-29 05:00:26', '2018-10-29 05:00:37', '2018-10-29 05:00:37', 1540785637, 6114, 1539332291, 0, 0, 0, 0, 0, 7, 332, 0, 0, 0, 0, 0, ''),
(326216, 0x64656d6f736572766572322e323031382d31302d33315f30302e31312e32365f3334, 0x64656d6f73657276657232, 'B', 'D', 402, 'T', '2018-10-29 00:11:19', '2018-10-29 05:00:39', '2018-10-29 05:00:50', '2018-10-29 05:00:50', 1540785650, 6115, 1539332291, 0, 0, 0, 0, 0, 7, 333, 0, 0, 0, 0, 0, '');
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
INSERT INTO `client_customer_assoc` (`id_client`, `customer_id`, `name`, `storage_id`, `day_full`) VALUES
(1, 1, 'demoserver1', 1, '7'),
(2, 2, 'demoserver2', 1, '5');
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

INSERT INTO `customer_billing` (`customer_id`, `customer_name`, `vol_factu`, `full_billing`) VALUES
(1, 'Customer 1', 53687091200, 'true'),
(2, 'Customer 2', 644245094400, 'true');
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
INSERT INTO `storage` (`storage_id`, `storage_name`, `enabled`) VALUES (1, 'Filer 1', 1);
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
