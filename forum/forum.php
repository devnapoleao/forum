<!DOCTYPE html>
<html>
<head>
    <title>Fórum</title>
</head>
<body>
    <h1>Fórum</h1>
    
    <?php
    // Inclui o arquivo de configuração do banco de dados
    include('config.php');

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
    $query = "SELECT * FROM publicacoes";
    $result = mysqli_query($connection, $query);

    // Verifica se há publicações no banco de dados
    if ($result) {
        while ($publicacao = mysqli_fetch_assoc($result)) {
            echo '<div class="publicacao">';
            echo '<form method="post" action="forum.php">';
            echo '<input type="hidden" name="publicacao_id" value="' . $publicacao['ID'] . '">';
            echo '<button type="submit" name="votar" value="up"><img src="setapracima.png" alt="Votar para cima"></button>';
            echo '<button type="submit" name="votar" value="down"><img src="setaparabaixo.png" alt="Votar para baixo"></button>';
            echo '</form>';
            echo '<a href="respostas.php?id=' . $publicacao['ID'] . '">' . $publicacao['Titulo'] . '</a><br>';
            echo 'Autor: ' . $publicacao['AutorID'] . '<br>'; // Substitua pelo nome do autor
            echo 'Data: ' . $publicacao['DataCriacao'] . '<br>';
            echo 'Pontos: ' . $publicacao['Pontos'] . '<br>';
            echo '<a href="comentar.php?id=' . $publicacao['ID'] . '">Comentar</a>';
            echo '</div><br>';
        }
    } else {
        echo "Não foi possível carregar as publicações do fórum.";
    }
    ?>

    <!-- Formulário para criar novas publicações -->
    <h2>Criar Nova Publicação</h2>
    <form method="post" action="criar_publicacao.php">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br><br>
        
        <label for "conteudo">Conteúdo:</label>
        <textarea id="conteudo" name="conteudo" rows="4" required></textarea><br><br>
        
        <input type="submit" name="criar_publicacao" value="Criar Publicação">
    </form>
</body>
</html>
