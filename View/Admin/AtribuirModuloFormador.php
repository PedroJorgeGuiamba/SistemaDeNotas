<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atribuir Módulo a Formador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Atribuir Módulo a Formador</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="realizar_atribuicao_modulo">
            <div class="mb-3">
                <label for="FormadorID" class="form-label">ID do Formador</label>
                <input type="number" class="form-control" id="FormadorID" name="FormadorID" required>
            </div>
            <div class="mb-3">
                <label for="ModuloID" class="form-label">ID do Módulo</label>
                <input type="number" class="form-control" id="ModuloID" name="ModuloID" required>
            </div>
            <div class="mb-3">
                <label for="TurmaID" class="form-label">ID da Turma</label>
                <input type="number" class="form-control" id="TurmaID" name="TurmaID" required>
            </div>
            <button type="submit" class="btn btn-primary">Atribuir</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>