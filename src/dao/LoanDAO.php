<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Loan.php';

class LoanDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function findAllWithDetails(): array {
        $stmt = $this->pdo->query("
            SELECT
                loans.id,
                loans.book_id,
                loans.member_id,
                loans.loan_date,
                loans.return_date,
                books.title     AS book_title,
                members.name    AS member_name
            FROM loans
            INNER JOIN books    ON loans.book_id    = books.id
            INNER JOIN members  ON loans.member_id  = members.id
            ORDER BY loans.loan_date DESC
        ");
        $rows = $stmt->fetchAll();

        $loans = [];
        foreach ($rows as $row) {
            $loans[] = new Loan (
                $row['id'],
                $row['book_id'],
                $row['member_id'],
                $row['loan_date'],
                $row['return_date'],
                $row['book_title'],
                $row['member_name'],
            );
        }
        return $loans;
    }

    public function save (Loan $loan): void {
        $stmt = $this->pdo->prepare("
        INSERT INTO loans (book_id, member_id, loan_date)
        VALUES (:book_id, :member_id, :loan_date)
        ");
        $stmt->execute([
            ':book_id'      => $loan->bookId,
            ':member_id'  => $loan->memberId,
            ':loan_date'    => $loan->loanDate,
        ]);
    }

    public function registerReturn(int $id, string $returnDate): void {
        $stmt = $this->pdo->prepare("
            UPDATE loans SET return_date = :return_date WHERE id = :id
            ");
        $stmt->execute([
            ':return_date'   =>   $returnDate,
            ':id'            =>   $id,
        ]);
    }

}