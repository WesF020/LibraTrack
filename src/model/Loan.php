<?php

class Loan {
    public int $id;
    public int $bookId;
    public int $memberId;
    public string $loanDate;
    public ?string $returnDate;
    public ?string $bookTitle;
    public ?string $memberName;

    public function __construct (
        int $id,
        int $bookId,
        int $memberId,
        string $loanDate,
        ?string $returnDate,
        ?string $bookTitle = null,
        ?string $memberName = null
    ) {
        $this->id           = $id;
        $this->bookId       = $bookId;
        $this->memberId     = $memberId;
        $this->loanDate     = $loanDate;
        $this->returnDate   = $returnDate;
        $this->bookTitle    = $bookTitle;
        $this->memberName   = $memberName;
    }
}