<?php
$host = 'localhost';          // Host do MySQL
$dbname = 'medicamentum_db';  // Nome do banco de dados
$user = 'root';               // Usuário do MySQL (padrão do XAMPP)
$pass = '';                   // Senha do MySQL (padrão do XAMPP é vazia)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>