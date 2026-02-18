<?php
session_start();
require_once __DIR__ . "/../config/database.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    $stmt = $pdo->prepare("SELECT * FROM contas WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user["senha"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_nome"] = $user["nome"];
        header("Location: ../dashboard.php");
        exit;
    } else {
        $msg = "Email ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login - IronMind</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body class="auth-body">

<div class="auth-wrapper">

    <div class="auth-logo">IRON<span>MIND</span></div>
    <div class="auth-subtitle">Treinos inteligentes & Gestão de água personalizada</div>

    <div class="auth-container">
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>

        <?php if ($msg): ?>
            <p class="auth-msg"><?= htmlspecialchars($msg); ?></p>
        <?php endif; ?>

        <div class="auth-link">
            Não tem conta? <a href="cadastro.php">Criar conta</a>
        </div>
    </div>

</div>
</body>
</html>