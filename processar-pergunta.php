<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pergunta = trim($_POST['pergunta']);

    if (!empty($email) && !empty($pergunta)) {
        try {
            $sql = "INSERT INTO chamados_ajuda (email, pergunta) VALUES (:email, :pergunta)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email, ':pergunta' => $pergunta]);

            // Redireciona de volta com mensagem de sucesso
            echo "<script>
                alert('Sua dúvida foi enviada! Volte aqui e use seu e-mail para ver a resposta.');
                window.location.href='perguntas.php';
            </script>";
        } catch (PDOException $e) {
            echo "Erro ao salvar: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    }
}
?>