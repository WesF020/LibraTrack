<?php

require_once __DIR__ . '/../service/BookService.php';

$service = new BookService();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title      = trim($_POST['title'] ??  '');
    $author     = trim($_POST['author'] ?? '');
    $isbn       = trim($_POST['isbn'] ?? '');
    $quantity   = (int) ($_POST['quantity'] ?? 1);

    if ($title && $author && $isbn) {
        $book = new Book(0, $title, $author, $isbn, $quantity);
        $service->addBook($book);
        header('Location: books.php');
        exit;
    } else {
        $error = "Preencha todos os campos obrigatórios.";
    }
}

    if(isset($_GET['delete'])) {
        $service->removeBook((int) $_GET['delete']);
        header('Location: books.php');
        exit;
    }

$books = $service->getAllBooks();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>LibraTrack - Livros</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<nav>
    <a href="books.php">Livros</a>
    <a href="members.php">Membros</a>
    <a href="loans.php">Empréstimos</a>
</nav>

<main>
    <h1>Livros</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text"     name="title"          placeholder="Título"       required>
        <input type="text"     name="author"         placeholder="Autor"        required>
        <input type="text"     name="isbn"           placeholder="ISBN"         required>
        <input type="number"   name="quantity"       placeholder="Quantidade"   value="1" min="1">
        <button type="submit">Adicionar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Quantidade</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book->title) ?></td>
                <td><?= htmlspecialchars($book->author) ?></td>
                <td><?= htmlspecialchars($book->isbn) ?></td>
                <td><?= htmlspecialchars($book->quantity) ?></td>
                <td><a href="?delete=<?= $book->id ?>">Excluir</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

</body>
</html>