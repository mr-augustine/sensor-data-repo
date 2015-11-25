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
    user_id         int(11) NOT NULL,
    dataset_name    varchar(32) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
    description     varchar(255) COLLATE utf8_unicode_ci,
    date_created    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (dataset_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
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
    measurement_timestamp   TIMESTAMP,
    sensor_id               int(11) NOT NULL,
    PRIMARY KEY (measurement_id),
    FOREIGN KEY (sensor_id) REFERENCES Sensors(sensor_id),
    CONSTRAINT midx_sid UNIQUE (measurement_index, sensor_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO Users (user_id, username, password) VALUES
    (1, 'jabituya', '$2y$10$c1YR3YAtv5VJy7bU4KbC.umWt9mbL8bFtaxnoDbd8nvmggcfqaM5W');
INSERT INTO Users (user_id, username, password) VALUES
    (2, 'mwatney', '$2y$10$5pcOvjUbkcXKz7vfjCNjcej/6KO89vcNg.u7m84tLL1/jc99jJWF6');
INSERT INTO Users (user_id, username, password) VALUES
    (3, 'ryan.stone', '$2y$10$.iyID/cQucx7SF61f/RsreV61lVXVYa/lvgkKSq/EWukT0HTeut1u');
INSERT INTO Users (user_id, username, password) VALUES
    (4, 'cooper', '$2y$10$hZecd/spqqmWagIE3VXxZeaEOJEhSUiEkzTNIx7FtbXK5OdsbLiy.');
INSERT INTO Users (user_id, username, password) VALUES
    (5, 'liz.shaw', '$2y$10$KGYOoNJr4yOF0meEDFPng.ZGgRlcfjv1a2H0ecDK03TETl7Eq2ZAS');
INSERT INTO Users (user_id, username, password) VALUES
    (6, 'charlie-g', '$2y$10$g8SDz5IjB5ASFIVPR9addec13G6zuqA6tDjyzDVJvSzpIRGtQljoO');
INSERT INTO Users (user_id, username, password) VALUES
    (7, 'altars', '$2y$10$ADsSkEAN.1DYmX5/35AAEeskCs.KTi8w3muBEMHoWatZJbYjoWYp6');
INSERT INTO Users (user_id, username, password) VALUES
    (8, 'asuda0x1', '$2y$10$z0hExq5pEWicWCgirPAmvOKQMxNvwMMi1rizFK4ta15HwqLVun7K6');
    

INSERT INTO Datasets (dataset_id, user_id, dataset_name, description) VALUES
    (1, 1, 'Lincoln Park Run', 'Lovely day for a walk with my robot');
    
INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    (1, 1, 'compass0', 'HEADING', 'DEGREES', 'SEQUENTIAL', "The robot's only compass. Placed ontop a mast.");
INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    (2, 1, 'ping0', 'RANGE', 'CENTIMETERS', 'SEQUENTIAL', "The robot's only ultrasonic sensor. Placed at the front/center.");
INSERT INTO Sensors (sensor_id, dataset_id, sensor_name, sensor_type, sensor_units, sequence_type, description) VALUES
    (3, 1, 'bump0', 'BINARY', 'ON-OFF', 'SEQUENTIAL', "The robot's only bump switch. Placed at the front/center.");
    
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (1, 1, '45.2', NULL, 1);
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (2, 2, '48.7', NULL, 1);
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (3, 3, '49.1', NULL, 1);
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (4, 1, '30', NULL, 2);
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (5, 2, '29', NULL, 2);
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (6, 3, '30', NULL, 2);
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (7, 1, 'OFF', NULL, 3);
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (8, 2, 'OFF', NULL, 3);
INSERT INTO Measurements (measurement_id, measurement_index, measurement_value, measurement_timestamp, sensor_id) VALUES
    (9, 3, 'ON', NULL, 3);