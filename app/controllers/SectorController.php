<?php

require_once 'app/models/Sector.php';

class SectorController
{
    public function index()
    {


        $sector = new Sector();
        $sectors = $sector->getAll();

        require_once 'app/views/sectors/index.php';
    }

    public function create()
    {


        $sector = new Sector();
        $sector->create($_POST['name'], $_POST['description'], $_POST['parent_id'] ?: null);

        header('Location: /energy-system/sectors');
    }

    public function showEditForm()
    {


        $sector = new Sector();
        $sector_data = $sector->findById($_GET['id']);
        $all_sectors = $sector->getAll();

        require_once 'app/views/sectors/edit.php';
    }

    public function update()
    {


        $sector = new Sector();
        $sector->update($_POST['id'], $_POST['name'], $_POST['description'], $_POST['parent_id'] ?: null);

        header('Location: /energy-system/sectors');
    }

    public function delete()
    {


        $sector = new Sector();
        $sector->delete($_POST['id']);

        header('Location: /energy-system/sectors');
    }
}
