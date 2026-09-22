<?php

require_once __DIR__ . '/../dao/MemberDAO.php';

class MemberService {
    private MemberDAO $dao;

    public function __construct() {
        $this->dao = new MemberDAO();
    }

    public function getAllMembers(): array {
        return $this->dao->findAll();
    }

    public function getMemberById(int $id): ?Member {
        return $this->dao->findById($id);
    }

    public function addMember(Member $member): void {
        $this->dao->save($member);
    }
    public function removeMember(int $id): void {
        $this->dao->delete($id);
    }
}