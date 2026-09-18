CREATE DATABASE IF NOT EXISTS libratrack_db;
USE libratrack_db;

CREATE TABLE books (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(150) NOT NULL,
    author      VARCHAR(100) NOT NULL,
    isbn        VARCHAR(20)  UNIQUE NOT NULL,
    quantity    INT          NOT NULL DEFAULT 1
);

CREATE TABLE members (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) UNIQUE NOT NULL,
    phone       VARCHAR(20)
);

CREATE TABLE loans (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    book_id     INT NOT NULL,
    member_id   INT NOT NULL,
    loan_date   DATE NOT NULL,
    return_date DATE,
    FOREIGN KEY (book_id)   REFERENCES books(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);

INSERT INTO books (title, author, isbn, quantity) VALUES
    ('O Senhor dos Anéis', 'J.R.R Tolkien', '978-8533613379', 3),
    ('1984', 'George Orwell', '978-8535913849', 2),
    ('Clean Code', 'Robert C. Martin', '978-0132350884', 1);

INSERT INTO members (name, email, phone) VALUES
    ('Wesley', 'wesley452@gmail.com', '8199234220'),
    ('Hugo', 'hugobrunO@gmail.com', '8198456589'),
    ('Natanael', 'natangoogle@gmail.com', '8198345998');

INSERT INTO loans (book_id, member_id, loan_date) VALUES
    (1, 1, '2026-09-01'),
    (2, 2, '2026-09-10');
