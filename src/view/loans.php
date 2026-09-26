<?php

require_once __DIR__ . '/../service/LoanService.php';
require_once __DIR__ . '/../service/BookService.php';
require_once __DIR__ . '/../service/MemberService.php';

$loanService   = new LoanService();
$bookService   = new BookService();
$memberService = new MemberService();
$error = null;

if (isset($_GET['return'])) {
    $returnDate = trim($_POST['return_date'] ?? date('Y-m-d'));
    $loanService->registerReturn((int) $_GET['return'], $returnDate);
    header('Location: loans.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId   = (int) ($_POST['book_id']   ?? 0);
    $memberId = (int) ($_POST['member_id'] ?? 0);
    $loanDate = trim($_POST['loan_date']   ?? '');

    if ($bookId && $memberId && $loanDate) {
        $loan = new Loan(0, $bookId, $memberId, $loanDate, null);
        $loanService->addLoan($loan);
        header('Location: loans.php');
        exit;
    } else {
        $error = "Preencha todos os campos obrigatórios.";
    }
}

$loans   = $loanService->getAllLoans();
$books   = $bookService->getAllBooks();
$members = $memberService->getAllMembers();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>LibraTrack — Empréstimos</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<nav>
    <a href="books.php">Livros</a>
    <a href="members.php">Membros</a>
    <a href="loans.php">Empréstimos</a>
</nav>

<main>
    <h1>Empréstimos</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <select name="book_id" required>
            <option value="">Selecione um livro</option>
            <?php foreach ($books as $book): ?>
                <option value="<?= $book->id ?>">
                    <?= htmlspecialchars($book->title) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="member_id" required>
            <option value="">Selecione um membro</option>
            <?php foreach ($members as $member): ?>
                <option value="<?= $member->id ?>">
                    <?= htmlspecialchars($member->name) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="date" name="loan_date" required>
        <button type="submit">Registrar Empréstimo</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Livro</th>
                <th>Membro</th>
                <th>Data do Empréstimo</th>
                <th>Data de Devolução</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($loans as $loan): ?>
            <tr>
                <td><?= htmlspecialchars($loan->bookTitle) ?></td>
                <td><?= htmlspecialchars($loan->memberName) ?></td>
                <td><?= htmlspecialchars($loan->loanDate) ?></td>
                <td>
                    <?php if ($loan->returnDate): ?>
                        <?= htmlspecialchars($loan->returnDate) ?>
                    <?php else: ?>
                        <form method="POST" action="?return=<?= $loan->id ?>" style="display:flex;gap:0.5rem;">
                            <input type="date" name="return_date" value="<?= date('Y-m-d')?>" required>
                            <button type="submit">Devolver</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

</body>
</html>