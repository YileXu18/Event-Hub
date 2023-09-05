CREATE TABLE `users` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(64) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `emailAddress` varchar(128) NOT NULL,
  `address` longtext,
  `DOB` date DEFAULT NULL,
  `Bio` varchar(256) DEFAULT NULL,
  `Preference` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userId_UNIQUE` (`userId`),
  UNIQUE KEY `emailAddress_UNIQUE` (`emailAddress`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `event` (
  `eventId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `eventName` varchar(256) NOT NULL,
  `eventLocation` longtext NOT NULL,
  `eventDate` date NOT NULL,
  `eventTime` time NOT NULL,
  `eventDescription` longtext,
  `eventType` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`eventId`),
  UNIQUE KEY `eventId_UNIQUE` (`eventId`),
  KEY `event_post_user_idx` (`userId`),
  CONSTRAINT `event_post_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `report` (
  `reportId` int NOT NULL AUTO_INCREMENT,
  `eventId` int NOT NULL,
  `userId` int NOT NULL,
  `reason` longtext NOT NULL,
  PRIMARY KEY (`reportId`),
  UNIQUE KEY `reportId_UNIQUE` (`reportId`),
  KEY `report_post_user_idx` (`userId`),
  KEY `report_post_event_idx` (`eventId`),
  CONSTRAINT `report_post_event` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`),
  CONSTRAINT `report_post_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `like` (
  `likeId` int NOT NULL AUTO_INCREMENT,
  `eventId` int NOT NULL,
  `userId` int NOT NULL,
  PRIMARY KEY (`likeId`),
  UNIQUE KEY `likeId_UNIQUE` (`likeId`),
  UNIQUE KEY `eventId` (`eventId`,`userId`),
  KEY `like_user_idx` (`userId`),
  KEY `like_event_idx` (`eventId`),
  CONSTRAINT `like_event` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`),
  CONSTRAINT `like_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

