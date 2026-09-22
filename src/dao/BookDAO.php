<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Book.php';

class BookDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM books ORDER BY title");
        $rows = $stmt->fetchAll();

        $books = [];

        foreach ($rows as $row) {
            $books[] = new Book (
                $row['id'],
                $row['title'],
                $row['author'],
                $row['isbn'],
                $row['quantity'],
            );
        }
        return $books;
    }

    public function findById(int $id): ?Book {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        return new Book(
            $row['id'],
            $row['title'],
            $row['author'],
            $row['isbn'],
            $row['quantity'],
        );
    }

    public function save (Book $book): void {
        $stmt = $this->pdo->prepare("
        INSERT INTO books (title, author, isbn, quantity)
        VALUES (:title, :author, :isbn, :quantity)
        ");
        $stmt->execute([
            ':title'    =>  $book->title,
            ':author'   =>  $book->author,
            ':isbn'     =>  $book->isbn,
            ':quantity' =>  $book->quantity,
        ]);
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

}