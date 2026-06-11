<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: inicio.php'); exit;
}
require_once 'conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id']    = $usuario['id'];
            $_SESSION['usuario_nome']  = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            header('Location: inicio.php'); exit;
        } else {
            $erro = "E-mail ou senha incorretos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ponto de Escuta</title>
    <link rel="stylesheet" href="style.css?v=2" />
</head>
<body>

<div class="form-page">
    <div class="form-box">
        <h2>Entrar</h2>

        <?php if ($erro): ?>
            <p class="msg-erro">❌ <?= $erro ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   placeholder="seu@email.com">

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required placeholder="••••••••">

            <button type="submit" style="width:100%;">Entrar</button>
        </form>

        <p>Não tem conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
    </div>
</div>

</body>
</html>