<?php

require_once __DIR__ . '/../dao/LoanDAO.php';

class LoanService {
    private LoanDAO $dao;

    public function __construct() {
        $this->dao = new LoanDAO();
    }

    public function getAllLoans(): array {
        return $this->dao->findAllWithDetails();
    }

    public function addLoan(Loan $loan): void {
        $this->dao->save($loan);
    }

    public function registerReturn(int $id, string $returnDate): void {
        $this->dao->registerReturn($id, $returnDate);
    }

}