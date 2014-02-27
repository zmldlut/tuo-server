-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2014 年 02 月 27 日 05:53
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
-- 表的结构 `eio`
--

CREATE TABLE IF NOT EXISTS `eio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL DEFAULT '1' COMMENT '问卷问题类型，默认为选择题',
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
(1, 1, 1, '', '测试问卷1', 'linwei', 3, 'levelA', 'levelB', 'levelC', 'levelD', 25, 7, 8, '2013-12-08 12:54:07', '2014-01-26 07:12:33'),
(2, 1, 2, '', 'test2', '1', 0, '1', '2', '3', '4', 0, 0, 2, NULL, '2013-12-08 04:35:09');

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
-- 表的结构 `eiocomment`
--

CREATE TABLE IF NOT EXISTS `eiocomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eioid` int(11) NOT NULL COMMENT '问卷外键',
  `userid` int(11) NOT NULL COMMENT '用户外键',
  `content` text NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户对于问卷的评论' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `eiocomment`
--

INSERT INTO `eiocomment` (`id`, `eioid`, `userid`, `content`, `uptime`) VALUES
(1, 1, 1, 'henhao', '2013-12-08 06:46:07'),
(2, 1, 1, '', '2013-12-10 07:44:21'),
(3, 1, 1, '', '2013-12-11 06:53:43'),
(4, 1, 1, '不好', '2014-02-26 10:25:45'),
(5, 1, 1, '后', '2014-02-26 11:58:51');

-- --------------------------------------------------------

--
-- 表的结构 `eiocontent`
--

CREATE TABLE IF NOT EXISTS `eiocontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eioid` int(11) NOT NULL COMMENT '所属的问卷id',
  `questionnum` int(11) NOT NULL,
  `question` text NOT NULL,
  `answerA` text NOT NULL,
  `answerB` text NOT NULL,
  `answerC` text NOT NULL,
  `answerD` text NOT NULL,
  `answerE` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `trueanswer` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='问卷的内容，即问题' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `eiocontent`
--

INSERT INTO `eiocontent` (`id`, `eioid`, `questionnum`, `question`, `answerA`, `answerB`, `answerC`, `answerD`, `answerE`, `trueanswer`) VALUES
(1, 1, 4, '你的年龄多大？', '10-20', '20-30', '30-40', '40-50', '', '1'),
(2, 1, 5, '对于此问卷是否满意？', '很满意', '满意', '一般', '不满意', '很不满意', '2'),
(3, 1, 3, '你使用该产品的频率是？', '每天', '每周', '每月', '', '', '1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `eioresult`
--

INSERT INTO `eioresult` (`id`, `eioid`, `userid`, `result`, `uptime`) VALUES
(1, 1, 1, '{"1":"2","2":"1"}#2#', '2014-01-25 13:28:18'),
(2, 1, 1, '{"1":"2","2":"1"}#2#', '2014-01-25 13:28:22'),
(3, 1, 1, '{"1":"1","2":"2","3":"1"}#3#levelA', '2014-01-26 07:11:47'),
(4, 1, 1, '{"1":"1","2":"2","3":"1"}#3#levelA', '2014-01-26 07:17:01'),
(5, 1, 1, '{"1":"1","2":"2","3":"1"}#3#levelA', '2014-01-26 07:34:52'),
(6, 1, 1, '{"1":"1","2":"2","3":"1"}#3#levelA', '2014-02-26 10:00:53'),
(7, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:20'),
(8, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:23'),
(9, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:23'),
(10, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:23'),
(11, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:24'),
(12, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:24'),
(13, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:24'),
(14, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:25'),
(15, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:25'),
(16, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:25'),
(17, 1, 1, '{1:1,2:2,3:1}#0#levelD', '2014-02-26 10:01:25'),
(18, 1, 1, '{1:"1",2:"2",3:"1"}#0#levelD', '2014-02-26 10:01:36'),
(19, 1, 1, '{"1":"1","2":"2","3":"1"}#3#levelA', '2014-02-26 10:01:50'),
(20, 1, 1, '{"2":"0","1":"1","0":"0"}#1#levelC', '2014-02-26 10:18:52'),
(21, 1, 1, '{"3":"1","2":"2","1":"1"}#3#levelA', '2014-02-26 10:24:36'),
(22, 1, 1, '{"3":"0","2":"0","1":"0"}#0#levelD', '2014-02-26 10:25:25'),
(23, 1, 1, '{"3":"0","2":"0","1":"0"}#0#levelD', '2014-02-26 10:31:37'),
(24, 1, 1, '{"3":"0","2":"0","1":"0"}#0#levelD', '2014-02-26 11:58:40'),
(25, 1, 1, '{"3":"-1","2":"-1","1":"-1"}#0#levelD', '2014-02-26 12:48:56'),
(26, 1, 1, '{"3":"0","2":"2","1":"1"}#2#levelB', '2014-02-26 14:17:01'),
(27, 1, 1, '{"3":"1","2":"2","1":"1"}#3#levelA', '2014-02-26 14:17:30');

-- --------------------------------------------------------

--
-- 表的结构 `eiotype`
--

CREATE TABLE IF NOT EXISTS `eiotype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `eiotype`
--

INSERT INTO `eiotype` (`id`, `typename`, `uptime`) VALUES
(1, 'SimpleSelectQuestion', '2013-12-08 06:07:03'),
(2, 'InputQuestion', '2013-12-08 06:07:03'),
(3, 'MultiSelectQuestion', '2013-12-08 06:07:11');

-- --------------------------------------------------------

--
-- 表的结构 `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `feedback`
--

INSERT INTO `feedback` (`id`, `userid`, `username`, `content`, `uptime`) VALUES
(1, 1, 'james', 'Hello_world!', '2013-12-28 06:31:16'),
(2, 1, 'james', 'zmldlut', '2013-12-28 06:41:18'),
(3, 1, 'james', 'zmldlut', '2013-12-28 06:41:39'),
(4, 1, 'james', 'zmldlut', '2013-12-28 06:45:05'),
(5, 1, 'james', 'asdfasdf', '2013-12-28 13:49:17'),
(6, 1, 'james', 'dhgjfghj', '2014-01-04 10:26:25'),
(7, 1, 'james', 'Hello_world!', '2014-01-18 03:52:22'),
(8, 1, 'james', '哈哈', '2014-01-18 03:54:26'),
(9, 1, 'james', '哈哈', '2014-01-18 04:00:39'),
(10, 1, 'james', '', '2014-01-18 14:05:56');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='说说表' AUTO_INCREMENT=79 ;

--
-- 转存表中的数据 `microblog`
--

INSERT INTO `microblog` (`id`, `userid`, `content`, `uptime`) VALUES
(4, 1, 'james 刚刚踩了 linwei 一脚，成功偷得1积分', '2013-12-03 12:01:44'),
(6, 1, 'james 今日已签到,成功获得1积分', '2013-12-03 12:03:47'),
(11, 1, 'james 今日已签到,成功获得1积分', '2013-12-03 12:50:44'),
(12, 1, 'james 刚刚踩了 james 一脚，成功偷得1积分', '2013-12-03 13:42:05'),
(13, 1, 'james 今日已签到,成功获得1积分', '2013-12-07 07:41:13'),
(14, 1, 'james 刚刚踩了 james 一脚，成功偷得1积分', '2013-12-07 07:41:22'),
(15, 1, 'james 踩了test1', '2013-12-09 02:28:16'),
(16, 1, 'james 赞了test1', '2013-12-09 02:28:26'),
(18, 1, 'james 踩了test1调查问卷', '2013-12-10 07:44:31'),
(19, 1, 'james 赞了test1调查问卷！', '2013-12-10 07:44:35'),
(20, 1, 'james 今日已签到,成功获得1积分', '2013-12-10 07:45:48'),
(24, 1, 'james 今日已签到,成功获得1积分', '2013-12-30 02:24:33'),
(25, 3, 'linda 今日已签到,成功获得1积分', '2013-12-30 02:27:21'),
(34, 2, 'linwei 今日已签到,成功获得1积分', '2014-01-06 02:55:31'),
(47, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了3积分！', '2014-01-26 07:17:01'),
(48, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了3积分！', '2014-01-26 07:34:52'),
(49, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了3积分！', '2014-02-26 10:00:53'),
(50, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:20'),
(51, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:23'),
(52, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:23'),
(53, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:23'),
(54, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:24'),
(55, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:24'),
(56, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:24'),
(57, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:25'),
(58, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:25'),
(59, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:25'),
(60, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:25'),
(61, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:01:36'),
(62, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了3积分！', '2014-02-26 10:01:50'),
(63, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了1积分！', '2014-02-26 10:18:52'),
(64, 1, 'james 赞了测试问卷1调查问卷！', '2014-02-26 10:19:53'),
(65, 1, 'james 踩了测试问卷1调查问卷', '2014-02-26 10:19:59'),
(66, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了3积分！', '2014-02-26 10:24:36'),
(67, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:25:25'),
(68, 1, '不好', '2014-02-26 10:25:45'),
(69, 1, 'james 赞了测试问卷1调查问卷！', '2014-02-26 10:28:04'),
(70, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 10:31:37'),
(71, 1, 'james 赞了测试问卷1调查问卷！', '2014-02-26 10:31:53'),
(72, 1, 'james 踩了测试问卷1调查问卷', '2014-02-26 10:31:58'),
(73, 1, 'james 赞了测试问卷1调查问卷！', '2014-02-26 10:32:02'),
(74, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 11:58:39'),
(75, 1, '后', '2014-02-26 11:58:51'),
(76, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了0积分！', '2014-02-26 12:48:56'),
(77, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了2积分！', '2014-02-26 14:17:00'),
(78, 1, 'james 刚刚做了问卷 测试问卷1 ，赢得了3积分！', '2014-02-26 14:17:30');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户通知表' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `notice`
--

INSERT INTO `notice` (`id`, `fromuserid`, `userid`, `content`, `type`, `status`, `uptime`) VALUES
(1, 1, 2, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2013-12-30 13:20:38'),
(2, 1, 2, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2013-12-30 03:22:56'),
(3, 1, 2, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2013-12-30 03:37:31'),
(4, 1, 3, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2013-12-30 03:37:45'),
(5, 1, 2, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2013-12-30 03:39:03'),
(6, 1, 3, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2013-12-30 03:39:08'),
(7, 2, 1, 'linwei 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2013-12-30 06:53:56'),
(8, 1, 2, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2013-12-31 02:29:21'),
(9, 1, 2, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2014-01-06 02:41:24'),
(10, 2, 1, 'linwei 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2014-01-06 02:48:50'),
(11, 1, 2, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2014-01-06 02:49:28'),
(12, 1, 3, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2014-01-06 02:49:32'),
(13, 1, 2, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2014-01-18 14:04:56'),
(14, 1, 3, 'james 刚刚踩了你一脚，成功偷得1积分！', 1, 0, '2014-01-18 14:05:27');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `pass`, `sign`, `face`, `sex`, `birthday`, `location`, `eiocount`, `fanscount`, `score`, `uptime`) VALUES
(1, 'james', 'james', 'james', '', 0, '2013-12-04', 'huashengdun', 0, 0, 65, '2014-01-04 10:26:14'),
(2, 'linwei', 'linwei', '', '', 1, '0000-00-00', '', 0, 0, -1, '2013-12-03 12:01:12'),
(3, 'linda', 'linda', '', '', 1, '0000-00-00', '', 0, 0, -3, '2013-12-03 12:43:59'),
(4, 'zmldlut', '19901028', 'a', 'a', 1, '1992-01-01', 'a', 0, 0, 1, '2013-12-12 08:54:34');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
