<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registrar Curso</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="realizar_registro_curso">
            <div class="mb-3">
                <label for="Nome" class="form-label">Nome do Curso</label>
                <input type="text" class="form-control" id="Nome" name="Nome" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
    
    <a href="index.php" class="btn btn-secondary mt-3">Voltar ao Painel do Administrador</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>