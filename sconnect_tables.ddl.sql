CREATE TABLE `sconnect_user` (
  `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `login_pwd` varchar(50) DEFAULT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(25) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(100) DEFAULT 'user',
  PRIMARY KEY (`user_id`),
  FULLTEXT KEY `FIRST_NAME` (`FIRST_NAME`,`LAST_NAME`,`STUDENT_ID`,`CONTACT_EMAIL`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

CREATE TABLE `sconnect_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_posted` datetime DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `price` float(7,2) DEFAULT NULL,
  `seller_user_id` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image_file_name` varchar(1000) DEFAULT NULL,
  `image` longblob,
  `image_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

CREATE TABLE `sconnect_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_posted` datetime DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `seller_user_id` int(11) DEFAULT NULL,
  `comments` text,
  `category` varchar(100) DEFAULT NULL,
  `price` float(7,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

CREATE TABLE `sconnect_item_bid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `buyer_user_id` int(11) DEFAULT NULL,
  `bid_amount` float(5,2) DEFAULT NULL,
  `message_to_seller` text,
  `date_comment_added` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `sconnect_item_bid_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `sconnect_item` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

CREATE TABLE `sconnect_service_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) DEFAULT NULL,
  `buyer_user_id` int(11) DEFAULT NULL,
  `comment` text,
  `date_comment_added` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `sconnect_service_comment_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `sconnect_service` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

CREATE TABLE `sconnect_user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post_type` varchar(100) NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;