<?php

require_once __DIR__ . '/../service/MemberService.php';

$service = new MemberService();
$error = null;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim($_POST['name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');

    if ($name && $email) {
        $member = new Member(0, $name, $email, $phone ?: null);
        $service->addMember($member);
        header('Location: members.php');
        exit;
    } else {
        $error = "Nome e e-mail são obrigatórios";
    }
}

if(isset($_GET['delete'])) {
    $service->removeMember((int) $_GET['delete']);
    header('Location: members.php');
    exit;
}

$members = $service->getAllMembers();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>LibraTrack - Membros</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<nav>
    <a href="books.php">Livros</a>
    <a href="members.php">Membros</a>
    <a href="loans.php">Empréstimos</a>
</nav>

<main>
    <h1>Membros</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
     <form method="POST">
            <input type="text"  name="name"  placeholder="Nome"     required>
            <input type="email" name="email" placeholder="E-mail"   required>
            <input type="text"  name="phone" placeholder="Telefone">
            <button type="submit">Adicionar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= htmlspecialchars($member->name) ?></td>
                    <td><?= htmlspecialchars($member->email) ?></td>
                    <td><?= htmlspecialchars($member->phone ?? '—') ?></td>
                    <td><a href="?delete=<?= $member->id ?>">Excluir</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</main>
</body>
</html>