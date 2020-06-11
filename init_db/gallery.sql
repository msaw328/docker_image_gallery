CREATE DATABASE gallery;
GRANT ALL PRIVILEGES ON DATABASE gallery TO admin;

\c gallery

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE,
    pwhash VARCHAR(60),
    email VARCHAR(50) UNIQUE
);
