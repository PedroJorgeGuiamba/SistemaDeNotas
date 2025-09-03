<?php
require_once __DIR__ ."/../../Models/Turma.php";

class TurmaController {
    private $model;

    public function __construct() {
        $this->model = new Turma();
    }

    public function exibirRegistroTurma() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/RegistrarTurma.php';

    }

    public function realizarRegistroTurma() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        if (!isset($_POST['Nome'])) {
            header('Location: index.php?action=exibir_registro_turma&error=' . urlencode('Dados incompletos'));
            exit;
        }
        $data = [
            'Nome' => $_POST['Nome'],
            'CursoID' => $_POST['CursoID'],
            'AnoLectivo' => $_POST['AnoLectivo']
        ];
        $result = $this->model->registrarTurma($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_registro_turma&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php?action=exibir_lista_turmas');
        }
    }

    public function exibirListaTurma() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/ListaTurmas.php';
    }
}
?>