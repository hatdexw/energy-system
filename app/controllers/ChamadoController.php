<?php

require_once 'app/models/Chamado.php';
require_once 'app/models/User.php'; // Para buscar usuários para atribuição

class ChamadoController
{
    public function index()
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /energy-system/login');
            exit();
        }

        $chamadoModel = new Chamado();
        $userModel = new User();

        // Parâmetros de busca e filtro
        $search = $_GET['search'] ?? '';
        $filter_status = $_GET['filter_status'] ?? '';
        $filter_prioridade = $_GET['filter_prioridade'] ?? '';
        $filter_assigned_to = $_GET['filter_assigned_to'] ?? '';

        // Dados do usuário logado para controle de acesso
        $logged_in_user_id = $_SESSION['user_id'] ?? null;
        $logged_in_user_role = $_SESSION['role'] ?? null;

        // Parâmetros de paginação
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Garante que $page é um inteiro
        $limit = 10; // Número de chamados por página, você pode ajustar isso
        $offset = ($page - 1) * $limit;

        // Obtém os chamados filtrados e paginados
        $chamados = $chamadoModel->getFilteredAndPaginatedChamados(
            $search,
            $filter_status,
            $filter_prioridade,
            $filter_assigned_to,
            $limit,
            $offset,
            $logged_in_user_id,
            $logged_in_user_role
        );

        // Obtém o total de chamados para a paginação
        $totalChamados = $chamadoModel->countFilteredChamados(
            $search,
            $filter_status,
            $filter_prioridade,
            $filter_assigned_to,
            $logged_in_user_id,
            $logged_in_user_role
        );
        $totalPages = ceil($totalChamados / $limit);

        $users = $userModel->getAll(); // Pega todos os usuários para o dropdown de atribuição

        require_once 'app/views/chamados/index.php';
    }

    public function create()
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /energy-system/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $tipo = $_POST['tipo'] ?? 'Incidente';
            $status = $_POST['status'] ?? 'Aberto';
            $prioridade = $_POST['prioridade'] ?? 'Baixa';
            $user_id = empty($_POST['user_id']) ? null : $_POST['user_id']; // Usuário responsável
            $requerente_id = $_POST['requerente']; // ID do requerente do campo oculto

            $chamadoModel = new Chamado();
            if ($chamadoModel->create($titulo, $descricao, $tipo, $status, $prioridade, $user_id, $requerente_id)) {
                // Se o chamado foi atribuído a alguém, criar uma notificação
                if (!empty($user_id)) {
                    require_once 'app/models/Notification.php';
                    $notificationModel = new Notification();
                    $message = "Você foi atribuído ao chamado: " . $titulo;
                    $notificationModel->create($user_id, $message);
                }
                header('Location: /energy-system/chamados');
                exit();
            } else {
                // Tratar erro na criação
                echo "Erro ao criar chamado.";
            }
        } else {
            // Exibir formulário de criação (se houver um)
            $userModel = new User();
            $users = $userModel->getAll();
            require_once 'app/views/chamados/create.php';
        }
    }

    public function edit()
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /energy-system/login');
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /energy-system/chamados');
            exit();
        }

        $chamadoModel = new Chamado();
        $chamado = $chamadoModel->getById($id);

        if (!$chamado) {
            header('Location: /energy-system/chamados');
            exit();
        }

        $userModel = new User();
        $users = $userModel->getAll();

        require_once 'app/views/chamados/edit.php';
    }

    public function update()
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /energy-system/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $status = $_POST['status'] ?? 'Aberto';
            $prioridade = $_POST['prioridade'] ?? 'Baixa';
            $user_id = empty($_POST['user_id']) ? null : $_POST['user_id'];

            if (!$id) {
                header('Location: /energy-system/chamados');
                exit();
            }

            $chamadoModel = new Chamado();
            if ($chamadoModel->update($id, $titulo, $descricao, $status, $prioridade, $user_id)) {
                header('Location: /energy-system/chamados');
                exit();
            } else {
                // Tratar erro na atualização
                echo "Erro ao atualizar chamado.";
            }
        } else {
            header('Location: /energy-system/chamados');
            exit();
        }
    }

    public function delete()
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /energy-system/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /energy-system/chamados');
                exit();
            }

            $chamadoModel = new Chamado();
            if ($chamadoModel->delete($id)) {
                header('Location: /energy-system/chamados');
                exit();
            }
        } else {
            header('Location: /energy-system/chamados');
            exit();
        }
    }
}