<!DOCTYPE html>
<html>
<head>
    <title>Respostas</title>
</head>
<body>
    <h1>Respostas</h1>
    
    <?php
    // Simulação de dados da publicação (substitua com sua própria lógica)
    $publicacao = array(
        'id' => 1,
        'titulo' => 'Título da Publicação 1',
        'nome' => 'Autor 1',
        'data' => '2023-09-25',
        'hora' => '14:30',
        'pontos' => 10,
    );

    // Simulação de um array de comentários associados à publicação (substitua com sua própria lógica)
    $comentarios = array(
        array(
            'id' => 1,
            'conteudo' => 'Este é o primeiro comentário.',
            'nome' => 'Comentador 1',
            'data' => '2023-09-25',
            'hora' => '15:00',
            'pontos' => 5,
        ),
        array(
            'id' => 2,
            'conteudo' => 'Outro comentário interessante.',
            'nome' => 'Comentador 2',
            'data' => '2023-09-25',
            'hora' => '16:45',
            'pontos' => 8,
        ),
    );

    // Exibir informações da publicação
    echo '<div class="publicacao">';
    echo '<h2>' . $publicacao['titulo'] . '</h2>';
    echo 'Autor: ' . $publicacao['nome'] . '<br>';
    echo 'Data: ' . $publicacao['data'] . ' Hora: ' . $publicacao['hora'] . '<br>';
    echo 'Pontos: ' . $publicacao['pontos'] . '<br>';
    echo '</div><br>';

    // Iterar sobre os comentários e exibi-los
    foreach ($comentarios as $comentario) {
        echo '<div class="comentario">';
        echo '<a href="votar.php?id=' . $comentario['id'] . '&voto=up"><img src="setapracima.png" alt="Votar para cima"></a>';
        echo '<a href="votar.php?id=' . $comentario['id'] . '&voto=down"><img src="setaparabaixo.png" alt="Votar para baixo"></a>';
        echo $comentario['conteudo'] . '<br>';
        echo 'Autor: ' . $comentario['nome'] . '<br>';
        echo 'Data: ' . $comentario['data'] . ' Hora: ' . $comentario['hora'] . '<br>';
        echo 'Pontos: ' . $comentario['pontos'] . '<br>';
        echo '<a href="responder.php?id=' . $comentario['id'] . '">Responder</a>';
        echo '</div><br>';
    }
    ?>
</body>
</html>
