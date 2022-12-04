CREATE DATABASE IF NOT EXISTS tasks_project_db;
use tasks_project_db;

CREATE TABLE IF NOT EXISTS users(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role varchar(50) NOT NULL,
    name varchar(100) NOT NULL,
    surname varchar(100) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    created_at datetime
)Engine=InnoDb;

CREATE TABLE IF NOT EXISTS tasks(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(255) NOT NULL,
    title varchar(255) NOT NULL,
    content TEXT,
    priority varchar(20) NOT NULL,
    hours varchar(100) NOT NULL,
    created_at datetime,

    CONSTRAINT fk_tasks_users FOREIGN KEY (user_id) REFERENCES users(id)
)Engine=InnoDb;

INSERT INTO users VALUES(NULL, 'ROLE_USER', 'paco', 'sanchez', 'paco@pa.com', '12345678', CURTIME());
INSERT INTO users VALUES(NULL, 'ROLE_USER', 'pablo', 'escobar', 'pablo@es.com', '12345678', CURTIME());
INSERT INTO users VALUES(NULL, 'ROLE_USER', 'sapo', 'mijo', 'sapo@mi.com', '12345678', CURTIME());

INSERT INTO tasks VALUES(NULL, 1, 'ejemplo', 'ejemplo bla bla bla', 'IMPORTANT', '20', CURTIME());
INSERT INTO tasks VALUES(NULL, 2, 'ejemplo', 'ejemplo bla bla bla', 'URGENT', '20', CURTIME());
INSERT INTO tasks VALUES(NULL, 3, 'ejemplo', 'ejemplo bla bla bla', 'meh', '20', CURTIME());