# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.29)
# Database: newgalateacasa
# Generation Time: 2013-04-01 18:45:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table expertises
# ------------------------------------------------------------

LOCK TABLES `expertises` WRITE;
/*!40000 ALTER TABLE `expertises` DISABLE KEYS */;

INSERT INTO `expertises` (`id`, `name`, `description`, `create_date`, `update_date`)
VALUES
  (1,'non, lacinia at, iaculis','dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada','2013-10-13 19:59:05','0000-00-00 00:00:00'),
  (2,'Quisque porttitor eros nec','ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula.','2012-12-16 06:37:29','0000-00-00 00:00:00'),
  (3,'placerat eget, venenatis','mauris,','2013-01-10 00:06:25','0000-00-00 00:00:00'),
  (4,'tellus. Phasellus','diam.','2012-10-07 05:00:27','0000-00-00 00:00:00'),
  (5,'vel turpis. Aliquam adipiscing','luctus ut, pellentesque','2013-07-05 21:40:25','0000-00-00 00:00:00'),
  (6,'non, lacinia at, iaculis','dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada','2013-10-13 19:59:05','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `expertises` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
