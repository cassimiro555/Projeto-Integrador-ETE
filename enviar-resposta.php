<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = (int) $_POST['id'];          // (int) evita SQL injection
    $resposta = trim($_POST['resposta']);
    $publica  = isset($_POST['publica']) ? (int) $_POST['publica'] : 0; // 0 ou 1

    if (!empty($resposta) && $id > 0) {
        try {
            $sql = "
                UPDATE chamados_ajuda 
                SET resposta = :resposta, 
                    status = 'respondido', 
                    publica = :publica,
                    data_resposta = NOW()
                WHERE id = :id
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':resposta' => $resposta,
                ':publica'  => $publica,
                ':id'       => $id
            ]);

            echo "<script>
                alert('Resposta salva com sucesso!');
                window.location.href='painel-psicologa.php';
            </script>";
        } catch (PDOException $e) {
            echo "Erro ao salvar resposta: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Preencha a resposta antes de enviar.'); history.back();</script>";
    }
}
?>