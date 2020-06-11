CREATE DATABASE gallery;
GRANT ALL PRIVILEGES ON DATABASE gallery TO admin;

\c gallery

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50)
);

INSERT INTO users (name) VALUES ('maciek');
INSERT INTO users (name) VALUES ('konrad');
INSERT INTO users (name) VALUES ('mikołaj');
INSERT INTO users (name) VALUES ('test2');
