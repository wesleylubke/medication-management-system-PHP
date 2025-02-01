<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo para o conteúdo dinâmico */
        .conteudo {
            display: none; /* Oculta o conteúdo inicialmente */
            padding: 10px;
            border: 1px solid #ddd;
            margin-top: 10px;
        }
        </style>
</head>


    
    <body>
        
        
        <nav class="navbar bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">
              <img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
              Bootstrap
            </a>
          </div>
        </nav>
        
        <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Item Frutas -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="linkFrutas">Frutas</a>
                    </li>
                    <!-- Item Cores -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="linkCores">Cores</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Conteúdo Dinâmico -->
    <div class="container mt-3">
        <!-- Conteúdo de Frutas -->
        <div id="conteudoFrutas" class="conteudo">
            <h3>Frutas</h3>
            <ul>
                <li>Maçã</li>
                <li>Banana</li>
                <li>Laranja</li>
                <li>Morango</li>
            </ul>
        </div>
        
        <!-- Conteúdo de Cores -->
        <div id="conteudoCores" class="conteudo">
            <h3>Cores</h3>
            <ul>
                <li>Vermelho</li>
                <li>Azul</li>
                <li>Verde</li>
                <li>Amarelo</li>
            </ul>
        </div>
    </div>

        </body>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        // Função para alternar a visibilidade dos conteúdos
        document.getElementById('linkFrutas').addEventListener('click', function (e) {
            e.preventDefault(); // Evita o comportamento padrão do link
            document.getElementById('conteudoFrutas').style.display = 'block';
            document.getElementById('conteudoCores').style.display = 'none';
        });

        document.getElementById('linkCores').addEventListener('click', function (e) {
            e.preventDefault(); // Evita o comportamento padrão do link
            document.getElementById('conteudoCores').style.display = 'block';
            document.getElementById('conteudoFrutas').style.display = 'none';
        });
    </script>

</html>