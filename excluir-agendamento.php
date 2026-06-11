<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $origem = $_POST['origem'] ?? 'painel-psicologa.php';

    // Garante que origem só aceita páginas válidas (segurança)
    $paginas_validas = ['painel-psicologa.php', 'agendamento.php'];
    if (!in_array($origem, $paginas_validas)) {
        $origem = 'painel-psicologa.php';
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id = :id");
        $stmt->execute([':id' => $id]);

        echo "<script>
            alert('Agendamento excluído com sucesso!');
            window.location.href='" . $origem . "';
        </script>";
    } catch (PDOException $e) {
        echo "Erro ao excluir: " . $e->getMessage();
    }
}
?>