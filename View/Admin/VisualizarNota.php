<?php
require_once __DIR__ . '/../../middleware/auth.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Notas Lançadas</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Nota ID</th>
                    <th>Matrícula ID</th>
                    <th>Módulo ID</th>
                    <th>Período</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nota['NotaID']); ?></td>
                        <td><?php echo htmlspecialchars($nota['NomeAluno']); ?></td>
                        <td><?php echo htmlspecialchars($nota['NomeModulo']); ?></td>
                        <td><?php echo htmlspecialchars($nota['Periodo']); ?></td>
                        <td><?php echo htmlspecialchars($nota['Valor']); ?></td>
                        <td>
                            <a href="index.php?action=exibir_editar_nota&id=<?php echo $nota['NotaID']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="index.php?action=realizar_excluir_nota&id=<?php echo $nota['NotaID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php?action=exibir_lancar_nota" class="btn btn-primary">Lançar Nova Nota</a>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>