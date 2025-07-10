<?php
require_once 'app/models/Periferico.php';

class PerifericoController {
    public function index() {
        $periferico_model = new Periferico();

        // Parâmetros de busca e filtro
        $search = $_GET['search'] ?? '';
        $filter_status = $_GET['filter_status'] ?? '';
        $filter_localizacao = $_GET['filter_localizacao'] ?? '';

        // Parâmetros de paginação
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Número de periféricos por página
        $offset = ($page - 1) * $limit;

        // Obtém os periféricos filtrados e paginados
        $perifericos = $periferico_model->getFilteredAndPaginatedPerifericos(
            $search,
            $filter_status,
            $filter_localizacao,
            $limit,
            $offset
        );

        // Obtém o total de periféricos para a paginação
        $totalPerifericos = $periferico_model->countFilteredPerifericos(
            $search,
            $filter_status,
            $filter_localizacao
        );
        $totalPages = ceil($totalPerifericos / $limit);

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