<?php

require_once 'app/models/Notification.php';

class NotificationController
{
    public function markAsRead()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /energy-system/login');
            exit();
        }

        $notification_id = $_GET['id'] ?? null;
        $user_id = $_SESSION['user_id'];

        $notificationModel = new Notification();

        if ($notification_id) {
            // Mark a single notification as read
            $notification = $notificationModel->findById($notification_id);
            if ($notification && $notification['user_id'] == $user_id) {
                $notificationModel->markAsRead($notification_id);
                if (!empty($notification['link'])) {
                    header('Location: ' . $notification['link']);
                    exit();
                }
            }
        } else {
            // Mark all notifications for the user as read
            $unread_notifications = $notificationModel->getUnreadNotifications($user_id);
            foreach ($unread_notifications as $notification) {
                $notificationModel->markAsRead($notification['id']);
            }
        }

        // Redirect back to the previous page or dashboard if no specific link was followed
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/energy-system/dashboard'));
        exit();
    }
}
