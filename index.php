<?php
session_start();
// var_dump($_SESSION); // Depuração
require_once __DIR__ . "/Controller/Auth/UserController.php";
require_once __DIR__ . "/Controller/Formador/NotaController.php";
require_once __DIR__ . "/Controller/Admin/ModuloController.php";
require_once __DIR__ . "/Controller/Admin/AlunoController.php";
require_once __DIR__ . "/Controller/Admin/LecionarController.php";
require_once __DIR__ . "/Controller/Admin/AdminNotaController.php";
require_once __DIR__ . "/Controller/Admin/CursoController.php";
require_once __DIR__ . "/Controller/Admin/FormadorController.php";
require_once __DIR__ . "/Controller/Admin/TurmaController.php";
require_once __DIR__ . "/Controller/Admin/MatriculaController.php";


$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : 'index');

$userController = new UserController();
$notaController = new NotaController();
$moduloController = new ModuloController();
$alunoController = new AlunoController();
$lecionarController = new LecionarController();
$adminNotaController = new AdminNotaController();
$cursoController = new CursoController();
$formadorController = new FormadorController();
$turmaController = new TurmaController();
$matriculaController = new MatriculaController();

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
    case 'exibir_registro_curso':
        $cursoController->exibirRegistroCurso();
        break;
    case 'realizar_registro_curso':
        $cursoController->realizarRegistroCurso();
        break;
    case 'exibir_lista_cursos':
        $cursoController->exibirListaCursos();
        break;
    case 'realizar_registro_formador':
        $formadorController->realizarRegistroFormador();
        break;
    case 'exibir_registro_formador':
        $formadorController->exibirRegistroFormador();
        break;
    case 'exibir_registro_turma':
        $turmaController->exibirRegistroTurma();
        break;
    case 'realizar_registro_turma':
        $turmaController->realizarRegistroTurma();
        break;
    case 'exibir_registro_matricula':
        $matriculaController->exibirRegistroMatricula();
        break;
    case 'realizar_registro_matricula':
        $matriculaController->realizarRegistroMatricula();
        break;
    case 'logout':
        $userController->logout();
        break;

    default:
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['tipo'] === 'Formador') {
                include __DIR__ . '/View/Formador/PainelDoFormador.php';
            } elseif ($_SESSION['tipo'] === 'Admin') {
                include __DIR__ . '/View/admin/PainelDoAdmin.php';
            } else {
                header('Location: index.php?action=exibir_login&error=' . urlencode('Tipo de usuário inválido'));
            }
        } else {
            header('Location: index.php?action=exibir_login');
        }
        break;
}
?>