/* Create the ha_lab3db database and supporting tables */
DROP DATABASE if EXISTS ha_lab3db;
CREATE DATABASE ha_lab3db;
USE ha_lab3db;

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