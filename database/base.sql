DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `permission` WRITE;
INSERT INTO `permission` VALUES (9,'auth/changePassword'),(6,'auth/confirmRegistration'),(11,'auth/confirmSelfDelete'),(8,'auth/forgotPassword'),(3,'auth/login'),(4,'auth/logout'),(5,'auth/register'),(7,'auth/resendRegisterMail'),(10,'auth/selfDelete'),(1,'home'),(13,'role/create'),(16,'role/delete'),(15,'role/edit'),(12,'role/list'),(14,'role/show'),(2,'sitemap'),(20,'user/delete'),(19,'user/edit'),(17,'user/list'),(18,'user/show');
UNLOCK TABLES;

DROP TABLE IF EXISTS `register_token`;
CREATE TABLE `register_token` (
  `user_id` int(11) NOT NULL,
  `token` varchar(52) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `password_token`;
CREATE TABLE `password_token` (
  `user_id` int(11) NOT NULL,
  `token` varchar(52) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `role` WRITE;
INSERT INTO `role` VALUES (1,'Guest'),(2,'User'),(3,'Moderator'),(4,'Admin');
UNLOCK TABLES;

DROP TABLE IF EXISTS `role_parent_role`;
CREATE TABLE `role_parent_role` (
  `role_id` int(11) NOT NULL,
  `parent_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `role_parent_role` WRITE;
INSERT INTO `role_parent_role` VALUES (2,1),(3,2),(4,3);
UNLOCK TABLES;

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `role_permission` WRITE;
INSERT INTO `role_permission` VALUES (1,1),(1,2),(1,3),(1,5),(2,4),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(4,12),(4,13),(4,14),(4,15),(4,16),(4,17),(4,18),(4,19),(4,20);
UNLOCK TABLES;

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` varchar(52) NOT NULL,
  `identity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session_identity_idx` (`identity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
