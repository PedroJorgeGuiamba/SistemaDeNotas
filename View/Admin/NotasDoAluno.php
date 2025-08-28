<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas do Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Notas do Aluno</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nota ID</th>
                    <th>Módulo ID</th>
                    <th>Período</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nota['NotaID']); ?></td>
                        <td><?php echo htmlspecialchars($nota['ModuloID']); ?></td>
                        <td><?php echo htmlspecialchars($nota['Periodo']); ?></td>
                        <td><?php echo htmlspecialchars($nota['Valor']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>