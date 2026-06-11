<?php
require_once 'auth.php'; // Protege a página
require_once 'conexao.php';

// Pega nome e e-mail direto da sessão de login — aluno não precisa digitar
$nome_logado  = $_SESSION['usuario_nome'];
$email_logado = $_SESSION['usuario_email'];

$msg_erro = '';
$msg_sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    $stmt = $pdo->prepare("
        SELECT id FROM agendamentos 
        WHERE data_agendada = ? AND hora_agendada = ? AND status != 'cancelado'
    ");
    $stmt->execute([$data, $hora]);

    if ($stmt->rowCount() > 0) {
        $msg_erro = "Este horário já está reservado. Escolha outro!";
    } else {
        $insere = $pdo->prepare("
            INSERT INTO agendamentos (nome_aluno, email_aluno, data_agendada, hora_agendada) 
            VALUES (?, ?, ?, ?)
        ");
        $insere->execute([$nome_logado, $email_logado, $data, $hora]);
        $msg_sucesso = "Agendamento solicitado com sucesso! Fique de olho nessa página.";
    }
}

// Busca todos os horários já ocupados (agrupa por data)
$stmtOcupados = $pdo->query("
    SELECT data_agendada, hora_agendada 
    FROM agendamentos 
    WHERE status != 'cancelado'
");
$horariosOcupados = [];
foreach ($stmtOcupados->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $data_fmt = $row['data_agendada']; // formato YYYY-MM-DD
    $hora_fmt = substr($row['hora_agendada'], 0, 5); // garante HH:MM
    $horariosOcupados[$data_fmt][] = $hora_fmt;
}

// Busca agendamentos do usuário logado
$stmt = $pdo->prepare("
    SELECT * FROM agendamentos 
    WHERE email_aluno = :email 
    ORDER BY data_agendada ASC, hora_agendada ASC
");
$stmt->execute([':email' => $email_logado]);
$meus_agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Todos os horários possíveis no sistema
$todos_horarios = ['14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agendamento - Ponto de Escuta</title>
    <link rel="stylesheet" href="style.css">
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
    <h2>Área de Agendamento</h2>

    <?php if ($msg_erro): ?>
        <p style="color:red;">❌ <?= $msg_erro ?></p>
    <?php endif; ?>
    <?php if ($msg_sucesso): ?>
        <p style="color:green;">✅ <?= $msg_sucesso ?></p>
    <?php endif; ?>

    <form method="POST" action="" id="form-agendamento">
        <!-- Nome e e-mail são exibidos mas não editáveis — vêm do login -->
        <p><strong>Nome:</strong> <?= htmlspecialchars($nome_logado) ?></p>
        <p><strong>E-mail:</strong> <?= htmlspecialchars($email_logado) ?></p>

        <label for="data">Data da consulta:</label><br>
        <input type="date" id="data" name="data" min="<?= date('Y-m-d') ?>" required><br><br>

        <!-- Aviso de sem vagas -->
        <div id="aviso-sem-vagas" style="display:none; background:#f8d7da; border-left:4px solid #dc3545; padding:10px 15px; margin-bottom:10px; border-radius:4px;">
            😕 <strong>Não há mais vagas disponíveis neste dia.</strong> Por favor, escolha outra data.
        </div>

        <label for="hora">Horário:</label><br>
        <select id="hora" name="hora" required>
            <option value="" disabled selected>Selecione um horário</option>
            <?php foreach ($todos_horarios as $h): ?>
                <option value="<?= $h ?>"><?= $h ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit" id="btn-agendar">Solicitar Agendamento</button>
    </form>

    <!-- MEUS AGENDAMENTOS -->
    <div>
        <h2>Meus Agendamentos</h2>

        <?php if (count($meus_agendamentos) === 0): ?>
            <p>Você ainda não tem agendamentos.</p>
        <?php else: ?>
            <?php foreach ($meus_agendamentos as $ag): ?>
                <div style="position:relative; border:1px solid #ccc; padding:15px; margin-bottom:15px;">

                    <!-- Botão excluir canto superior direito -->
                    <form method="POST" action="excluir-agendamento.php"
                          style="position:absolute; top:10px; right:10px;"
                          onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?')">
                        <input type="hidden" name="id" value="<?= $ag['id'] ?>">
                        <input type="hidden" name="origem" value="agendamento.php">
                        <button type="submit">🗑️ Excluir</button>
                    </form>

                    <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($ag['data_agendada'])) ?></p>
                    <p><strong>Horário:</strong> <?= date('H:i', strtotime($ag['hora_agendada'])) ?></p>
                    <p><strong>Status:</strong>
                        <?php
                        $icons = [
                            'pendente'   => '⏳ Aguardando confirmação',
                            'confirmado' => '✅ Confirmado',
                            'cancelado'  => '❌ Cancelado'
                        ];
                        echo $icons[$ag['status']];
                        ?>
                    </p>

                    <?php if (!empty($ag['aviso'])): ?>
                        <div style="background:#fff3cd; border-left:4px solid #ffc107; padding:10px; margin-top:10px;">
                            <strong>📢 Aviso da psicóloga:</strong>
                            <p><?= nl2br(htmlspecialchars($ag['aviso'])) ?></p>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</main>

<script>
    // Horários ocupados vindos do PHP (objeto: { "2025-07-10": ["14:00","15:00"], ... })
    const horariosOcupados = <?= json_encode($horariosOcupados) ?>;

    // Todos os horários possíveis
    const todosHorarios = <?= json_encode($todos_horarios) ?>;

    const campoDdata  = document.getElementById('data');
    const selectHora  = document.getElementById('hora');
    const avisoSemVagas = document.getElementById('aviso-sem-vagas');
    const btnAgendar  = document.getElementById('btn-agendar');

    campoDdata.addEventListener('change', function () {
        const dataSelecionada = this.value; // formato YYYY-MM-DD
        const ocupados = horariosOcupados[dataSelecionada] || [];

        // Limpa o select mantendo só o placeholder
        selectHora.innerHTML = '<option value="" disabled selected>Selecione um horário</option>';

        let disponiveis = 0;

        todosHorarios.forEach(function (hora) {
            const option = document.createElement('option');
            option.value = hora;
            option.textContent = hora;

            if (ocupados.includes(hora)) {
                // Horário já reservado — desabilita e mostra indicação
                option.disabled = true;
                option.textContent = hora + ' — reservado';
                option.style.color = '#aaa';
            } else {
                disponiveis++;
            }

            selectHora.appendChild(option);
        });

        // Sem nenhum horário livre → mostra aviso e desabilita botão
        if (disponiveis === 0) {
            avisoSemVagas.style.display = 'block';
            selectHora.disabled = true;
            btnAgendar.disabled = true;
        } else {
            avisoSemVagas.style.display = 'none';
            selectHora.disabled = false;
            btnAgendar.disabled = false;
        }
    });
</script>

</body>
</html>