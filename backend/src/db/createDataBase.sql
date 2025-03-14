CREATE DATABASE loginChallenge;

USE loginChallenge;

CREATE TABLE persons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    cellphone_number VARCHAR(20) NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_person INT NOT NULL,
    last_login TIMESTAMP NULL,
    FOREIGN KEY (id_person) REFERENCES persons(id) ON DELETE CASCADE
);

