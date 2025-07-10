<?php

require_once 'app/models/User.php';

class ProfileController
{
    public function index()
    {
        

        $user = new User();
        $user_data = $user->findById($_SESSION['user_id']);

        $sector = new Sector();
        $sectors = $sector->getAll();

        require_once 'app/views/profile/index.php';
    }

    public function update()
    {
        

        $user = new User();
        $user->update($_SESSION['user_id'], $_POST['email'], $_POST['full_name'], $_POST['sector_id'] ?: null);

        header('Location: /energy-system/profile');
    }
}
