USE b6vlma4zt58z9kkb60qq;

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
    last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_person) REFERENCES persons(id) ON DELETE CASCADE
);

INSERT INTO persons (name, lastname, email, cellphone_number)
VALUES 
  ('Juan Diego', 'Quintero', 'juandiegoquintero2505@gmail.com', '3000000000'),
  ('jktic', 'soluciones', 'jktic.soluciones@gmail.coom', '3100000000');

INSERT INTO users (username, password, id_person)
VALUES 
  ('juandiego', '$2a$10$ZhuN0fvKklZF9.97SQjS1edRfAZGHifD6Qw0CNzIKXvPB6SM6JLie', 1),
  ('jktic', '$2a$10$hY28G7WNfGeywIshUjqoo.pOwXojxQaGhNIgnFZf45J3Tx1IU5Dn2', 2);
