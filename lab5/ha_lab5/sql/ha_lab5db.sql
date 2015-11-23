/* Create the ha_lab5db database, supporting tables, and initial data */
DROP DATABASE if EXISTS ha_lab5db;
CREATE DATABASE ha_lab5db;
USE ha_lab5db;

DROP TABLE if EXISTS Users;
CREATE TABLE Users (
    user_id         int(11) NOT NULL AUTO_INCREMENT,
    username        varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
    password        varchar(255) NOT NULL COLLATE utf8_unicode_ci,
    PRIMARY KEY (user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS DataSets;
CREATE TABLE DataSets (
    dataset_id      int(11) NOT NULL AUTO_INCREMENT,
    dataset_name    varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
    description     varchar(255) COLLATE utf8_unicode_ci,
    date_created    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (dataset_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS Sensors;
CREATE TABLE Sensors (
    sensor_id       int(11) NOT NULL AUTO_INCREMENT,
    dataset_id      int(11) NOT NULL,
    sensor_name     varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    sensor_type     varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    sensor_units    varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    sequence_type   varchar(32) NOT NULL COLLATE utf8_unicode_ci,
    description     varchar(128) COLLATE utf8_unicode_ci,
    PRIMARY KEY (sensor_id),
    FOREIGN KEY (dataset_id) REFERENCES Datasets(dataset_id)
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

INSERT INTO Users (user_id, username, password) VALUES
    (1, 'jabituya', 'wwwwwwww');
INSERT INTO Users (user_id, username, password) VALUES
    (2, 'mwatney', 'aaaaaaaa');
INSERT INTO Users (user_id, username, password) VALUES
    (3, 'ryan.stone', 'bbbbbbbb');
INSERT INTO Users (user_id, username, password) VALUES
    (4, 'cooper', 'cccccccc');
INSERT INTO Users (user_id, username, password) VALUES
    (5, 'liz.shaw', 'dddddddd');
INSERT INTO Users (user_id, username, password) VALUES
    (6, 'charlie-g', 'xxxxxxxx');
INSERT INTO Users (user_id, username, password) VALUES
    (7, 'altars', 'yyyyyyyy');
INSERT INTO Users (user_id, username, password) VALUES
    (8, 'asuda0x1', 'zzzzzzzz');
    

INSERT INTO Datasets (dataset_id, dataset_name) VALUES
    (1, 'Lincoln Park Run');
    
INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    (1, 1, 'compass0', 'HEADING', 'DEGREES', 'SEQUENTIAL', "The robot's only compass. Placed ontop a mast.");
INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    (2, 1, 'ping0', 'RANGE', 'CENTIMETERS', 'SEQUENTIAL', "The robot's only ultrasonic sensor. Placed at the front/center.");
INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    (3, 1, 'bump0', 'BINARY', 'ON-OFF', 'SEQUENTIAL', "The robot's only bump switch. Placed at the front/center.");