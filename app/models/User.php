<?php

require_once 'app/config/database.php';

class User
{
    public function create($username, $password, $email, $full_name, $sector_id = null, $role = 'user')
    {
        global $conn;

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name, sector_id, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $username, $hashed_password, $email, $full_name, $sector_id, $role);

        return $stmt->execute();
    }

    public function findByUsername($username)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT id, username, password, email, full_name, sector_id, role, profile_picture FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function findById($id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT id, username, password, email, full_name, sector_id, role, profile_picture FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function update($id, $email, $full_name, $sector_id = null)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE users SET email = ?, full_name = ?, sector_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $email, $full_name, $sector_id, $id);

        return $stmt->execute();
    }

    public function updateRole($id, $role)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $role, $id);

        return $stmt->execute();
    }

    public function getAll()
    {
        global $conn;

        $result = $conn->query("SELECT id, username, email, full_name, sector_id, role FROM users");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function delete($id)
    {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function updatePassword($id, $hashed_password)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $id);

        return $stmt->execute();
    }

    public function updateProfilePicture($id, $filepath)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
        $stmt->bind_param("si", $filepath, $id);

        return $stmt->execute();
    }
}
