<?php

require_once 'app/config/database.php';

class Document
{
    public function create($user_id, $filename, $filepath)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO documents (user_id, filename, filepath) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $filename, $filepath);

        return $stmt->execute();
    }

    public function getAllByUserId($user_id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM documents WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
