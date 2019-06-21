/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.53 : Database - chat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ly_cos` */

CREATE TABLE `ly_cos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '云存储key编号',
  `region_id` int(11) NOT NULL COMMENT '云存储地域id',
  `app_id` int(11) NOT NULL,
  `secret_id` varchar(50) NOT NULL,
  `secret_key` varchar(50) NOT NULL,
  `bucket_name` varchar(50) NOT NULL COMMENT '存储桶名称',
  `code` char(10) NOT NULL COMMENT '唯一标识码',
  `status` tinyint(1) NOT NULL COMMENT '状态，0禁用，1启用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_cos` */

LOCK TABLES `ly_cos` WRITE;


UNLOCK TABLES;

/*Table structure for table `ly_cos_file` */

CREATE TABLE `ly_cos_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件编号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `name` varchar(200) NOT NULL COMMENT '文件名称',
  `url` varchar(200) NOT NULL COMMENT '文件url',
  `url_md5` char(32) NOT NULL COMMENT 'url_md5',
  `status` tinyint(1) NOT NULL COMMENT '状态，0禁用，1启用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_md5` (`url_md5`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_cos_file` */

LOCK TABLES `ly_cos_file` WRITE;

UNLOCK TABLES;

/*Table structure for table `ly_cos_region` */

CREATE TABLE `ly_cos_region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '地区中文名称',
  `name` varchar(20) NOT NULL COMMENT '地区名称',
  `short_name` char(10) NOT NULL COMMENT '简称',
  `cdn_domain` varchar(100) NOT NULL,
  `xml_domain` varchar(100) NOT NULL,
  `json_domain` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_cos_region` */

LOCK TABLES `ly_cos_region` WRITE;

insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (1,'北京一区（华北）','beijing-1','bj-1','file.myqcloud.com','cos.ap-beijing-1.myqcloud.com','cosbj-1.myqcloud.com',1,1543083141,1543083141);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (2,'北京','ap-beijing','bj','file.myqcloud.com','cos.ap-beijing.myqcloud.com','cosbj.myqcloud.com',1,1543083190,1543083190);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (3,'上海（华东）','ap-shanghai','sh','file.myqcloud.com','cos.ap-shanghai.myqcloud.com','cossh.myqcloud.com',1,1543083249,1543083249);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (4,'广州（华南）','ap-guangzhou','gz','file.myqcloud.com','cos.ap-guangzhou.myqcloud.com','cosgz.myqcloud.com',1,1543083345,1543083345);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (5,'成都（西南）','ap-chengdu','cd','file.myqcloud.com','cos.ap-chengdu.myqcloud.com','coscd.myqcloud.com',1,1543083377,1543083377);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (6,'重庆','ap-chongqing','cq','file.myqcloud.com','cos.ap-chongqing.myqcloud.com','coscq.myqcloud.com',1,1543083448,1543083448);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (7,'新加坡','ap-singapore','sgp','file.myqcloud.com','cos.ap-singapore.myqcloud.com','cossgp.myqcloud.com',1,1543083520,1543083520);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (8,'香港','ap-hongkong','hk','file.myqcloud.com','cos.ap-hongkong.myqcloud.com','coshk.myqcloud.com',1,1543083585,1543083585);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (9,'多伦多','na-toronto','ca','file.myqcloud.com','cos.na-toronto.myqcloud.com','cosca.myqcloud.com',1,1543083656,1543083656);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (10,'法兰克福','eu-frankfurt','ger','file.myqcloud.com','cos.eu-frankfurt.myqcloud.com','cosger.myqcloud.com',1,1543083717,1543083717);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (11,'孟买','ap-mumbai','in','file.myqcloud.com','cos.ap-mumbai.myqcloud.com','cosin.myqcloud.com',1,1543083810,1543083810);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (12,'首尔','ap-seoul','kr','file.myqcloud.com','cos.ap-seoul.myqcloud.com','cos.kr.myqcloud.com',1,1543083864,1543083864);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (13,'硅谷','na-siliconvalley','usa','file.myqcloud.com','cos.na-siliconvalley.myqcloud.com','cos.usa.myqcloud.com',1,1543083907,1543083907);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (14,'弗吉尼亚','na-ashburn','ash','file.myqcloud.com','cos.na-ashburn.myqcloud.com','cosash.myqcloud.com',1,1543083981,1543083981);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (15,'曼谷','ap-bangkok','tk','file.myqcloud.com','cos.ap-bangkok.myqcloud.com','costk.myqcloud.com',1,1543084024,1543084024);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (16,'莫斯科','eu-moscow','ru','file.myqcloud.com','cos.eu-moscow.myqcloud.com','cosru.myqcloud.com',1,1543084060,1543084060);
insert  into `ly_cos_region`(`id`,`title`,`name`,`short_name`,`cdn_domain`,`xml_domain`,`json_domain`,`status`,`create_time`,`update_time`) values (17,'东京','ap-tokyo','jp','file.myqcloud.com','cos.ap-tokyo.myqcloud.com','cosjp.myqcloud.com',1,1543084095,1543084095);

UNLOCK TABLES;

/*Table structure for table `ly_file_extension` */

CREATE TABLE `ly_file_extension` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '可上传的文件类型',
  `extension` varchar(50) NOT NULL COMMENT '文件后缀',
  `status` tinyint(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `extension` (`extension`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_file_extension` */

LOCK TABLES `ly_file_extension` WRITE;

insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (1,'jpg',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (2,'jpeg',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (3,'rar',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (4,'gif',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (5,'zip',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (6,'bmp',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (7,'gz',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (8,'txt',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (9,'png',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (10,'avi',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (11,'mp3',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (12,'mp4',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (13,'pdf',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (14,'doc',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (15,'docx',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (16,'ppt',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (17,'pptx',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (18,'xls',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (19,'xlsx',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (20,'tif',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (21,'tiff',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (22,'3gpp',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (23,'mp2',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (24,'asf',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (25,'ogg',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (26,'rtf',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (27,'csv',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (28,'wps',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (29,'ico',1,0,0);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (30,'js',1,1561105219,1561105219);
insert  into `ly_file_extension`(`id`,`extension`,`status`,`create_time`,`update_time`) values (31,'css',1,1561105230,1561105230);

UNLOCK TABLES;

/*Table structure for table `ly_message` */

CREATE TABLE `ly_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL COMMENT '分类id',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `to_user_id` int(11) NOT NULL COMMENT '目标用户id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '消息内容',
  `uuid` char(32) NOT NULL COMMENT '唯一标识码',
  `status` tinyint(1) NOT NULL COMMENT '状态,0禁用，1启用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  KEY `user_id` (`user_id`),
  KEY `title` (`title`(191))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message` */

LOCK TABLES `ly_message` WRITE;


UNLOCK TABLES;

/*Table structure for table `ly_message_category` */

CREATE TABLE `ly_message_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL,
  `unique_code` char(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_code` (`unique_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_category` */

LOCK TABLES `ly_message_category` WRITE;

insert  into `ly_message_category`(`id`,`title`,`unique_code`,`status`,`create_time`,`update_time`) values (2,'Problem Case','problem_case',1,0,0);
insert  into `ly_message_category`(`id`,`title`,`unique_code`,`status`,`create_time`,`update_time`) values (3,'Digital File','digital_file',1,0,1561107159);

UNLOCK TABLES;

/*Table structure for table `ly_message_file` */

CREATE TABLE `ly_message_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息关联的文件',
  `message_id` int(11) NOT NULL COMMENT '消息id',
  `file_id` int(11) NOT NULL COMMENT '云存储文件id',
  `sort` int(5) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态，0不显示，1显示',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `message_file` (`message_id`,`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_file` */

LOCK TABLES `ly_message_file` WRITE;


UNLOCK TABLES;

/*Table structure for table `ly_message_read` */

CREATE TABLE `ly_message_read` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `message_user_id` (`message_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_read` */

LOCK TABLES `ly_message_read` WRITE;


UNLOCK TABLES;

/*Table structure for table `ly_message_reply` */

CREATE TABLE `ly_message_reply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `message_id` int(11) NOT NULL COMMENT '消息编号',
  `content` text NOT NULL COMMENT '回复内容',
  `uuid` char(32) NOT NULL COMMENT '唯一标识码',
  `status` tinyint(1) NOT NULL COMMENT '状态，0禁用，1启用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_reply` */

LOCK TABLES `ly_message_reply` WRITE;


UNLOCK TABLES;

/*Table structure for table `ly_message_reply_file` */

CREATE TABLE `ly_message_reply_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `reply_id` int(11) NOT NULL COMMENT '消息回复id',
  `file_id` int(11) NOT NULL COMMENT '文件id',
  `sort` int(5) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态，0不显示，1显示',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reply_file_id` (`reply_id`,`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_reply_file` */

LOCK TABLES `ly_message_reply_file` WRITE;


UNLOCK TABLES;

/*Table structure for table `ly_site` */

CREATE TABLE `ly_site` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '网站标题',
  `description` varchar(200) NOT NULL COMMENT '网站描述',
  `thumb` varchar(100) NOT NULL COMMENT '网站略缩图',
  `logo` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL COMMENT '网站标识码',
  `status` tinyint(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_site` */

LOCK TABLES `ly_site` WRITE;

insert  into `ly_site`(`id`,`title`,`description`,`thumb`,`logo`,`icon`,`code`,`status`,`create_time`,`update_time`) values (1,'WoNiu ES','Wo Niu Email System','/upload/20190605/4249c526b1f73d82a3a13e43a47af451.png','/upload/20190605/b0a5b7282911132d260269cd06fb8a46.jpg','/upload/20190605/ffc64d82e25bf8ead734b9a33a169301.ico','woniu_es',1,0,1559719699);

UNLOCK TABLES;

/*Table structure for table `ly_user` */

CREATE TABLE `ly_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `nickname` varchar(100) NOT NULL COMMENT '昵称',
  `avatar` varchar(200) NOT NULL COMMENT '头像',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户类型，0管理员，1用户',
  `status` tinyint(1) NOT NULL COMMENT '状态，0禁止，1启用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_user` */

LOCK TABLES `ly_user` WRITE;

insert  into `ly_user`(`id`,`username`,`password`,`nickname`,`avatar`,`type`,`status`,`create_time`,`update_time`) values (1,'us','$2y$10$jtG4m4q6nGXw9v.DGebsOeotkWKDedhvAQECyn/Bde5Mt8QVmoQe.','us user','/upload/20190605/9f546edbf072c38ae66a4a3aa72dedd5.jpg',1,1,0,1559720459);
insert  into `ly_user`(`id`,`username`,`password`,`nickname`,`avatar`,`type`,`status`,`create_time`,`update_time`) values (2,'liuyi','$2y$10$JIoejddMpT3WlBLrLRh76uRkMlpFr7Jz41o8Nuu65WfudJa64330K','liu yi','/upload/20190605/b56fb7dc95428c3e7ef9889ad16c9b38.jpeg',0,1,1559463188,1559720015);
insert  into `ly_user`(`id`,`username`,`password`,`nickname`,`avatar`,`type`,`status`,`create_time`,`update_time`) values (3,'hk','$2y$10$xlbARFMryUvwIrNAiF192uu2rEFwBSXnuDHujvYL.RTNeeFl5wAM6','hk user','/upload/20190605/da4887ba4181ddad4e7f84c21c53d9bf.jpg',1,1,1559463253,1559720430);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
