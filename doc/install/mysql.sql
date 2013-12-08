-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 12 月 08 日 06:11
-- 服务器版本: 5.5.32
-- PHP 版本: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `eioapp`
--
CREATE DATABASE IF NOT EXISTS `eioapp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `eioapp`;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '用户名',
  `pass` varchar(100) NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `level` tinyint(1) NOT NULL COMMENT '1为超级管理员，2为普通管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员用户表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eioid` int(11) NOT NULL COMMENT '问卷外键',
  `userid` int(11) NOT NULL COMMENT '用户外键',
  `content` text NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户对于问卷的评论' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `eio`
--

CREATE TABLE IF NOT EXISTS `eio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL DEFAULT '1',
  `classifyid` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `questioncount` int(11) NOT NULL DEFAULT '0' COMMENT '问卷所包含的问题数',
  `levelA` text NOT NULL,
  `levelB` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `levelC` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `levelD` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `didcount` int(11) NOT NULL DEFAULT '0',
  `praisecount` int(11) NOT NULL DEFAULT '0',
  `stampcount` int(11) NOT NULL DEFAULT '0',
  `publishtime` datetime DEFAULT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='问卷列表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `eio`
--

INSERT INTO `eio` (`id`, `typeid`, `classifyid`, `icon`, `title`, `author`, `questioncount`, `levelA`, `levelB`, `levelC`, `levelD`, `didcount`, `praisecount`, `stampcount`, `publishtime`, `uptime`) VALUES
(1, 1, 1, '', 'test1', 'linwei', 0, '1', '2', '3', '4', 0, 0, 0, '2013-12-08 12:54:07', '2013-12-08 04:54:07'),
(2, 1, 2, '', 'test2', '1', 0, '1', '2', '3', '4', 0, 0, 0, NULL, '2013-12-08 04:35:09');

-- --------------------------------------------------------

--
-- 表的结构 `eioclassify`
--

CREATE TABLE IF NOT EXISTS `eioclassify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `eioclassify`
--

INSERT INTO `eioclassify` (`id`, `name`, `icon`, `uptime`) VALUES
(1, '热门', '', '2013-12-08 02:57:30'),
(2, '基本', '', '2013-12-08 02:57:30'),
(3, '职场', '', '2013-12-08 02:57:55'),
(4, '情感', '', '2013-12-08 02:57:55'),
(5, '校园', '', '2013-12-08 02:58:02');

-- --------------------------------------------------------

--
-- 表的结构 `eiocontent`
--

CREATE TABLE IF NOT EXISTS `eiocontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eioid` int(11) NOT NULL COMMENT '所属的问卷id',
  `qustion` text NOT NULL,
  `answerA` text NOT NULL,
  `answerB` text NOT NULL,
  `answerC` text NOT NULL,
  `answerD` text NOT NULL,
  `trueanswer` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问卷的内容，即问题' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `eioheight`
--

CREATE TABLE IF NOT EXISTS `eioheight` (
  `app_EIO_height_id` int(11) NOT NULL,
  `app_EIO_height_data` int(11) NOT NULL,
  `app_EIO_height_sex` varchar(1) NOT NULL,
  `app_EIO_height_location` text NOT NULL,
  `app_EIO_height_age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附加表，标准身高';

-- --------------------------------------------------------

--
-- 表的结构 `eioresult`
--

CREATE TABLE IF NOT EXISTS `eioresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eioid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `result` text COLLATE utf8_unicode_ci NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `eiotype`
--

CREATE TABLE IF NOT EXISTS `eiotype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `microblog`
--

CREATE TABLE IF NOT EXISTS `microblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL COMMENT '用户外键',
  `content` text NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='说说表' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `microblog`
--

INSERT INTO `microblog` (`id`, `userid`, `content`, `uptime`) VALUES
(1, 1, 'james 刚刚踩了 james 一脚，成功偷得1积分', '2013-12-03 12:00:24'),
(2, 1, 'james 刚刚踩了 linwei 一脚，成功偷得1积分', '2013-12-03 12:01:22'),
(3, 1, 'james 刚刚踩了 linwei 一脚，成功偷得1积分', '2013-12-03 12:01:30'),
(4, 1, 'james 刚刚踩了 linwei 一脚，成功偷得1积分', '2013-12-03 12:01:44'),
(5, 1, 'james 今日已签到,成功获得1积分', '2013-12-03 12:03:16'),
(6, 1, 'james 今日已签到,成功获得1积分', '2013-12-03 12:03:47'),
(7, 1, 'james 刚刚踩了 linwei 一脚，成功偷得1积分', '2013-12-03 12:04:09'),
(8, 2, '哈哈，哈哈', '2013-12-03 12:43:22'),
(9, 2, '测试linwei', '2013-12-03 12:43:39'),
(10, 3, 'hah', '2013-12-03 12:45:28'),
(11, 1, 'james 今日已签到,成功获得1积分', '2013-12-03 12:50:44'),
(12, 1, 'james 刚刚踩了 james 一脚，成功偷得1积分', '2013-12-03 13:42:05'),
(13, 1, 'james 今日已签到,成功获得1积分', '2013-12-07 07:41:13'),
(14, 1, 'james 刚刚踩了 james 一脚，成功偷得1积分', '2013-12-07 07:41:22');

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromuserid` int(11) NOT NULL,
  `userid` int(11) NOT NULL COMMENT '用户外键',
  `content` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为。。。',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为未读，1为已读',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户通知表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `questionresult`
--

CREATE TABLE IF NOT EXISTS `questionresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eiocontentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问卷问题的回答' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `relationship`
--

CREATE TABLE IF NOT EXISTS `relationship` (
  `userid` int(11) NOT NULL,
  `fansid` int(11) NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='朋友圈关系表';

--
-- 转存表中的数据 `relationship`
--

INSERT INTO `relationship` (`userid`, `fansid`, `uptime`) VALUES
(1, 2, '2013-12-03 12:17:13'),
(2, 1, '2013-12-03 12:17:13'),
(1, 3, '2013-12-03 12:44:14'),
(3, 1, '2013-12-03 12:44:14');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `sign` varchar(100) NOT NULL COMMENT '用户个人说明',
  `face` varchar(100) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为男，0为女',
  `birthday` date NOT NULL,
  `location` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `eiocount` int(11) NOT NULL DEFAULT '0' COMMENT '做过的问卷数',
  `fanscount` int(11) NOT NULL DEFAULT '0' COMMENT '粉丝数',
  `score` int(11) NOT NULL DEFAULT '0',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `pass`, `sign`, `face`, `sex`, `birthday`, `location`, `eiocount`, `fanscount`, `score`, `uptime`) VALUES
(1, 'james', 'james', '', '', 1, '0000-00-00', '', 0, 0, 10, '2013-12-03 11:57:13'),
(2, 'linwei', 'linwei', '', '', 1, '0000-00-00', '', 0, 0, -5, '2013-12-03 12:01:12'),
(3, 'linda', 'linda', '', '', 1, '0000-00-00', '', 0, 0, 0, '2013-12-03 12:43:59');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
