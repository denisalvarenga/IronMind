<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Dashboard - IronMind</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body class="dashboard-body">

<div class="symbiote" id="symbiote"></div>

<div class="dashboard-container">
    <div class="dashboard-buttons">
        <a href="gerador_de_treino.php">
            <button>Gerar Novo Treino</button>
        </a>

        <a href="historico.php">
            <button>Ver Histórico de Treinos</button>
        </a>

        <a href="auth/logout.php">
            <button class="logout">Sair</button>
        </a>
    </div>
</div>

<div class="welcome">
    Bem-vindo, <?= htmlspecialchars($_SESSION["user_nome"]); ?>
</div>

<script>
const symbiote = document.getElementById("symbiote");

let mouseX = window.innerWidth / 2;
let mouseY = window.innerHeight / 2;
let currentX = mouseX;
let currentY = mouseY;

document.addEventListener("mousemove", (e) => {
    mouseX = e.clientX - 250;
    mouseY = e.clientY - 250;
});

function animate() {
    currentX += (mouseX - currentX) * 0.05;
    currentY += (mouseY - currentY) * 0.05;

    symbiote.style.transform = `translate(${currentX}px, ${currentY}px)`;
    requestAnimationFrame(animate);
}

animate();
</script>

</body>
</html>






