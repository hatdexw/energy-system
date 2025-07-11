<?php

require_once 'app/config/database.php';

class Notification
{
    public function create($user_id, $message, $link = null)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, link) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $message, $link);

        return $stmt->execute();
    }

    public function getUnreadNotifications($user_id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function markAsRead($notification_id)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
        $stmt->bind_param("i", $notification_id);

        return $stmt->execute();
    }

    public function countUnreadNotifications($user_id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_row()[0];
    }

    public function findById($notification_id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM notifications WHERE id = ?");
        $stmt->bind_param("i", $notification_id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
