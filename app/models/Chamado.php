<?php

require_once 'app/config/database.php';

class Chamado
{
    public function create($titulo, $descricao, $tipo, $status, $prioridade, $user_id = null, $requerente_id)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO chamados (titulo, descricao, tipo, status, prioridade, user_id, requerente_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssii", $titulo, $descricao, $tipo, $status, $prioridade, $user_id, $requerente_id);

        return $stmt->execute();
    }

    public function getAll()
    {
        global $conn;

        $stmt = $conn->prepare("SELECT c.*, u.full_name as assigned_to_full_name FROM chamados c LEFT JOIN users u ON c.user_id = u.id ORDER BY c.created_at DESC");
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT c.*, u.full_name as assigned_to_full_name FROM chamados c LEFT JOIN users u ON c.user_id = u.id WHERE c.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function update($id, $titulo, $descricao, $status, $prioridade, $user_id = null)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE chamados SET titulo = ?, descricao = ?, status = ?, prioridade = ?, user_id = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $titulo, $descricao, $status, $prioridade, $user_id, $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM chamados WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function getFilteredAndPaginatedChamados($search, $filter_status, $filter_prioridade, $filter_assigned_to, $limit, $offset)
    {
        global $conn;

        $query = "SELECT c.*, u.full_name as assigned_to_full_name FROM chamados c LEFT JOIN users u ON c.user_id = u.id";
        $conditions = [];
        $params = [];
        $types = "";

        if (!empty($search)) {
            $conditions[] = "(c.titulo LIKE ? OR c.descricao LIKE ?)";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $types .= "ss";
        }
        if (!empty($filter_status)) {
            $conditions[] = "c.status = ?";
            $params[] = $filter_status;
            $types .= "s";
        }
        if (!empty($filter_prioridade)) {
            $conditions[] = "c.prioridade = ?";
            $params[] = $filter_prioridade;
            $types .= "s";
        }
        if (!empty($filter_assigned_to)) {
            $conditions[] = "c.user_id = ?";
            $params[] = $filter_assigned_to;
            $types .= "i";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY c.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countFilteredChamados($search, $filter_status, $filter_prioridade, $filter_assigned_to)
    {
        global $conn;

        $query = "SELECT COUNT(*) FROM chamados c LEFT JOIN users u ON c.user_id = u.id";
        $conditions = [];
        $params = [];
        $types = "";

        if (!empty($search)) {
            $conditions[] = "(c.titulo LIKE ? OR c.descricao LIKE ?)";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $types .= "ss";
        }
        if (!empty($filter_status)) {
            $conditions[] = "c.status = ?";
            $params[] = $filter_status;
            $types .= "s";
        }
        if (!empty($filter_prioridade)) {
            $conditions[] = "c.prioridade = ?";
            $params[] = $filter_prioridade;
            $types .= "s";
        }
        if (!empty($filter_assigned_to)) {
            $conditions[] = "c.user_id = ?";
            $params[] = $filter_assigned_to;
            $types .= "i";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_row()[0];
    }

    public function countAll()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM chamados");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_row()[0];
    }

    public function countByStatus($status)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM chamados WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_row()[0];
    }

    public function getRecentOpenChamados($limit = 5)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT c.*, u.full_name FROM chamados c LEFT JOIN users u ON c.user_id = u.id WHERE c.status = 'Aberto' ORDER BY c.created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
