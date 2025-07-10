<?php
require_once 'app/config/database.php';

class Periferico {

    public function getAll() {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM perifericos ORDER BY id DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM perifericos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($nome, $marca, $modelo, $numero_serie, $patrimonio, $localizacao, $status, $observacoes) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO perifericos (nome, marca, modelo, numero_serie, patrimonio, localizacao, status, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nome, $marca, $modelo, $numero_serie, $patrimonio, $localizacao, $status, $observacoes);
        return $stmt->execute();
    }

    public function update($id, $nome, $marca, $modelo, $numero_serie, $patrimonio, $localizacao, $status, $observacoes) {
        global $conn;
        $stmt = $conn->prepare("UPDATE perifericos SET nome = ?, marca = ?, modelo = ?, numero_serie = ?, patrimonio = ?, localizacao = ?, status = ?, observacoes = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $nome, $marca, $modelo, $numero_serie, $patrimonio, $localizacao, $status, $observacoes, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM perifericos WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function countAll() {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM perifericos");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_row()[0];
    }

    public function getFilteredAndPaginatedPerifericos($search, $filter_status, $filter_localizacao, $limit, $offset) {
        global $conn;

        $query = "SELECT * FROM perifericos";
        $conditions = [];
        $params = [];
        $types = "";

        if (!empty($search)) {
            $conditions[] = "(nome LIKE ? OR marca LIKE ? OR modelo LIKE ? OR numero_serie LIKE ? OR patrimonio LIKE ? OR localizacao LIKE ?)";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $types .= "ssssss";
        }
        if (!empty($filter_status)) {
            $conditions[] = "status = ?";
            $params[] = $filter_status;
            $types .= "s";
        }
        if (!empty($filter_localizacao)) {
            $conditions[] = "localizacao = ?";
            $params[] = $filter_localizacao;
            $types .= "s";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countFilteredPerifericos($search, $filter_status, $filter_localizacao) {
        global $conn;

        $query = "SELECT COUNT(*) FROM perifericos";
        $conditions = [];
        $params = [];
        $types = "";

        if (!empty($search)) {
            $conditions[] = "(nome LIKE ? OR marca LIKE ? OR modelo LIKE ? OR numero_serie LIKE ? OR patrimonio LIKE ? OR localizacao LIKE ?)";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $params[] = "%" . $search . "%";
            $types .= "ssssss";
        }
        if (!empty($filter_status)) {
            $conditions[] = "status = ?";
            $params[] = $filter_status;
            $types .= "s";
        }
        if (!empty($filter_localizacao)) {
            $conditions[] = "localizacao = ?";
            $params[] = $filter_localizacao;
            $types .= "s";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();

        return $stmt->get_result()->fetch_row()[0];
    }
}
?>