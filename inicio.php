<?php require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Ponto de Escuta</title>
    <link rel="stylesheet" href="style.css?v=2" />
</head>
<body>

<header>
    <h1>PONTO DE ESCUTA</h1>
    <nav>
        <a href="inicio.php">Início</a>
        <a href="agendamento.php">Agendamento</a>
        <a href="psicologa.php">Nossa Psicóloga</a>
        <a href="sobre.php">Sobre</a>
    </nav>
    <p>Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong> | <a href="logout.php">Sair</a></p>
</header>

<main class="container">

    <h2 style="margin-bottom:22px;">O que você precisa hoje?</h2>

    <div class="cards-nav">
        <div class="card">
            <h2>Agendamento</h2>
            <p>Marque sua consulta para uma conversa com nossa psicóloga.</p>
            <a href="agendamento.php"><button class="botao-pagina">Fazer agendamento</button></a>
        </div>

        <div class="card">
            <h2>Psicóloga</h2>
            <p>Conheça nossa psicóloga e onde encontrá-la.</p>
            <a href="psicologa.php"><button class="botao-pagina">Conhecer</button></a>
        </div>

        <div class="card">
            <h2>Sobre</h2>
            <p>Saiba mais sobre o projeto Ponto de Escuta.</p>
            <a href="sobre.php"><button class="botao-pagina">Sobre</button></a>
        </div>

        <div class="card">
            <h2>Caixa de Perguntas</h2>
            <p>Faça uma pergunta ou tire uma dúvida com a psicóloga.</p>
            <a href="perguntas.php"><button class="botao-pagina">Perguntar</button></a>
        </div>
    </div>

</main>

<footer>
    <p>Site desenvolvido por João Victor Cassimiro e Camile Canavarro · Projeto Integrador — ETEPLAP</p>
</footer>

</body>
</html>