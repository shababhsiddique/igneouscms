-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2014 at 03:14 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_cmsv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `lookup_status`
--

CREATE TABLE IF NOT EXISTS `lookup_status` (
  `status_id` int(1) NOT NULL AUTO_INCREMENT,
  `status` varchar(15) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lookup_status`
--

INSERT INTO `lookup_status` (`status_id`, `status`) VALUES
(0, 'unmoderated'),
(1, 'approved'),
(2, 'declined'),
(3, 'published'),
(4, 'Unpublished');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `admin_id` int(2) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) NOT NULL,
  `admin_email_address` varchar(100) NOT NULL,
  `admin_password` varchar(32) NOT NULL,
  `privilage_level` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_name`, `admin_email_address`, `admin_password`, `privilage_level`) VALUES
(1, 'Admin', 'admin@cms.com', '0192023a7bbd73250516f069df18b500', 7),
(2, 'Manager', 'manager@cms.com', '0795151defba7a4b5dfa89170de46277', 2),
(3, 'New Admin User', 'new@cms.com', 'e10adc3949ba59abbe56e057f20f883e', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_articles`
--

CREATE TABLE IF NOT EXISTS `tbl_articles` (
  `article_id` int(5) NOT NULL AUTO_INCREMENT,
  `article_title` varchar(100) NOT NULL,
  `article_img` varchar(200) NOT NULL,
  `article_author` varchar(100) NOT NULL DEFAULT '',
  `article_body` text NOT NULL,
  `article_category` varchar(50) NOT NULL DEFAULT 'News',
  `last_edit` datetime NOT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '3' COMMENT '3=published,4=unpublished',
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_articles`
--

INSERT INTO `tbl_articles` (`article_id`, `article_title`, `article_img`, `article_author`, `article_body`, `article_category`, `last_edit`, `status_id`) VALUES
(3, 'Article Title', '', 'Autho', '<p>Body of article</p>', 'cat', '0000-00-00 00:00:00', 2),
(4, 'Article Title 2', 'Snapshot_20121214_4.JPG', 'Selfie', '<p>Selfie article</p>', 'Cat', '0000-00-00 00:00:00', 0),
(5, 'saf', 'il_570xN.438777963_9lrj_.jpg', 'sfaaaa', '<p>safsdfasdfddd</p>', 'dsdas', '0000-00-00 00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blocks`
--

CREATE TABLE IF NOT EXISTS `tbl_blocks` (
  `block_id` int(3) NOT NULL AUTO_INCREMENT,
  `block_title` varchar(50) NOT NULL,
  `block_html` text NOT NULL COMMENT 'static html block',
  PRIMARY KEY (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_blocks`
--

INSERT INTO `tbl_blocks` (`block_id`, `block_title`, `block_html`) VALUES
(1, 'home_block_main', '<h1>This is dynamic block h1</h1>\n<p>Your paragraph here. <b>Your paragraph here</b>. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph<i> <u><a href="http://localhost/cmsv2/page/1" title="here" target="">her</a></u></i><u><a href="javascript:nicTemp();">e</a>.</u> Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your p<span style="background-color: rgb(255, 255, 204);">ara<font color="#ff0000"><b>graph here</b></font>. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph her</span>e. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here. Your paragraph here.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_config`
--

CREATE TABLE IF NOT EXISTS `tbl_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(50) NOT NULL,
  `config_value` varchar(500) NOT NULL,
  PRIMARY KEY (`config_id`),
  UNIQUE KEY `config_key` (`config_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_config`
--

INSERT INTO `tbl_config` (`config_id`, `config_key`, `config_value`) VALUES
(1, 'site_title', 'Igneous CMS v2'),
(2, 'site_logo', 'lumextech_icon.png'),
(3, 'home_page', '1'),
(4, 'color_file', 'css/var.less'),
(5, 'css_hash', '4cb6eb37b9833f00f69c901cb4f148f4'),
(6, 'contact_email', 'contact@lumextech.com'),
(7, 'contact_phone', '+880 1727 421 885'),
(8, 'contact_address', '1/C N. Dhanmondi, Dhaka'),
(9, 'cache_duration', '0'),
(10, 'YOUR_UNIQUE_KEY', 'VAlueee');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emails`
--

CREATE TABLE IF NOT EXISTS `tbl_emails` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `email_message` text NOT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `menu_id` int(2) NOT NULL AUTO_INCREMENT,
  `menu_parent_id` int(2) NOT NULL DEFAULT '0' COMMENT '0=root leve',
  `menu_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'lighter stays above the heavier',
  `menu_display_link` varchar(50) NOT NULL,
  `menu_site_url` varchar(50) NOT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`menu_id`, `menu_parent_id`, `menu_weight`, `menu_display_link`, `menu_site_url`, `status_id`) VALUES
(1, 0, 1, 'Homes', '/', 3),
(2, 1, 2, 'Pages', '/pages', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

CREATE TABLE IF NOT EXISTS `tbl_pages` (
  `page_id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(50) NOT NULL,
  `page_body` text NOT NULL COMMENT 'json presented pointers',
  `status_id` tinyint(1) NOT NULL DEFAULT '3' COMMENT '3=published,4=unpublished',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`page_id`, `page_title`, `page_body`, `status_id`) VALUES
(1, 'First Page', '<p>This is the first page of this new <b>CMS</b>. The CMS is feeling something.&nbsp;<span style="line-height: 1.42857143;">This is the first page of this new</span><span style="line-height: 1.42857143;">&nbsp;</span><span style="line-height: 1.42857143; font-weight: 700;">CMS</span><span style="line-height: 1.42857143;">. The CMS is feeling something.&nbsp;</span><span style="line-height: 1.42857143;">This is the first page of this new</span><span style="line-height: 1.42857143;">&nbsp;</span><span style="line-height: 1.42857143; font-weight: 700;">CMS</span><span style="line-height: 1.42857143;">. The CMS is feeling something.&nbsp;</span><span style="line-height: 1.42857143;">This is the first page of this new</span><span style="line-height: 1.42857143;">&nbsp;</span><span style="line-height: 1.42857143; font-weight: 700;">CMS</span><span style="line-height: 1.42857143;">. The CMS is feeling something.&nbsp;</span><span style="line-height: 1.42857143;">This is the first page of this new</span><span style="line-height: 1.42857143;">&nbsp;</span><span style="line-height: 1.42857143; font-weight: 700;">CMS</span><span style="line-height: 1.42857143;">. The CMS is feeling something.&nbsp;</span><span style="line-height: 1.42857143;">This is the first page of this new</span><span style="line-height: 1.42857143;">&nbsp;</span><span style="line-height: 1.42857143; font-weight: 700;">CMS</span><span style="line-height: 1.42857143;">. The CMS is feeling something.&nbsp;</span><span style="line-height: 1.42857143;">This is the first page of this new</span><span style="line-height: 1.42857143;">&nbsp;</span><span style="line-height: 1.42857143; font-weight: 700;">CMS</span><span style="line-height: 1.42857143;">. The CMS is feeling something.&nbsp;</span><span style="line-height: 1.42857143;">This is the first page of this new</span><span style="line-height: 1.42857143;">&nbsp;</span><span style="line-height: 1.42857143; font-weight: 700;">CMS</span><span style="line-height: 1.42857143;">. The CMS is feeling something.&nbsp;</span><span style="line-height: 1.42857143;">This is the first page of this new</span><span style="line-height: 1.42857143;">&nbsp;</span><span style="line-height: 1.42857143; font-weight: 700;">CMS</span><span style="line-height: 1.42857143;">. The CMS is feeling something.&nbsp;</span></p>', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
