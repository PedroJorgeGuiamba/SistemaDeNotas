<?php
require_once __DIR__ ."/../../Models/Nota.php";

class NotaController {
    private $model;

    public function __construct() {
        $this->model = new Nota();
    }

    public function exibirNotas() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        $notas = $this->model->listarNotas();
        include __DIR__ . '/../../View/Admin/VisualizarNota.php';
    }

    public function exibirLancarNota() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        include __DIR__ . '/../../View/Admin/LancarNota.php';
    }

    public function realizarLancarNota() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        if (!isset($_POST['MatriculaID']) || !isset($_POST['ModuloID']) || !isset($_POST['Periodo']) || !isset($_POST['Valor'])) {
            header('Location: index.php?action=exibir_lancar_nota&error=' . urlencode('Dados incompletos'));
            exit;
        }
        if (!is_numeric($_POST['Valor']) || $_POST['Valor'] < 0 || $_POST['Valor'] > 20) {
            header('Location: index.php?action=exibir_lancar_nota&error=' . urlencode('Valor da nota deve ser um número entre 0 e 20'));
            exit;
        }
        $data = [
            'MatriculaID' => (int)$_POST['MatriculaID'],
            'ModuloID' => (int)$_POST['ModuloID'],
            'Periodo' => $_POST['Periodo'],
            'Valor' => (float)$_POST['Valor']
        ];
        $result = $this->model->lancarNota($data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_lancar_nota&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php?action=exibir_notas');
        }
    }

    public function exibirEditarNota() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) {
            header('Location: index.php?action=exibir_notas&error=' . urlencode('ID não especificado'));
            exit;
        }
        $nota = $this->model->obterNota($id);
        if (!$nota) {
            header('Location: index.php?action=exibir_notas&error=' . urlencode('Nota não encontrada'));
            exit;
        }
        include __DIR__ . '/../../View/Formador/EditarNota.php';
    }

    public function realizarEditarNota() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
        if (!$id || !isset($_POST['Valor'])) {
            header('Location: index.php?action=exibir_notas&error=' . urlencode('Dados incompletos'));
            exit;
        }
        if (!is_numeric($_POST['Valor']) || $_POST['Valor'] < 0 || $_POST['Valor'] > 20) {
            header('Location: index.php?action=exibir_editar_nota&id=' . $id . '&error=' . urlencode('Valor da nota deve ser um número entre 0 e 20'));
            exit;
        }
        $data = [
            'Valor' => (float)$_POST['Valor']
        ];
        $result = $this->model->editarNota($id, $data);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_editar_nota&id=' . $id . '&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php?action=exibir_notas');
        }
    }

    public function realizarExcluirNota() {
        if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'Admin') {
            header('Location: index.php?error=acesso_negado');
            exit;
        }
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) {
            header('Location: index.php?action=exibir_notas&error=' . urlencode('ID não especificado'));
            exit;
        }
        $result = $this->model->excluirNota($id);
        if (isset($result['error'])) {
            header('Location: index.php?action=exibir_notas&error=' . urlencode($result['error']));
        } else {
            header('Location: index.php?action=exibir_notas');
        }
    }
}
?>