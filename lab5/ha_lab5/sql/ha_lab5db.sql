/* Create the ha_lab5db database, supporting tables, and initial data */
DROP DATABASE if EXISTS ha_lab5db;
CREATE DATABASE ha_lab5db;
USE ha_lab5db;

DROP TABLE if EXISTS Users;
CREATE TABLE Users (
    user_id         int(11) NOT NULL AUTO_INCREMENT,
    password        varchar(255) COLLATE utf8_unicode_ci,
    PRIMARY KEY (user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS DataSets;
CREATE TABLE DataSets (
    dataset_id      int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (dataset_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS Sensors;
CREATE TABLE Sensors (
    sensor_id       int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (sensor_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS Measurements;
CREATE TABLE Measurements (
    measurement_id          int(11) NOT NULL AUTO_INCREMENT,
    measurement_index       int(11) NOT NULL,
    measurement_value       varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    measurement_timestamp   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sensor_id               int(11) NOT NULL,
    PRIMARY KEY (measurement_id),
    FOREIGN KEY (sensor_id) REFERENCES Sensors(sensor_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;