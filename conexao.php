<?php
// Todas as páginas importam esse arquivo para conectar ao banco
// Troque os dados abaixo pelos seus
$host = 'localhost';
$dbname = 'ponto_de_escuta';
$usuario = 'root';
$senha = '';
$porta = '3307'; // troque para 3306 se for a porta padrão

try {
    $pdo = new PDO("mysql:host=$host;port=$porta;dbname=$dbname;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>