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
  KEY `app_secret` (`app_id`,`secret_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_cos` */

LOCK TABLES `ly_cos` WRITE;

insert  into `ly_cos`(`id`,`region_id`,`app_id`,`secret_id`,`secret_key`,`bucket_name`,`code`,`status`,`create_time`,`update_time`) values (1,8,1251279962,'AKIDU9lDeB2GG7reLsAeq9GI9rQ2ndsKE7yH','fQYgw59X24zzxUWcgs4EdF8ixEUU2yuo','hk','tencent',1,1543079134,1559489941);

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_cos_file` */

LOCK TABLES `ly_cos_file` WRITE;

insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (5,1,'501.png','/files/2019/6/3/155955135070501.png','33bc7b64bced1e08cd8e6f37be7277a4',1,1559556095,1559556095);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (6,1,'8186955363.jpg','/files/2019/6/3/1559551385578186955363.jpg','51e60567495dbc0464a57fc1d8067bcb',1,1559556095,1559556095);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (7,1,'48.8.5.zip','/files/2019/6/3/15595579800048.8.5.zip','de87e945c6656fccbe6cc0b4811610db',1,1559557988,1559557988);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (8,1,'7v0.7.3.zip','/files/2019/6/3/1559557989137v0.7.3.zip','dac38464f5b071d3d5882c358ffd53c6',1,1559557988,1559557988);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (17,1,'916111609-cc11468eb78e56c8779ddb04afb9008c.jpg','/files/2019/6/4/155958018174916111609-cc11468eb78e56c8779ddb04afb9008c.jpg','2ab876d8062b6bd32d86e5311ab0e5c0',1,1559581428,1559581428);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (18,1,'30 (1).jpg','/files/2019/6/4/15595801925730 (1).jpg','89f3368b8b040bb36ed960c09c440cfa',1,1559581428,1559581428);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (19,1,'616111609-cc11468eb78e56c8779ddb04afb9008c.jpg','/files/2019/6/4/155958147346616111609-cc11468eb78e56c8779ddb04afb9008c.jpg','d45c678d61e406114c918e2676c0497f',1,1559581478,1559581478);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (20,1,'720170209113459951.jpg','/files/2019/6/4/155958147206720170209113459951.jpg','e189272017537e9531962b1740d33ecb',1,1559581478,1559581478);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (21,1,'001.jpg','/files/2019/6/4/155958279859001.jpg','053c7b0ccdb61048553509489d12f2df',1,1559582803,1559582803);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (22,1,'2596d945123f47.png','/files/2019/6/4/1559582804342596d945123f47.png','b6e5bd951c34e6030a0a32de99506629',1,1559582803,1559582803);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (23,1,'68.8.5.zip','/files/2019/6/4/15596181886468.8.5.zip','05ac91418345327fcfedc3fcb781d5c4',1,1559618214,1559618214);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (24,1,'115595579800048.8.5.zip','/files/2019/6/4/155961819961115595579800048.8.5.zip','da1944378b57ade643bf9a964b43790a',1,1559618214,1559618214);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (25,1,'8cos-js-sdk-v5-master.zip','/files/2019/6/4/1559618271098cos-js-sdk-v5-master.zip','64f5f600a9439e6dbfbca53e9ceeef12',1,1559618269,1559618269);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (26,1,'5plupload-master.zip','/files/2019/6/4/1559618305115plupload-master.zip','06015eb11463b1468e845a8ecdbc86ba',1,1559618306,1559618306);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (27,1,'215595579800048.8.5.zip','/files/2019/6/4/155962028354215595579800048.8.5.zip','b8610db51823384d3d09f051fd9a6b1d',1,1559620281,1559620281);
insert  into `ly_cos_file`(`id`,`user_id`,`name`,`url`,`url_md5`,`status`,`create_time`,`update_time`) values (28,1,'915595579800048.8.5.zip','/files/2019/6/4/155962033497915595579800048.8.5.zip','ad14d2331501fbe9411bf5fe38d41bca',1,1559620332,1559620332);

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
  PRIMARY KEY (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

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

UNLOCK TABLES;

/*Table structure for table `ly_message` */

CREATE TABLE `ly_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `to_user_id` int(11) NOT NULL COMMENT '目标用户id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '消息内容',
  `status` tinyint(1) NOT NULL COMMENT '状态,0禁用，1启用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `title` (`title`(191))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message` */

LOCK TABLES `ly_message` WRITE;

insert  into `ly_message`(`id`,`user_id`,`to_user_id`,`title`,`content`,`status`,`create_time`,`update_time`) values (5,1,3,'注册saD非常','阿斯蒂芬<img src=\"/upload/20190603/f8394e4df6ef9fbff8ce9022d5d1963c.jpeg\" alt=\"undefined\">',1,1559556095,1559618230);
insert  into `ly_message`(`id`,`user_id`,`to_user_id`,`title`,`content`,`status`,`create_time`,`update_time`) values (6,1,3,'快来去订单啦','随便输入些文字内容<img src=\"/upload/20190603/ad46120beaff20e47f279f0529280505.jpg\" alt=\"undefined\">',1,1559557988,1559618225);
insert  into `ly_message`(`id`,`user_id`,`to_user_id`,`title`,`content`,`status`,`create_time`,`update_time`) values (7,1,3,'Case Western Reserve University: One of the nation’s best','Case Western Reserve University: the top-ranked private research university in Ohio and one of the bestin the U.S. Located in Cleveland, Ohio.',1,1559618214,1559618214);
insert  into `ly_message`(`id`,`user_id`,`to_user_id`,`title`,`content`,`status`,`create_time`,`update_time`) values (8,1,3,'CASE Construction Equipment','CASE sells and supports a full line of construction equipment around the world, including backhoeloaders, excavators, wheel loaders, dozers, skid steer loaders, compaction equipment, forklifts, motorgraders and tractor loaders. Through CASE Construction Equipment dealers, customers have access toa true professional partner with world-class equipment and aftermarket support, industry-leading ...',1,1559618268,1559618268);
insert  into `ly_message`(`id`,`user_id`,`to_user_id`,`title`,`content`,`status`,`create_time`,`update_time`) values (9,1,3,'Case IH Agriculture and Farm Equipment','With over 175 years in the field, Case IH is a global leader in agriculture and farm equipment. By teamingwith customers, Case IH offers equipment for producers designed by producers.',1,1559618306,1559618306);
insert  into `ly_message`(`id`,`user_id`,`to_user_id`,`title`,`content`,`status`,`create_time`,`update_time`) values (10,1,3,'asdf','asdfxcvzv<img src=\"/upload/20190604/7b279f1369f7e7741368278c720ed9a5.jpg\" alt=\"undefined\">',1,1559620281,1559620281);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_file` */

LOCK TABLES `ly_message_file` WRITE;

insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (3,5,5,5,1,1559556095,1559556095);
insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (4,5,6,6,1,1559556095,1559556095);
insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (5,6,7,7,1,1559557988,1559557988);
insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (6,6,8,8,1,1559557989,1559557989);
insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (7,7,23,23,1,1559618214,1559618214);
insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (8,7,24,24,1,1559618214,1559618214);
insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (9,8,25,25,1,1559618269,1559618269);
insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (10,9,26,26,1,1559618306,1559618306);
insert  into `ly_message_file`(`id`,`message_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (11,10,27,27,1,1559620281,1559620281);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_read` */

LOCK TABLES `ly_message_read` WRITE;

insert  into `ly_message_read`(`id`,`message_id`,`user_id`,`status`,`create_time`,`update_time`) values (8,10,1,1,1559639579,1559639579);
insert  into `ly_message_read`(`id`,`message_id`,`user_id`,`status`,`create_time`,`update_time`) values (9,9,1,1,1559639593,1559639593);
insert  into `ly_message_read`(`id`,`message_id`,`user_id`,`status`,`create_time`,`update_time`) values (10,8,1,1,1559639905,1559639905);
insert  into `ly_message_read`(`id`,`message_id`,`user_id`,`status`,`create_time`,`update_time`) values (11,5,1,1,1559641577,1559641577);
insert  into `ly_message_read`(`id`,`message_id`,`user_id`,`status`,`create_time`,`update_time`) values (12,6,1,1,1559641649,1559641649);
insert  into `ly_message_read`(`id`,`message_id`,`user_id`,`status`,`create_time`,`update_time`) values (13,7,1,1,1559642294,1559642294);

UNLOCK TABLES;

/*Table structure for table `ly_message_reply` */

CREATE TABLE `ly_message_reply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `message_id` int(11) NOT NULL COMMENT '消息编号',
  `content` text NOT NULL COMMENT '回复内容',
  `status` tinyint(1) NOT NULL COMMENT '状态，0禁用，1启用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_reply` */

LOCK TABLES `ly_message_reply` WRITE;

insert  into `ly_message_reply`(`id`,`user_id`,`message_id`,`content`,`status`,`create_time`,`update_time`) values (7,1,5,'asdfasf&nbsp;&nbsp;<img src=\"/upload/20190604/ad19e9939bcd15127d785a07556c868c.jpg\" alt=\"undefined\">',1,1559581428,1559581428);
insert  into `ly_message_reply`(`id`,`user_id`,`message_id`,`content`,`status`,`create_time`,`update_time`) values (8,1,5,'我还是想了解下，这个是干什么用的<img src=\"/upload/20190604/d66b9a1f687a3fc057bf221b439973a0.jpg\" alt=\"undefined\">',1,1559581478,1559581478);
insert  into `ly_message_reply`(`id`,`user_id`,`message_id`,`content`,`status`,`create_time`,`update_time`) values (9,1,5,'<p>这是第三次回复</p><p>再看看吧<img src=\"/upload/20190604/3bb04f8ea22c95b12547360c187f9473.jpg\" alt=\"undefined\"></p>',1,1559582803,1559582803);
insert  into `ly_message_reply`(`id`,`user_id`,`message_id`,`content`,`status`,`create_time`,`update_time`) values (10,1,10,'<p>asdffasdfvasd</p><p>ojasdfjklasd</p><p><br></p>',1,1559620332,1559620332);

UNLOCK TABLES;

/*Table structure for table `ly_message_reply_file` */

CREATE TABLE `ly_message_reply_file` (
  `id` int(11) DEFAULT NULL,
  `reply_id` int(11) DEFAULT NULL COMMENT '消息回复id',
  `file_id` int(11) DEFAULT NULL COMMENT '文件id',
  `sort` int(5) DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态，0不显示，1显示',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ly_message_reply_file` */

LOCK TABLES `ly_message_reply_file` WRITE;

insert  into `ly_message_reply_file`(`id`,`reply_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (NULL,7,17,17,1,1559581428,1559581428);
insert  into `ly_message_reply_file`(`id`,`reply_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (NULL,7,18,18,1,1559581428,1559581428);
insert  into `ly_message_reply_file`(`id`,`reply_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (NULL,8,19,19,1,1559581478,1559581478);
insert  into `ly_message_reply_file`(`id`,`reply_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (NULL,8,20,20,1,1559581478,1559581478);
insert  into `ly_message_reply_file`(`id`,`reply_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (NULL,9,21,21,1,1559582803,1559582803);
insert  into `ly_message_reply_file`(`id`,`reply_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (NULL,9,22,22,1,1559582803,1559582803);
insert  into `ly_message_reply_file`(`id`,`reply_id`,`file_id`,`sort`,`status`,`create_time`,`update_time`) values (NULL,10,28,28,1,1559620332,1559620332);

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

insert  into `ly_site`(`id`,`title`,`description`,`thumb`,`logo`,`icon`,`code`,`status`,`create_time`,`update_time`) values (1,'WoNiu ES','WoNiu Email System','/upload/20190602/ebad9bf5cb779e0801f9dd900d5ea23b.png','/upload/20190602/bb22123c0b3eacfbb9266a338693181f.jpg','/upload/20190602/59f0b8c7bdc85607b8c6bce78c337ded.ico','woniu_es',1,0,1559454649);

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

insert  into `ly_user`(`id`,`username`,`password`,`nickname`,`avatar`,`type`,`status`,`create_time`,`update_time`) values (1,'us','$2y$10$jtG4m4q6nGXw9v.DGebsOeotkWKDedhvAQECyn/Bde5Mt8QVmoQe.','us user','/upload/20190602/243d485a2f2bdc166d65416ec0f09552.jpg',1,1,0,1559528792);
insert  into `ly_user`(`id`,`username`,`password`,`nickname`,`avatar`,`type`,`status`,`create_time`,`update_time`) values (2,'liuyi','$2y$10$Yx4OgDBrSTRIgogCVYHOB.ACnYS0Q.7yvGzBHWhQwlvZWSiI2JTYe','liu yi','/upload/20190602/94dce04daf11306c7fc281c331ec11a9.jpeg',0,1,1559463188,1559528835);
insert  into `ly_user`(`id`,`username`,`password`,`nickname`,`avatar`,`type`,`status`,`create_time`,`update_time`) values (3,'hk','$2y$10$xlbARFMryUvwIrNAiF192uu2rEFwBSXnuDHujvYL.RTNeeFl5wAM6','hk user','/upload/20190602/aed771e3c11deafac15933a483aada85.jpg',1,1,1559463253,1559526802);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
