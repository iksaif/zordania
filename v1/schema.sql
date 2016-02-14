-- MySQL dump 10.10
--
-- Host: localhost    Database: zordania
-- ------------------------------------------------------
-- Server version	5.0.20-Debian_1-log

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
CREATE TABLE `zrd_al` (
  `al_aid` int(10) unsigned NOT NULL auto_increment,
  `al_name` varchar(150) NOT NULL default '',
  `al_mid` int(10) unsigned NOT NULL default '0',
  `al_points` int(10) unsigned NOT NULL default '0',
  `al_open` smallint(1) NOT NULL default '0',
  `al_nb_mbr` smallint(2) unsigned NOT NULL default '1',
  `al_descr` text NOT NULL,
  `al_rules` text NOT NULL,
  PRIMARY KEY  (`al_aid`),
  KEY `al_points` (`al_points`),
  KEY `al_open` (`al_open`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_al`
--


/*!40000 ALTER TABLE `zrd_al` DISABLE KEYS */;
LOCK TABLES `zrd_al` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_al` ENABLE KEYS */;

--
-- Table structure for table `zrd_al_res`
--

DROP TABLE IF EXISTS `zrd_al_res`;
CREATE TABLE `zrd_al_res` (
  `al_res_rid` int(11) unsigned NOT NULL auto_increment,
  `al_res_aid` int(10) unsigned NOT NULL default '0',
  `al_res_type` smallint(6) unsigned NOT NULL default '0',
  `al_res_nb` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`al_res_rid`),
  KEY `al_res_aid` (`al_res_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_al_res`
--


/*!40000 ALTER TABLE `zrd_al_res` DISABLE KEYS */;
LOCK TABLES `zrd_al_res` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_al_res` ENABLE KEYS */;

--
-- Table structure for table `zrd_al_res_log`
--

DROP TABLE IF EXISTS `zrd_al_res_log`;
CREATE TABLE `zrd_al_res_log` (
  `al_res_log_id` int(10) unsigned NOT NULL auto_increment,
  `al_res_log_aid` int(10) unsigned NOT NULL default '0',
  `al_res_log_mid` int(10) unsigned NOT NULL default '0',
  `al_res_log_res_type` smallint(3) unsigned NOT NULL default '0',
  `al_res_log_res_nb` int(10) NOT NULL default '0',
  `al_res_log_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `al_res_log_ip` varchar(30) NOT NULL,
  PRIMARY KEY  (`al_res_log_id`),
  KEY `al_res_log_aid` (`al_res_log_aid`),
  KEY `al_res_log_date` (`al_res_log_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_al_res_log`
--


/*!40000 ALTER TABLE `zrd_al_res_log` DISABLE KEYS */;
LOCK TABLES `zrd_al_res_log` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_al_res_log` ENABLE KEYS */;

--
-- Table structure for table `zrd_al_shoot`
--

DROP TABLE IF EXISTS `zrd_al_shoot`;
CREATE TABLE `zrd_al_shoot` (
  `shoot_msgid` int(10) unsigned NOT NULL auto_increment,
  `shoot_mid` int(10) unsigned NOT NULL default '0',
  `shoot_aid` int(10) unsigned NOT NULL default '0',
  `shoot_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `shoot_texte` text NOT NULL,
  PRIMARY KEY  (`shoot_msgid`),
  KEY `shoot_aid` (`shoot_aid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_al_shoot`
--


/*!40000 ALTER TABLE `zrd_al_shoot` DISABLE KEYS */;
LOCK TABLES `zrd_al_shoot` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_al_shoot` ENABLE KEYS */;

--
-- Table structure for table `zrd_atq`
--

DROP TABLE IF EXISTS `zrd_atq`;
CREATE TABLE `zrd_atq` (
  `atq_aid` int(10) unsigned NOT NULL auto_increment,
  `atq_mid` int(10) unsigned NOT NULL default '0',
  `atq_date_dep` timestamp NOT NULL default '0000-00-00 00:00:00',
  `atq_date_arv` timestamp NOT NULL default '0000-00-00 00:00:00',
  `atq_date_vil` timestamp NOT NULL default '0000-00-00 00:00:00',
  `atq_lid` int(10) unsigned NOT NULL default '0',
  `atq_mid2` int(10) unsigned NOT NULL default '0',
  `atq_dst` smallint(5) unsigned NOT NULL default '0',
  `atq_atq_unt` int(6) unsigned NOT NULL default '0',
  `atq_atq_btc` int(6) unsigned NOT NULL default '0',
  `atq_def` int(8) unsigned NOT NULL default '0',
  `atq_speed` smallint(3) unsigned NOT NULL default '0',
  `atq_res1_type` smallint(2) unsigned NOT NULL default '0',
  `atq_res1_nb` int(10) unsigned NOT NULL default '0',
  `atq_res2_type` smallint(2) unsigned NOT NULL default '0',
  `atq_res2_nb` int(10) unsigned NOT NULL default '0',
  `atq_result` tinyint(1) unsigned NOT NULL default '0',
  `atq_bilan` text NOT NULL,
  PRIMARY KEY  (`atq_aid`),
  KEY `atq_mid` (`atq_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

--
-- Dumping data for table `zrd_atq`
--


/*!40000 ALTER TABLE `zrd_atq` DISABLE KEYS */;
LOCK TABLES `zrd_atq` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_atq` ENABLE KEYS */;

--
-- Table structure for table `zrd_bon`
--

DROP TABLE IF EXISTS `zrd_bon`;
CREATE TABLE `zrd_bon` (
  `bon_id` int(10) unsigned NOT NULL auto_increment,
  `bon_mid` int(10) unsigned NOT NULL default '0',
  `bon_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `bon_code` varchar(20) NOT NULL default '',
  `bon_ok` varchar(50) NOT NULL default '0',
  `bon_res_type` smallint(2) NOT NULL default '0',
  `bon_res_nb` int(5) NOT NULL default '0',
  PRIMARY KEY  (`bon_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_bon`
--


/*!40000 ALTER TABLE `zrd_bon` DISABLE KEYS */;
LOCK TABLES `zrd_bon` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_bon` ENABLE KEYS */;

--
-- Table structure for table `zrd_btc`
--

DROP TABLE IF EXISTS `zrd_btc`;
CREATE TABLE `zrd_btc` (
  `btc_bid` int(10) unsigned NOT NULL auto_increment,
  `btc_mid` int(10) unsigned NOT NULL default '0',
  `btc_type` smallint(5) unsigned NOT NULL default '0',
  `btc_vie` int(6) NOT NULL default '0',
  `btc_tour` smallint(4) unsigned NOT NULL default '0',
  `btc_etat` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`btc_bid`),
  KEY `btc_mid` (`btc_mid`),
  KEY `btc_type` (`btc_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_btc`
--


/*!40000 ALTER TABLE `zrd_btc` DISABLE KEYS */;
LOCK TABLES `zrd_btc` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_btc` ENABLE KEYS */;

--
-- Table structure for table `zrd_cmt`
--

DROP TABLE IF EXISTS `zrd_cmt`;
CREATE TABLE `zrd_cmt` (
  `cmt_cid` int(10) unsigned NOT NULL auto_increment,
  `cmt_nid` int(10) unsigned NOT NULL default '0',
  `cmt_mid` int(11) unsigned NOT NULL default '0',
  `cmt_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `cmt_texte` text NOT NULL,
  `cmt_ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`cmt_cid`),
  KEY `cmd_nid` (`cmt_nid`),
  KEY `cmt_mid` (`cmt_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_cmt`
--


/*!40000 ALTER TABLE `zrd_cmt` DISABLE KEYS */;
LOCK TABLES `zrd_cmt` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_cmt` ENABLE KEYS */;

--
-- Table structure for table `zrd_con`
--

DROP TABLE IF EXISTS `zrd_con`;
CREATE TABLE `zrd_con` (
  `con_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `con_nb` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`con_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_con`
--


/*!40000 ALTER TABLE `zrd_con` DISABLE KEYS */;
LOCK TABLES `zrd_con` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_con` ENABLE KEYS */;

--
-- Table structure for table `zrd_frm_cat`
--

DROP TABLE IF EXISTS `zrd_frm_cat`;
CREATE TABLE `zrd_frm_cat` (
  `cat_id` int(10) unsigned NOT NULL auto_increment,
  `cat_name` varchar(200) NOT NULL default '',
  `cat_droit` tinyint(1) unsigned NOT NULL default '0',
  `cat_pos` int(3) NOT NULL default '0',
  PRIMARY KEY  (`cat_id`),
  KEY `cat_pos` (`cat_pos`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_frm_cat`
--


/*!40000 ALTER TABLE `zrd_frm_cat` DISABLE KEYS */;
LOCK TABLES `zrd_frm_cat` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_frm_cat` ENABLE KEYS */;

--
-- Table structure for table `zrd_frm_frm`
--

DROP TABLE IF EXISTS `zrd_frm_frm`;
CREATE TABLE `zrd_frm_frm` (
  `frm_id` int(10) unsigned NOT NULL auto_increment,
  `frm_cid` int(10) unsigned NOT NULL default '0',
  `frm_name` varchar(200) NOT NULL default '',
  `frm_descr` text NOT NULL,
  `frm_droit` tinyint(1) unsigned NOT NULL default '0',
  `frm_pos` int(3) NOT NULL default '0',
  `frm_pst_nb` int(10) unsigned NOT NULL default '0',
  `frm_msg_nb` int(10) unsigned NOT NULL default '0',
  `frm_lst_pst_pid` int(10) unsigned NOT NULL default '0',
  `frm_lst_mid` int(10) unsigned NOT NULL default '0',
  `frm_lst_pst_titre` varchar(255) NOT NULL default '',
  `frm_lst_pst_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`frm_id`),
  KEY `frm_cid` (`frm_cid`),
  KEY `frm_pos` (`frm_pos`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_frm_frm`
--


/*!40000 ALTER TABLE `zrd_frm_frm` DISABLE KEYS */;
LOCK TABLES `zrd_frm_frm` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_frm_frm` ENABLE KEYS */;

--
-- Table structure for table `zrd_frm_pst`
--

DROP TABLE IF EXISTS `zrd_frm_pst`;
CREATE TABLE `zrd_frm_pst` (
  `pst_id` int(10) unsigned NOT NULL auto_increment,
  `pst_mid` int(10) unsigned NOT NULL default '0',
  `pst_fid` int(10) unsigned NOT NULL default '0',
  `pst_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `pst_titre` varchar(255) NOT NULL default '',
  `pst_texte` text NOT NULL,
  `pst_pid` int(10) unsigned NOT NULL default '0',
  `pst_etat` tinyint(1) unsigned NOT NULL default '0',
  `pst_open` tinyint(1) unsigned NOT NULL default '0',
  `pst_lmid` int(10) unsigned NOT NULL default '0',
  `pst_ldate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `pst_msg_nb` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`pst_id`),
  KEY `pst_pid` (`pst_pid`),
  FULLTEXT KEY `pst_titre` (`pst_titre`,`pst_texte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_frm_pst`
--


/*!40000 ALTER TABLE `zrd_frm_pst` DISABLE KEYS */;
LOCK TABLES `zrd_frm_pst` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_frm_pst` ENABLE KEYS */;

--
-- Table structure for table `zrd_grp`
--

DROP TABLE IF EXISTS `zrd_grp`;
CREATE TABLE `zrd_grp` (
  `grp_gid` tinyint(3) unsigned NOT NULL auto_increment,
  `grp_droits` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`grp_gid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_grp`
--


/*!40000 ALTER TABLE `zrd_grp` DISABLE KEYS */;
LOCK TABLES `zrd_grp` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_grp` ENABLE KEYS */;

--
-- Table structure for table `zrd_histo`
--

DROP TABLE IF EXISTS `zrd_histo`;
CREATE TABLE `zrd_histo` (
  `histo_hid` int(10) unsigned NOT NULL auto_increment,
  `histo_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `histo_mid` int(10) unsigned NOT NULL default '0',
  `histo_mid2` int(10) unsigned NOT NULL default '0',
  `histo_type` smallint(2) unsigned NOT NULL default '0',
  `histo_var1` smallint(5) unsigned NOT NULL default '0',
  `histo_var2` smallint(5) unsigned NOT NULL default '0',
  `histo_var3` smallint(5) unsigned NOT NULL default '0',
  `histo_var4` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`histo_hid`),
  KEY `histo_mid` (`histo_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_histo`
--


/*!40000 ALTER TABLE `zrd_histo` DISABLE KEYS */;
LOCK TABLES `zrd_histo` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_histo` ENABLE KEYS */;

--
-- Table structure for table `zrd_leg`
--

DROP TABLE IF EXISTS `zrd_leg`;
CREATE TABLE `zrd_leg` (
  `leg_lid` int(11) unsigned NOT NULL auto_increment,
  `leg_mid` int(10) unsigned NOT NULL default '0',
  `leg_cid` int(10) unsigned NOT NULL default '0',
  `leg_etat` smallint(3) NOT NULL default '0',
  `leg_name` varchar(20) NOT NULL default '',
  `leg_xp` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`leg_lid`),
  KEY `leg_etat` (`leg_etat`),
  KEY `leg_mid` (`leg_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_leg`
--


/*!40000 ALTER TABLE `zrd_leg` DISABLE KEYS */;
LOCK TABLES `zrd_leg` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_leg` ENABLE KEYS */;

--
-- Table structure for table `zrd_log`
--

DROP TABLE IF EXISTS `zrd_log`;
CREATE TABLE `zrd_log` (
  `log_lid` int(10) unsigned NOT NULL auto_increment,
  `log_mid` int(10) unsigned NOT NULL default '0',
  `log_ip` varchar(15) NOT NULL default '',
  `log_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `log_url` varchar(255) NOT NULL default '',
  `log_post` text NOT NULL,
  `log_cookie` text NOT NULL,
  PRIMARY KEY  (`log_lid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_log`
--


/*!40000 ALTER TABLE `zrd_log` DISABLE KEYS */;
LOCK TABLES `zrd_log` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_log` ENABLE KEYS */;

--
-- Table structure for table `zrd_map`
--

DROP TABLE IF EXISTS `zrd_map`;
CREATE TABLE `zrd_map` (
  `map_cid` int(10) NOT NULL auto_increment,
  `map_x` smallint(3) NOT NULL default '0',
  `map_y` smallint(3) NOT NULL default '0',
  `map_type` smallint(1) NOT NULL default '0',
  `map_rand` smallint(1) NOT NULL default '1',
  PRIMARY KEY  (`map_cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_map`
--


/*!40000 ALTER TABLE `zrd_map` DISABLE KEYS */;
LOCK TABLES `zrd_map` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_map` ENABLE KEYS */;

--
-- Table structure for table `zrd_mbr`
--

DROP TABLE IF EXISTS `zrd_mbr`;
CREATE TABLE `zrd_mbr` (
  `mbr_mid` int(10) unsigned NOT NULL auto_increment,
  `mbr_login` varchar(40) NOT NULL default '',
  `mbr_pseudo` varchar(40) NOT NULL default '',
  `mbr_pass` varchar(40) NOT NULL default '',
  `mbr_mail` varchar(50) NOT NULL default '',
  `mbr_lang` char(2) NOT NULL default '',
  `mbr_etat` tinyint(3) unsigned NOT NULL default '0',
  `mbr_gid` smallint(5) unsigned NOT NULL default '0',
  `mbr_decal` time NOT NULL default '00:00:00',
  `mbr_alaid` int(10) NOT NULL default '0',
  `mbr_race` int(1) unsigned NOT NULL default '0',
  `mbr_mapcid` int(10) unsigned NOT NULL default '0',
  `mbr_population` int(10) unsigned NOT NULL default '0',
  `mbr_points` int(10) unsigned NOT NULL default '0',
  `mbr_atq_nb` int(5) unsigned NOT NULL default '0',
  `mbr_ldate` timestamp NULL default '0000-00-00 00:00:00',
  `mbr_lmodif_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `mbr_inscr_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `mbr_lip` varchar(50) NOT NULL default '',
  `mbr_sign` text NOT NULL,
  `mbr_descr` text NOT NULL,
  PRIMARY KEY  (`mbr_mid`),
  UNIQUE KEY `mbr_mail` (`mbr_mail`),
  UNIQUE KEY `mbr_pseudo` (`mbr_pseudo`),
  KEY `mbr_lmodif_date` (`mbr_lmodif_date`),
  KEY `mbr_etat` (`mbr_etat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_mbr`
--


/*!40000 ALTER TABLE `zrd_mbr` DISABLE KEYS */;
LOCK TABLES `zrd_mbr` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_mbr` ENABLE KEYS */;

--
-- Table structure for table `zrd_mch`
--

DROP TABLE IF EXISTS `zrd_mch`;
CREATE TABLE `zrd_mch` (
  `mch_cid` int(10) unsigned NOT NULL auto_increment,
  `mch_mid` int(10) unsigned NOT NULL default '0',
  `mch_type` smallint(5) unsigned NOT NULL default '0',
  `mch_nb` int(10) unsigned NOT NULL default '0',
  `mch_type2` smallint(5) unsigned NOT NULL default '0',
  `mch_nb2` int(10) unsigned NOT NULL default '0',
  `mch_tours` int(5) NOT NULL default '0',
  `mch_ach` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mch_cid`),
  KEY `mch_mid` (`mch_mid`),
  KEY `mch_type` (`mch_type`),
  KEY `mch_ach` (`mch_ach`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_mch`
--


/*!40000 ALTER TABLE `zrd_mch` DISABLE KEYS */;
LOCK TABLES `zrd_mch` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_mch` ENABLE KEYS */;

--
-- Table structure for table `zrd_mch_cours`
--

DROP TABLE IF EXISTS `zrd_mch_cours`;
CREATE TABLE `zrd_mch_cours` (
  `mch_cours_id` int(10) unsigned NOT NULL auto_increment,
  `mch_cours_res` smallint(2) NOT NULL default '0',
  `mch_cours_cours` float unsigned NOT NULL default '0',
  PRIMARY KEY  (`mch_cours_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_mch_cours`
--


/*!40000 ALTER TABLE `zrd_mch_cours` DISABLE KEYS */;
LOCK TABLES `zrd_mch_cours` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_mch_cours` ENABLE KEYS */;

--
-- Table structure for table `zrd_mch_sem`
--

DROP TABLE IF EXISTS `zrd_mch_sem`;
CREATE TABLE `zrd_mch_sem` (
  `mch_sem_id` int(10) unsigned NOT NULL auto_increment,
  `mch_sem_res` smallint(2) unsigned NOT NULL default '0',
  `mch_sem_cours` float NOT NULL default '0',
  `mch_sem_jour` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mch_sem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_mch_sem`
--


/*!40000 ALTER TABLE `zrd_mch_sem` DISABLE KEYS */;
LOCK TABLES `zrd_mch_sem` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_mch_sem` ENABLE KEYS */;

--
-- Table structure for table `zrd_msg`
--

DROP TABLE IF EXISTS `zrd_msg`;
CREATE TABLE `zrd_msg` (
  `msg_msgid` int(10) unsigned NOT NULL auto_increment,
  `msg_mid` int(10) unsigned NOT NULL default '0',
  `msg_mid2` int(10) unsigned NOT NULL default '0',
  `msg_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `msg_titre` varchar(150) NOT NULL default '',
  `msg_texte` text NOT NULL,
  `msg_not_readed` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`msg_msgid`),
  KEY `msg_mid` (`msg_mid`),
  KEY `msg_mid2` (`msg_mid2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_msg`
--


/*!40000 ALTER TABLE `zrd_msg` DISABLE KEYS */;
LOCK TABLES `zrd_msg` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_msg` ENABLE KEYS */;

--
-- Table structure for table `zrd_ntes`
--

DROP TABLE IF EXISTS `zrd_ntes`;
CREATE TABLE `zrd_ntes` (
  `nte_nid` int(10) unsigned NOT NULL auto_increment,
  `nte_mid` int(10) unsigned NOT NULL default '0',
  `nte_titre` varchar(250) NOT NULL default '',
  `nte_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `nte_texte` text NOT NULL,
  `nte_import` enum('0','1','2','3','4') NOT NULL default '0',
  PRIMARY KEY  (`nte_nid`),
  KEY `nte_mid` (`nte_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_ntes`
--


/*!40000 ALTER TABLE `zrd_ntes` DISABLE KEYS */;
LOCK TABLES `zrd_ntes` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_ntes` ENABLE KEYS */;

--
-- Table structure for table `zrd_nws`
--

DROP TABLE IF EXISTS `zrd_nws`;
CREATE TABLE `zrd_nws` (
  `nws_nid` int(10) unsigned NOT NULL auto_increment,
  `nws_mid` int(10) unsigned NOT NULL default '0',
  `nws_cat` tinyint(1) unsigned NOT NULL default '1',
  `nws_etat` tinyint(3) unsigned NOT NULL default '0',
  `nws_ip` varchar(15) NOT NULL default '',
  `nws_lang` char(2) NOT NULL default '',
  `nws_titre` varchar(100) NOT NULL default '',
  `nws_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `nws_texte` text NOT NULL,
  `nws_closed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`nws_nid`),
  KEY `nws_mid` (`nws_mid`),
  KEY `nws_etat` (`nws_etat`),
  FULLTEXT KEY `nws_titre` (`nws_titre`,`nws_texte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_nws`
--


/*!40000 ALTER TABLE `zrd_nws` DISABLE KEYS */;
LOCK TABLES `zrd_nws` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_nws` ENABLE KEYS */;

--
-- Table structure for table `zrd_rec`
--

DROP TABLE IF EXISTS `zrd_rec`;
CREATE TABLE `zrd_rec` (
  `rec_id` int(10) unsigned NOT NULL auto_increment,
  `rec_mid` int(10) unsigned NOT NULL default '0',
  `rec_type` smallint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`rec_id`),
  KEY `rec_mid` (`rec_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_rec`
--


/*!40000 ALTER TABLE `zrd_rec` DISABLE KEYS */;
LOCK TABLES `zrd_rec` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_rec` ENABLE KEYS */;

--
-- Table structure for table `zrd_res`
--

DROP TABLE IF EXISTS `zrd_res`;
CREATE TABLE `zrd_res` (
  `res_rid` int(11) unsigned NOT NULL auto_increment,
  `res_mid` int(10) NOT NULL default '0',
  `res_type` smallint(6) unsigned NOT NULL default '0',
  `res_nb` int(11) unsigned NOT NULL default '0',
  `res_btc` smallint(6) NOT NULL default '1',
  `res_prio` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`res_rid`),
  KEY `res_mid` (`res_mid`),
  KEY `res_type` (`res_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_res`
--


/*!40000 ALTER TABLE `zrd_res` DISABLE KEYS */;
LOCK TABLES `zrd_res` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_res` ENABLE KEYS */;

--
-- Table structure for table `zrd_ses`
--

DROP TABLE IF EXISTS `zrd_ses`;
CREATE TABLE `zrd_ses` (
  `ses_sesid` varchar(40) NOT NULL default '',
  `ses_mid` int(11) unsigned NOT NULL default '0',
  `ses_ip` varchar(50) NOT NULL default '',
  `ses_lact` varchar(15) NOT NULL default '0',
  `ses_ldate` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ses_sesid`),
  KEY `ses_ip` (`ses_ip`),
  KEY `ses_mid` (`ses_mid`),
  KEY `ses_ldate` (`ses_ldate`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_ses`
--


/*!40000 ALTER TABLE `zrd_ses` DISABLE KEYS */;
LOCK TABLES `zrd_ses` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_ses` ENABLE KEYS */;

--
-- Table structure for table `zrd_src`
--

DROP TABLE IF EXISTS `zrd_src`;
CREATE TABLE `zrd_src` (
  `src_sid` int(10) unsigned NOT NULL auto_increment,
  `src_mid` int(10) unsigned NOT NULL default '0',
  `src_type` smallint(5) unsigned NOT NULL default '0',
  `src_tour` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`src_sid`),
  KEY `src_mid` (`src_mid`),
  KEY `src_type` (`src_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_src`
--


/*!40000 ALTER TABLE `zrd_src` DISABLE KEYS */;
LOCK TABLES `zrd_src` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_src` ENABLE KEYS */;

--
-- Table structure for table `zrd_stq`
--

DROP TABLE IF EXISTS `zrd_stq`;
CREATE TABLE `zrd_stq` (
  `stq_sid` int(10) unsigned NOT NULL auto_increment,
  `stq_date` timestamp NULL default '0000-00-00 00:00:00',
  `stq_mbr_act` int(10) unsigned NOT NULL default '0',
  `stq_mbr_inac` int(4) unsigned NOT NULL default '0',
  `stq_mbr_con` int(4) unsigned NOT NULL default '0',
  `stq_unt_tot` int(8) unsigned NOT NULL default '0',
  `stq_btc_tot` int(8) unsigned NOT NULL default '0',
  `stq_unt_avg` int(3) unsigned NOT NULL default '0',
  `stq_btc_avg` int(3) unsigned NOT NULL default '0',
  `stq_res_avg` int(8) unsigned NOT NULL default '0',
  `stq_src_avg` int(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`stq_sid`),
  KEY `stq_type` (`stq_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_stq`
--


/*!40000 ALTER TABLE `zrd_stq` DISABLE KEYS */;
LOCK TABLES `zrd_stq` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_stq` ENABLE KEYS */;

--
-- Table structure for table `zrd_unt`
--

DROP TABLE IF EXISTS `zrd_unt`;
CREATE TABLE `zrd_unt` (
  `unt_uid` int(11) unsigned NOT NULL auto_increment,
  `unt_mid` int(10) unsigned NOT NULL default '0',
  `unt_lid` int(10) NOT NULL default '0',
  `unt_type` smallint(6) unsigned NOT NULL default '0',
  `unt_nb` int(11) unsigned NOT NULL default '0',
  `unt_prio` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`unt_uid`),
  KEY `unt_mid` (`unt_mid`),
  KEY `unt_type` (`unt_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_unt`
--


/*!40000 ALTER TABLE `zrd_unt` DISABLE KEYS */;
LOCK TABLES `zrd_unt` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_unt` ENABLE KEYS */;

--
-- Table structure for table `zrd_vld`
--

DROP TABLE IF EXISTS `zrd_vld`;
CREATE TABLE `zrd_vld` (
  `vld_mid` int(10) unsigned NOT NULL default '0',
  `vld_rand` varchar(40) NOT NULL default '',
  `vld_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `vld_act` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`vld_mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zrd_vld`
--


/*!40000 ALTER TABLE `zrd_vld` DISABLE KEYS */;
LOCK TABLES `zrd_vld` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `zrd_vld` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

