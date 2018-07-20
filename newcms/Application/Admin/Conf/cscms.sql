/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : cms_www_domain5_com

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-06-20 17:09:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for c_admin
-- ----------------------------
DROP TABLE IF EXISTS `c_admin`;
CREATE TABLE `c_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '管理员名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `create_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  `state` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1启用 0禁用',
  `group_id` int(11) unsigned NOT NULL DEFAULT '2' COMMENT '（这个项目没有权限管理做准备）管理员权限等级1为超级管理员 2为普通管理员',
  `image` varchar(255) NOT NULL COMMENT '头像',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_admin
-- ----------------------------
INSERT INTO `c_admin` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1448851902', '1', '1', '/Public/Admin/images/logo.jpg');
INSERT INTO `c_admin` VALUES ('2', 'admin1', 'e10adc3949ba59abbe56e057f20f883e', '1418851902', '1', '2', '/Public/Admin/images/logo.jpg');
INSERT INTO `c_admin` VALUES ('5', 'admin6', 'e10adc3949ba59abbe56e057f20f883e', '1469000383', '1', '2', '/Public/Uploads/Adminbum/2016-07-20/578f2abf16aae.jpg');

-- ----------------------------
-- Table structure for c_admin_nav
-- ----------------------------
DROP TABLE IF EXISTS `c_admin_nav`;
CREATE TABLE `c_admin_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '左侧菜单ID',
  `pid` int(11) unsigned NOT NULL COMMENT '菜单的父ID',
  `name` varchar(255) NOT NULL COMMENT '菜单名',
  `url` varchar(255) NOT NULL COMMENT '菜单链接',
  `ico` varchar(255) NOT NULL COMMENT '菜单图标',
  `order_number` int(11) unsigned NOT NULL COMMENT '排序',
  `child_number` int(11) unsigned DEFAULT '0' COMMENT '子类数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_admin_nav
-- ----------------------------
INSERT INTO `c_admin_nav` VALUES ('1', '0', '管理员管理', 'Admin/ShowNav/auth', 'Hui-iconfont-root', '1', '3');
INSERT INTO `c_admin_nav` VALUES ('4', '0', '系统设置', 'Admin/ShowNav/config', 'Hui-iconfont-system', '6', '2');
INSERT INTO `c_admin_nav` VALUES ('5', '4', '后台菜单管理', 'Admin/Nav/nav_index', '', '1', '0');
INSERT INTO `c_admin_nav` VALUES ('6', '1', '权限管理', 'Admin/Auth/admin_rule', '', '2', '0');
INSERT INTO `c_admin_nav` VALUES ('7', '1', '账户管理', 'Admin/Auth/admin_list', '', '3', '0');
INSERT INTO `c_admin_nav` VALUES ('8', '1', '角色管理', 'Admin/Auth/admin_group', '', '1', '0');
INSERT INTO `c_admin_nav` VALUES ('14', '0', '分类列表', 'Admin/Category/category_index', 'Hui-iconfont-face-mogui', '3', '0');
INSERT INTO `c_admin_nav` VALUES ('16', '0', '视频子页面域名', 'Admin/Domain/domain_index', 'Hui-iconfont-log', '5', '0');
INSERT INTO `c_admin_nav` VALUES ('17', '0', '内容模块', 'Admin/content/content_index', 'Hui-iconfont-save', '2', '0');
INSERT INTO `c_admin_nav` VALUES ('18', '4', '基本信息', 'Admin/Baseinfo/base_index', '', '2', '0');

-- ----------------------------
-- Table structure for c_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `c_auth_group`;
CREATE TABLE `c_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(100) NOT NULL COMMENT '用户组中文名称',
  `status` tinyint(1) unsigned NOT NULL COMMENT '为1正常，为0禁用',
  `rules` text COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `create_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_auth_group
-- ----------------------------
INSERT INTO `c_auth_group` VALUES ('1', '超级管理员', '1', '', '1464075673');
INSERT INTO `c_auth_group` VALUES ('2', '普通管理员', '1', '1,2,3,4,8,10,9,21,5,11,13,12,17,18,20,19,22,23,6,7,14,16,15', '1464075673');

-- ----------------------------
-- Table structure for c_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `c_auth_group_access`;
CREATE TABLE `c_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`uid`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_auth_group_access
-- ----------------------------
INSERT INTO `c_auth_group_access` VALUES ('1', '1');
INSERT INTO `c_auth_group_access` VALUES ('3', '2');
INSERT INTO `c_auth_group_access` VALUES ('6', '2');

-- ----------------------------
-- Table structure for c_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `c_auth_rule`;
CREATE TABLE `c_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pid` mediumint(8) unsigned NOT NULL COMMENT '父ID',
  `name` char(80) NOT NULL COMMENT '规则唯一标识',
  `title` char(20) NOT NULL COMMENT '规则中文名称',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '为1正常，为0禁用',
  `condition` char(100) NOT NULL COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `order_number` int(11) unsigned NOT NULL COMMENT '排序',
  `child_number` int(11) unsigned DEFAULT '0' COMMENT '子类数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_auth_rule
-- ----------------------------
INSERT INTO `c_auth_rule` VALUES ('1', '0', '小说1', '后台首页', '1', '1', '', '50', '1');
INSERT INTO `c_auth_rule` VALUES ('2', '1', 'Admin/Index/welcome', '欢迎界面', '1', '1', '', '1', '0');
INSERT INTO `c_auth_rule` VALUES ('3', '0', 'Admin/ShowNav/auth', '管理员管理', '1', '1', '', '2', '3');
INSERT INTO `c_auth_rule` VALUES ('4', '3', 'Admin/Auth/admin_group', '角色管理', '1', '1', '', '1', '4');
INSERT INTO `c_auth_rule` VALUES ('5', '3', 'Admin/Auth/admin_rule', '权限管理', '1', '1', '', '2', '3');
INSERT INTO `c_auth_rule` VALUES ('6', '0', 'Admin/ShowNav/config', '系统设置', '1', '1', '', '4', '1');
INSERT INTO `c_auth_rule` VALUES ('7', '6', 'Admin/Nav/nav_index', '后台菜单管理', '1', '1', '', '1', '3');
INSERT INTO `c_auth_rule` VALUES ('8', '4', 'Admin/Auth/admin_group_add', '添加角色', '1', '1', '', '1', '0');
INSERT INTO `c_auth_rule` VALUES ('9', '4', 'Admin/Auth/admin_group_upload', '修改角色', '1', '1', '', '3', '0');
INSERT INTO `c_auth_rule` VALUES ('10', '4', 'Admin/Auth/admin_group_delete', '删除角色', '1', '1', '', '2', '0');
INSERT INTO `c_auth_rule` VALUES ('11', '5', 'Admin/Auth/admin_rule_add', '添加权限', '1', '1', '', '1', '0');
INSERT INTO `c_auth_rule` VALUES ('12', '5', 'Admin/Auth/admin_rule_upload', '修改权限', '1', '1', '', '3', '0');
INSERT INTO `c_auth_rule` VALUES ('13', '5', 'Admin/Auth/admin_rule_delete', '删除权限', '1', '1', '', '2', '0');
INSERT INTO `c_auth_rule` VALUES ('14', '7', 'Admin/Nav/nav_add', '添加菜单', '1', '1', '', '1', '0');
INSERT INTO `c_auth_rule` VALUES ('15', '7', 'Admin/Nav/nav_upload', '修改菜单', '1', '1', '', '3', '0');
INSERT INTO `c_auth_rule` VALUES ('16', '7', 'Admin/Nav/nav_delete', '删除菜单', '1', '1', '', '2', '0');
INSERT INTO `c_auth_rule` VALUES ('17', '3', 'Admin/Auth/admin_list', '账户管理', '1', '1', '', '3', '3');
INSERT INTO `c_auth_rule` VALUES ('18', '17', 'Admin/Auth/admin_add', '添加账户', '1', '1', '', '1', '0');
INSERT INTO `c_auth_rule` VALUES ('19', '17', 'Admin/Auth/admin_upload', '修改账户', '1', '1', '', '3', '0');
INSERT INTO `c_auth_rule` VALUES ('20', '17', 'Admin/Auth/admin_delete', '删除账户', '1', '1', '', '2', '0');
INSERT INTO `c_auth_rule` VALUES ('21', '4', 'Admin/Auth/admin_rule_group', '配置权限', '1', '1', '', '4', '0');
INSERT INTO `c_auth_rule` VALUES ('22', '0', 'Admin/ShowNav/user', '用户管理', '1', '1', '', '3', '1');
INSERT INTO `c_auth_rule` VALUES ('23', '22', 'Admin/User/user_index', '用户列表', '1', '1', '', '1', '1');
INSERT INTO `c_auth_rule` VALUES ('24', '23', 'Admin/User/user_upload', '修改用户', '1', '1', '', '3', '0');

-- ----------------------------
-- Table structure for c_baseinfo
-- ----------------------------
DROP TABLE IF EXISTS `c_baseinfo`;
CREATE TABLE `c_baseinfo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '基本配置',
  `domain` varchar(100) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '标题',
  `keywords` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '关键词',
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '描述',
  `pc_color` char(50) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT 'pc端主颜色',
  `mv_color` char(50) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '移动端主颜色',
  `login_num` int(10) DEFAULT NULL COMMENT '登录次数',
  `now_ip` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '本次登录ip',
  `last_ip` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '上次登录ip',
  `now_time` datetime DEFAULT NULL,
  `last_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_baseinfo
-- ----------------------------
INSERT INTO `c_baseinfo` VALUES ('1', 'www.domain5.com', '1211211', '12112111', '11112111112', null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for c_category
-- ----------------------------
DROP TABLE IF EXISTS `c_category`;
CREATE TABLE `c_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类表',
  `pid` int(10) DEFAULT '0' COMMENT '默认为0（顶级）',
  `name` varchar(100) NOT NULL COMMENT '分类名称',
  `order_number` int(10) DEFAULT '50',
  `num` int(10) DEFAULT '0' COMMENT '子类个数',
  `createtime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_category
-- ----------------------------
INSERT INTO `c_category` VALUES ('1', '0', '小说', '51', '1', '1525686978');
INSERT INTO `c_category` VALUES ('2', '0', '视频', '52', '1', '1528774962');
INSERT INTO `c_category` VALUES ('3', '0', '图片', '50', '1', '1529050045');
INSERT INTO `c_category` VALUES ('12', '2', '视频12', '50', '0', '1528774979');
INSERT INTO `c_category` VALUES ('21', '3', '图片1', '50', '0', '1525687303');
INSERT INTO `c_category` VALUES ('30', '1', '小说11', '50', '0', '1525687303');
-- ----------------------------
-- Table structure for c_content
-- ----------------------------
DROP TABLE IF EXISTS `c_content`;
CREATE TABLE `c_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '视频表',
  `source` varchar(255) NOT NULL COMMENT '来源',
  `cid` int(11) DEFAULT '0' COMMENT '分类id',
  `pid` int(11) DEFAULT NULL COMMENT '大分类id',
  `title` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '视频标题',
  `keywords` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `cover` text CHARACTER SET utf8 COMMENT '视频封面',
  `content` text CHARACTER SET utf8 COMMENT '视频链接',
  `sort` int(10) DEFAULT '50' COMMENT '排序，越大越靠前',
  `create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
-- ----------------------------
-- Table structure for c_domain
-- ----------------------------
DROP TABLE IF EXISTS `c_domain`;
CREATE TABLE `c_domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '域名表',
  `domain` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '域名',
  `state` enum('1','0') DEFAULT '1' COMMENT '域名状态 0被封 1未被封',
  `create_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c_manage
-- ----------------------------
DROP TABLE IF EXISTS `c_manage`;
CREATE TABLE `c_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '加密密码',
  `head_img` varchar(100) DEFAULT NULL COMMENT '管理员头像',
  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态 1启用 0禁用',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_manage
-- ----------------------------
INSERT INTO `c_manage` VALUES ('1', 'admin', '160725d55ad283aa400af464c76d713c07ad', '19293261a1acc53.jpeg', '1', '1477301169', '1512984743');