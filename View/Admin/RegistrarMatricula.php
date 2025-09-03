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
        <h2>Registrar Matricula</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="realizar_registro_matricula">
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
                        echo '<option value="">Nenhum curso disponível</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="AlunoID" class="form-label">Aluno</label>
                <select class="form-control" id="AlunoID" name="AlunoID" required>
                    <option value="">Selecione um aluno</option>
                    <?php
                    // Buscar cursos da API
                    $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=alunos");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $alunos = json_decode(curl_exec($ch), true);
                    curl_close($ch);
                    if ($alunos && !isset($alunos['error'])) {
                        foreach ($alunos as $aluno) {
                            echo '<option value="' . htmlspecialchars($aluno['AlunoID']) . '">' . htmlspecialchars($aluno['Nome']) . '</option>';
                        }
                    } else {
                        echo '<option value="">Nenhum curso disponível</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>

        </form>

        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>