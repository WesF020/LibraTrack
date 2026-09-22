<?php

require_once __DIR__ . '/../dao/BookDAO.php';

class BookService {
    private BookDAO $dao;

    public function __construct() {
        $this->dao = new BookDAO();
    }

    public function getAllBooks(): array {
        return $this->dao->findAll();
    }

    public function getBookById(int $id): ?Book {
        return $this->dao->findById($id);
    }

    public function addBook (Book $book): void {
        $this->dao->save($book);
    }

    public function deleteBook (int $id): void {
        $this->dao->delete($id);
    }
}