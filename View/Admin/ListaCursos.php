<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Cursos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ch = curl_init("http://localhost/SistemaDeNotas/Api/api.php?resource=cursos");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $cursos = json_decode(curl_exec($ch), true);
                curl_close($ch);
                if ($cursos && !isset($cursos['error'])) {
                    foreach ($cursos as $curso) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($curso['CursoID']) . '</td>';
                        echo '<td>' . htmlspecialchars($curso['Nome']) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">Nenhum curso encontrado.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="index.php?action=exibir_registro_curso" class="btn btn-primary">Registrar Novo Curso</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>