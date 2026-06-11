<?php
require_once 'conexao.php';

// Busca perguntas pendentes
$stmt = $pdo->query("
    SELECT * FROM chamados_ajuda 
    WHERE status = 'pendente' 
    ORDER BY data_envio ASC
");
$perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Busca todos os agendamentos ordenados por data
$stmt_ag = $pdo->query("
    SELECT * FROM agendamentos 
    ORDER BY data_agendada ASC, hora_agendada ASC
");
$agendamentos = $stmt_ag->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel da Psicóloga</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="container">

<!-- ========== SEÇÃO 1: PERGUNTAS ========== -->
<h2>📋 Perguntas Pendentes</h2>

<?php if (count($perguntas) === 0): ?>
    <p>✅ Nenhuma pergunta pendente no momento!</p>
<?php else: ?>
    <?php foreach ($perguntas as $p): ?>
        <div class="card">
            <p><strong>De:</strong> <?= htmlspecialchars($p['email']) ?></p>
            <p><strong>Pergunta:</strong> <?= htmlspecialchars($p['pergunta']) ?></p>
            <p><small>Enviado em: <?= date('d/m/Y H:i', strtotime($p['data_envio'])) ?></small></p>

            <form method="POST" action="enviar-resposta.php">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <input type="hidden" name="email_destino" value="<?= $p['email'] ?>">
                <input type="hidden" name="pergunta_original" value="<?= htmlspecialchars($p['pergunta']) ?>">

                <label><strong>Sua Resposta:</strong></label>
                <textarea name="resposta" rows="4" required placeholder="Digite a resposta aqui..."></textarea>

                <div class="opcao-visibilidade">
                    <strong>Visibilidade:</strong><br>
                    <label><input type="radio" name="publica" value="0" checked> 🔒 Privada</label>
                    <label><input type="radio" name="publica" value="1"> 🌍 Pública</label>
                </div>

                <button type="submit" class="btn-verde">Salvar Resposta</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<!-- ========== SEÇÃO 2: AGENDAMENTOS ========== -->
<div class="secao">
    <h2>📅 Agendamentos</h2>

    <?php if (count($agendamentos) === 0): ?>
        <p>Nenhum agendamento ainda.</p>
    <?php else: ?>
        <?php foreach ($agendamentos as $ag): ?>
            
            <div class="card">
                  <form method="POST" action="excluir-agendamento.php" 
                    style="float:right;"
                    onsubmit="return confirm('Tem certeza que deseja excluir este agendamento? Esta ação não pode ser desfeita.')">
                    <input type="hidden" name="id" value="<?= $ag['id'] ?>">
                    <input type="hidden" name="origem" value="painel-psicologa.php">
                    <button type="submit" class="btn-vermelho">🗑️ Excluir</button>
                </form>
                <p><strong>Aluno:</strong> <?= htmlspecialchars($ag['nome_aluno']) ?></p>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($ag['email_aluno']) ?></p>
                <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($ag['data_agendada'])) ?></p>
                <p><strong>Horário:</strong> <?= date('H:i', strtotime($ag['hora_agendada'])) ?></p>
                <p><strong>Status atual:</strong> 
                   <span class="status-<?= $ag['status'] ?>"><?= ucfirst($ag['status']) ?></span>
                </p>

                <!-- Mostra aviso atual se tiver -->
                <?php if (!empty($ag['aviso'])): ?>
                    <div class="aviso-atual">
                        <strong>Aviso atual:</strong> <?= nl2br(htmlspecialchars($ag['aviso'])) ?>
                    </div>
                <?php endif; ?>

                <!-- Formulário para mudar status e deixar aviso -->
                <form method="POST" action="atualizar-agendamento.php" style="margin-top:12px;">
                    <input type="hidden" name="id" value="<?= $ag['id'] ?>">

                    <label><strong>Aviso para o aluno (opcional):</strong></label>
                    <textarea name="aviso" rows="2" 
                              placeholder="Ex: Consulta remarcada para outra data..."
                    ><?= htmlspecialchars($ag['aviso'] ?? '') ?></textarea>

                    <label><strong>Alterar status:</strong></label><br>
                    <select name="status" style="padding:6px; border-radius:4px; margin-top:5px;">
                        <option value="pendente"   <?= $ag['status']==='pendente'   ? 'selected':'' ?>>⏳ Pendente</option>
                        <option value="confirmado" <?= $ag['status']==='confirmado' ? 'selected':'' ?>>✅ Confirmado</option>
                        <option value="cancelado"  <?= $ag['status']==='cancelado'  ? 'selected':'' ?>>❌ Cancelado</option>
                    </select><br>

                    <button type="submit" class="btn-azul">Salvar alteração</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>