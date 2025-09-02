<?php
require_once __DIR__ ."/../../Models/Curso.php";

class CursoController {
    private $model;

    public function __construct() {
        $this->model = new Curso();
    }

    public function exibirRegistroCurso() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/RegistrarCurso.php';

    }

    public function realizarRegistroCurso() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        if (!isset($_POST['Nome'])) {
            header('Location: index.php?action=exibir_registro_curso&error=' . urlencode('Dados incompletos'));
            exit;
        }
        $data = [
            'Nome' => $_POST['Nome']
        ];
        $result = $this->model->registrarCurso($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_registro_curso&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php?action=exibir_lista_cursos');
        }
    }

    public function exibirListaCursos() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/ListaCursos.php';
    }
}
?>