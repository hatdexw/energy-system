<?php

require_once 'app/config/database.php';

class Reuniao
{
    public function create($titulo, $descricao, $data_hora, $criador_id, $participantes)
    {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO reunioes (titulo, descricao, data_hora, criador_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $titulo, $descricao, $data_hora, $criador_id);

        if ($stmt->execute()) {
            $reuniao_id = $conn->insert_id;
            $stmt_participante = $conn->prepare("INSERT INTO reuniao_participantes (reuniao_id, usuario_id) VALUES (?, ?)");
            foreach ($participantes as $participante_id) {
                $stmt_participante->bind_param("ii", $reuniao_id, $participante_id);
                $stmt_participante->execute();
            }
            return $reuniao_id;
        } else {
            return false;
        }
    }

    public function findById($id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT r.*, u.full_name as criador_nome FROM reunioes r JOIN users u ON r.criador_id = u.id WHERE r.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getParticipantes($reuniao_id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT u.id, u.full_name, u.email, rp.status, rp.motivo_recusa FROM reuniao_participantes rp JOIN users u ON rp.usuario_id = u.id WHERE rp.reuniao_id = ?");
        $stmt->bind_param("i", $reuniao_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getReunioesByUser($user_id)
    {
        global $conn;

        $stmt = $conn->prepare("
            SELECT r.*, u.full_name as criador_nome, rp.status as status_participante
            FROM reunioes r
            JOIN users u ON r.criador_id = u.id
            LEFT JOIN reuniao_participantes rp ON r.id = rp.reuniao_id AND rp.usuario_id = ?
            WHERE r.criador_id = ? OR rp.usuario_id = ?
            ORDER BY r.data_hora DESC
        ");
        $stmt->bind_param("iii", $user_id, $user_id, $user_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE reunioes SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);

        return $stmt->execute();
    }

    public function respond($reuniao_id, $user_id, $status, $motivo = null)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE reuniao_participantes SET status = ?, motivo_recusa = ? WHERE reuniao_id = ? AND usuario_id = ?");
        $stmt->bind_param("ssii", $status, $motivo, $reuniao_id, $user_id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM reunioes WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}