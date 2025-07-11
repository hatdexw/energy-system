<?php

require_once 'app/models/NormativeDocument.php';
require_once 'app/models/Sector.php';

class NormativeDocumentController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $normativeDocumentModel = new NormativeDocument();
        $documents = $normativeDocumentModel->getAll($_SESSION['user_id'], $_SESSION['role']);

        include 'app/views/normative_documents/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $document_number = $_POST['document_number'] ?? null;
            $issue_date = $_POST['issue_date'] ?? null;
            $version = $_POST['version'] ?? null;
            $unidade = "E-ENERGY INDÚSTRIA DE PRODUTOS MAGNÉTICOS LTDA"; // Valor fixo
            $area = $_POST['area'] ?? null;
            $validade = $_POST['validade'] ?? null;
            $created_by = $_SESSION['user_id'];

            $normativeDocumentModel = new NormativeDocument();
            if ($normativeDocumentModel->create($title, $content, $document_number, $issue_date, $version, $unidade, $area, $validade, $created_by, 'Rascunho')) {
                header("Location: /energy-system/normative_documents");
            } else {
                $error = "Erro ao criar o documento normativo.";
                include 'app/views/normative_documents/create.php';
            }
        } else {
            $sectorModel = new Sector();
            $sectors = $sectorModel->getAll();
            include 'app/views/normative_documents/create.php';
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
            echo "ID do documento não fornecido.";
            exit();
        }

        $normativeDocumentModel = new NormativeDocument();
        $document = $normativeDocumentModel->findById($id, $_SESSION['user_id'], $_SESSION['role']);

        if (!$document) {
            http_response_code(404);
            echo "Documento não encontrado.";
            exit();
        }

        include 'app/views/normative_documents/show.php';
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo "ID do documento não fornecido.";
            exit();
        }

        $normativeDocumentModel = new NormativeDocument();
        $document = $normativeDocumentModel->findById($id);

        if (!$document) {
            http_response_code(404);
            echo "Documento não encontrado.";
            exit();
        }

        // Apenas o criador pode editar
        if ($document['created_by'] != $_SESSION['user_id']) {
            http_response_code(403);
            echo "Você não tem permissão para editar este documento.";
            exit();
        }

        $sectorModel = new Sector();
        $sectors = $sectorModel->getAll();

        include 'app/views/normative_documents/edit.php';
    }

    public function update()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $title = $_POST['title'];
            $content = $_POST['content'];
            $document_number = $_POST['document_number'] ?? null;
            $issue_date = $_POST['issue_date'] ?? null;
            $version = $_POST['version'] ?? null;
            $unidade = "E-ENERGY INDÚSTRIA DE PRODUTOS MAGNÉTICOS LTDA"; // Valor fixo
            $area = $_POST['area'] ?? null;
            $validade = $_POST['validade'] ?? null;

            if (!$id) {
                http_response_code(400);
                echo "ID do documento não fornecido.";
                exit();
            }

            $normativeDocumentModel = new NormativeDocument();
            $document = $normativeDocumentModel->findById($id);

            if (!$document) {
                http_response_code(404);
                echo "Documento não encontrado.";
                exit();
            }

            // Apenas o criador pode atualizar
            if ($document['created_by'] != $_SESSION['user_id']) {
                http_response_code(403);
                echo "Você não tem permissão para atualizar este documento.";
                exit();
            }

            if ($normativeDocumentModel->update($id, $title, $content, $document_number, $issue_date, $version, $unidade, $area, $validade)) {
                header("Location: /energy-system/normative_documents/show?id=" . $id);
            } else {
                $error = "Erro ao atualizar o documento normativo.";
                include 'app/views/normative_documents/edit.php';
            }
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

            if (!$id) {
                http_response_code(400);
                echo "ID do documento não fornecido.";
                exit();
            }

            $normativeDocumentModel = new NormativeDocument();
            $document = $normativeDocumentModel->findById($id);

            if (!$document) {
                http_response_code(404);
                echo "Documento não encontrado.";
                exit();
            }

            // Apenas o criador pode deletar
            if ($document['created_by'] != $_SESSION['user_id']) {
                http_response_code(403);
                echo "Você não tem permissão para deletar este documento.";
                exit();
            }

            if ($normativeDocumentModel->delete($id)) {
                header("Location: /energy-system/normative_documents");
            } else {
                $error = "Erro ao deletar o documento normativo.";
                // Poderíamos redirecionar de volta para a lista com uma mensagem de erro
                header("Location: /energy-system/normative_documents");
            }
        }
    }

    public function updateStatus()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        // Apenas administradores podem alterar o status
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo "Acesso negado. Apenas administradores podem alterar o status do documento.";
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? null;

            if (!$id || !$status) {
                http_response_code(400);
                echo "ID do documento ou status não fornecido.";
                exit();
            }

            $normativeDocumentModel = new NormativeDocument();
            if ($normativeDocumentModel->updateStatus($id, $status)) {
                header("Location: /energy-system/normative_documents/show?id=" . $id);
            } else {
                // Tratar erro, talvez redirecionar com mensagem
                header("Location: /energy-system/normative_documents/show?id=" . $id);
            }
        }
    }
}
