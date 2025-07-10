<?php

require_once 'app/models/User.php';

class ProfileController
{
    public function index()
    {
        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        $page_title = 'Meu Perfil';
        ob_start();
        include 'app/views/profile/index.php';
        $content = ob_get_clean();
        require_once 'app/views/layout/layout.php';
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $user_id = $_SESSION['user_id'];
            $file = $_FILES['profile_picture'];

            // Validar o arquivo
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowed_types)) {
                $_SESSION['error_message'] = 'Formato de arquivo inválido. Apenas JPG, PNG e GIF são permitidos.';
                header('Location: /energy-system/profile');
                exit;
            }

            if ($file['size'] > 2 * 1024 * 1024) { // 2MB
                $_SESSION['error_message'] = 'O arquivo é muito grande. O tamanho máximo é 2MB.';
                header('Location: /energy-system/profile');
                exit;
            }

            // Gerar um nome de arquivo único
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'profile_' . $user_id . '_' . time() . '.' . $extension;
            $filepath = 'uploads/profile_pictures/' . $filename;

            // Criar o diretório se não existir
            if (!is_dir('uploads/profile_pictures')) {
                mkdir('uploads/profile_pictures', 0777, true);
            }

            // Mover o arquivo
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                $userModel = new User();
                $userModel->updateProfilePicture($user_id, $filepath);

                $_SESSION['success_message'] = 'Foto de perfil atualizada com sucesso!';
            } else {
                $_SESSION['error_message'] = 'Ocorreu um erro ao enviar o arquivo.';
            }
        }

        header('Location: /energy-system/profile');
        exit;
    }
}
