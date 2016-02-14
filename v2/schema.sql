-- MySQL dump 10.13  Distrib 5.5.40, for Linux (x86_64)
--
-- Host: localhost    Database: zordv2
-- ------------------------------------------------------
-- Server version	5.5.40-log

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
-- Table structure for table `zrd_al`
--

DROP TABLE IF EXISTS `zrd_al`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_al` (
  `al_aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `al_name` varchar(150) NOT NULL DEFAULT '',
  `al_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `al_points` int(10) unsigned NOT NULL DEFAULT '0',
  `al_open` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `al_nb_mbr` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `al_descr` text NOT NULL,
  `al_rules` text NOT NULL,
  `al_diplo` text NOT NULL,
  PRIMARY KEY (`al_aid`),
  KEY `al_points` (`al_points`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_al`
--

LOCK TABLES `zrd_al` WRITE;
/*!40000 ALTER TABLE `zrd_al` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_al` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_al_mbr`
--

DROP TABLE IF EXISTS `zrd_al_mbr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_al_mbr` (
  `ambr_mid` int(10) unsigned NOT NULL,
  `ambr_aid` int(10) unsigned NOT NULL,
  `ambr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ambr_etat` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`ambr_mid`),
  KEY `ambr_aid` (`ambr_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_al_mbr`
--

LOCK TABLES `zrd_al_mbr` WRITE;
/*!40000 ALTER TABLE `zrd_al_mbr` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_al_mbr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_al_res`
--

DROP TABLE IF EXISTS `zrd_al_res`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_al_res` (
  `ares_aid` int(10) unsigned NOT NULL DEFAULT '0',
  `ares_type` smallint(3) unsigned NOT NULL DEFAULT '0',
  `ares_nb` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ares_aid`,`ares_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_al_res`
--

LOCK TABLES `zrd_al_res` WRITE;
/*!40000 ALTER TABLE `zrd_al_res` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_al_res` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_al_res_log`
--

DROP TABLE IF EXISTS `zrd_al_res_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_al_res_log` (
  `arlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `arlog_aid` int(10) unsigned NOT NULL DEFAULT '0',
  `arlog_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `arlog_type` smallint(3) unsigned NOT NULL DEFAULT '0',
  `arlog_nb` int(10) NOT NULL DEFAULT '0',
  `arlog_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `arlog_ip` varchar(50) NOT NULL,
  PRIMARY KEY (`arlog_id`),
  KEY `al_res_log_aid` (`arlog_aid`),
  KEY `al_res_log_date` (`arlog_date`)
) ENGINE=MyISAM AUTO_INCREMENT=24003 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_al_res_log`
--

LOCK TABLES `zrd_al_res_log` WRITE;
/*!40000 ALTER TABLE `zrd_al_res_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_al_res_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_al_shoot`
--

DROP TABLE IF EXISTS `zrd_al_shoot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_al_shoot` (
  `shoot_msgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shoot_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `shoot_aid` int(10) unsigned NOT NULL DEFAULT '0',
  `shoot_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shoot_texte` text NOT NULL,
  PRIMARY KEY (`shoot_msgid`),
  KEY `shoot_aid` (`shoot_aid`)
) ENGINE=MyISAM AUTO_INCREMENT=10688 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_al_shoot`
--

LOCK TABLES `zrd_al_shoot` WRITE;
/*!40000 ALTER TABLE `zrd_al_shoot` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_al_shoot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_atq`
--

DROP TABLE IF EXISTS `zrd_atq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_atq` (
  `atq_aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `atq_mid1` int(10) unsigned NOT NULL DEFAULT '0',
  `atq_mid2` int(10) unsigned NOT NULL DEFAULT '0',
  `atq_lid1` int(10) unsigned NOT NULL,
  `atq_lid2` int(10) unsigned NOT NULL,
  `atq_type` tinyint(1) unsigned NOT NULL,
  `atq_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atq_cid` int(10) unsigned NOT NULL,
  `atq_bilan` text NOT NULL,
  PRIMARY KEY (`atq_aid`),
  KEY `atq_mid` (`atq_mid1`)
) ENGINE=MyISAM AUTO_INCREMENT=1532 DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_atq`
--

LOCK TABLES `zrd_atq` WRITE;
/*!40000 ALTER TABLE `zrd_atq` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_atq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_atq_mbr`
--

DROP TABLE IF EXISTS `zrd_atq_mbr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_atq_mbr` (
  `atq_aid` int(11) NOT NULL,
  `atq_mid` int(11) NOT NULL,
  PRIMARY KEY (`atq_aid`,`atq_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lien membres / attaque';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_atq_mbr`
--

LOCK TABLES `zrd_atq_mbr` WRITE;
/*!40000 ALTER TABLE `zrd_atq_mbr` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_atq_mbr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_bon`
--

DROP TABLE IF EXISTS `zrd_bon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_bon` (
  `bon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bon_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `bon_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bon_code` varchar(20) NOT NULL DEFAULT '',
  `bon_ok` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bon_res_type` smallint(3) unsigned NOT NULL DEFAULT '0',
  `bon_res_nb` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12478 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_bon`
--

LOCK TABLES `zrd_bon` WRITE;
/*!40000 ALTER TABLE `zrd_bon` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_bon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_btc`
--

DROP TABLE IF EXISTS `zrd_btc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_btc` (
  `btc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `btc_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `btc_type` smallint(3) unsigned NOT NULL DEFAULT '0',
  `btc_vie` smallint(6) unsigned NOT NULL DEFAULT '0',
  `btc_etat` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`btc_id`),
  KEY `btc_mid_type` (`btc_mid`,`btc_type`)
) ENGINE=MyISAM AUTO_INCREMENT=16588 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_btc`
--

LOCK TABLES `zrd_btc` WRITE;
/*!40000 ALTER TABLE `zrd_btc` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_btc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_cmt`
--

DROP TABLE IF EXISTS `zrd_cmt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_cmt` (
  `cmt_cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cmt_nid` int(10) unsigned NOT NULL DEFAULT '0',
  `cmt_mid` int(11) unsigned NOT NULL DEFAULT '0',
  `cmt_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cmt_texte` text NOT NULL,
  `cmt_ip` varchar(50) NOT NULL,
  PRIMARY KEY (`cmt_cid`),
  KEY `cmd_nid` (`cmt_nid`),
  KEY `cmt_mid` (`cmt_mid`)
) ENGINE=MyISAM AUTO_INCREMENT=6907 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_cmt`
--

LOCK TABLES `zrd_cmt` WRITE;
/*!40000 ALTER TABLE `zrd_cmt` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_cmt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_con`
--

DROP TABLE IF EXISTS `zrd_con`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_con` (
  `con_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `con_nb` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`con_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_con`
--

LOCK TABLES `zrd_con` WRITE;
/*!40000 ALTER TABLE `zrd_con` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_con` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_diplo`
--

DROP TABLE IF EXISTS `zrd_diplo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_diplo` (
  `dpl_did` int(11) NOT NULL AUTO_INCREMENT,
  `dpl_etat` tinyint(4) NOT NULL DEFAULT '0',
  `dpl_type` tinyint(4) NOT NULL DEFAULT '0',
  `dpl_al1` int(11) NOT NULL,
  `dpl_al2` int(11) NOT NULL,
  `dpl_debut` date NOT NULL,
  `dpl_fin` date DEFAULT NULL,
  PRIMARY KEY (`dpl_did`),
  KEY `dpl_al2` (`dpl_al2`),
  KEY `dpl_al1` (`dpl_al1`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='diplomatie';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_diplo`
--

LOCK TABLES `zrd_diplo` WRITE;
/*!40000 ALTER TABLE `zrd_diplo` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_diplo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_diplo_shoot`
--

DROP TABLE IF EXISTS `zrd_diplo_shoot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_diplo_shoot` (
  `dpl_shoot_msgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dpl_shoot_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `dpl_shoot_did` int(10) unsigned NOT NULL DEFAULT '0',
  `dpl_shoot_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dpl_shoot_texte` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`dpl_shoot_msgid`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_diplo_shoot`
--

LOCK TABLES `zrd_diplo_shoot` WRITE;
/*!40000 ALTER TABLE `zrd_diplo_shoot` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_diplo_shoot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_bans`
--

DROP TABLE IF EXISTS `zrd_frm_bans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_bans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `expire` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_bans`
--

LOCK TABLES `zrd_frm_bans` WRITE;
/*!40000 ALTER TABLE `zrd_frm_bans` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_bans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_categories`
--

DROP TABLE IF EXISTS `zrd_frm_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(80) NOT NULL DEFAULT 'New Category',
  `disp_position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_categories`
--

LOCK TABLES `zrd_frm_categories` WRITE;
/*!40000 ALTER TABLE `zrd_frm_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_censoring`
--

DROP TABLE IF EXISTS `zrd_frm_censoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_censoring` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search_for` varchar(60) NOT NULL DEFAULT '',
  `replace_with` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_censoring`
--

LOCK TABLES `zrd_frm_censoring` WRITE;
/*!40000 ALTER TABLE `zrd_frm_censoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_censoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_config`
--

DROP TABLE IF EXISTS `zrd_frm_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_config` (
  `conf_name` varchar(255) NOT NULL DEFAULT '',
  `conf_value` text,
  PRIMARY KEY (`conf_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_config`
--

LOCK TABLES `zrd_frm_config` WRITE;
/*!40000 ALTER TABLE `zrd_frm_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_forum_perms`
--

DROP TABLE IF EXISTS `zrd_frm_forum_perms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_forum_perms` (
  `group_id` int(10) NOT NULL DEFAULT '0',
  `forum_id` int(10) NOT NULL DEFAULT '0',
  `read_forum` tinyint(1) NOT NULL DEFAULT '1',
  `post_replies` tinyint(1) NOT NULL DEFAULT '1',
  `post_topics` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`group_id`,`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_forum_perms`
--

LOCK TABLES `zrd_frm_forum_perms` WRITE;
/*!40000 ALTER TABLE `zrd_frm_forum_perms` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_forum_perms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_forums`
--

DROP TABLE IF EXISTS `zrd_frm_forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_forums` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(80) NOT NULL DEFAULT 'New forum',
  `forum_desc` text,
  `redirect_url` varchar(100) DEFAULT NULL,
  `moderators` text,
  `num_topics` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `last_post` int(10) unsigned DEFAULT NULL,
  `last_post_id` int(10) unsigned DEFAULT NULL,
  `last_poster` varchar(200) DEFAULT NULL,
  `last_subject` varchar(255) DEFAULT NULL,
  `sort_by` tinyint(1) NOT NULL DEFAULT '0',
  `disp_position` int(10) NOT NULL DEFAULT '0',
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_forums`
--

LOCK TABLES `zrd_frm_forums` WRITE;
/*!40000 ALTER TABLE `zrd_frm_forums` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_forums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_groups`
--

DROP TABLE IF EXISTS `zrd_frm_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_groups` (
  `g_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `g_title` varchar(50) NOT NULL DEFAULT '',
  `g_user_title` varchar(50) DEFAULT NULL,
  `g_read_board` tinyint(1) NOT NULL DEFAULT '1',
  `g_post_replies` tinyint(1) NOT NULL DEFAULT '1',
  `g_post_topics` tinyint(1) NOT NULL DEFAULT '1',
  `g_post_polls` tinyint(1) NOT NULL DEFAULT '1',
  `g_edit_posts` tinyint(1) NOT NULL DEFAULT '1',
  `g_delete_posts` tinyint(1) NOT NULL DEFAULT '1',
  `g_delete_topics` tinyint(1) NOT NULL DEFAULT '1',
  `g_set_title` tinyint(1) NOT NULL DEFAULT '1',
  `g_search` tinyint(1) NOT NULL DEFAULT '1',
  `g_search_users` tinyint(1) NOT NULL DEFAULT '1',
  `g_edit_subjects_interval` smallint(6) NOT NULL DEFAULT '300',
  `g_post_flood` smallint(6) NOT NULL DEFAULT '30',
  `g_search_flood` smallint(6) NOT NULL DEFAULT '30',
  PRIMARY KEY (`g_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_groups`
--

LOCK TABLES `zrd_frm_groups` WRITE;
/*!40000 ALTER TABLE `zrd_frm_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_online`
--

DROP TABLE IF EXISTS `zrd_frm_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_online` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `ident` varchar(200) NOT NULL DEFAULT '',
  `logged` int(10) unsigned NOT NULL DEFAULT '0',
  `idle` tinyint(1) NOT NULL DEFAULT '0',
  KEY `frm_online_user_id_idx` (`user_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_online`
--

LOCK TABLES `zrd_frm_online` WRITE;
/*!40000 ALTER TABLE `zrd_frm_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_posts`
--

DROP TABLE IF EXISTS `zrd_frm_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poster` varchar(200) NOT NULL DEFAULT '',
  `poster_id` int(10) unsigned NOT NULL DEFAULT '1',
  `poster_ip` varchar(15) DEFAULT NULL,
  `poster_email` varchar(50) DEFAULT NULL,
  `message` text,
  `hide_smilies` tinyint(1) NOT NULL DEFAULT '0',
  `posted` int(10) unsigned NOT NULL DEFAULT '0',
  `edited` int(10) unsigned DEFAULT NULL,
  `edited_by` varchar(200) DEFAULT NULL,
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `frm_posts_topic_id_idx` (`topic_id`),
  KEY `frm_posts_multi_idx` (`poster_id`,`topic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=98723 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_posts`
--

LOCK TABLES `zrd_frm_posts` WRITE;
/*!40000 ALTER TABLE `zrd_frm_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_ranks`
--

DROP TABLE IF EXISTS `zrd_frm_ranks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_ranks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rank` varchar(50) NOT NULL DEFAULT '',
  `min_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_ranks`
--

LOCK TABLES `zrd_frm_ranks` WRITE;
/*!40000 ALTER TABLE `zrd_frm_ranks` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_ranks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_reports`
--

DROP TABLE IF EXISTS `zrd_frm_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `reported_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text,
  `zapped` int(10) unsigned DEFAULT NULL,
  `zapped_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `frm_reports_zapped_idx` (`zapped`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_reports`
--

LOCK TABLES `zrd_frm_reports` WRITE;
/*!40000 ALTER TABLE `zrd_frm_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_search_cache`
--

DROP TABLE IF EXISTS `zrd_frm_search_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_search_cache` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `ident` varchar(200) NOT NULL DEFAULT '',
  `search_data` text,
  PRIMARY KEY (`id`),
  KEY `frm_search_cache_ident_idx` (`ident`(8))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_search_cache`
--

LOCK TABLES `zrd_frm_search_cache` WRITE;
/*!40000 ALTER TABLE `zrd_frm_search_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_search_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_search_matches`
--

DROP TABLE IF EXISTS `zrd_frm_search_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_search_matches` (
  `post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `word_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject_match` tinyint(1) NOT NULL DEFAULT '0',
  KEY `frm_search_matches_word_id_idx` (`word_id`),
  KEY `frm_search_matches_post_id_idx` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_search_matches`
--

LOCK TABLES `zrd_frm_search_matches` WRITE;
/*!40000 ALTER TABLE `zrd_frm_search_matches` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_search_matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_search_words`
--

DROP TABLE IF EXISTS `zrd_frm_search_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_search_words` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`word`),
  KEY `frm_search_words_id_idx` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99629 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_search_words`
--

LOCK TABLES `zrd_frm_search_words` WRITE;
/*!40000 ALTER TABLE `zrd_frm_search_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_search_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_topics`
--

DROP TABLE IF EXISTS `zrd_frm_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poster` varchar(200) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `posted` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_poster` varchar(200) DEFAULT NULL,
  `num_views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num_replies` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `sticky` tinyint(1) NOT NULL DEFAULT '0',
  `moved_to` int(10) unsigned DEFAULT NULL,
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `frm_topics_forum_id_idx` (`forum_id`),
  KEY `frm_topics_moved_to_idx` (`moved_to`)
) ENGINE=MyISAM AUTO_INCREMENT=4168 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_topics`
--

LOCK TABLES `zrd_frm_topics` WRITE;
/*!40000 ALTER TABLE `zrd_frm_topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_frm_users`
--

DROP TABLE IF EXISTS `zrd_frm_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_frm_users` (
  `id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL DEFAULT '4',
  `login` varchar(200) NOT NULL,
  `password` varchar(40) NOT NULL DEFAULT '',
  `username` varchar(40) DEFAULT NULL,
  `signature` text,
  `disp_topics` tinyint(3) unsigned DEFAULT NULL,
  `disp_posts` tinyint(3) unsigned DEFAULT NULL,
  `show_smilies` tinyint(1) NOT NULL DEFAULT '1',
  `show_img` tinyint(1) NOT NULL DEFAULT '1',
  `show_img_sig` tinyint(1) NOT NULL DEFAULT '1',
  `show_avatars` tinyint(1) NOT NULL DEFAULT '1',
  `show_sig` tinyint(1) NOT NULL DEFAULT '1',
  `timezone` time NOT NULL DEFAULT '00:00:00',
  `language` varchar(25) NOT NULL DEFAULT 'fr_FR',
  `style` varchar(25) NOT NULL DEFAULT 'Classik',
  `num_posts` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post` int(10) unsigned DEFAULT NULL,
  `registration_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `last_visit` int(10) unsigned NOT NULL DEFAULT '0',
  `alliance` varchar(30) NOT NULL,
  `alliance_id` int(10) unsigned NOT NULL,
  `race` tinyint(1) unsigned NOT NULL,
  `points` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `frm_users_username_idx` (`login`(8))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_frm_users`
--

LOCK TABLES `zrd_frm_users` WRITE;
/*!40000 ALTER TABLE `zrd_frm_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_frm_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_hero`
--

DROP TABLE IF EXISTS `zrd_hero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_hero` (
  `hro_id` int(11) NOT NULL AUTO_INCREMENT,
  `hro_mid` int(11) NOT NULL,
  `hro_nom` varchar(50) NOT NULL,
  `hro_type` tinyint(4) NOT NULL,
  `hro_lid` int(11) NOT NULL,
  `hro_xp` int(11) NOT NULL,
  `hro_vie` int(11) NOT NULL,
  `hro_bonus` tinyint(4) DEFAULT '0',
  `hro_bonus_from` timestamp NULL DEFAULT NULL,
  `hro_bonus_to` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_hero`
--

LOCK TABLES `zrd_hero` WRITE;
/*!40000 ALTER TABLE `zrd_hero` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_hero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_histo`
--

DROP TABLE IF EXISTS `zrd_histo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_histo` (
  `histo_hid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `histo_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `histo_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `histo_mid2` int(10) unsigned NOT NULL DEFAULT '0',
  `histo_type` smallint(2) unsigned NOT NULL DEFAULT '0',
  `histo_vars` text NOT NULL,
  PRIMARY KEY (`histo_hid`),
  KEY `histo_mid` (`histo_mid`)
) ENGINE=MyISAM AUTO_INCREMENT=31892 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_histo`
--

LOCK TABLES `zrd_histo` WRITE;
/*!40000 ALTER TABLE `zrd_histo` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_histo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_leg`
--

DROP TABLE IF EXISTS `zrd_leg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_leg` (
  `leg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `leg_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `leg_cid` int(10) unsigned NOT NULL DEFAULT '0',
  `leg_etat` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `leg_name` varchar(40) NOT NULL,
  `leg_xp` int(10) unsigned NOT NULL DEFAULT '0',
  `leg_vit` smallint(3) unsigned NOT NULL,
  `leg_dest` int(10) unsigned NOT NULL,
  `leg_tours` smallint(4) unsigned NOT NULL,
  `leg_fat` smallint(3) unsigned NOT NULL,
  `leg_stop` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`leg_id`),
  KEY `leg_cid` (`leg_cid`),
  KEY `leg_mid_etat` (`leg_mid`,`leg_etat`)
) ENGINE=MyISAM AUTO_INCREMENT=1336 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_leg`
--

LOCK TABLES `zrd_leg` WRITE;
/*!40000 ALTER TABLE `zrd_leg` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_leg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_leg_res`
--

DROP TABLE IF EXISTS `zrd_leg_res`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_leg_res` (
  `lres_lid` int(10) unsigned NOT NULL,
  `lres_type` smallint(3) unsigned NOT NULL,
  `lres_nb` int(10) NOT NULL,
  PRIMARY KEY (`lres_lid`,`lres_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_leg_res`
--

LOCK TABLES `zrd_leg_res` WRITE;
/*!40000 ALTER TABLE `zrd_leg_res` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_leg_res` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_map`
--

DROP TABLE IF EXISTS `zrd_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_map` (
  `map_cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `map_x` smallint(5) NOT NULL DEFAULT '0',
  `map_y` smallint(5) NOT NULL DEFAULT '0',
  `map_climat` tinyint(1) unsigned NOT NULL,
  `map_type` smallint(1) unsigned NOT NULL DEFAULT '0',
  `map_rand` smallint(1) unsigned NOT NULL DEFAULT '1',
  `map_region` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`map_cid`),
  KEY `map_x_y` (`map_x`,`map_y`),
  KEY `map_region` (`map_region`)
) ENGINE=MyISAM AUTO_INCREMENT=250001 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_map`
--

LOCK TABLES `zrd_map` WRITE;
/*!40000 ALTER TABLE `zrd_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_mbr`
--

DROP TABLE IF EXISTS `zrd_mbr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_mbr` (
  `mbr_mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mbr_login` varchar(50) NOT NULL,
  `mbr_pseudo` varchar(50) NOT NULL,
  `mbr_pass` varchar(40) NOT NULL DEFAULT '',
  `mbr_mail` varchar(50) NOT NULL DEFAULT '',
  `mbr_lang` char(5) NOT NULL,
  `mbr_etat` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mbr_gid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `mbr_decal` time NOT NULL DEFAULT '00:00:00',
  `mbr_race` int(1) unsigned NOT NULL DEFAULT '0',
  `mbr_mapcid` int(10) unsigned NOT NULL DEFAULT '0',
  `mbr_place` smallint(4) unsigned NOT NULL,
  `mbr_population` smallint(4) unsigned NOT NULL DEFAULT '0',
  `mbr_points` int(10) unsigned NOT NULL DEFAULT '0',
  `mbr_pts_armee` int(10) unsigned NOT NULL DEFAULT '0',
  `mbr_atq_nb` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `mbr_ldate` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `mbr_lmodif_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mbr_inscr_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mbr_lip` varchar(50) NOT NULL,
  `mbr_sign` text NOT NULL,
  `mbr_descr` text NOT NULL,
  `mbr_design` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `mbr_vlg` varchar(50) NOT NULL,
  `mbr_parrain` int(10) unsigned NOT NULL,
  `mbr_numposts` int(11) NOT NULL DEFAULT '0',
  `mbr_sexe` smallint(6) NOT NULL DEFAULT '1' COMMENT '1 ou 2',
  `mbr_votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mbr_mid`),
  UNIQUE KEY `mbr_mail` (`mbr_mail`),
  UNIQUE KEY `mbr_pseudo` (`mbr_pseudo`),
  UNIQUE KEY `mbr_login` (`mbr_login`),
  KEY `mbr_lmodif_date` (`mbr_lmodif_date`),
  KEY `mbr_etat` (`mbr_etat`),
  KEY `mbr_race` (`mbr_race`),
  KEY `mbr_parrain` (`mbr_parrain`)
) ENGINE=MyISAM AUTO_INCREMENT=8151 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_mbr`
--

LOCK TABLES `zrd_mbr` WRITE;
/*!40000 ALTER TABLE `zrd_mbr` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_mbr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_mbr_log`
--

DROP TABLE IF EXISTS `zrd_mbr_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_mbr_log` (
  `mlog_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mlog_mid` int(10) unsigned NOT NULL,
  `mlog_ip` varchar(15) NOT NULL,
  `mlog_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`mlog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=244273 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_mbr_log`
--

LOCK TABLES `zrd_mbr_log` WRITE;
/*!40000 ALTER TABLE `zrd_mbr_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_mbr_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_mbr_old`
--

DROP TABLE IF EXISTS `zrd_mbr_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_mbr_old` (
  `mold_mid` int(10) unsigned NOT NULL,
  `mold_pseudo` varchar(50) NOT NULL,
  `mold_mail` varchar(50) NOT NULL,
  `mold_lip` varchar(50) NOT NULL,
  `mold_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mold_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_mbr_old`
--

LOCK TABLES `zrd_mbr_old` WRITE;
/*!40000 ALTER TABLE `zrd_mbr_old` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_mbr_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_mch`
--

DROP TABLE IF EXISTS `zrd_mch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_mch` (
  `mch_cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mch_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `mch_type` smallint(3) unsigned NOT NULL DEFAULT '0',
  `mch_nb` int(10) unsigned NOT NULL DEFAULT '0',
  `mch_prix` int(10) unsigned NOT NULL DEFAULT '0',
  `mch_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mch_etat` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mch_cid`),
  KEY `mch_mid` (`mch_mid`),
  KEY `mch_type` (`mch_type`),
  KEY `mch_etat` (`mch_etat`)
) ENGINE=MyISAM AUTO_INCREMENT=11812 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_mch`
--

LOCK TABLES `zrd_mch` WRITE;
/*!40000 ALTER TABLE `zrd_mch` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_mch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_mch_cours`
--

DROP TABLE IF EXISTS `zrd_mch_cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_mch_cours` (
  `mcours_res` smallint(3) NOT NULL DEFAULT '0',
  `mcours_cours` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mcours_res`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_mch_cours`
--

LOCK TABLES `zrd_mch_cours` WRITE;
/*!40000 ALTER TABLE `zrd_mch_cours` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_mch_cours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_mch_sem`
--

DROP TABLE IF EXISTS `zrd_mch_sem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_mch_sem` (
  `msem_res` smallint(3) unsigned NOT NULL DEFAULT '0',
  `msem_date` date NOT NULL,
  `msem_cours` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`msem_res`,`msem_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_mch_sem`
--

LOCK TABLES `zrd_mch_sem` WRITE;
/*!40000 ALTER TABLE `zrd_mch_sem` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_mch_sem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_msg_env`
--

DROP TABLE IF EXISTS `zrd_msg_env`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_msg_env` (
  `menv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menv_mid` int(10) unsigned NOT NULL,
  `menv_to` int(10) unsigned DEFAULT NULL,
  `menv_mrec_id` int(10) unsigned NOT NULL,
  `menv_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `menv_titre` varchar(255) NOT NULL,
  `menv_texte` text NOT NULL,
  PRIMARY KEY (`menv_id`),
  KEY `menv_mid` (`menv_mid`)
) ENGINE=MyISAM AUTO_INCREMENT=451828 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_msg_env`
--

LOCK TABLES `zrd_msg_env` WRITE;
/*!40000 ALTER TABLE `zrd_msg_env` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_msg_env` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_msg_rec`
--

DROP TABLE IF EXISTS `zrd_msg_rec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_msg_rec` (
  `mrec_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mrec_mid` int(10) unsigned NOT NULL,
  `mrec_from` int(10) unsigned NOT NULL,
  `mrec_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mrec_titre` varchar(255) NOT NULL,
  `mrec_texte` text NOT NULL,
  `mrec_readed` tinyint(1) unsigned NOT NULL,
  `msg_sign` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mrec_id`),
  KEY `mrec_mid` (`mrec_mid`)
) ENGINE=MyISAM AUTO_INCREMENT=464607 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_msg_rec`
--

LOCK TABLES `zrd_msg_rec` WRITE;
/*!40000 ALTER TABLE `zrd_msg_rec` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_msg_rec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_ntes`
--

DROP TABLE IF EXISTS `zrd_ntes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_ntes` (
  `nte_nid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nte_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `nte_titre` varchar(250) NOT NULL DEFAULT '',
  `nte_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nte_texte` text NOT NULL,
  `nte_import` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  PRIMARY KEY (`nte_nid`),
  KEY `nte_mid` (`nte_mid`)
) ENGINE=MyISAM AUTO_INCREMENT=12652 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_ntes`
--

LOCK TABLES `zrd_ntes` WRITE;
/*!40000 ALTER TABLE `zrd_ntes` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_ntes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_nws`
--

DROP TABLE IF EXISTS `zrd_nws`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_nws` (
  `nws_nid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nws_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `nws_cat` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `nws_etat` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `nws_lang` char(5) NOT NULL,
  `nws_titre` varchar(100) NOT NULL DEFAULT '',
  `nws_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nws_texte` text NOT NULL,
  `nws_closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`nws_nid`),
  KEY `nws_mid` (`nws_mid`),
  KEY `nws_etat` (`nws_etat`),
  KEY `nws_date` (`nws_date`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_nws`
--

LOCK TABLES `zrd_nws` WRITE;
/*!40000 ALTER TABLE `zrd_nws` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_nws` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_rec`
--

DROP TABLE IF EXISTS `zrd_rec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_rec` (
  `rec_mid` int(10) unsigned NOT NULL,
  `rec_type` smallint(3) unsigned NOT NULL,
  `rec_nb` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`rec_mid`,`rec_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='RÃ©compenses';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_rec`
--

LOCK TABLES `zrd_rec` WRITE;
/*!40000 ALTER TABLE `zrd_rec` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_rec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_reg`
--

DROP TABLE IF EXISTS `zrd_reg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_reg` (
  `reg_id` smallint(3) unsigned NOT NULL,
  `reg_race` smallint(2) unsigned NOT NULL,
  `reg_nb` int(10) unsigned NOT NULL,
  PRIMARY KEY (`reg_id`,`reg_race`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_reg`
--

LOCK TABLES `zrd_reg` WRITE;
/*!40000 ALTER TABLE `zrd_reg` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_reg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_res`
--

DROP TABLE IF EXISTS `zrd_res`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_res` (
  `res_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `res_type1` int(10) unsigned NOT NULL,
  `res_type2` int(10) unsigned NOT NULL,
  `res_type3` int(10) unsigned NOT NULL,
  `res_type4` int(10) unsigned NOT NULL,
  `res_type5` int(10) unsigned NOT NULL,
  `res_type6` int(10) unsigned NOT NULL,
  `res_type7` int(10) unsigned NOT NULL,
  `res_type8` int(10) unsigned NOT NULL,
  `res_type9` int(10) unsigned NOT NULL,
  `res_type10` int(10) unsigned NOT NULL,
  `res_type11` int(10) unsigned NOT NULL,
  `res_type12` int(10) unsigned NOT NULL,
  `res_type13` int(10) unsigned NOT NULL,
  `res_type14` int(10) unsigned NOT NULL,
  `res_type15` int(10) unsigned NOT NULL,
  `res_type16` int(10) unsigned NOT NULL,
  `res_type17` int(10) unsigned NOT NULL,
  PRIMARY KEY (`res_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_res`
--

LOCK TABLES `zrd_res` WRITE;
/*!40000 ALTER TABLE `zrd_res` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_res` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_res_todo`
--

DROP TABLE IF EXISTS `zrd_res_todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_res_todo` (
  `rtdo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rtdo_mid` int(10) unsigned NOT NULL,
  `rtdo_type` smallint(3) unsigned NOT NULL,
  `rtdo_nb` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`rtdo_id`),
  KEY `rtdo_mid_type` (`rtdo_mid`,`rtdo_type`)
) ENGINE=MyISAM AUTO_INCREMENT=12859 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_res_todo`
--

LOCK TABLES `zrd_res_todo` WRITE;
/*!40000 ALTER TABLE `zrd_res_todo` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_res_todo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_sdg`
--

DROP TABLE IF EXISTS `zrd_sdg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_sdg` (
  `sdg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sdg_texte` text NOT NULL,
  `sdg_rep_nb` mediumint(6) unsigned NOT NULL,
  `sdg_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sdg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_sdg`
--

LOCK TABLES `zrd_sdg` WRITE;
/*!40000 ALTER TABLE `zrd_sdg` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_sdg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_sdg_rep`
--

DROP TABLE IF EXISTS `zrd_sdg_rep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_sdg_rep` (
  `srep_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `srep_sid` int(10) unsigned NOT NULL,
  `srep_texte` text NOT NULL,
  `srep_nb` mediumint(6) unsigned NOT NULL,
  PRIMARY KEY (`srep_id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_sdg_rep`
--

LOCK TABLES `zrd_sdg_rep` WRITE;
/*!40000 ALTER TABLE `zrd_sdg_rep` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_sdg_rep` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_sdg_vte`
--

DROP TABLE IF EXISTS `zrd_sdg_vte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_sdg_vte` (
  `svte_sid` mediumint(6) unsigned NOT NULL,
  `svte_mid` int(10) unsigned NOT NULL,
  `svte_rid` mediumint(6) unsigned NOT NULL,
  PRIMARY KEY (`svte_sid`,`svte_mid`,`svte_rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_sdg_vte`
--

LOCK TABLES `zrd_sdg_vte` WRITE;
/*!40000 ALTER TABLE `zrd_sdg_vte` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_sdg_vte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_ses`
--

DROP TABLE IF EXISTS `zrd_ses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_ses` (
  `ses_sesid` varchar(40) NOT NULL DEFAULT '',
  `ses_mid` int(11) unsigned NOT NULL DEFAULT '0',
  `ses_ip` varchar(50) NOT NULL,
  `ses_lact` varchar(15) NOT NULL DEFAULT '0',
  `ses_ldate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ses_rand` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ses_sesid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_ses`
--

LOCK TABLES `zrd_ses` WRITE;
/*!40000 ALTER TABLE `zrd_ses` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_ses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_sign`
--

DROP TABLE IF EXISTS `zrd_sign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_sign` (
  `sign_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sign_msgid` int(11) unsigned NOT NULL,
  `sign_admid` int(11) unsigned NOT NULL,
  `sign_debut` datetime NOT NULL,
  `sign_fin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sign_com` text NOT NULL,
  `sign_etat` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sign_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_sign`
--

LOCK TABLES `zrd_sign` WRITE;
/*!40000 ALTER TABLE `zrd_sign` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_sign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_src`
--

DROP TABLE IF EXISTS `zrd_src`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_src` (
  `src_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `src_type` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`src_mid`,`src_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_src`
--

LOCK TABLES `zrd_src` WRITE;
/*!40000 ALTER TABLE `zrd_src` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_src` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_src_todo`
--

DROP TABLE IF EXISTS `zrd_src_todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_src_todo` (
  `stdo_mid` int(10) unsigned NOT NULL,
  `stdo_type` smallint(3) unsigned NOT NULL,
  `stdo_tours` smallint(4) unsigned NOT NULL,
  `stdo_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`stdo_mid`,`stdo_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_src_todo`
--

LOCK TABLES `zrd_src_todo` WRITE;
/*!40000 ALTER TABLE `zrd_src_todo` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_src_todo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_stq`
--

DROP TABLE IF EXISTS `zrd_stq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_stq` (
  `stq_date` date NOT NULL,
  `stq_mbr_act` int(10) unsigned NOT NULL DEFAULT '0',
  `stq_mbr_inac` smallint(4) unsigned NOT NULL DEFAULT '0',
  `stq_mbr_con` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`stq_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_stq`
--

LOCK TABLES `zrd_stq` WRITE;
/*!40000 ALTER TABLE `zrd_stq` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_stq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_surv`
--

DROP TABLE IF EXISTS `zrd_surv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_surv` (
  `surv_id` int(11) NOT NULL AUTO_INCREMENT,
  `surv_mid` int(11) NOT NULL,
  `surv_admin` int(11) NOT NULL,
  `surv_debut` datetime NOT NULL,
  `surv_etat` int(11) NOT NULL,
  `surv_type` int(11) NOT NULL,
  `surv_cause` varchar(500) CHARACTER SET latin1 NOT NULL,
  `surv_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`surv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_surv`
--

LOCK TABLES `zrd_surv` WRITE;
/*!40000 ALTER TABLE `zrd_surv` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_surv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_trn`
--

DROP TABLE IF EXISTS `zrd_trn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_trn` (
  `trn_mid` int(10) unsigned NOT NULL,
  `trn_type1` tinyint(2) unsigned NOT NULL,
  `trn_type2` tinyint(2) unsigned NOT NULL,
  `trn_type3` tinyint(2) unsigned NOT NULL,
  `trn_type4` tinyint(2) unsigned NOT NULL,
  `trn_type5` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`trn_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_trn`
--

LOCK TABLES `zrd_trn` WRITE;
/*!40000 ALTER TABLE `zrd_trn` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_trn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_unt`
--

DROP TABLE IF EXISTS `zrd_unt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_unt` (
  `unt_lid` int(10) unsigned NOT NULL DEFAULT '0',
  `unt_type` smallint(3) unsigned NOT NULL DEFAULT '0',
  `unt_rang` tinyint(2) unsigned NOT NULL,
  `unt_nb` int(10) NOT NULL,
  PRIMARY KEY (`unt_lid`,`unt_type`,`unt_rang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_unt`
--

LOCK TABLES `zrd_unt` WRITE;
/*!40000 ALTER TABLE `zrd_unt` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_unt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_unt_todo`
--

DROP TABLE IF EXISTS `zrd_unt_todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_unt_todo` (
  `utdo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `utdo_mid` int(10) unsigned NOT NULL,
  `utdo_type` smallint(3) unsigned NOT NULL,
  `utdo_nb` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`utdo_id`),
  KEY `utdo_mid_type` (`utdo_mid`,`utdo_type`)
) ENGINE=MyISAM AUTO_INCREMENT=20143 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_unt_todo`
--

LOCK TABLES `zrd_unt_todo` WRITE;
/*!40000 ALTER TABLE `zrd_unt_todo` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_unt_todo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_vld`
--

DROP TABLE IF EXISTS `zrd_vld`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_vld` (
  `vld_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `vld_rand` varchar(40) NOT NULL DEFAULT '',
  `vld_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vld_act` varchar(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`vld_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_vld`
--

LOCK TABLES `zrd_vld` WRITE;
/*!40000 ALTER TABLE `zrd_vld` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_vld` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zrd_votes`
--

DROP TABLE IF EXISTS `zrd_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zrd_votes` (
  `votes_vid` int(10) unsigned NOT NULL DEFAULT '0',
  `votes_mid` int(10) unsigned NOT NULL DEFAULT '0',
  `votes_nb` int(10) unsigned DEFAULT '0',
  `votes_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zrd_votes`
--

LOCK TABLES `zrd_votes` WRITE;
/*!40000 ALTER TABLE `zrd_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `zrd_votes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-01  0:00:17
