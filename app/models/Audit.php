<?php

require_once 'app/config/database.php';

class Audit
{
    public function create($user_id, $title, $description, $audit_date)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO audits (user_id, title, description, audit_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $title, $description, $audit_date);

        return $stmt->execute();
    }

    public function getAllByUserId($user_id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM audits WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll()
    {
        global $conn;

        $stmt = $conn->prepare("SELECT a.*, u.full_name FROM audits a JOIN users u ON a.user_id = u.id ORDER BY a.audit_date DESC LIMIT 5");
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
