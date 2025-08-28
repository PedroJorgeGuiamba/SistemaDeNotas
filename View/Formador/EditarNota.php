<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Nota</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="realizar_editar_nota">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($nota['NotaID']); ?>">
            <div class="mb-3">
                <label for="MatriculaID" class="form-label">Matrícula ID</label>
                <input type="text" class="form-control" id="MatriculaID" value="<?php echo htmlspecialchars($nota['MatriculaID']); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="ModuloID" class="form-label">Módulo ID</label>
                <input type="text" class="form-control" id="ModuloID" value="<?php echo htmlspecialchars($nota['ModuloID']); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="Periodo" class="form-label">Período</label>
                <input type="text" class="form-control" id="Periodo" value="<?php echo htmlspecialchars($nota['Periodo']); ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="Valor" class="form-label">Valor (0-20)</label>
                <input type="number" step="0.1" min="0" max="20" class="form-control" id="Valor" name="Valor" value="<?php echo htmlspecialchars($nota['Valor']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="index.php?action=exibir_notas" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>