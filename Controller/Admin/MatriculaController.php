<?php
require_once __DIR__ ."/../../Models/Matricula.php";

class MatriculaController {
    private $model;

    public function __construct() {
        $this->model = new Matricula();
    }

    public function exibirRegistroMatricula() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/RegistrarMatricula.php';

    }

    public function realizarRegistroMatricula() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        $data = [
            'AlunoID' => $_POST['AlunoID'],
            'TurmaID' => $_POST['TurmaID']
        ];
        $result = $this->model->registrarMatricula($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_registro_matricula&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php?action=exibir_lista_matriculas');
        }
    }

    public function exibirListaMatriculas() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/ListaMatriculas.php';
    }
}
?>