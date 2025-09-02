<?php
require_once __DIR__ ."/../../Models/Nota.php";

class AdminNotaController {
    private $model;

    public function __construct() {
        $this->model = new Nota();
    }

    public function exibirNotasAluno() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        $alunoId = isset($_GET['aluno_id']) ? (int)$_GET['aluno_id'] : null;
        if (!$alunoId) {
            header('Location: index.php?error=' . urlencode('ID do aluno não especificado'));
            exit;
        }
        $notas = $this->model->listarNotasPorAluno($alunoId);
        include __DIR__ . '/../../View/Admin/NotasDoAluno.php';
    }
}
?>