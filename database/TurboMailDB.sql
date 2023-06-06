CREATE DATABASE IF NOT EXISTS TurboMailDB;

CREATE TABLE IF NOT EXISTS User (
    id BIGINT NOT NULL,
    first_name VARCHAR(128) NOT NULL,
    last_name VARCHAR(128) NOT NULL,
    email VARCHAR(256) NOT NULL,
    password VARCHAR(256) NOT NULL,
    CONSTRAINT PK_User PRIMARY KEY (id),
    CONSTRAINT UC_User UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS Relation (
    id BIGINT NOT NULL,
    id_sender BIGINT NOT NULL,
    id_receiver BIGINT NOT NULL,
    status BOOLEAN NOT NULL,
    CONSTRAINT PK_Relation PRIMARY KEY (id),
    CONSTRAINT FK_Relation_Sender FOREIGN KEY (id_sender) REFERENCES User(id),
    CONSTRAINT FK_Relation_Receiver FOREIGN KEY (id_receiver) REFERENCES User(id)
);

CREATE TABLE IF NOT EXISTS Message (
    id BIGINT NOT NULL,
    id_sender BIGINT NOT NULL,
    id_receiver BIGINT NOT NULL,
    id_relation BIGINT NOT NULL,
    message TEXT NOT NULL,
    date DATETIME NOT NULL,
    CONSTRAINT PK_Message PRIMARY KEY (id),
    CONSTRAINT FK_Message FOREIGN KEY (id_relation) REFERENCES Relation(id)
);