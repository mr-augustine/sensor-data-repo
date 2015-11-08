/* Create the ha_lab4db database and supporting tables */
DROP DATABASE if EXISTS ha_lab4db;
CREATE DATABASE ha_lab4db;
USE ha_lab4db;

DROP TABLE if EXISTS Users;
CREATE TABLE Users (
  userId             int(11) NOT NULL AUTO_INCREMENT,
  email              varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  password           varchar(255) COLLATE utf8_unicode_ci,
  date_created       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS UserData;
CREATE TABLE UserData (
  userDataId		 int(11) NOT NULL AUTO_INCREMENT,
  userId			 int(11) NOT NULL COLLATE utf8_unicode_ci,
  user_name			 varchar(30) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  skill_level		 varchar(30) NOT NULL COLLATE utf8_unicode_ci,
  profile_pic		 varchar(255) COLLATE utf8_unicode_ci,
  started_hobby 	 DATE,
  date_created		 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fav_color		 	 char(7) NOT NULL COLLATE utf8_unicode_ci,
  url				 varchar(255) COLLATE utf8_unicode_ci,
  phone				 varchar(255) COLLATE utf8_unicode_ci,
  PRIMARY KEY (userDataId),
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS Skills;
CREATE TABLE Skills (
  skillId			 int(3) NOT NULL AUTO_INCREMENT,
  skill_name		 varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  PRIMARY KEY (skillId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS SkillAssocs;
CREATE TABLE SkillAssocs (
  skillAssocId		 int(11) NOT NULL AUTO_INCREMENT,
  skillId			 int(3) NOT NULL,
  userDataId		 int(11) NOT NULL,
  PRIMARY KEY (skillAssocId),
  FOREIGN KEY (skillId) REFERENCES Skills(skillId),
  FOREIGN KEY (userDataId) REFERENCES UserData(userDataId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS RobotData;
CREATE TABLE RobotData (
  robotId		 	 int(11) NOT NULL AUTO_INCREMENT,
  robot_name		 varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  status			 varchar(30) NOT NULL COLLATE utf8_unicode_ci,
  PRIMARY KEY (robotId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS RobotAssocs;
CREATE TABLE RobotAssocs (
  robotAssocId		 int(11) NOT NULL AUTO_INCREMENT,
  robotId			 int(11) NOT NULL,
  creatorId			 int(11) NOT NULL,
  PRIMARY KEY (robotAssocId),
  FOREIGN KEY (robotId) REFERENCES RobotData(robotId),
  FOREIGN KEY (creatorId) REFERENCES UserData(userDataId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO Skills (skillId, skill_name) VALUES
	(1, 'system-design');
INSERT INTO Skills (skillId, skill_name) VALUES
	(2, 'programming');
INSERT INTO Skills (skillId, skill_name) VALUES
	(3, 'machining');
INSERT INTO Skills (skillId, skill_name) VALUES
	(4, 'soldering');
INSERT INTO Skills (skillId, skill_name) VALUES
	(5, 'wiring');
INSERT INTO Skills (skillId, skill_name) VALUES
	(6, 'circuit-design');
INSERT INTO Skills (skillId, skill_name) VALUES
	(7, 'power-systems');
INSERT INTO Skills (skillId, skill_name) VALUES
	(8, 'computer-vision');
INSERT INTO Skills (skillId, skill_name) VALUES
	(9, 'ultrasonic');
INSERT INTO Skills (skillId, skill_name) VALUES
	(10, 'infrared');
INSERT INTO Skills (skillId, skill_name) VALUES
	(11, 'GPS');
INSERT INTO Skills (skillId, skill_name) VALUES
	(12, 'compass');


INSERT INTO Users (userId, email, password) VALUES 
	   (1, 'bjabituya@yahoo.com', 'wwwwwwww');
INSERT INTO Users (userId, email, password) VALUES 
	   (2, 'mwatney@mars.com', 'aaaaaaaa');
INSERT INTO Users (userId, email, password) VALUES 
	   (3, 'ryan.stone@iss.gov', 'bbbbbbbb');
INSERT INTO Users (userId, email, password) VALUES 
	   (4, 'jcoop@tps.gov', 'cccccccc');
INSERT INTO Users (userId, email, password) VALUES 
	   (5, 'liz.shaw@lv223.com', 'dddddddd');
INSERT INTO Users (userId, email, password) VALUES 
	   (6, 'charlie.g@hotmail.com', 'xxxxxxxx');
INSERT INTO Users (userId, email, password) VALUES 
	   (7, 'altars@gmail.com', 'yyyyyyyy');
INSERT INTO Users (userId, email, password) VALUES 
	   (8, 'asuda@kenbishi.jp', 'zzzzzzzz');


INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(1, 1, 'jabituya', 'advanced', 'none.jpg', '2015-10-17 07:38:46', '#008000', 'http://www.google.com', '210-555-9090');
INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(2, 2, 'mwatney', 'novice', 'none.jpg', '2015-10-26 12:00:00', '#ff8000', 'http://www.strandedonmars.com', '210-555-9090');
INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(3, 3, 'ryan.stone', 'novice', 'none.jpg', '2015-10-26 12:00:01', '#004080', 'http://www.ihatespace.com', '210-555-9090');
INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(4, 4, 'cooper', 'advanced', 'none.jpg', '2015-10-26 12:00:02', '#c0c0c0', 'http://www.si.edu', '210-555-9090');
INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(5, 5, 'liz.shaw', 'novice', 'none.jpg', '2015-10-26 12:00:03', '#008080', 'http://www.weylandindustries.com', '210-555-9090');
INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(6, 6, 'charlie.g', 'advanced', 'none.jpg', '2012-09-09 12:00:04', '#800080', 'http://www.knightindustries.com', '210-555-4321');
INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(7, 7, 'altars', 'expert', 'none.jpg', '1980-03-12 12:00:05', '#8000ff', 'http://www.monolithrobots.com', '210-555-7654');
INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(8, 8, 'asuda0x1', 'expert', 'none.jpg', '1970-01-05 12:00:06', '#0080c0', 'http://www.defenseministry.jp', '210-999-9999');

INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(1, 1, 1);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(2, 1, 2);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(3, 1, 8);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(4, 2, 1);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(5, 2, 12);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(6, 3, 9);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(7, 3, 10);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(8, 4, 11);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(9, 4, 3);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(10, 4, 5);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(11, 4, 7);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(12, 5, 4);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(13, 5, 8);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(14, 6, 4);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(15, 6, 8);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(16, 6, 11);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(17, 6, 9);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(18, 6, 6);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(19, 7, 8);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(20, 7, 1);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(21, 8, 2);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(22, 8, 5);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(23, 8, 12);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(24, 8, 10);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(25, 8, 11);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(26, 8, 4);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(27, 8, 9);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(28, 8, 7);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(29, 8, 1);
	
INSERT INTO RobotData (robotId, robot_name, status) VALUES
	(1, "TARS", "in-development");
INSERT INTO RobotData (robotId, robot_name, status) VALUES
	(2, "KIPP", "retired");
INSERT INTO RobotData (robotId, robot_name, status) VALUES
	(3, "CASE", "design");
	
INSERT INTO RobotAssocs (robotAssocId, robotId, creatorId) VALUES
	(1, 1, 7);
INSERT INTO RobotAssocs (robotAssocId, robotId, creatorId) VALUES
	(2, 2, 4);
INSERT INTO RobotAssocs (robotAssocId, robotId, creatorId) VALUES
	(3, 3, 4);