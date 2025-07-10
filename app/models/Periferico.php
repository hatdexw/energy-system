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
}
?>