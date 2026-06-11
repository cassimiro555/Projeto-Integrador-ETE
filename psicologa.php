<?php require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nossa Psicóloga - Ponto de Escuta</title>
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

    <div class="psicologa-hero">
        <h2>Maria Azinalda Neves Baptista</h2>
        <h3>Analista de Psicologia Educacional · ETEPLAP</h3>
    </div>

    <div class="psicologa-texto">
        <h3>Psicologia Educacional: escuta, acolhimento e construção de possibilidades</h3>

        <p>A Psicologia Educacional constitui um importante instrumento de cuidado, prevenção e promoção do desenvolvimento humano, favorecendo a formação integral dos estudantes e contribuindo para uma educação mais acolhedora, inclusiva e comprometida com o desenvolvimento das potencialidades de cada estudante.</p>

        <p>Atuo como Analista de Psicologia Educacional na Escola Técnica Estadual Professor Lucilo Ávila Pessoa, desenvolvendo ações voltadas ao acolhimento, à escuta qualificada, à orientação, ao acompanhamento e aos encaminhamentos necessários junto aos estudantes do Ensino Médio Integral e dos cursos técnicos subsequentes.</p>

        <p>Minhas atividades têm como foco a promoção da saúde emocional, o fortalecimento das habilidades socioemocionais e o apoio aos estudantes em seu processo de desenvolvimento pessoal, acadêmico e profissional, contribuindo para que enfrentam os desafios de sua trajetória e construam projetos de vida.</p>
    </div>

</main>

<footer>
    <p>Site desenvolvido por João Victor Cassimiro e Camile Canavarro · Projeto Integrador — ETEPLAP</p>
</footer>

</body>
</html>