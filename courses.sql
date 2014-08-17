-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.32 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              7.0.0.4315
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for таблица gbua_ad_courses.article
DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `short` varchar(50) DEFAULT NULL,
  `content` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `published` datetime NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `ord` tinyint(4) DEFAULT NULL,
  `level` enum('beginner','advansed') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_article_product` (`product_id`),
  CONSTRAINT `FK_article_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.article: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` (`id`, `alias`, `title`, `short`, `content`, `product_id`, `created`, `updated`, `published`, `author_id`, `ord`, `level`) VALUES
	(1, 'sd', 'ffsd', 'sd', '<p>sd</p>', 13, '2014-07-16 00:00:00', '2014-07-27 21:56:22', '2014-07-27 10:55:00', NULL, NULL, NULL),
	(2, 'my_first_article', 'My first article', 'used to be a fact that native mobile applications ', '<p>oday we&rsquo;re all aware, at least we should be, that the mobile market is significant when developing anything for the web.</p>\r\n<p>For years there has been discussion and differing points of view about native applications versus web applications and on which is the best. Regardless of your opinion, it used to be a fact that native mobile applications allowed to access hardware components that web pages couldn&rsquo;t. But is this gap still valid today? Have web technologies improved to the point where we, as developers, can code with just HTML, CSS, and JavaScript?</p>', 12, '2014-07-28 22:25:01', '2014-07-28 22:25:01', '2014-07-23 10:50:00', NULL, NULL, NULL),
	(3, 'my_second_article', 'My second article', 'This API also defines events that can be fired', '<p>he <a href="http://www.w3.org/TR/battery-status/" target="_blank">Battery Status API</a> provides information about the system&rsquo;s battery level or status. Thanks to this API you are able to know if the battery is charging or not, how long before the battery will be fully discharged, or simply its current level. These details are accessible through four properties that all belong to the <code>window.navigator.battery</code> object. This API also defines events that can be fired when there are changes in the mentioned properties.</p>', 12, '2014-07-28 22:25:55', '2014-07-28 22:25:55', '2014-07-30 07:25:00', NULL, NULL, NULL),
	(4, 'my_third-article', 'my third article', 'hem. This means that we’ll see different styles on', '<p>On mobile devices we&rsquo;re familiar with the concept of notifications, they are implemented by many apps that we have installed on our devices. On the web, websites implement them in different ways. Think of Google+ and Twitter, they both have a notification mechanism but the implementations are different.</p>\r\n<p>The <a href="http://www.w3.org/TR/notifications/" target="_blank">Web Notifications API</a> is an API created with this aim, to standardize the way developers notify users. A notification allows alerting a user outside the context of a web page of an event, such as the delivery of email. While the way developers can create a notification is the same, the specifications don&rsquo;t describe how and where a UI should display them. This means that we&rsquo;ll see different styles on different browsers. For example on mobile devices we may see them in the notifications bar.</p>', 14, '2014-07-28 22:26:49', '2014-07-28 22:50:08', '2014-07-09 11:05:00', NULL, NULL, NULL);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.article_tags
DROP TABLE IF EXISTS `article_tags`;
CREATE TABLE IF NOT EXISTS `article_tags` (
  `article_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  UNIQUE KEY `article_id_tag_id` (`article_id`,`tag_id`),
  KEY `FK_arttags_tag_id` (`tag_id`),
  CONSTRAINT `FK_arttags_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_arttags_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.article_tags: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `article_tags` DISABLE KEYS */;
INSERT INTO `article_tags` (`article_id`, `tag_id`) VALUES
	(1, 4),
	(1, 6),
	(2, 2),
	(2, 7),
	(3, 2),
	(3, 8),
	(4, 2),
	(4, 8);
/*!40000 ALTER TABLE `article_tags` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.course
DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `picture` varchar(32) DEFAULT NULL,
  `thumb` varchar(32) DEFAULT NULL,
  `ico` varchar(32) DEFAULT NULL,
  `ord` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_course_product` (`product_id`),
  CONSTRAINT `FK_course_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.course: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` (`id`, `alias`, `title`, `product_id`, `created`, `updated`, `active`, `picture`, `thumb`, `ico`, `ord`) VALUES
	(4, 'dasd', 'sadas', 12, '2014-07-20 17:25:24', '2014-07-20 17:25:24', 1, '', '', '', NULL);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.product
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `scope_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `picture` varchar(32) DEFAULT NULL,
  `thumb` varchar(32) DEFAULT NULL,
  `ico` varchar(32) DEFAULT NULL,
  `style` varchar(32) DEFAULT NULL,
  `ord` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_scope` (`scope_id`),
  CONSTRAINT `FK_product_scope` FOREIGN KEY (`scope_id`) REFERENCES `scope` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.product: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `alias`, `title`, `scope_id`, `created`, `updated`, `active`, `picture`, `thumb`, `ico`, `style`, `ord`) VALUES
	(12, 'javascript', 'Javascript', 50, '2014-07-20 14:19:14', '2014-07-28 23:03:00', 1, '12.png', '12.png', '12.png', NULL, NULL),
	(13, 'css', 'CSS', 50, '2014-07-20 14:30:45', '2014-07-20 14:30:45', 1, '13.png', '13.png', '13.png', NULL, NULL),
	(14, 'php', 'PHP', 50, '2014-07-20 14:33:13', '2014-07-20 14:33:13', 1, '14.png', '14.png', '14.png', NULL, NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.scope
DROP TABLE IF EXISTS `scope`;
CREATE TABLE IF NOT EXISTS `scope` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `picture` varchar(32) DEFAULT NULL,
  `thumb` varchar(32) DEFAULT NULL,
  `ico` varchar(32) DEFAULT NULL,
  `ord` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='scope of activity';

-- Дамп данных таблицы gbua_ad_courses.scope: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `scope` DISABLE KEYS */;
INSERT INTO `scope` (`id`, `alias`, `title`, `created`, `updated`, `active`, `picture`, `thumb`, `ico`, `ord`) VALUES
	(50, 'programming', 'Программирование', '2014-07-20 14:10:14', '2014-07-20 14:10:14', 1, '50.jpg', '50.jpg', '50.jpg', NULL),
	(51, 'design', 'Дизайн', '2014-07-20 14:11:53', '2014-07-20 14:12:14', 0, '51.jpg', '51.jpg', '51.jpg', NULL);
/*!40000 ALTER TABLE `scope` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.seo
DROP TABLE IF EXISTS `seo`;
CREATE TABLE IF NOT EXISTS `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `keyword` varchar(50) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.seo: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
INSERT INTO `seo` (`id`, `rule`, `title`, `keyword`, `desc`, `created`, `updated`, `active`) VALUES
	(1, '/courses/php/dfdf', 'ыыыыыы', 'фффффф', 'аааааа ллллллл', '2014-07-28 23:40:27', '2014-07-28 23:40:27', 1);
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.settings
DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.settings: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `name`, `value`) VALUES
	(1, 'google_api_key', 'AIzaSyAzyijfdT8wWJfOhUTBzhW29_NkRbNn0Gs');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.tag
DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.tag: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` (`id`, `alias`, `name`) VALUES
	(1, 'first', 'первый'),
	(2, 'jquery', 'jquery'),
	(3, 'games', 'игры'),
	(4, 'test', 'test'),
	(6, 'seven', 'seven'),
	(7, 'course', 'course'),
	(8, 'autocad', 'autocad');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `avatar` varchar(250) DEFAULT NULL,
  `type` enum('author','user','admin') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.user: ~22 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`, `email`, `created`, `updated`, `active`, `avatar`, `type`) VALUES
	(1, 'test1z', 'pass1', 'test1@example.com', NULL, NULL, 1, NULL, NULL),
	(2, 'test2', 'pass2', 'test2@example.com', NULL, NULL, 1, NULL, NULL),
	(3, 'test3', 'pass3', 'test3@example.com', NULL, NULL, 1, NULL, NULL),
	(4, 'test4', 'pass4', 'test4@example.com', NULL, NULL, 1, NULL, NULL),
	(5, 'test5', 'pass5', 'test5@example.com', NULL, NULL, 1, NULL, NULL),
	(6, 'test6', 'pass6', 'test6@example.com', NULL, NULL, 1, NULL, NULL),
	(7, 'test7', 'pass7', 'test7@example.com', NULL, NULL, 1, NULL, NULL),
	(8, 'test8', 'pass8', 'test8@example.com', NULL, NULL, 1, NULL, NULL),
	(9, 'test9', 'pass9', 'test9@example.com', NULL, NULL, 1, NULL, NULL),
	(10, 'test10', 'pass10', 'test10@example.com', NULL, NULL, 1, NULL, NULL),
	(11, 'test11', 'pass11', 'test11@example.com', NULL, NULL, 1, NULL, NULL),
	(12, 'test12', 'pass12', 'test12@example.com', NULL, NULL, 1, NULL, NULL),
	(13, 'test13', 'pass13', 'test13@example.com', NULL, NULL, 1, NULL, NULL),
	(14, 'test14', 'pass14', 'test14@example.com', NULL, NULL, 1, NULL, NULL),
	(15, 'test15', 'pass15', 'test15@example.com', NULL, NULL, 1, NULL, NULL),
	(16, 'test16', 'pass16', 'test16@example.com', NULL, NULL, 1, NULL, NULL),
	(17, 'test17', 'pass17', 'test17@example.com', NULL, NULL, 1, NULL, NULL),
	(18, 'test18', 'pass18', 'test18@example.com', NULL, NULL, 1, NULL, NULL),
	(19, 'test19', 'pass19', 'test19@example.com', NULL, NULL, 1, NULL, NULL),
	(20, 'test20', 'pass20', 'test20@example.com', NULL, NULL, 1, NULL, NULL),
	(21, 'test21', 'pass21', 'test21@example.com', NULL, NULL, 1, NULL, NULL),
	(22, 'admin', 'admin', 'sdad', '2014-07-12 17:13:08', '2014-07-12 17:13:08', 1, NULL, NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for таблица gbua_ad_courses.video
DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `link` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `desc` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `ico` varchar(200) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `ord` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `FK_video_article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gbua_ad_courses.video: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
INSERT INTO `video` (`id`, `article_id`, `link`, `alias`, `title`, `desc`, `created`, `updated`, `picture`, `thumb`, `ico`, `active`, `ord`) VALUES
	(24, 1, 'https://www.youtube.com/watch?v=VTqk3jDEh4Q', 'VTqk3jDEh4Q', 'Ножи Skif для туризма', 'Видеообзор туристических ножей Skif с нескладным клинком. Модели Skif FB-001 Агрессор, FB-002 Касатка, FB-003 Гепард....', '2014-07-20 17:27:58', '2014-07-20 17:27:58', 'https://i.ytimg.com/vi/VTqk3jDEh4Q/hqdefault.jpg', 'https://i.ytimg.com/vi/VTqk3jDEh4Q/mqdefault.jpg', 'https://i.ytimg.com/vi/VTqk3jDEh4Q/default.jpg', 1, 0),
	(25, 1, 'https://www.youtube.com/watch?v=PsJWEaWB32o', 'PsJWEaWB32o', 'Полный обзор HTC One от Droider.ru', 'Еще видео и обзоры на: http://Droider.ru http://Facebook.com/Droider http://VK.com/Droider_ru http://Twitter.com/Droider_ru В новом выпуске Обзоров без ...', '2014-07-20 17:29:04', '2014-07-20 17:29:04', 'https://i.ytimg.com/vi/PsJWEaWB32o/hqdefault.jpg', 'https://i.ytimg.com/vi/PsJWEaWB32o/mqdefault.jpg', 'https://i.ytimg.com/vi/PsJWEaWB32o/default.jpg', 1, 1),
	(26, 1, 'https://www.youtube.com/watch?v=GCjIbnxECzo', 'GCjIbnxECzo', 'Обзор Surface Pro 3', 'Купить Microsoft Surface Pro 3: http://www.up-house.ru/brands/microsoft Полный обзор Microsoft Surface Pro 3 http://youtube.com/rozetked При копировании ...', '2014-07-20 17:29:04', '2014-07-20 17:29:04', 'https://i.ytimg.com/vi/GCjIbnxECzo/hqdefault.jpg', 'https://i.ytimg.com/vi/GCjIbnxECzo/mqdefault.jpg', 'https://i.ytimg.com/vi/GCjIbnxECzo/default.jpg', 1, 2),
	(27, 1, 'https://www.youtube.com/watch?v=gsvDlR0YWBk', 'gsvDlR0YWBk', 'Закарпатец расказал всю правду о "хунтовский" Родине, России и Европе. 13 минут!', 'Житель Закарпатья за 13 минут просто и по-человечески поделился своим мнением о происходящем в Закарпатье, России и Крыму. Человек рассказал, ...', '2014-07-20 17:29:05', '2014-07-20 17:29:42', 'https://i.ytimg.com/vi/gsvDlR0YWBk/hqdefault.jpg', 'https://i.ytimg.com/vi/gsvDlR0YWBk/mqdefault.jpg', 'https://i.ytimg.com/vi/gsvDlR0YWBk/default.jpg', 1, 3),
	(28, 1, 'https://www.youtube.com/watch?v=qYCBjwBqYJ0', 'qYCBjwBqYJ0', 'Обзор HTC One mini 2', 'Обзор HTC One mini 2. Второе поколение компактного (по меркам HTC) смартфона поступает в продажу. Здесь увеличили размер экрана, поставили ...', '2014-07-20 17:29:05', '2014-07-20 17:29:05', 'https://i.ytimg.com/vi/qYCBjwBqYJ0/hqdefault.jpg', 'https://i.ytimg.com/vi/qYCBjwBqYJ0/mqdefault.jpg', 'https://i.ytimg.com/vi/qYCBjwBqYJ0/default.jpg', 1, 4);
/*!40000 ALTER TABLE `video` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
