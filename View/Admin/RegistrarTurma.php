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
        <h2>Registrar Turmas</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="realizar_registro_turma">
            <div class="mb-3">
                <label for="Nome" class="form-label">Nome da Turma</label>
                <input type="text" class="form-control" id="Nome" name="Nome" required>
            </div>

            <div class="mb-3">
                <label for="CursoID" class="form-label">Curso</label>
                <select class="form-control" id="CursoID" name="CursoID" required>
                    <option value="">Selecione um curso</option>
                    <?php
                    // Buscar cursos da API
                    $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=cursos");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $cursos = json_decode(curl_exec($ch), true);
                    curl_close($ch);
                    if ($cursos && !isset($cursos['error'])) {
                        foreach ($cursos as $curso) {
                            echo '<option value="' . htmlspecialchars($curso['CursoID']) . '">' . htmlspecialchars($curso['Nome']) . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhum curso disponível</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="AnoLectivo" class="form-label">Ano Lectivo</label>
                <input type="number" class="form-control" id="AnoLectivo" name="AnoLectivo" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>

        </form>

        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>