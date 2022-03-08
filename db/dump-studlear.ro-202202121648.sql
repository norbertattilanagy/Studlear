-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: studlear.ro
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.22-MariaDB

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
-- Table structure for table `answer_homework`
--

DROP TABLE IF EXISTS `answer_homework`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer_homework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(250) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `homework_id` int(11) NOT NULL,
  `point` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answer_homework_FK` (`homework_id`),
  KEY `answer_homework_FK_1` (`user_id`),
  CONSTRAINT `answer_homework_FK` FOREIGN KEY (`homework_id`) REFERENCES `homework` (`id`),
  CONSTRAINT `answer_homework_FK_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer_homework`
--

LOCK TABLES `answer_homework` WRITE;
/*!40000 ALTER TABLE `answer_homework` DISABLE KEYS */;
INSERT INTO `answer_homework` VALUES (1,'Cours_items/Homework/Student/202202101349162/',2,6,9),(2,'Cours_items/Homework/Student/202202101450084/',4,6,NULL);
/*!40000 ALTER TABLE `answer_homework` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `start_event` datetime DEFAULT NULL,
  `end_event` datetime DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calendar_FK` (`user_id`),
  CONSTRAINT `calendar_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkbox`
--

DROP TABLE IF EXISTS `checkbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `single_player_quiz` tinyint(1) DEFAULT NULL,
  `classic` tinyint(1) DEFAULT NULL,
  `quiz_id` int(11) NOT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checkbox_FK_1` (`quiz_id`),
  CONSTRAINT `checkbox_FK` FOREIGN KEY (`quiz_id`) REFERENCES `single_player_quiz` (`id`),
  CONSTRAINT `checkbox_FK_1` FOREIGN KEY (`quiz_id`) REFERENCES `multiplayer_quiz` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkbox`
--

LOCK TABLES `checkbox` WRITE;
/*!40000 ALTER TABLE `checkbox` DISABLE KEYS */;
/*!40000 ALTER TABLE `checkbox` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'Matematica','1234'),(2,'Mate','1234'),(3,'Algebra','1234'),(4,'Analiza','1234'),(5,'Geometrie','1234'),(6,'Informatica','1234');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_file`
--

DROP TABLE IF EXISTS `course_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `file_name` varchar(250) NOT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_file_FK` (`lesson_group_id`),
  CONSTRAINT `course_file_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_file`
--

LOCK TABLES `course_file` WRITE;
/*!40000 ALTER TABLE `course_file` DISABLE KEYS */;
INSERT INTO `course_file` VALUES (10,'Fisier1','Cours_items/Cours_file/202202091925381/',1,1),(12,'Fisier2','Cours_items/Cours_file/202202091932221/',2,1);
/*!40000 ALTER TABLE `course_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_group`
--

DROP TABLE IF EXISTS `course_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(250) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_group_FK` (`user_id`),
  KEY `course_group_FK_1` (`course_id`),
  CONSTRAINT `course_group_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `course_group_FK_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_group`
--

LOCK TABLES `course_group` WRITE;
/*!40000 ALTER TABLE `course_group` DISABLE KEYS */;
INSERT INTO `course_group` VALUES (1,'Mate',1,1),(2,'Mate',2,1),(3,'Matematica',3,1),(4,'Matematica',4,1),(5,'Matematica',5,1),(7,'Info',6,1);
/*!40000 ALTER TABLE `course_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_user`
--

DROP TABLE IF EXISTS `course_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_user_FK` (`user_id`),
  KEY `course_user_FK_1` (`course_id`),
  CONSTRAINT `course_user_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `course_user_FK_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_user`
--

LOCK TABLES `course_user` WRITE;
/*!40000 ALTER TABLE `course_user` DISABLE KEYS */;
INSERT INTO `course_user` VALUES (1,1,1,1),(2,2,1,1),(3,3,1,1),(4,4,1,1),(5,5,1,1),(6,6,1,1),(7,1,2,0),(8,1,4,0);
/*!40000 ALTER TABLE `course_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folder`
--

DROP TABLE IF EXISTS `folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `folder_name` varchar(250) NOT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `folder_FK` (`lesson_group_id`),
  CONSTRAINT `folder_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folder`
--

LOCK TABLES `folder` WRITE;
/*!40000 ALTER TABLE `folder` DISABLE KEYS */;
INSERT INTO `folder` VALUES (3,'Folder2','Cours_items/Folder/202202091601511/',2,0),(4,'Folder','Cours_items/Folder/202202091634051/',1,1);
/*!40000 ALTER TABLE `folder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homework`
--

DROP TABLE IF EXISTS `homework`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `homework` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `requirement` varchar(250) NOT NULL,
  `folder_name` varchar(250) DEFAULT NULL,
  `end_event` datetime DEFAULT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `homework_FK` (`lesson_group_id`),
  CONSTRAINT `homework_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homework`
--

LOCK TABLES `homework` WRITE;
/*!40000 ALTER TABLE `homework` DISABLE KEYS */;
INSERT INTO `homework` VALUES (3,'Tema2','Cours_items/Homework/Requirement/202202101124061.txt','Cours_items/Homework/Teacher/202202101124061/','2022-02-28 12:00:00',2,1),(6,'Tema1','Cours_items/Homework/Requirement/202202101144441.txt','Cours_items/Homework/Teacher/202202101144441/','2022-02-21 12:00:00',1,1);
/*!40000 ALTER TABLE `homework` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lesson_group`
--

DROP TABLE IF EXISTS `lesson_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lesson_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_title` varchar(250) NOT NULL,
  `course_id` int(11) NOT NULL,
  `order_number` int(11) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lesson_group_FK` (`course_id`),
  CONSTRAINT `lesson_group_FK` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson_group`
--

LOCK TABLES `lesson_group` WRITE;
/*!40000 ALTER TABLE `lesson_group` DISABLE KEYS */;
INSERT INTO `lesson_group` VALUES (1,'Curs1',1,1,1),(2,'Curs2',1,2,1),(3,'Curs3',1,3,0),(4,'Curs4',1,4,1);
/*!40000 ALTER TABLE `lesson_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `link_FK` (`lesson_group_id`),
  CONSTRAINT `link_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` VALUES (1,'Link2','https://getbootstrap.com','Cours_items/Link/202202091234321.txt',2,1);
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multiplayer_quiz`
--

DROP TABLE IF EXISTS `multiplayer_quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multiplayer_quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `start_event` datetime DEFAULT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `multiplayer_quiz_FK` (`lesson_group_id`),
  CONSTRAINT `multiplayer_quiz_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiplayer_quiz`
--

LOCK TABLES `multiplayer_quiz` WRITE;
/*!40000 ALTER TABLE `multiplayer_quiz` DISABLE KEYS */;
/*!40000 ALTER TABLE `multiplayer_quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_FK` (`lesson_group_id`),
  CONSTRAINT `notification_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (2,'Anunt1','Cours_items/Notification/202202041321581.txt',1,1),(4,'Anunt 2','Cours_items/Notification/202202041330021.txt',1,0),(8,'Anunt','Cours_items/Notification/202202071405371.txt',2,1);
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poll`
--

DROP TABLE IF EXISTS `poll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(250) DEFAULT NULL,
  `radio_button` tinyint(1) DEFAULT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `poll_FK` (`lesson_group_id`),
  CONSTRAINT `poll_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poll`
--

LOCK TABLES `poll` WRITE;
/*!40000 ALTER TABLE `poll` DISABLE KEYS */;
/*!40000 ALTER TABLE `poll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_option`
--

DROP TABLE IF EXISTS `quiz_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(250) DEFAULT NULL,
  `element` varchar(100) DEFAULT NULL,
  `correct` tinyint(1) DEFAULT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_option_FK_2` (`question_id`),
  CONSTRAINT `quiz_option_FK` FOREIGN KEY (`question_id`) REFERENCES `poll` (`id`),
  CONSTRAINT `quiz_option_FK_1` FOREIGN KEY (`question_id`) REFERENCES `radio_button` (`id`),
  CONSTRAINT `quiz_option_FK_2` FOREIGN KEY (`question_id`) REFERENCES `checkbox` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_option`
--

LOCK TABLES `quiz_option` WRITE;
/*!40000 ALTER TABLE `quiz_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radio_button`
--

DROP TABLE IF EXISTS `radio_button`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radio_button` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `single_player_quiz` tinyint(1) DEFAULT NULL,
  `classic` tinyint(1) DEFAULT NULL,
  `quiz_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `radio_button_FK_1` (`quiz_id`),
  CONSTRAINT `radio_button_FK` FOREIGN KEY (`quiz_id`) REFERENCES `single_player_quiz` (`id`),
  CONSTRAINT `radio_button_FK_1` FOREIGN KEY (`quiz_id`) REFERENCES `multiplayer_quiz` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radio_button`
--

LOCK TABLES `radio_button` WRITE;
/*!40000 ALTER TABLE `radio_button` DISABLE KEYS */;
/*!40000 ALTER TABLE `radio_button` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `select`
--

DROP TABLE IF EXISTS `select`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `select_question_id` int(11) NOT NULL,
  `point` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `select_FK` (`select_question_id`),
  CONSTRAINT `select_FK` FOREIGN KEY (`select_question_id`) REFERENCES `select_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `select`
--

LOCK TABLES `select` WRITE;
/*!40000 ALTER TABLE `select` DISABLE KEYS */;
/*!40000 ALTER TABLE `select` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `select_question`
--

DROP TABLE IF EXISTS `select_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `select_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) DEFAULT NULL,
  `single_player_quiz` int(11) NOT NULL,
  `point` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `select_question_FK` (`single_player_quiz`),
  CONSTRAINT `select_question_FK` FOREIGN KEY (`single_player_quiz`) REFERENCES `single_player_quiz` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `select_question`
--

LOCK TABLES `select_question` WRITE;
/*!40000 ALTER TABLE `select_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `select_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `single_player_quiz`
--

DROP TABLE IF EXISTS `single_player_quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `single_player_quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `solving_time` time DEFAULT NULL,
  `start_event` datetime DEFAULT NULL,
  `end_event` datetime DEFAULT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `single_player_quiz_FK` (`lesson_group_id`),
  CONSTRAINT `single_player_quiz_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `single_player_quiz`
--

LOCK TABLES `single_player_quiz` WRITE;
/*!40000 ALTER TABLE `single_player_quiz` DISABLE KEYS */;
/*!40000 ALTER TABLE `single_player_quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `text_question`
--

DROP TABLE IF EXISTS `text_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `text_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `short` tinyint(1) DEFAULT NULL,
  `quiz_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `text_question_FK` (`quiz_id`),
  CONSTRAINT `text_question_FK` FOREIGN KEY (`quiz_id`) REFERENCES `single_player_quiz` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `text_question`
--

LOCK TABLES `text_question` WRITE;
/*!40000 ALTER TABLE `text_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `text_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `true_false`
--

DROP TABLE IF EXISTS `true_false`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `true_false` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `corect` tinyint(1) DEFAULT NULL,
  `quiz_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `true_false_FK` (`quiz_id`),
  CONSTRAINT `true_false_FK` FOREIGN KEY (`quiz_id`) REFERENCES `single_player_quiz` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `true_false`
--

LOCK TABLES `true_false` WRITE;
/*!40000 ALTER TABLE `true_false` DISABLE KEYS */;
/*!40000 ALTER TABLE `true_false` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `profile_image` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Nagy Norbert','norbertattilanagy@gmail.com','1234','teacher',''),(2,'Kis George','kis.george@gmail.com','1234','student',NULL),(3,'George George','george.george@gmail.com','1234','student',NULL),(4,'Nagy','nagy@gmail.com','1234','student',NULL),(5,'Big George','Big.George@gmail.com','1234','student',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_conference`
--

DROP TABLE IF EXISTS `video_conference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_conference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `password` varchar(250) DEFAULT NULL,
  `start_event` datetime DEFAULT NULL,
  `end_event` datetime DEFAULT NULL,
  `lesson_group_id` int(11) NOT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_conference_FK` (`lesson_group_id`),
  CONSTRAINT `video_conference_FK` FOREIGN KEY (`lesson_group_id`) REFERENCES `lesson_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_conference`
--

LOCK TABLES `video_conference` WRITE;
/*!40000 ALTER TABLE `video_conference` DISABLE KEYS */;
INSERT INTO `video_conference` VALUES (1,'Videoconferinta1','https://us04web.zoom.us/j/7264994585?pwd=bmJDUVR4ZENjMExFS2Z0cGRVWlVtUT09','640649','2022-02-08 08:00:00','2022-02-08 10:00:00',1,1),(3,'Videoconferinta2','https://us04web.zoom.us/j/7264994585?pwd=bmJDUVR4ZENjMExFS2Z0cGRVWlVtUT09','640649','2022-02-10 11:00:00','2022-02-10 12:00:00',2,1);
/*!40000 ALTER TABLE `video_conference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'studlear.ro'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-12 16:48:12
