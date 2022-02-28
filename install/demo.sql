/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2020-08-31 16:23:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_admin
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin`;
CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `nickname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '昵称',
  `loginNum` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `lastLoginTime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最后一次登录时间',
  `lastAddress` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '上次登录地址',
  `nowLoginTime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '此次登录时间',
  `nowAddress` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '此次登录地点',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员表';

-- ----------------------------
-- Records of tb_admin
-- ----------------------------

-- ----------------------------
-- Table structure for tb_config
-- ----------------------------
DROP TABLE IF EXISTS `tb_config`;
CREATE TABLE `tb_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `webName` longtext COLLATE utf8_unicode_ci COMMENT '网站名称',
  `webKeywords` longtext COLLATE utf8_unicode_ci COMMENT '网站首页关键字',
  `webDescription` longtext COLLATE utf8_unicode_ci COMMENT '网站首页描述',
  `webLogo` longtext COLLATE utf8_unicode_ci COMMENT '网站LOGO地址',
  `webCopyright` longtext COLLATE utf8_unicode_ci COMMENT '网站底部版权信息',
  `isShowPf` int(11) DEFAULT NULL COMMENT '是否右侧漂浮 0NO 1YES',
  `ShowPfColor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '漂浮背景颜色',
  `isSetImg` int(11) DEFAULT NULL COMMENT '默认是否开启生成缩略图 0NO 1YES',
  `otherCode` longtext COLLATE utf8_unicode_ci COMMENT '第三方的代码',
  `editorBase` longtext COLLATE utf8_unicode_ci COMMENT '编辑器根路径',
  `editorImgExt` longtext COLLATE utf8_unicode_ci COMMENT '辑器编图片允许的后缀',
  `editorLinkExt` longtext COLLATE utf8_unicode_ci COMMENT '附件允许的后缀',
  `editorMaxSize` int(11) DEFAULT NULL COMMENT '辑器编允许上传文件的最大大小 单位K 例如500K',
  `isWaterMark` int(11) DEFAULT NULL COMMENT '图片水印是否启用 1YES 0NO',
  `waterMarkWidth` int(11) DEFAULT NULL COMMENT '启用水印的条件 最小宽度',
  `waterMarkHeight` int(11) DEFAULT NULL COMMENT '启用水印的条件 最小高度',
  `waterMarkPosition` int(11) DEFAULT NULL COMMENT '图片水印位置',
  `waterMarkMarginW` int(11) DEFAULT NULL COMMENT '图片水印边距 左右',
  `waterMarkMarginH` int(11) DEFAULT NULL COMMENT '图片水印边距 上下',
  `waterMarkPath` longtext COLLATE utf8_unicode_ci COMMENT '图片水印路径',
  `tel` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '联系电话',
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址',
  `ewm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '二维码',
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置表';

-- ----------------------------
-- Records of tb_config
-- ----------------------------
INSERT INTO `tb_config` VALUES ('1', '成都三以网络', '', '', 'Upload/2019-08-26/1613177767_AUTO.png', '<p>Copyright ©2019 成都华佗微纳智能传感科技有限公司 .All rights reserved &nbsp; &nbsp;蜀ICP备111111111号 &nbsp;网站建设：<a href=\"http://www.3eee.cn\" target=\"_blank\">成都三以网络</a></p>', '0', 'BF1919', '1', '', '/module2/', 'jpg|gif|png', 'rar|doc', '2', '0', '400', '300', '9', '5', '5', 'Upload/2013-08-26/1421269743.png', '', '', '', '');

-- ----------------------------
-- Table structure for tb_float
-- ----------------------------
DROP TABLE IF EXISTS `tb_float`;
CREATE TABLE `tb_float` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '题标',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '代码',
  `type` int(11) DEFAULT NULL COMMENT '类型 0别类 1QQ 2邮箱 3Msn 4Skype 5电话',
  `serialNum` int(11) DEFAULT NULL COMMENT ' 序号',
  PRIMARY KEY (`id`),
  KEY `serialNum` (`serialNum`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='浮动窗口表';

-- ----------------------------
-- Records of tb_float
-- ----------------------------
INSERT INTO `tb_float` VALUES ('1', '客服QQ', '', '0', '1');
INSERT INTO `tb_float` VALUES ('2', '客服一', '1234567', '1', '2');
INSERT INTO `tb_float` VALUES ('3', '客服二', '1234567', '1', '3');
INSERT INTO `tb_float` VALUES ('4', '客服三', '1234567', '1', '4');
INSERT INTO `tb_float` VALUES ('5', '', '028-88888888', '5', '6');
INSERT INTO `tb_float` VALUES ('6', '', '13800000000', '5', '7');
INSERT INTO `tb_float` VALUES ('7', '咨询热线', '', '0', '5');

-- ----------------------------
-- Table structure for tb_guestbook
-- ----------------------------
DROP TABLE IF EXISTS `tb_guestbook`;
CREATE TABLE `tb_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `subject` varchar(255) DEFAULT NULL COMMENT '留言主题',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `tel` varchar(255) DEFAULT NULL COMMENT '联系电话',
  `email` varchar(255) DEFAULT NULL COMMENT 'EMAIL',
  `content` longtext COMMENT '留言内容',
  `repaly` longtext COMMENT '回复内容',
  `isSh` int(11) DEFAULT NULL COMMENT '否是审核 0NO 1YES',
  `ip` varchar(255) DEFAULT NULL COMMENT '留言者IP',
  `addTime` datetime DEFAULT NULL COMMENT '留言时间',
  PRIMARY KEY (`id`),
  KEY `isSh` (`isSh`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言表';

-- ----------------------------
-- Records of tb_guestbook
-- ----------------------------

-- ----------------------------
-- Table structure for tb_link
-- ----------------------------
DROP TABLE IF EXISTS `tb_link`;
CREATE TABLE `tb_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编码',
  `sort` int(11) DEFAULT NULL COMMENT '类别',
  `serialNum` int(11) DEFAULT NULL COMMENT '序号',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `picture` longtext COMMENT '图片',
  `icon` varchar(255) DEFAULT NULL,
  `jianjie` longtext,
  `link` longtext,
  `rootId` int(11) DEFAULT NULL,
  `content` longtext,
  `newsid` int(11) DEFAULT '0' COMMENT '相册id  对应news的id',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `serialNum` (`serialNum`),
  KEY `sortserialNum` (`sort`,`serialNum`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='链接表';

-- ----------------------------
-- Records of tb_link
-- ----------------------------
INSERT INTO `tb_link` VALUES ('1', '1', '1', 'test', 'Upload/2019-08-26/1634105759_AUTO.jpg', null, null, '', '1', null, '0');
INSERT INTO `tb_link` VALUES ('2', '1', '2', 'test', 'Upload/2019-08-26/1634105759_AUTO.jpg', null, null, '', '1', null, '0');
INSERT INTO `tb_link` VALUES ('3', '1', '3', 'test', 'Upload/2019-08-26/1634105759_AUTO.jpg', null, null, '', '1', null, '0');
INSERT INTO `tb_link` VALUES ('4', '1', '4', 'test', 'Upload/2019-08-26/1634105759_AUTO.jpg', null, null, '', '1', null, '0');
INSERT INTO `tb_link` VALUES ('5', '1', '5', 'test', 'Upload/2019-08-26/1634105759_AUTO.jpg', null, null, '', '1', null, '0');

-- ----------------------------
-- Table structure for tb_linksort
-- ----------------------------
DROP TABLE IF EXISTS `tb_linksort`;
CREATE TABLE `tb_linksort` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `pid` int(11) DEFAULT NULL COMMENT '父类ID',
  `sortName` varchar(255) DEFAULT NULL COMMENT '类别名称',
  `serialNum` int(11) DEFAULT NULL COMMENT '序号',
  `xiangceId` int(11) DEFAULT NULL,
  `rootId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `serialNum` (`serialNum`),
  KEY `pidserialNum` (`pid`,`serialNum`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='链接类别表';

-- ----------------------------
-- Records of tb_linksort
-- ----------------------------
INSERT INTO `tb_linksort` VALUES ('1', '0', '首页幻灯', '1', null, null);
INSERT INTO `tb_linksort` VALUES ('2', '0', '内页幻灯', '2', null, null);

-- ----------------------------
-- Table structure for tb_member
-- ----------------------------
DROP TABLE IF EXISTS `tb_member`;
CREATE TABLE `tb_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL COMMENT '户名用',
  `password` varchar(32) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(50) DEFAULT NULL COMMENT '称昵',
  `loginNum` int(11) DEFAULT NULL COMMENT '录登次数',
  `lastLoginTime` datetime DEFAULT NULL COMMENT '最后一次登录时间',
  `fsdf` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of tb_member
-- ----------------------------

-- ----------------------------
-- Table structure for tb_news
-- ----------------------------
DROP TABLE IF EXISTS `tb_news`;
CREATE TABLE `tb_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编码',
  `sort` int(11) DEFAULT NULL COMMENT '类别',
  `serialNum` int(11) DEFAULT NULL COMMENT '序号',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `picture` longtext COMMENT '图片',
  `addTime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `status` int(11) DEFAULT '0',
  `rootId` int(11) DEFAULT NULL,
  `seotitle` longtext,
  `keywords` longtext,
  `description` longtext,
  `jianjie` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `serialNum` (`serialNum`),
  KEY `sortserialNum` (`sort`,`serialNum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻表';

-- ----------------------------
-- Records of tb_news
-- ----------------------------

-- ----------------------------
-- Table structure for tb_newssort
-- ----------------------------
DROP TABLE IF EXISTS `tb_newssort`;
CREATE TABLE `tb_newssort` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `pid` int(11) DEFAULT NULL COMMENT '父类ID',
  `sortName` varchar(255) DEFAULT NULL COMMENT '类别名称',
  `serialNum` int(11) DEFAULT NULL COMMENT '序号',
  `rootId` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `serialNum` (`serialNum`),
  KEY `pid` (`pid`),
  KEY `pidserialNum` (`pid`,`serialNum`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='新闻类别表';

-- ----------------------------
-- Records of tb_newssort
-- ----------------------------
INSERT INTO `tb_newssort` VALUES ('3', '0', '公司简介', '3', '0');

-- ----------------------------
-- Table structure for tb_onepage
-- ----------------------------
DROP TABLE IF EXISTS `tb_onepage`;
CREATE TABLE `tb_onepage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `bbb` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单页表';

-- ----------------------------
-- Records of tb_onepage
-- ----------------------------
