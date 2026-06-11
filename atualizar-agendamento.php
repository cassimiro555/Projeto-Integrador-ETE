<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int) $_POST['id'];
    $status = $_POST['status'];
    $aviso  = trim($_POST['aviso']);

    // Garante que o status só aceite valores válidos
    $status_validos = ['pendente', 'confirmado', 'cancelado'];
    if (!in_array($status, $status_validos)) {
        die("Status inválido.");
    }

    try {
        $sql = "UPDATE agendamentos SET status = :status, aviso = :aviso WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':aviso'  => $aviso,
            ':id'     => $id
        ]);

        echo "<script>
            alert('Agendamento atualizado com sucesso!');
            window.location.href='painel-psicologa.php';
        </script>";
    } catch (PDOException $e) {
        echo "Erro ao atualizar: " . $e->getMessage();
    }
}
?>