<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registrar Aluno</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="realizar_registro_aluno">
            <div class="mb-3">
                <label for="Nome" class="form-label">Nome do Aluno</label>
                <input type="text" class="form-control" id="Nome" name="Nome" required>
            </div>
            <div class="mb-3">
                <label for="DataNascimento" class="form-label">Nome do Aluno</label>
                <input type="date" class="form-control" id="DataNascimento" name="DataNascimento" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>