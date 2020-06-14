CREATE DATABASE gallery;
GRANT ALL PRIVILEGES ON DATABASE gallery TO admin;

\c gallery

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE,
    pwhash TEXT
);

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    owner_id INTEGER REFERENCES users (id),
    name VARCHAR(50)
);

CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    author_id INTEGER REFERENCES users (id) NOT NULL,
    cat_id INTEGER REFERENCES categories (id) ON DELETE SET NULL,
    title VARCHAR(50) NOT NULL,
    descr TEXT,
    created_at TIMESTAMP,
    mime VARCHAR(15),
    contents BYTEA,
    thumb BYTEA
);
