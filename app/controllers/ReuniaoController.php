<?php

require_once 'app/models/Reuniao.php';
require_once 'app/models/User.php';
require_once 'app/models/Notification.php';

class ReuniaoController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $reuniao_model = new Reuniao();
        $reunioes = $reuniao_model->getReunioesByUser($_SESSION['user_id']);

        include 'app/views/reunioes/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $user_model = new User();
        $users = $user_model->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'];
            $descricao = $_POST['descricao'];
            $data_hora = $_POST['data_hora'];
            $participantes_json = $_POST['participantes_json'] ?? '[]';
            $participantes = json_decode($participantes_json, true);
            $criador_id = $_SESSION['user_id'];

            $reuniao_model = new Reuniao();
            $reuniao_id = $reuniao_model->create($titulo, $descricao, $data_hora, $criador_id, $participantes);

            if ($reuniao_id) {
                $notification_model = new Notification();
                $reuniao_link = "/energy-system/reunioes/show?id=" . $reuniao_id;
                foreach ($participantes as $participante_id) {
                    $message = "Você foi convidado para a reunião: \"" . $titulo . "\".";
                    $notification_model->create($participante_id, $message, $reuniao_link);
                }
                header("Location: /energy-system/reunioes");
            } else {
                $error = "Erro ao criar a reunião.";
                include 'app/views/reunioes/create.php';
            }
        } else {
            include 'app/views/reunioes/create.php';
        }
    }

    public function show()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo "ID da reunião não fornecido.";
            exit();
        }

        $reuniao_model = new Reuniao();
        $reuniao = $reuniao_model->findById($id);
        $participantes = $reuniao_model->getParticipantes($id);

        if (!$reuniao) {
            http_response_code(404);
            echo "Reunião não encontrada.";
            exit();
        }

        include 'app/views/reunioes/show.php';
    }

    public function respond()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $status = $_POST['status'];
            $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : null;
            $user_id = $_SESSION['user_id'];

            $reuniao_model = new Reuniao();
            $reuniao_model->respond($id, $user_id, $status, $motivo);

            header("Location: /energy-system/reunioes/show?id=" . $id);
        }
    }

    public function updateStatus()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $reuniao_model = new Reuniao();
            $reuniao = $reuniao_model->findById($id);

            if ($reuniao['criador_id'] != $_SESSION['user_id']) {
                http_response_code(403);
                echo "Acesso negado.";
                exit();
            }

            $status = $_POST['status'];
            $reuniao_model->updateStatus($id, $status);

            header("Location: /energy-system/reunioes/show?id=" . $id);
        }
    }

    public function delete()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $reuniao_model = new Reuniao();
            $reuniao = $reuniao_model->findById($id);

            if ($reuniao['criador_id'] != $_SESSION['user_id']) {
                http_response_code(403);
                echo "Acesso negado.";
                exit();
            }

            $reuniao_model->delete($id);
            header("Location: /energy-system/reunioes");
        }
    }
}