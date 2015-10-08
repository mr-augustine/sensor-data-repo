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
  userDataId         int(11) NOT NULL AUTO_INCREMENT,
  userId             int(11) NOT NULL AUTO_INCREMENT,
  user_name          varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  skill_level        int(1) NOT NULL,
  profile_pic        varchar(255) UNIQUE COLLATE utf8_unicode_ci,
  started_hobby      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fav_color          varchar(6) COLLATE utf8_unicode_ci,
  url                varchar(255) 
  PRIMARY KEY (userDataId),
  FOREIGN KEY REFERENCES Users(userId),
)

DROP TABLE if EXISTS Skills;
CREATE TABLE SKills ()

DROP TABLE if EXISTS SkillAssocs;
CREATE TABLE SkillAssocs ()

DROP TABLE if EXISTS RobotData;
CREATE TABLE RobotData ()

DROP TABLE if EXISTS InspiredBys;
CREATE TABLE InspiredBys ()

DROP TABLE if EXISTS Tags;
CREATE TABLE Tags ()

DROP TABLE if EXISTS TagAssocs;
CREATE TABLE TagAssocs ()

DROP TABLE if EXISTS CreatorAssocs;
CREATE TABLE CreatorAssocs ()