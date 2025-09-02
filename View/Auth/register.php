<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registrar Novo Usuário</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="../../index.php" method="POST">
            <input type="hidden" name="action" value="do_register">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Role</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="Admin">Admin</option>
                    <option value="Formador">Formador</option>
                    <option value="Formando">Formando</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>