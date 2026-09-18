<?php

class Book {
    public int $id;
    public string $title;
    public string $author;
    public string $isbn;
    public int $quantity;

    public function __construct(
        int $id,
        string $title,
        string $author,
        string $isbn,
        int $quantity
    ) {
        $this->id        = $id;
        $this->title     = $title;
        $this->author    = $author;
        $this->isbn      = $isbn;
        $this->quantity  = $quantity;
    }
}