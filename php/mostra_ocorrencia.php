<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Ocorrencia</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/ocorrencias.css">
    <link rel="stylesheet" href="../css/background.css">
    <link rel="stylesheet" href="../css/mostra_ocorrencia.css">
    <link rel="stylesheet" href="../css/paginacao.css">
    <link rel="stylesheet" href="../css/barra_progresso.css">
</head>


<style>

    .chat-button .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #FF7575;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .chat-button .btn:hover {
        background-color: #FFD375;
    }
</style>



<body class="w3-khaki">
    
    <?php include_once "navbar.php"; ?>

    <div class="container">
        <?php
        include "abreconexao.php";

        $chatId = uniqid();

        if (isset($_GET['ID_Ocorrencia'])) { 
            $id = $conn->real_escape_string($_GET['ID_Ocorrencia']); 

            $query = "SELECT * FROM Ocorrencia WHERE ID_Ocorrencia = '$id' ";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Display occurrence details
                echo '<div class="image">';
                echo '<img src="Imagens/' . $row['foto'] . '" alt="Imagem do problema">';
                echo '</div>';
                echo '<div class="info">';
                echo '<br>';
                echo '<h3>' . $row['titulo'] . '</h3>';
                echo '<br>';
                echo '<h3>Categoria: ' . $row['categoria'] . '</h3>';
                echo '<h3>Sub-Categoria: ' . $row['subCategoria'] . '</h3>';
                echo '<br>';
                echo '<p>Localização: ' . $row['localizacao'] . '</p>';
                echo '<br>';
                echo '<p>Descrição: ' . $row['descricao'] . '</p>';
                echo '<p>Data de Submissão: ' . $row['data_inicio'] . '</p>';
                echo '</div>';
                echo '<div class="chat-button">';
                echo '<a href="chat_TESTE.php?ID_Ocorrencia=' . $id . '&chat_id=' . $chatId . '" class="btn">Iniciar Chat</a>';
                echo '</div>';

            } else {
                echo 'Ocorrência não encontrada.';
            }
        } else {
            echo 'ID da ocorrência não fornecido.';
        }

        $conn->close();
        ?>
    </div>
    

    <footer>
        <div class="progress-bar-container">
            <?php
            // Echo progress bar based on "estado"
            switch ($row['estado']) {
                case 'Ativo':
                    echo '<div class="w3-light-grey">';
                    echo '<div class="w3-container w3-blue w3-center" style="width:33%">Ativo</div>';
                    echo '</div><br>';
                    break;
                case 'Em Análise':
                    echo '<div class="w3-light-grey">';
                    echo '<div class="w3-container w3-orange w3-center" style="width:66%">Em Análise</div>';
                    echo '</div><br>';
                    break;
                case 'Resolvido':
                    echo '<div class="w3-light-grey">';
                    echo '<div class="w3-container w3-green w3-center" style="width:100%">Resolvido</div>';
                    echo '</div><br>';
                    break;
                default:
                    // Handle other cases if needed
                    break;
            }
            ?>
        </div>
    </footer>
</body>
</html>
