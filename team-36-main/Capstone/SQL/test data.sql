INSERT INTO `users` (`userId`,`firstName`,`lastName`,`phoneNumber`,`emailAddress`,`address`,`DOB`,`Bio`,`Preference`,`password`) VALUES (1,'T1','Test1','1111111111','test1@gamil.com','test1','1980-01-01','test1','basketball,football,watch movie',NULL);
INSERT INTO `users` (`userId`,`firstName`,`lastName`,`phoneNumber`,`emailAddress`,`address`,`DOB`,`Bio`,`Preference`,`password`) VALUES (2,'T2','Test2','2222222222','test2@gamil.com','test2','1980-02-02','test2','football,guitar',NULL);
INSERT INTO `users` (`userId`,`firstName`,`lastName`,`phoneNumber`,`emailAddress`,`address`,`DOB`,`Bio`,`Preference`,`password`) VALUES (3,'T3','Test3','3333333333','test3@gamil.com','test3','1980-03-03','test3','basketball,tennis,guitar',NULL);
INSERT INTO `users` (`userId`,`firstName`,`lastName`,`phoneNumber`,`emailAddress`,`address`,`DOB`,`Bio`,`Preference`,`password`) VALUES (4,'T4','Test4','4444444444','test4@gamil.com','test4','1980-04-04','test4','piano,badminton,draw',NULL);
INSERT INTO `users` (`userId`,`firstName`,`lastName`,`phoneNumber`,`emailAddress`,`address`,`DOB`,`Bio`,`Preference`,`password`) VALUES (5,'T5','Test5','5555555555','test5@163.com','test5','1980-05-05','test5','dance, singing, drawl','78302615C8B79CAC8DF6D2607F8A83EE');
INSERT INTO `users` (`userId`,`firstName`,`lastName`,`phoneNumber`,`emailAddress`,`address`,`DOB`,`Bio`,`Preference`,`password`) VALUES (6,'T6','Test6','6666666666','test6@outlook.com','test6','1980-06-06','test6','basketball, singing','49D556807993F993A5E974E741F67215');


INSERT INTO `event ` (`eventId`,`userId`,`eventName`,`eventLocation`,`eventDate`,`eventTime`,`eventDescription`,`eventType`) VALUES (1,1,'play basketball','NYU Gymnasium','2022-02-01','09:00:00','play basketball','basketball');
INSERT INTO `event` (`eventId`,`userId`,`eventName`,`eventLocation`,`eventDate`,`eventTime`,`eventDescription`,`eventType`) VALUES (2,2,'Guitar Club','Columbia University School of the Arts','2022-02-02','14:00:00','Exchange tips on playing guitar','guitar');
INSERT INTO `event` (`eventId`,`userId`,`eventName`,`eventLocation`,`eventDate`,`eventTime`,`eventDescription`,`eventType`) VALUES (3,5,'music party','Tom\'s Manor','2022-03-03','10:00:00','singing','singing');


INSERT INTO `report` (`reportId`,`eventId`,`userId`,`reason`) VALUES (1,1,3,'test 111');
INSERT INTO `report` (`reportId`,`eventId`,`userId`,`reason`) VALUES (2,1,6,'test 222');
INSERT INTO `report` (`reportId`,`eventId`,`userId`,`reason`) VALUES (3,2,4,'test 333');
INSERT INTO `report` (`reportId`,`eventId`,`userId`,`reason`) VALUES (4,3,5,'test 444');
INSERT INTO `report` (`reportId`,`eventId`,`userId`,`reason`) VALUES (5,2,6,'test 555');


INSERT INTO `like` (`likeId`,`eventId`,`userId`) VALUES (1,1,3);
INSERT INTO `like` (`likeId`,`eventId`,`userId`) VALUES (2,1,6);
INSERT INTO `like` (`likeId`,`eventId`,`userId`) VALUES (3,2,3);
INSERT INTO `like` (`likeId`,`eventId`,`userId`) VALUES (4,2,5);
INSERT INTO `like` (`likeId`,`eventId`,`userId`) VALUES (5,3,2);
INSERT INTO `like` (`likeId`,`eventId`,`userId`) VALUES (6,3,5);
INSERT INTO `like` (`likeId`,`eventId`,`userId`) VALUES (7,3,6);


INSERT INTO `attend` (`attendId`,`eventId`,`userId`) VALUES (1,1,1);
INSERT INTO `attend` (`attendId`,`eventId`,`userId`) VALUES (4,1,3);
INSERT INTO `attend` (`attendId`,`eventId`,`userId`) VALUES (5,1,6);
INSERT INTO `attend` (`attendId`,`eventId`,`userId`) VALUES (2,2,2);
INSERT INTO `attend` (`attendId`,`eventId`,`userId`) VALUES (6,2,3);
INSERT INTO `attend` (`attendId`,`eventId`,`userId`) VALUES (3,3,5);
INSERT INTO `attend` (`attendId`,`eventId`,`userId`) VALUES (7,3,6);
