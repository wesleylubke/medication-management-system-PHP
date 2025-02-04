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

// Buscar o medicamento pelo ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM nome_medicamento WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medicamento) {
        die("Medicamento não encontrado.");
    }
} else {
    die("ID do medicamento não fornecido.");
}

// Processar o formulário de edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $duracao_tratamento = !empty($_POST['duracao_tratamento']) ? $_POST['duracao_tratamento'] : $_POST['doses_restantes'];
    $tipo_duracao = !empty($_POST['duracao_tratamento']) ? 'dias' : 'doses';

    $sql = "UPDATE nome_medicamento 
            SET nome_medicamento = :nome_medicamento, 
                marca_laboratorio = :marca_laboratorio, 
                dosagem = :dosagem, 
                tipo_dosagem = :tipo_dosagem, 
                frequencia_uso = :frequencia_uso, 
                primeira_dose = :primeira_dose,
                duracao_tratamento = :duracao_tratamento,
                tipo_duracao = :tipo_duracao
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome_medicamento' => $_POST['nome_medicamento'],
        ':marca_laboratorio' => $_POST['marca_laboratorio'],
        ':dosagem' => $_POST['dosagem'],
        ':tipo_dosagem' => $_POST['tipo_dosagem'],
        ':frequencia_uso' => $_POST['frequencia_uso'],
        ':primeira_dose' => $_POST['primeira_dose'],
        ':duracao_tratamento' => $duracao_tratamento,
        ':tipo_duracao' => $tipo_duracao,
        ':id' => $id
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
    <title>Editar Medicamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Medicamento</h1>
        <form method="POST" action="editar.php?id=<?php echo $id; ?>">

            <!-- Nome do Medicamento -->
            <div class="mb-3">
                <label for="nome_medicamento" class="form-label">Nome do Medicamento</label>
                <input type="text" class="form-control" id="nome_medicamento" name="nome_medicamento" value="<?php echo htmlspecialchars($medicamento['nome_medicamento']); ?>" required>
            </div>

            <!-- Marca/Laboratório -->
            <div class="mb-3">
                <label for="marca_laboratorio" class="form-label">Marca/Laboratório</label>
                <input type="text" class="form-control" id="marca_laboratorio" name="marca_laboratorio" value="<?php echo htmlspecialchars($medicamento['marca_laboratorio']); ?>" required>
            </div>

            <!-- Dosagem -->
            <div class="mb-3">
                <label for="dosagem" class="form-label">Dosagem</label>
                <input type="number" class="form-control" id="dosagem" name="dosagem" step="0.01" value="<?php echo htmlspecialchars($medicamento['dosagem']); ?>" required>
            </div>

            <!-- Tipo de Dosagem -->
            <div class="mb-3">
                <label class="form-label">Tipo de Dosagem</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_dosagem" id="ml" value="ml" <?php echo ($medicamento['tipo_dosagem'] == 'ml') ? 'checked' : ''; ?> required>
                    <label class="form-check-label" for="ml">ml</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_dosagem" id="mg" value="mg" <?php echo ($medicamento['tipo_dosagem'] == 'mg') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="mg">mg</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_dosagem" id="g" value="g" <?php echo ($medicamento['tipo_dosagem'] == 'g') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="g">g</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_dosagem" id="comprimido" value="comprimido" <?php echo ($medicamento['tipo_dosagem'] == 'comprimido') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="comprimido">Comprimido</label>
                </div>
            </div>

            <!-- Frequência de Uso -->
            <div class="mb-3">
                <label for="frequencia_uso" class="form-label">Frequência de Uso</label>
                <select id="frequencia_uso" name="frequencia_uso">
                <option value="" disabled>Select an option</option>
            </select>
            </div>

            <!-- Primeira Dose -->
            <div class="mb-3">
                <label for="primeira_dose" class="form-label">Primeira Dose</label>
                <input type="datetime-local" class="form-control" id="primeira_dose" name="primeira_dose" value="<?php echo date('Y-m-d\TH:i', strtotime($medicamento['primeira_dose'])); ?>" required>
            </div>

            <!-- Duração do Tratamento -->
            <div class="mb-3">
                <label for="duracao_tratamento" class="form-label">Duração do Tratamento (dias)</label>
                <input type="number" class="form-control" id="duracao_tratamento" name="duracao_tratamento" min="1"
                    value="<?php echo ($medicamento['tipo_duracao'] == 'dias') ? $medicamento['duracao_tratamento'] : ''; ?>">
            </div>

            <!-- Doses Restantes -->
            <div class="mb-3">
                <label for="doses_restantes" class="form-label">Doses Restantes</label>
                <input type="number" class="form-control" id="doses_restantes" name="doses_restantes" min="1"
                    value="<?php echo ($medicamento['tipo_duracao'] == 'doses') ? $medicamento['duracao_tratamento'] : ''; ?>">
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

<script>
                // Arrays containing the values and labels for the select options
                let frequencia_text = ["1x ao dia/ ou a cada 24h", "2x ao dia/ ou a cada 12h", "3x ao dia/ ou a cada 08h", "4x ao dia/ ou a cada 06h", "6x ao dia/ ou a cada 04h"];
                let frequencia_value = [24, 12, 8, 6, 4];

                let select = document.getElementById("frequencia_uso");

                // Retrieve the value from PHP and convert it to JavaScript
                let frequenciaBanco = <?php echo isset($medicamento['frequencia_uso']) ? $medicamento['frequencia_uso'] : 'null'; ?>;

                // Dynamically add options to the <select> element
                frequencia_text.forEach((text, index) => {
                    let option = document.createElement("option");
                    option.value = frequencia_value[index];
                    option.text = text;

                    // If the value matches the one from the database, mark it as selected
                    if (frequenciaBanco !== null && frequenciaBanco == frequencia_value[index]) {
                        option.selected = true;
                    }

                    select.add(option);
                });

                // Capture user selection
                select.addEventListener("change", function() {
                    let selectedIndex = select.selectedIndex;
                    let selectedValue = select.value;
                    let selectedText = select.options[selectedIndex].text;
                    console.log("Selected Value: " + selectedValue + ", Text: " + selectedText);
                });
            </script>

<div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Atualizar Medicamento</button>
                <a href="index.php?excluir=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este medicamento?');">Excluir Medicamento</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>