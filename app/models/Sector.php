<?php

require_once 'app/config/database.php';

class Sector
{
    public function create($name, $description, $parent_id = null)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO sectors (name, description, parent_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $description, $parent_id);

        return $stmt->execute();
    }

    public function getAll()
    {
        global $conn;

        $result = $conn->query("SELECT * FROM sectors");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM sectors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function update($id, $name, $description, $parent_id = null)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE sectors SET name = ?, description = ?, parent_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $name, $description, $parent_id, $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM sectors WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
