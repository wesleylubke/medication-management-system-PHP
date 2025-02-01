<?php
// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'medicamentum_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_medicamento = $_POST['nome_medicamento'];
    $marca_laboratorio = $_POST['marca_laboratorio'];
    $dosagem = $_POST['dosagem'];
    $tipo_dosagem = $_POST['tipo_dosagem'];
    $frequencia_uso = $_POST['frequencia_uso'];
    $primeira_dose = $_POST['primeira_dose'];
    $duracao_tratamento = !empty($_POST['duracao_tratamento']) ? $_POST['duracao_tratamento'] : $_POST['doses_restantes'];
    $tipo_duracao = !empty($_POST['duracao_tratamento']) ? 'dias' : 'doses';

    $sql = "INSERT INTO nome_medicamento (nome_medicamento, marca_laboratorio, dosagem, tipo_dosagem, frequencia_uso, primeira_dose, duracao_tratamento, tipo_duracao) 
            VALUES (:nome_medicamento, :marca_laboratorio, :dosagem, :tipo_dosagem, :frequencia_uso, :primeira_dose, :duracao_tratamento, :tipo_duracao)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome_medicamento' => $nome_medicamento,
        ':marca_laboratorio' => $marca_laboratorio,
        ':dosagem' => $dosagem,
        ':tipo_dosagem' => $tipo_dosagem,
        ':frequencia_uso' => $frequencia_uso,
        ':primeira_dose' => $primeira_dose,
        ':duracao_tratamento' => $duracao_tratamento,
        ':tipo_duracao' => $tipo_duracao
    ]);

    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Medicamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Cadastrar Medicamento</h1>
        <form method="POST" action="cadastrar.php">
            <!-- Nome do Medicamento -->
            <div class="mb-3">
                <label for="nome_medicamento" class="form-label">Nome do Medicamento</label>
                <input type="text" class="form-control" id="nome_medicamento" name="nome_medicamento" required>
            </div>

            <!-- Marca/Laboratório -->
            <div class="mb-3">
                <label for="marca_laboratorio" class="form-label">Marca/Laboratório</label>
                <input type="text" class="form-control" id="marca_laboratorio" name="marca_laboratorio" required>
            </div>

            <!-- Dosagem -->
            <div class="mb-3">
                <label for="dosagem" class="form-label">Dosagem</label>
                <input type="number" class="form-control" id="dosagem" name="dosagem" step="0.01" required>
            </div>

            <!-- Tipo de Dosagem -->
            <div class="mb-3">
                <label class="form-label">Tipo de Dosagem</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_dosagem" id="ml" value="ml" required>
                    <label class="form-check-label" for="ml">ml</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_dosagem" id="mg" value="mg">
                    <label class="form-check-label" for="mg">mg</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_dosagem" id="g" value="g">
                    <label class="form-check-label" for="g">g</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_dosagem" id="comprimido" value="comprimido">
                    <label class="form-check-label" for="comprimido">Comprimido</label>
                </div>
            </div>

            <!-- Frequência de Uso -->
            <div class="mb-3">
                <label for="frequencia_uso" class="form-label">Frequência de Uso</label>
                <select class="form-select" id="frequencia_uso" name="frequencia_uso" required>
                    <option value="24">1x ao dia/ ou a cada 24h</option>
                    <option value="12">2x ao dia/ ou a cada 12h</option>
                    <option value="8">3x ao dia/ ou a cada 08h</option>
                    <option value="6">4x ao dia/ ou a cada 06h</option>
                    <option value="4">6x ao dia/ ou a cada 04h</option>
                </select>
            </div>

            <!-- Primeira Dose -->
            <div class="mb-3">
                <label for="primeira_dose" class="form-label">Primeira Dose</label>
                <input type="datetime-local" class="form-control" id="primeira_dose" name="primeira_dose" required>
            </div>

            <!-- Duração do Tratamento -->
            <div class="mb-3">
                <label for="duracao_tratamento" class="form-label">Duração do Tratamento (dias)</label>
                <input type="number" class="form-control" id="duracao_tratamento" name="duracao_tratamento" min="1" oninput="toggleField('duracao_tratamento', 'doses_restantes')">
            </div>

            <!-- Doses Restantes -->
            <div class="mb-3">
                <label for="doses_restantes" class="form-label">Doses Restantes</label>
                <input type="number" class="form-control" id="doses_restantes" name="doses_restantes" min="1" oninput="toggleField('doses_restantes', 'duracao_tratamento')">
            </div>

            <!-- Botão de Cadastro -->
            <button type="submit" class="btn btn-primary w-100">Cadastrar Medicamento</button>
        </form>
    </div>

    <script>
        function toggleField(activeField, inactiveField) {
            var activeInput = document.getElementById(activeField);
            var inactiveInput = document.getElementById(inactiveField);

            if (activeInput.value) {
                inactiveInput.disabled = true;
                inactiveInput.value = '';
            } else {
                inactiveInput.disabled = false;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>