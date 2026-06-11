<?php
session_start();
require_once 'conexao.php';

$erro    = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome']);
    $email    = trim($_POST['email']);
    $senha    = $_POST['senha'];
    $confirma = $_POST['confirma_senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } elseif ($senha !== $confirma) {
        $erro = "As senhas não coincidem.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha precisa ter pelo menos 6 caracteres.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() > 0) {
            $erro = "Este e-mail já está cadastrado.";
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
            $stmt->execute([':nome' => $nome, ':email' => $email, ':senha' => $senha_hash]);
            $sucesso = "Cadastro realizado! Você já pode fazer login.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Ponto de Escuta</title>
    <link rel="stylesheet" href="style.css?v=2" />
</head>
<body>

<div class="form-page">
    <div class="form-box">
        <h2>Criar conta</h2>

        <?php if ($erro): ?>
            <p class="msg-erro">❌ <?= $erro ?></p>
        <?php endif; ?>
        <?php if ($sucesso): ?>
            <p class="msg-sucesso">✅ <?= $sucesso ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nome">Nome completo</label>
            <input type="text" id="nome" name="nome" required
                   value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                   placeholder="Seu nome">

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   placeholder="seu@email.com">

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required placeholder="Mínimo 6 caracteres">

            <label for="confirma_senha">Confirmar senha</label>
            <input type="password" id="confirma_senha" name="confirma_senha" required placeholder="Repita a senha">

            <button type="submit" style="width:100%;">Cadastrar</button>
        </form>

        <p>Já tem conta? <a href="login.php">Faça login aqui</a></p>
    </div>
</div>

</body>
</html>