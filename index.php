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

// Processar exclusão de medicamento
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $sql = "DELETE FROM nome_medicamento WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    // Redirecionar para evitar reenvio do formulário
    header("Location: index.php");
    exit();
}

// Buscar todos os medicamentos cadastrados
$sql = "SELECT * FROM nome_medicamento";
$stmt = $pdo->query($sql);
$medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Medicamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Lista de Medicamentos</h1>
        <a href="cadastrar.php" class="btn btn-primary mb-3">Cadastrar Novo Medicamento</a>

        <!-- Exibir cards com os medicamentos -->
        <div class="row">
            <?php if (count($medicamentos) > 0): ?>
                <?php foreach ($medicamentos as $medicamento): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($medicamento['nome_medicamento']); ?></h5>
                                <p class="card-text">
                                    <strong>Marca/Laboratório:</strong> <?php echo htmlspecialchars($medicamento['marca_laboratorio']); ?><br>
                                    <strong>Dosagem:</strong> <?php echo htmlspecialchars($medicamento['dosagem']); ?> <?php echo htmlspecialchars($medicamento['tipo_dosagem']); ?><br>
                                    <strong>Usar a cada(x/horas):</strong> <?php echo htmlspecialchars($medicamento['frequencia_uso']); ?><br>
                                    <strong>Tipo dose:</strong> <?php echo htmlspecialchars($medicamento['tipo_dosagem']); ?><br>
                                    <strong>Primeira Dose:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($medicamento['primeira_dose']))); ?><br>

                                    <!-- Exibição da Duração do Tratamento -->
                                    <strong>Duração do Tratamento:</strong>
                                    <?php
                                    if (isset($medicamento['duracao_tratamento']) && $medicamento['duracao_tratamento'] > 0) {
                                        echo htmlspecialchars($medicamento['duracao_tratamento']) . ' ' . htmlspecialchars($medicamento['tipo_duracao']);
                                    } else {
                                        echo "Não informado";
                                    }
                                    ?>
                                    <br>

                                </p>
                                <!-- Botões de Editar e Excluir -->
                                <div class="d-flex justify-content-between">
                                    <a href="editar.php?id=<?php echo $medicamento['id']; ?>" class="btn btn-warning">Editar</a>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">Nenhum medicamento cadastrado.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>