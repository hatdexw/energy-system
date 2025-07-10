<?php
session_start();

require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/DocumentController.php';
require_once 'app/controllers/ChamadoController.php'; // Alterado de TaskController

require_once 'app/controllers/AuditController.php';
require_once 'app/controllers/SectorController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/PerifericoController.php';
require_once 'app/controllers/ProfileController.php';

$url = isset($_GET['url']) ? $_GET['url'] : 'home';

// Global authentication check
if (!in_array($url, ['login', 'logout', 'home'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /energy-system/login');
        exit();
    }
}

switch ($url) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    
    case 'login':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLoginForm();
        }
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'dashboard':
        require_once 'app/views/home/dashboard.php';
        break;
    case 'documents':
        $controller = new DocumentController();
        $controller->index();
        break;
    case 'documents/upload':
        $controller = new DocumentController();
        $controller->upload();
        break;
    case 'chamados': // Nova rota para Chamados
        $controller = new ChamadoController();
        $controller->index();
        break;
    case 'chamados/create': // Nova rota para criar Chamado
        $controller = new ChamadoController();
        $controller->create();
        break;
    case 'chamados/edit': // Nova rota para editar Chamado
        $controller = new ChamadoController();
        $controller->edit();
        break;
    case 'chamados/update': // Nova rota para atualizar Chamado
        $controller = new ChamadoController();
        $controller->update();
        break;
    case 'chamados/delete': // Nova rota para deletar Chamado
        $controller = new ChamadoController();
        $controller->delete();
        break;
    case 'change-password':
        $controller = new AuthController();
        $controller->changePassword();
        break;
    case 'audits':
        $controller = new AuditController();
        $controller->index();
        break;
    case 'audits/create':
        $controller = new AuditController();
        $controller->create();
        break;
    case 'sectors':
        $controller = new SectorController();
        $controller->index();
        break;
    case 'sectors/create':
        $controller = new SectorController();
        $controller->create();
        break;
    case 'sectors/edit':
        $controller = new SectorController();
        $controller->showEditForm();
        break;
    case 'sectors/update':
        $controller = new SectorController();
        $controller->update();
        break;
    case 'sectors/delete':
        $controller = new SectorController();
        $controller->delete();
        break;
    case 'users':
        $controller = new UserController();
        $controller->index();
        break;
    case 'users/create':
        $controller = new UserController();
        $controller->create();
        break;
    case 'users/edit':
        $controller = new UserController();
        $controller->showEditForm();
        break;
    case 'users/update':
        $controller = new UserController();
        $controller->update();
        break;
    case 'users/delete':
        $controller = new UserController();
        $controller->delete();
        break;
    case 'perifericos':
        $controller = new PerifericoController();
        $controller->index();
        break;
    case 'perifericos/create':
        $controller = new PerifericoController();
        $controller->create();
        break;
    case 'perifericos/store':
        $controller = new PerifericoController();
        $controller->store();
        break;
    case 'perifericos/edit':
        $controller = new PerifericoController();
        $id = $_GET['id'] ?? null;
        $controller->edit($id);
        break;
    case 'perifericos/update':
        $controller = new PerifericoController();
        $controller->update();
        break;
    case 'perifericos/delete':
        $controller = new PerifericoController();
        $id = $_GET['id'] ?? null;
        $controller->delete($id);
        break;
    case 'profile':
        $controller = new ProfileController();
        $controller->index();
        break;
    case 'profile/upload':
        $controller = new ProfileController();
        $controller->upload();
        break;
    default:
        // Not Found
        break;
}