
DROP TABLE IF EXISTS `affiliates`;
CREATE TABLE `affiliates` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `constants`;
CREATE TABLE `constants` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `value` text NOT NULL,
    `order` tinyint(3) unsigned NOT NULL,
    `status` tinyint(3) unsigned NOT NULL DEFAULT 1,
    `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name_order` (`name`, `order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `email_logs`;
CREATE TABLE `email_logs` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL DEFAULT 0,
    `data` text NOT NULL,
    `message` text NOT NULL,
    `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_logs`;
CREATE TABLE `user_logs` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL DEFAULT 0,
    `ip` char(15) DEFAULT NULL,
    `country_code` char(2) DEFAULT NULL,
    `state` varchar(32) DEFAULT NULL,
    `city` varchar(32) DEFAULT NULL,
    `post_code` varchar(8) DEFAULT NULL,
    `latitude` DECIMAL(10, 8) NOT NULL DEFAULT 0.00000000,
    `longitude` DECIMAL(11, 8) NOT NULL DEFAULT 0.00000000,
    `accuracy_radius` int(11) unsigned NOT NULL DEFAULT 0,
    `controller` varchar(32) NOT NULL DEFAULT '',
    `method` varchar(32) NOT NULL DEFAULT '',
    `url_parameters` varchar(255) NOT NULL DEFAULT '',
    `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_add_date` (`user_id`, `add_date`),
    KEY `ip_add_date` (`ip`, `add_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `controller` varchar(25) NOT NULL,
    `message` varchar(255) NOT NULL,
    `added` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
    `data` blob NOT NULL,
    KEY `cc_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_email_verifications`;
CREATE TABLE `user_email_verifications` (
    `user_id` int(11) unsigned NOT NULL,
    `email` varchar(96) NOT NULL,
    `verify_code` varchar(32) NOT NULL DEFAULT '',
    `status` tinyint(3) unsigned NOT NULL DEFAULT 1,
    `add_date` datetime NOT NULL,
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `verify_code` (`verify_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_login_verifications`;
CREATE TABLE `user_login_verifications` (
    `code` varchar(32) NOT NULL DEFAULT '',
    `parameters` varchar(255) NOT NULL DEFAULT '',
    `status` tinyint(3) unsigned NOT NULL DEFAULT 1,
    `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_password_reset`;
CREATE TABLE `user_password_reset` (
    `user_id` int(11) unsigned NOT NULL,
    `verify_code` varchar(32) NOT NULL DEFAULT '',
    `status` tinyint(3) unsigned NOT NULL DEFAULT 0,
    `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_facebook_link`;
CREATE TABLE `user_facebook_link` (
    `user_id` int(11) unsigned NOT NULL,
    `id` varchar(20) NOT NULL,
    `email` varchar(100) NOT NULL DEFAULT '',
    `name` varchar(60) NOT NULL DEFAULT '',
    `first_name` varchar(30) NOT NULL DEFAULT '',
    `last_name` varchar(30) NOT NULL DEFAULT '',
    `gender` varchar(10) NOT NULL DEFAULT '',
    `link` varchar(100) NOT NULL DEFAULT '',
    `locale` varchar(10) NOT NULL DEFAULT '',
    `timezone` tinyint(3) unsigned NOT NULL DEFAULT 0,
    `verified` char(1) NOT NULL DEFAULT '',
    `access_token` varchar(99) NOT NULL DEFAULT '',
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `facebook_user_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_instagram_link`;
CREATE TABLE `user_instagram_link` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `instagram_user_id` bigint(20) unsigned NOT NULL,
    `username` varchar(100) NOT NULL DEFAULT '',
    `bio` text NOT NULL,
    `website` varchar(255) NOT NULL DEFAULT '',
    `profile_picture` varchar(255) NOT NULL DEFAULT '',
    `full_name` varchar(100) NOT NULL DEFAULT '',
    `access_token` varchar(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_id` (`user_id`),
    UNIQUE KEY `instagram_user_id` (`instagram_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_twitter_link`;
CREATE TABLE `user_twitter_link` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `oauth_token` varchar(99) NOT NULL,
    `oauth_token_secret` varchar(99) NOT NULL,
    `twitter_user_id` varchar(20) NOT NULL,
    `twitter_screen_name` varchar(50) NOT NULL,
    `profile_image_url` varchar(150) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `email` varchar(96) NOT NULL DEFAULT '',
    `password` char(32) NOT NULL DEFAULT '',
    `first_name` varchar(48) NOT NULL DEFAULT '',
    `last_name` varchar(32) NOT NULL DEFAULT '',
    `nick_name` varchar(16) NOT NULL DEFAULT '',
    `image` varchar(255) NOT NULL DEFAULT '',
    `gender` char(1) NOT NULL DEFAULT '',
    `type` tinyint(3) unsigned NOT NULL DEFAULT 0,
    `status` tinyint(3) unsigned NOT NULL DEFAULT 0,
    `spam` tinyint(3) unsigned NOT NULL DEFAULT 0,
    `affiliate_id` int(11) unsigned NOT NULL DEFAULT 0,
    `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
    `last_login_date` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_email` (`email`),
    KEY `user_add_date` (`add_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users` VALUES(NULL, 'me@mydomain.com', '', '', '', '', '', '', 1, 2, 1, 0, NULL, NULL);
UPDATE `users` SET `password` = md5('XXXXXXXXXX') WHERE `email` = 'me@mydomain.com';

DROP TABLE IF EXISTS `user_attributes`;
CREATE TABLE `user_attributes` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) unsigned NOT NULL,
    `name` varchar(255) NOT NULL,
    `value` varchar(255) NOT NULL DEFAULT '',
    `status` tinyint(3) unsigned NOT NULL DEFAULT 1,
    `add_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user` (`user_id`, `name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
