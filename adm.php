<?php
$pdo = new PDO('mysql:host=localhost;dbname=nome_do_banco', 'usuario', 'senha');

// Se a psicóloga respondeu a uma pergunta
if (isset($_POST['responder'])) {
    $id_pergunta = $_POST['id_pergunta'];
    $resposta = $_POST['resposta'];
    $email_aluno = $_POST['email_aluno'];
    $pergunta_original = $_POST['pergunta_original'];

    // 1. Atualiza o banco de dados
    $stmt = $pdo->prepare("UPDATE perguntas SET resposta = ?, respondida = 1 WHERE id = ?");
    $stmt->execute([$resposta, $id_pergunta]);

    // 2. Envia o E-mail (Exemplo simplificado com mail())
    $para = $email_aluno;
    $assunto = "Resposta da Psicologia Escolar";
    $mensagem = "Olá!\n\nVocê enviou a seguinte dúvida:\n\"$pergunta_original\"\n\nResposta da psicóloga:\n$resposta";
    $cabecalhos = "From: psicologia@escola.com" . "\r\n" . "Reply-To: psicologia@escola.com";

    if(mail($para, $assunto, $mensagem, $cabecalhos)) {
        echo "<script>alert('Resposta enviada com sucesso para o e-mail do aluno!');</script>";
    } else {
        echo "<script>alert('Respondido no banco, mas houve falha ao enviar o e-mail.');</script>";
    }
}

// Buscar perguntas que ainda não foram respondidas
$perguntas = $pdo->query("SELECT * FROM perguntas WHERE respondida = 0")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel da Psicóloga</title>
</head>
<body>
    <h2>Perguntas Recebidas</h2>

    <?php if (count($perguntas) == 0): ?>
        <p>Não há perguntas pendentes no momento. 🎉</p>
    <?php else: ?>
        <?php foreach ($perguntas as $p): ?>
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
                <p><strong>De:</strong> <?= htmlspecialchars($p['nome_usuario']) ?> (<?= htmlspecialchars($p['email_usuario']) ?>)</p>
                <p><strong>Pergunta:</strong> <?= htmlspecialchars($p['pergunta']) ?></p>
                
                <form method="POST" action="">
                    <input type="hidden" name="id_pergunta" value="<?= $p['id'] ?>">
                    <input type="hidden" name="email_aluno" value="<?= $p['email_usuario'] ?>">
                    <input type="hidden" name="pergunta_original" value="<?= $p['pergunta'] ?>">
                    
                    <label>Sua Resposta:</label><br>
                    <textarea name="resposta" rows="4" cols="50" required></textarea><br><br>
                    
                    <button type="submit" name="responder">Enviar Resposta por E-mail</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>