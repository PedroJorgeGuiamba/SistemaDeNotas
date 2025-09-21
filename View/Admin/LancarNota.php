<?php
require_once __DIR__ . '/../../middleware/auth.php'; // protege a página e inicia a sessão
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Módulo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Lançar Notas</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="realizar_lancar_nota">
            <div class="mb-3">
                <label for="Periodo" class="form-label">Periodo</label>
                <input type="text" class="form-control" id="Periodo" name="Periodo" required>
            </div>

            <!-- <div class="mb-3">
                <label for="MatriculaID" class="form-label">Aluno (Matrícula)</label>
                <select class="form-control" id="MatriculaID" name="MatriculaID" required>
                    <option value="">Selecione um aluno</option>
                    <?php
                    // Buscar matriculas com aluno
                    $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=matriculas_com_aluno");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $matriculas = json_decode(curl_exec($ch), true);
                    curl_close($ch);

                    if ($matriculas && !isset($matriculas['error'])) {
                        foreach ($matriculas as $mat) {
                            echo '<option value="' . htmlspecialchars($mat['MatriculaID']) . '">' . htmlspecialchars($mat['NomeAluno']) . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhum aluno disponível</option>';
                    }
                    ?>
                </select>
            </div> -->

            <div class="mb-3">
                <label for="MatriculaID" class="form-label">Aluno (Matrícula)</label>
                <select class="form-control" id="MatriculaID" name="MatriculaID" required>
                    <option value="">Selecione um aluno</option>
                    <?php
                    $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=matriculas_com_aluno");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $matriculas = json_decode(curl_exec($ch), true);
                    curl_close($ch);

                    if ($matriculas && !isset($matriculas['error'])) {
                        foreach ($matriculas as $mat) {
                            echo '<option value="' . htmlspecialchars($mat['MatriculaID']) . '">' . htmlspecialchars($mat['NomeAluno']) . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhum aluno disponível</option>';
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
                <label for="Valor" class="form-label">Valor</label>
                <input type="text" class="form-control" id="Valor" name="Valor" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>

        </form>

        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>