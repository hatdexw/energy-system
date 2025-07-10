<?php

require_once 'app/models/Audit.php';

class AuditController
{
    public function index()
    {
        

        $audit = new Audit();
        $audits = $audit->getAllByUserId($_SESSION['user_id']);

        require_once 'app/views/audits/index.php';
    }

    public function create()
    {
        

        $audit = new Audit();
        $audit->create($_SESSION['user_id'], $_POST['title'], $_POST['description'], $_POST['audit_date']);

        header('Location: /energy-system/audits');
    }
}
