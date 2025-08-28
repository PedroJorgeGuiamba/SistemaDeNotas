<?php
session_start();
require_once __DIR__ ."/Controller/Auth/UserController.php";
require_once __DIR__ ."/Controller/Notas/NotaController.php";
require_once __DIR__ ."/Controller/Admin/ModuloController.php";
require_once __DIR__ ."/Controller/Admin/AlunoController.php";
require_once __DIR__ ."/Controller/Admin/LecionarController.php";
require_once __DIR__ ."/Controller/Admin/AdminNotaController.php";

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : 'index');

$userController = new UserController();
$notaController = new NotaController();
$moduloController = new ModuloController();
$alunoController = new AlunoController();
$lecionarController = new LecionarController();
$adminNotaController = new AdminNotaController();

switch ($action) {
    case 'exibir_login':
        $userController->exibirLogin();
        break;
    case 'realizar_login':
        $userController->realizarLogin();
        break;
    case 'exibir_registro':
        $userController->exibirRegistro();
        break;
    case 'realizar_registro':
        $userController->realizarRegistro();
        break;
    case 'exibir_notas':
        $notaController->exibirNotas();
        break;
    case 'exibir_lancar_nota':
        $notaController->exibirLancarNota();
        break;
    case 'realizar_lancar_nota':
        $notaController->realizarLancarNota();
        break;
    case 'exibir_editar_nota':
        $notaController->exibirEditarNota();
        break;
    case 'realizar_editar_nota':
        $notaController->realizarEditarNota();
        break;
    case 'realizar_excluir_nota':
        $notaController->realizarExcluirNota();
        break;
    case 'exibir_registro_modulo':
        $moduloController->exibirRegistroModulo();
        break;
    case 'realizar_registro_modulo':
        $moduloController->realizarRegistroModulo();
        break;
    case 'exibir_registro_aluno':
        $alunoController->exibirRegistroAluno();
        break;
    case 'realizar_registro_aluno':
        $alunoController->realizarRegistroAluno();
        break;
    case 'exibir_atribuicao_modulo':
        $lecionarController->exibirAtribuicaoModulo();
        break;
    case 'realizar_atribuicao_modulo':
        $lecionarController->realizarAtribuicaoModulo();
        break;
    case 'exibir_notas_aluno':
        $adminNotaController->exibirNotasAluno();
        break;
    default:
        if (isset($_SESSION['user_id'])) {
            echo "Bem-vindo, usuário logado! Tipo: " . $_SESSION['tipo'];
            if ($_SESSION['tipo'] === 'formador') {
                echo '<br><a href="index.php?action=exibir_notas">Visualizar Notas</a>';
                echo '<br><a href="index.php?action=exibir_lancar_nota">Lançar Nova Nota</a>';
            } elseif ($_SESSION['tipo'] === 'admin') {
                echo '<br><a href="index.php?action=exibir_registro_modulo">Registrar Módulo</a>';
                echo '<br><a href="index.php?action=exibir_registro">Registrar Formador</a>';
                echo '<br><a href="index.php?action=exibir_atribuicao_modulo">Atribuir Módulo a Formador</a>';
                echo '<br><a href="index.php?action=exibir_registro_aluno">Criar Aluno</a>';
                echo '<br><a href="index.php?action=exibir_notas_aluno&aluno_id=1">Visualizar Notas do Aluno (exemplo ID 1)</a>'; // Ajuste ID conforme necessário
            }
            // Aqui pode incluir uma dashboard ou lista
        } else {
            header('Location: index.php?action=exibir_login');
        }
        break;
}
?>