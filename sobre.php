<?php require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - Ponto de Escuta</title>
    <link rel="stylesheet" href="style.css?v=2" />
</head>
<body>

<header>
    <h1>ETEPLAP</h1>
    <nav>
        <a href="inicio.php">Início</a>
        <a href="agendamento.php">Agendamento</a>
        <a href="psicologa.php">Nossa Psicóloga</a>
        <a href="sobre.php">Sobre</a>
    </nav>
    <p>Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong> | <a href="logout.php">Sair</a></p>
</header>

<main class="container">

    <div class="sobre-box">
        <h2>Sobre o Ponto de Escuta</h2>

        <p>O Ponto de Escuta é um projeto desenvolvido por João Victor Cassimiro e Camile Canavarro, alunos do curso de Redes de Computadores da ETEPLAP, como parte do Projeto Integrador no primeiro módulo. O objetivo da plataforma é oferecer um espaço virtual seguro, discreto e acolhedor para que os estudantes possam compartilhar suas preocupações, desafios e sentimentos, além de facilitar o agendamento online de atendimentos com a psicóloga escolar.</p>

        <p>A ideia surgiu ao perceber que muitos alunos sentem vergonha, medo ou ansiedade de procurar ajuda presencialmente, mesmo precisando de apoio emocional e psicológico. Dessa forma, o site oferece uma maneira simples e rápida de marcar os horários, garantindo mais privacidade e conforto, sem a necessidade de enfrentar situações constrangedoras pessoalmente.</p>

        <p>Nosso propósito é proporcionar um ambiente onde os alunos possam se sentir ouvidos e apoiados, promovendo o bem-estar emocional e a saúde mental dentro do ambiente escolar. Através do Ponto de Escuta, esperamos criar uma comunidade de apoio e compreensão, mostrando aos estudantes que pedir ajuda é algo importante e necessário.</p>

        <p>Esta é uma iniciativa tecnológica desenvolvida pelos próprios alunos para melhorar a comunicação e o bem-estar na comunidade escolar. Estamos totalmente comprometidos em oferecer um serviço de qualidade e confidencialidade, garantindo que cada estudante se sinta seguro ao compartilhar sua experiência conosco.</p>
    </div>

</main>

<footer>
    <p>Site desenvolvido por João Victor Cassimiro e Camile Canavarro · Projeto Integrador — ETEPLAP</p>
</footer>

</body>
</html>