<?php

require_once 'app/models/User.php';
require_once 'app/models/Sector.php';

class UserController
{
    public function index()
    {


        $user = new User();
        $users = $user->getAll();

        $sector = new Sector();
        $sectors = $sector->getAll();

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
