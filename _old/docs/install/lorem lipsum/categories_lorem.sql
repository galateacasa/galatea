# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.29)
# Database: newgalateacasa
# Generation Time: 2013-04-01 18:44:48 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table categories
# ------------------------------------------------------------

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `parent_id`, `name`, `image`, `description`, `create_date`, `update_date`, `delete_date`)
VALUES
  (1,0,'arcu. Aliquam ultrices iaculis',NULL,'et libero.','2013-06-25 12:19:52',NULL,NULL),
  (2,0,'nulla at sem',NULL,'Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque','2014-03-29 16:33:07',NULL,NULL),
  (3,0,'Donec porttitor tellus',NULL,'orci lacus vestibulum lorem, sit amet ultricies sem magna','2012-04-29 08:37:58',NULL,NULL),
  (4,0,'ut, nulla. Cras',NULL,'Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean','2012-09-30 07:20:14',NULL,NULL),
  (5,0,'Donec at arcu.',NULL,'varius. Nam porttitor scelerisque','2013-12-05 20:20:07',NULL,NULL);

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
