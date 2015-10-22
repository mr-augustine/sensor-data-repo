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
  profile_pic		 varchar(255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
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
	   (2, 'charlie.g@hotmail.com', 'xxxxxxxx');
INSERT INTO Users (userId, email, password) VALUES 
	   (3, 'altars@gmail.com', 'yyyyyyyy');
INSERT INTO Users (userId, email, password) VALUES 
	   (4, 'asuda@kenbishi.jp', 'zzzzzzzz');


INSERT INTO UserData (userDataId, userId, user_name, skill_level, profile_pic, started_hobby, fav_color, url, phone) VALUES
	(1, 1, 'jabituya', 'advanced', 'none.jpg', '2015-10-17 07:38:46', '#008000', 'http://www.google.com', '210-555-9090');

INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(1, 1, 1);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(2, 1, 2);
INSERT INTO SkillAssocs (skillAssocId, userDataId, skillId) VALUES
	(3, 1, 8);