<?php

require_once 'app/models/User.php';
require_once 'app/models/Sector.php';

class UserController
{
    public function index()
    {
        $userModel = new User();
        $sectorModel = new Sector();

        // Parâmetros de busca e filtro
        $search = $_GET['search'] ?? '';
        $filter_role = $_GET['filter_role'] ?? '';
        $filter_sector = $_GET['filter_sector'] ?? '';

        // Parâmetros de paginação
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Número de usuários por página
        $offset = ($page - 1) * $limit;

        // Obtém os usuários filtrados e paginados
        $users = $userModel->getFilteredAndPaginatedUsers(
            $search,
            $filter_role,
            $filter_sector,
            $limit,
            $offset
        );

        // Obtém o total de usuários para a paginação
        $totalUsers = $userModel->countFilteredUsers(
            $search,
            $filter_role,
            $filter_sector
        );
        $totalPages = ceil($totalUsers / $limit);

        $sectors = $sectorModel->getAll(); // Pega todos os setores para o dropdown de filtro

        require_once 'app/views/users/index.php';
    }

    public function create()
    {


        $user = new User();
        $user->create($_POST['username'], $_POST['password'], $_POST['email'], $_POST['full_name'], $_POST['sector_id'] ?: null, $_POST['role']);

        header('Location: /energy-system/users');
    }

    public function showEditForm()
    {


        $user = new User();
        $user_data = $user->findById($_GET['id']);

        $sector = new Sector();
        $sectors = $sector->getAll();

        require_once 'app/views/users/edit.php';
    }

    public function update()
    {


        $user = new User();
        $user->update($_POST['id'], $_POST['email'], $_POST['full_name'], $_POST['sector_id'] ?: null);
        $user->updateRole($_POST['id'], $_POST['role']);

        header('Location: /energy-system/users');
    }

    public function delete()
    {


        $user = new User();
        $user->delete($_POST['id']);

        header('Location: /energy-system/users');
    }
}
