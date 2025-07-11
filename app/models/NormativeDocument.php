<?php

require_once 'app/config/database.php';

class NormativeDocument
{
    public function create($title, $content, $document_number, $issue_date, $version, $unidade, $area, $validade, $created_by, $status = 'Rascunho')
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO normative_documents (title, content, document_number, issue_date, version, unidade, area, validade, created_by, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssis", $title, $content, $document_number, $issue_date, $version, $unidade, $area, $validade, $created_by, $status);

        return $stmt->execute();
    }

    public function findById($id, $user_id = null, $user_role = null)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT nd.*, u.full_name as created_by_name FROM normative_documents nd JOIN users u ON nd.created_by = u.id WHERE nd.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $document = $stmt->get_result()->fetch_assoc();

        if ($document) {
            // Admins can always view any document
            if ($user_role === 'admin') {
                return $document;
            }
            // Regular users can view approved documents or documents they created
            if ($document['status'] === 'Aprovado' || $document['created_by'] == $user_id) {
                return $document;
            }
        }
        return null; // Document not found or user does not have permission
    }

    public function getAll($user_id = null, $user_role = null)
    {
        global $conn;

        $query = "SELECT nd.*, u.full_name as created_by_name FROM normative_documents nd JOIN users u ON nd.created_by = u.id";
        $params = [];
        $types = "";

        if ($user_role === 'user') {
            $query .= " WHERE nd.status = 'Aprovado' OR nd.created_by = ?";
            $params[] = $user_id;
            $types .= "i";
        }

        $query .= " ORDER BY nd.created_at DESC";

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function update($id, $title, $content, $document_number, $issue_date, $version, $unidade, $area, $validade)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE normative_documents SET title = ?, content = ?, document_number = ?, issue_date = ?, version = ?, unidade = ?, area = ?, validade = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $title, $content, $document_number, $issue_date, $version, $unidade, $area, $validade, $id);

        return $stmt->execute();
    }

    public function updateStatus($id, $status)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE normative_documents SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM normative_documents WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
