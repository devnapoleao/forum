<?php
// Inclui o arquivo de configuração do banco de dados
include('config.php');

// Função para obter o nome do autor com base no ID do autor
function getAuthorName($authorID, $connection) {
    $authorID = mysqli_real_escape_string($connection, $authorID);
    $query = "SELECT Nome FROM Usuarios WHERE ID = $authorID";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Nome'];
    } else {
        return 'Autor Desconhecido';
    }
}

// Processa a votação da publicação, se o formulário for enviado
if (isset($_POST['votar'])) {
    if (isset($_POST['voto'])) {
        $publicacaoID = mysqli_real_escape_string($connection, $_POST['publicacao_id']);
        $voto = mysqli_real_escape_string($connection, $_POST['voto']);

        // Pode ser necessário verificar se o usuário já votou nesta publicação para evitar múltiplas votações

        if ($voto === 'up') {
            // Incrementa os pontos da publicação para votos positivos
            $query = "UPDATE publicacoes SET Pontos = Pontos + 1 WHERE ID = $publicacaoID";
        } elseif ($voto === 'down') {
            // Decrementa os pontos da publicação para votos negativos
            $query = "UPDATE publicacoes SET Pontos = Pontos - 1 WHERE ID = $publicacaoID";
        }

        if (!empty($query) && mysqli_query($connection, $query)) {
            // Redireciona de volta para a página do fórum após o voto
            header("Location: forum.php");
            exit();
        } else {
            echo "Erro ao processar o voto. Tente novamente.";
        }
    } else {
        echo "Erro: a chave 'voto' não está definida no array \$_POST.";
    }
}

// Consulta SQL para obter todas as publicações do banco de dados
$query = "SELECT * FROM Publicacoes";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fórum</title>
    <style>
            body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
        h1 {
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .publicacao {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            background-color: #fff;
        }
        .publicacao a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
        .publicacao a:hover {
            text-decoration: underline;
        }
        .voto-button {
            background: none;
            border: none;
            cursor: pointer;
        }
        .criar-publicacao {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
        h1 {
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .publicacao {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            background-color: #fff;
        }
        .publicacao a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
        .publicacao a:hover {
            text-decoration: underline;
        }
        .voto-button {
            background: none;
            border: none;
            cursor: pointer;
        }
        .criar-publicacao {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px auto; /* Centralize verticalmente */
            border-radius: 5px;
            max-width: 600px; /* Defina a largura do formulário */
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        /* Estilos para telas menores (dispositivos móveis) */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .publicacao {
                padding: 5px;
            }

            .criar-publicacao {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Fórum</h1>
    </header>

    <!-- Formulário para criar novas publicações -->
    <div class="container criar-publicacao">
        <h2>Criar Nova Publicação</h2>
        <form method="post" action="criar_publicacao.php">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            
            <label for="conteudo">Conteúdo:</label>
            <textarea id="conteudo" name="conteudo" rows="4" required>
            </textarea>
            
            <?php
            // Obtenha o ID do usuário a partir do cookie
            if (isset($_COOKIE['usuarioID'])) {
                $usuarioID = $_COOKIE['usuarioID'];
                echo '<input type="hidden" name="autor_id" value="' . $usuarioID . '">';
            }
            ?>
            
            <input type="submit" name="criar_publicacao" value="Criar Publicação">
        </form>

        </div>
    <div class="container">
    <div class="container">
    <?php
    // Consulta SQL para obter todas as publicações do banco de dados ordenadas pelas mais recentes
    $query = "SELECT * FROM Publicacoes ORDER BY DataCriacao DESC";
    $result = mysqli_query($connection, $query);

    if ($result) {
        while ($publicacao = mysqli_fetch_assoc($result)) {
            echo '<div class="publicacao">';
            echo '<form method="post" action="forum.php">';
            echo '<input type="hidden" name="publicacao_id" value="' . $publicacao['ID'] . '">';
            echo '</form>';
            echo '<a href="respostas.php?id=' . $publicacao['ID'] . '">' . $publicacao['Titulo'] . '</a><br>';
            echo 'Autor: ' . getAuthorName($publicacao['AutorID'], $connection) . '<br>';
            echo '</div><br>';
        }
    } else {
        echo "Não foi possível carregar as publicações do fórum.";
    }
    ?>
</div>


       
    </div>
</body>
</html>
