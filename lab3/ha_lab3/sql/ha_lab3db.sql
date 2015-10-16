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
  skill_level		 int(1) COLLATE utf8_unicode_ci,
  profile_pic		 varchar(255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  started_hobby 	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  date_created		 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fav_color		 	 char(6) NOT NULL COLLATE utf8_unicode_ci,
  url				 varchar(255) COLLATE utf8_unicode_ci,
  phone				 varchar(255) COLLATE utf8_unicode_ci,
  PRIMARY KEY (userDataId),
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO Users (userId, email, password) VALUES 
	   (1, 'bjabituya@yahoo.com', 'wwwwwwww');
INSERT INTO Users (userId, email, password) VALUES 
	   (2, 'charlie.g@hotmail.com', 'xxxxxxxx');
INSERT INTO Users (userId, email, password) VALUES 
	   (3, 'altars@gmail.com', 'yyyyyyyy');
INSERT INTO Users (userId, email, password) VALUES 
	   (4, 'asuda@kenbishi.jp', 'zzzzzzzz');
