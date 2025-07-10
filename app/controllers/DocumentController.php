<?php

require_once 'app/models/Document.php';

class DocumentController
{
    public function index()
    {
        

        $document = new Document();
        $documents = $document->getAllByUserId($_SESSION['user_id']);

        require_once 'app/views/documents/index.php';
    }

    public function upload()
    {
        

        if (isset($_FILES['document'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["document"]['name']);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["document"]['size'] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
            && $fileType != "gif" && $fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
                echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC, & DOCX files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["document"]['tmp_name'], $target_file)) {
                    $document = new Document();
                    $document->create($_SESSION['user_id'], $_FILES["document"]['name'], $target_file);
                    header('Location: /energy-system/documents');
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
}
