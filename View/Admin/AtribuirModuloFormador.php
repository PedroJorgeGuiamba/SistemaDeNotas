<?php
    require_once __DIR__ . '/../../middleware/auth.php'; // protege a página e inicia a sessão
?>

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
                <label for="TurmaID" class="form-label">Turma</label>
                <select class="form-control" id="TurmaID" name="TurmaID" required>
                    <option value="">Selecione uma turma</option>
                    <?php
                    // Buscar cursos da API
                    $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=turmas");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $turmas = json_decode(curl_exec($ch), true);
                    curl_close($ch);
                    if ($turmas && !isset($turmas['error'])) {
                        foreach ($turmas as $turma) {
                            echo '<option value="' . htmlspecialchars($turma['TurmaID']) . '">' . htmlspecialchars($turma['Nome']) . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhuma turma disponível</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="ModuloID" class="form-label">Modulo</label>
                <select class="form-control" id="ModuloID" name="ModuloID" required>
                    <option value="">Selecione um Modulo</option>
                    <?php
                    // Buscar cursos da API
                    $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=modulos");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $modulos = json_decode(curl_exec($ch), true);
                    curl_close($ch);
                    if ($modulos && !isset($modulos['error'])) {
                        foreach ($modulos as $modulo) {
                            echo '<option value="' . htmlspecialchars($modulo['ModuloID']) . '">' . htmlspecialchars($modulo['Nome']) . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhum modulo disponível</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="FormadorID" class="form-label">Formador</label>
                <select class="form-control" id="FormadorID" name="FormadorID" required>
                    <option value="">Selecione um Formador</option>
                    <?php
                    // Buscar cursos da API
                    $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=formador");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $formadores = json_decode(curl_exec($ch), true);
                    curl_close($ch);
                    if ($formadores && !isset($formadores['error'])) {
                        foreach ($formadores as $formador) {
                            echo '<option value="' . htmlspecialchars($formador['FormadorID']) . '">' . htmlspecialchars($formador['Nome']) . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhum Formador disponível</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atribuir</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>