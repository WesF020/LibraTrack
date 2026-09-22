<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Member.php';

class MemberDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM members ORDER BY name");
        $rows = $stmt->fetchAll();

        $members = [];
        foreach ($rows as $row) {
            $members[] = new Member(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone']
            );
        }
        return $members;
    }

    public function findById(int $id): ?Member {
        $stmt = $this->pdo->prepare("SELECT * FROM members WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        return new Member (
            $row['id'],
            $row['name'],
            $row['email'],
            $row['phone'],
        );
    }

    public function save (Member $member): void {
        $stmt = $this->pdo->prepare("
        INSERT INTO members (name, email, phone)
        VALUES (:name, :email, :phone)
        ");
        $stmt->execute([
            ':name'     => $member->name,
            ':email'    => $member->email,
            ':phone'    => $member->phone,
        ]);
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM members WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

}