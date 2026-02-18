<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}

require_once __DIR__ . "/config/database.php";

$resultado = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $peso = floatval($_POST["peso"] ?? 0);
    $altura = floatval($_POST["altura"] ?? 0);
    $idade = intval($_POST["idade"] ?? 0);
    $sexo = trim($_POST["sexo"] ?? "");
    $objetivo = trim($_POST["objetivo"] ?? "");
    $nivel = trim($_POST["nivel"] ?? "");

    $imc = ($altura > 0) ? $peso / ($altura * $altura) : 0;
    $aguaLitros = ($peso * 35) / 1000;

    $userId = $_SESSION["user_id"];
    $usuarioNome = $_SESSION["user_nome"];

    // Treino semanal baseado no objetivo
    if ($nivel === "iniciante") {
        $series = "3x12";
    } elseif ($nivel === "intermediario") {
        $series = "4x10";
    } else {
        $series = "5x8";
    }

    if ($objetivo === "massa") {
        $treinoSemana = [
            "Segunda" => ["Supino reto" => $series, "Supino inclinado" => $series, "Tríceps pulley" => $series],
            "Terça" => ["Puxada na frente" => $series, "Remada curvada" => $series, "Rosca direta" => $series],
            "Quarta" => ["Agachamento" => $series, "Leg press" => $series, "Cadeira extensora" => $series],
            "Quinta" => ["Desenvolvimento ombro" => $series, "Elevação lateral" => $series, "Abdominal infra" => "3x15"],
            "Sexta" => ["Supino" => $series, "Barra fixa" => $series, "Agachamento" => $series]
        ];
    } elseif ($objetivo === "definicao") {
        $treinoSemana = [
            "Segunda" => ["Supino reto" => $series, "Esteira" => "20 min"],
            "Terça" => ["Remada baixa" => $series, "Abdominal prancha" => "3x30s"],
            "Quarta" => ["Agachamento" => $series, "Bicicleta" => "20 min"],
            "Quinta" => ["Desenvolvimento ombro" => $series, "HIIT" => "15 min"],
            "Sexta" => ["Circuito funcional" => "4 voltas"]
        ];
    } else { // secar
        $treinoSemana = [
            "Segunda" => ["Esteira" => "40 min", "Abdominal" => "3x15"],
            "Terça" => ["Agachamento" => $series, "Bicicleta" => "20 min"],
            "Quarta" => ["HIIT" => "20 min", "Prancha" => "3x30s"],
            "Quinta" => ["Treino funcional" => "4 voltas"],
            "Sexta" => ["Cardio leve" => "50 min"]
        ];
    }

    try {
        // Limpa treinos antigos do usuário
        $pdo->prepare("DELETE FROM treinos WHERE user_id = ?")->execute([$userId]);

        foreach ($treinoSemana as $dia => $exercicios) {
            // Inserir treino do dia
            $stmtTreino = $pdo->prepare("
                INSERT INTO treinos (user_id, usuario, dia_semana)
                VALUES (?, ?, ?)
            ");
            $stmtTreino->execute([$userId, $usuarioNome, $dia]);
            $treinoId = $pdo->lastInsertId(); // pega id do treino inserido

            // Inserir cada exercício na tabela exercicios_treinos
            foreach ($exercicios as $nome => $detalhe) {
                $stmtEx = $pdo->prepare("
                    INSERT INTO exercicios_treinos (treino_id, exercicio, series)
                    VALUES (?, ?, ?)
                ");
                $stmtEx->execute([$treinoId, $nome, $detalhe]);
            }
        }

        $resultado = true;

    } catch (PDOException $e) {
        die("Erro ao salvar treino: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>IronMind</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

<h1>IronMind</h1>
<p>Assistente Inteligente de Treino</p>

<form method="POST">
    <label>Peso (kg)</label>
    <input type="number" step="0.1" name="peso" required>

    <label>Altura (m)</label>
    <input type="number" step="0.01" name="altura" required>

    <label>Idade</label>
    <input type="number" name="idade" required>

    <label>Sexo</label>
    <select name="sexo" required>
        <option value="">Selecione</option>
        <option value="masculino">Masculino</option>
        <option value="feminino">Feminino</option>
    </select>

    <label>Objetivo</label>
    <select name="objetivo" required>
        <option value="">Selecione</option>
        <option value="massa">Ganhar Massa</option>
        <option value="definicao">Definição</option>
        <option value="secar">Perda de Gordura</option>
    </select>

    <label>Nível</label>
    <select name="nivel" required>
        <option value="">Selecione</option>
        <option value="iniciante">Iniciante</option>
        <option value="intermediario">Intermediário</option>
        <option value="avancado">Avançado</option>
    </select>

    <button type="submit">Gerar Plano</button>
</form>

<?php if ($resultado): ?>
<div class="resultado-box">
    <h2>Plano Gerado</h2>
    <p><strong>IMC:</strong> <?= number_format($imc, 2); ?></p>
    <p><strong>Nível:</strong> <?= htmlspecialchars(ucfirst($nivel)); ?></p>
    <p><strong>Água recomendada:</strong> <?= number_format($aguaLitros, 2); ?> litros/dia</p>

    <h3>Divisão Semanal</h3>
    <div class="tabela-treino">
        <?php foreach ($treinoSemana as $dia => $exercicios): ?>
            <div class="dia-bloco">
                <div class="dia-titulo"><?= htmlspecialchars($dia); ?></div>
                <?php foreach ($exercicios as $nome => $detalhe): ?>
                    <div class="linha">
                        <div class="exercicio"><?= htmlspecialchars($nome); ?></div>
                        <div class="series"><?= htmlspecialchars($detalhe); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="acoes-finais">
        <a href="auth/logout.php" class="btn-secundario">Deslogar</a>
        <a href="dashboard.php" class="btn-primario">Voltar ao Menu</a>
    </div>
</div>
<?php endif; ?>

</div>
</body>
</html>
