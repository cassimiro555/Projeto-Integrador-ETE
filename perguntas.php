<?php
require_once 'auth.php';
require_once 'conexao.php';

$email_logado = $_SESSION['usuario_email'];
$nome_logado  = $_SESSION['usuario_nome'];

// Busca respostas privadas do usuário logado
$stmt = $pdo->prepare("
    SELECT pergunta, resposta, publica, data_resposta 
    FROM chamados_ajuda 
    WHERE email = :email AND status = 'respondido'
    ORDER BY data_resposta DESC
");
$stmt->execute([':email' => $email_logado]);
$minhas_respostas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Busca perguntas públicas respondidas
$stmt_pub = $pdo->query("
    SELECT pergunta, resposta, data_resposta 
    FROM chamados_ajuda 
    WHERE publica = 1 AND status = 'respondido'
    ORDER BY data_resposta DESC
");
$respostas_publicas = $stmt_pub->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Caixinha de Perguntas - Ponto de Escuta</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<header>
    <h1>ETEPLAP</h1>
    <nav>
        <a href="inicio.php">Inicio</a>
        <a href="agendamento.php">Agendamento</a>
        <a href="psicologa.php">Nossa Psicóloga</a>
        <a href="sobre.php">Sobre</a>
    </nav>
    <p>Olá, <strong><?= htmlspecialchars($nome_logado) ?></strong> | 
       <a href="logout.php">Sair</a></p>
</header>

<main class="container">

    <h2>Envie sua dúvida para a psicóloga</h2>
    <p>Sua pergunta será respondida aqui mesmo, nesta página.</p>

    <form action="processar-pergunta.php" method="POST">
        <!-- E-mail vem da sessão, oculto — aluno não precisa digitar -->
        <input type="hidden" name="email" value="<?= htmlspecialchars($email_logado) ?>">

        <label for="pergunta">Sua Pergunta:</label><br>
        <textarea id="pergunta" name="pergunta" required 
                  placeholder="Digite aqui..."></textarea><br><br>

        <button type="submit">Enviar Pergunta</button>
    </form>

    <!-- MINHAS RESPOSTAS — aparecem automaticamente para o usuário logado -->
    <?php if (count($minhas_respostas) > 0): ?>
        <div style="margin-top:40px;">
            <h2>Minhas Respostas</h2>
            <?php foreach ($minhas_respostas as $r): ?>
                <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
                    <p><strong>Sua pergunta:</strong> <?= htmlspecialchars($r['pergunta']) ?></p>
                    <p><strong>Resposta da psicóloga:</strong> <?= nl2br(htmlspecialchars($r['resposta'])) ?></p>
                    <small>Respondido em: <?= date('d/m/Y H:i', strtotime($r['data_resposta'])) ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="margin-top:40px;">
            <h2>Minhas Respostas</h2>
            <p>⏳ Você ainda não tem respostas. Assim que a psicóloga responder, aparecerá aqui!</p>
        </div>
    <?php endif; ?>

    <!-- DÚVIDAS FREQUENTES PÚBLICAS -->
    <?php if (count($respostas_publicas) > 0): ?>
        <div style="margin-top:40px;">
            <h2>Dúvidas Frequentes</h2>
            <p>Essas respostas foram compartilhadas para ajudar mais pessoas.</p>
            <?php foreach ($respostas_publicas as $r): ?>
                <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
                    <p><strong>Dúvida:</strong> <?= htmlspecialchars($r['pergunta']) ?></p>
                    <p><strong>Resposta:</strong> <?= nl2br(htmlspecialchars($r['resposta'])) ?></p>
                    <small>Respondido em: <?= date('d/m/Y H:i', strtotime($r['data_resposta'])) ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>
</body>
</html>