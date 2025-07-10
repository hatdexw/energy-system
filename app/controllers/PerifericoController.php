<?php
require_once 'app/models/Periferico.php';

class PerifericoController {
    public function index() {
        $periferico_model = new Periferico();
        $perifericos = $periferico_model->getAll();
        require 'app/views/perifericos/index.php';
    }

    public function create() {
        require 'app/views/perifericos/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $periferico_model = new Periferico();
            $periferico_model->create(
                $_POST['nome'],
                $_POST['marca'],
                $_POST['modelo'],
                $_POST['numero_serie'],
                $_POST['patrimonio'],
                $_POST['localizacao'],
                $_POST['status'],
                $_POST['observacoes']
            );
            header('Location: /energy-system/perifericos');
        }
    }

    public function edit($id) {
        $periferico_model = new Periferico();
        $periferico = $periferico_model->find($id);
        require 'app/views/perifericos/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $periferico_model = new Periferico();
            $periferico_model->update(
                $_POST['id'],
                $_POST['nome'],
                $_POST['marca'],
                $_POST['modelo'],
                $_POST['numero_serie'],
                $_POST['patrimonio'],
                $_POST['localizacao'],
                $_POST['status'],
                $_POST['observacoes']
            );
            header('Location: /energy-system/perifericos');
        }
    }

    public function delete($id) {
        $periferico_model = new Periferico();
        $periferico_model->delete($id);
        header('Location: /energy-system/perifericos');
    }
}
?>