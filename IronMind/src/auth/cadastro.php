<?php
require_once __DIR__ . "/../config/database.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO contas (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        $msg = "Cadastro realizado! <a href='login.php'>Fazer login</a>";
    } catch (PDOException $e) {
        $msg = "Email já cadastrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro - IronMind</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body class="auth-body">

<div class="auth-container">

    <img src="../assets/logo.png" class="logo-top">

    <div class="auth-title">IRON<span>MIND</span></div>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Cadastrar</button>
    </form>

    <?php if ($msg): ?>
        <p class="auth-msg"><?= $msg; ?></p>
    <?php endif; ?>

    <div class="auth-link">
        Já tem conta? <a href="login.php">Entrar</a>
    </div>

</div>
</body>
</html>