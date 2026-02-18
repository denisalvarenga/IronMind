<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}

require_once "config/database.php";

$user_id = $_SESSION["user_id"];

// Pega todos os treinos do usuário
$stmtTreinos = $pdo->prepare("SELECT * FROM treinos WHERE user_id = ? ORDER BY criado_em DESC");
$stmtTreinos->execute([$user_id]);
$treinos = $stmtTreinos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Histórico - IronMind</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
<h1>Histórico de Treinos</h1>

<?php if ($treinos): ?>
    <?php foreach ($treinos as $treino): ?>
        <div class="card">
            <strong>Dia:</strong> <?= htmlspecialchars($treino["dia_semana"]); ?><br>
            <small>Criado em: <?= $treino["criado_em"]; ?></small>
            <div class="tabela-treino" style="margin-top:10px;">
                <?php
                // Pega os exercícios desse treino
                $stmtEx = $pdo->prepare("SELECT * FROM exercicios_treinos WHERE treino_id = ?");
                $stmtEx->execute([$treino["id"]]);
                $exercicios = $stmtEx->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php if ($exercicios): ?>
                    <?php foreach ($exercicios as $ex): ?>
                        <div class="linha">
                            <div class="exercicio"><?= htmlspecialchars($ex["exercicio"]); ?></div>
                            <div class="series"><?= htmlspecialchars($ex["series"]); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum exercício registrado.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Você ainda não tem treinos salvos.</p>
<?php endif; ?>

<br><br>
<a href="dashboard.php">← Voltar para o Dashboard</a>
</div>

</body>
</html>

