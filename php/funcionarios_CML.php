<?php
session_start();



if (!isset($_SESSION['ID_funcionario'])) {
    
    header("Location: loginCML.php");
    exit();
}
?>


<?php include_once "navbar_CML.php"; ?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/funcionarioCML.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Funcionários CML</title>

</head>
<body>

    <div id="container">
        <form action="ocorrencias.php" method='POST'>        

            <form action="funcionarios_CML.php" method="get">
            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria">
                <option value="">Selecione uma categoria</option>
                <option value="Passeios e Acessibilidades">Passeios e Acessibilidades</option>
                <option value="Higiene Urbana">Higiene Urbana</option>
                <option value="Iluminação Pública">Iluminação Pública</option>
                <option value="Estradas e Ciclovias">Estradas e Ciclovias</option>
                <option value="Árvores e espaços verdes">Árvores e espaços verdes</option>
                <option value="Equipamentos Municipais - Desporto">Equipamentos Municipais - Desporto</option>
                <option value="Segurança pública e ruído">Segurança pública e ruído</option>
                <option value="Saneamento">Saneamento</option>
                <option value="Habitação municipal">Habitação municipal</option>
                <option value="Animais em ambiente urbano">Animais em ambiente urbano</option>
                <option value="Equipamentos Municipais - cultura">Equipamentos Municipais - cultura</option>
                <option value="Equipamentos municipais - educação">Equipamentos municipais - educação</option>
                <?php
                include "abreconexao.php";
                $sqlCategorias = "SELECT * FROM Categoria";
                $resultCategorias = $conn->query($sqlCategorias);
                if ($resultCategorias->num_rows > 0) {
                    while($rowCategoria = $resultCategorias->fetch_assoc()) {
                        echo "<option value='".$rowCategoria['nome']."'>".$rowCategoria['nome']."</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" value="Pesquisar por Categoria">
        </form>

        <form action="funcionarios_CML.php" method="get">
            <label for="subcategoria">Subcategoria:</label>
            <select id="subcategoria" name="subcategoria">
                <option value="">Selecione uma subcategoria</option>
                <?php
                $sqlSubcategorias = "SELECT * FROM Subcategoria";
                $resultSubcategorias = $conn->query($sqlSubcategorias);
                if ($resultSubcategorias->num_rows > 0) {
                    while($rowSubcategoria = $resultSubcategorias->fetch_assoc()) {
                        echo "<option value='".$rowSubcategoria['nome']."'>".$rowSubcategoria['nome']."</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" value="Pesquisar por Subcategoria">
        </form>

        <form action="funcionarios_CML.php" method="get">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
                <option value="Registo">Registo</option>
                <option value="Ativo">Ativo</option>
                <option value="Resolvido">Resolvido</option>
            </select>
            <input type="submit" value="Pesquisar por Estado">
        </form>

        <form action="funcionarios_CML.php" method="get">
            <label for="localidade">Localidade:</label>
            <input type="text" id="localidade" name="localidade" placeholder="Digite a localidade">
            <input type="submit" value="Pesquisar por Localidade">
        </form>

        <form action="funcionarios_CML.php" method="get">
            <label for="morada">Morada:</label>
            <input type="text" id="morada" name="morada" placeholder="Digite a morada">
            <input type="submit" value="Pesquisar por Morada">
        </form>
        
            <input type="submit" value="Submit">
        </form>

    </div>

    <div class="container2">
        <h2>Estatísticas de Ocorrências</h2>
        <div class="statistics">
            <?php
            
            $estatisticas = obterEstatisticasOcorrencias();

            
            ?>
            <div class="statistic">
                <h3>Zona com Mais Ocorrências</h3>
                <p><?php echo $estatisticas['localizacao']; ?></p>
            </div>
            <div class="statistic">
                <h3>Categoria Mais Escolhida</h3>
                <p><?php echo $estatisticas['categoria']; ?></p>
            </div>
            <div class="statistic">
                <h3>Subcategoria Mais Escolhida</h3>
                <p><?php echo $estatisticas['subCategoria']; ?></p>
            </div>
        </div>
        <img src="Imagens/categorias.png" alt="Gráfico de categorias" style="max-width: 100%; height: auto;">
        <img src="Imagens/Localizacoes.png" alt="Gráfico de localizações" style="max-width: 100%; height: auto;">
    </div>
    <br><br>
<div class="container2">
    <h2>Ocorrências</h2>
    <?php
    // Retrieve all occurrences
    $ocorrencias = obterTodasOcorrencias();

    // Display each occurrence
    foreach ($ocorrencias as $ocorrencia) {
        echo "<div class='ocorrencia'>";
        exibirDetalhesOcorrenciaCompleta($ocorrencia);
        echo "<br>";
        echo "<button class='fechar-btn' onclick='resolveOcorrencia(" . $ocorrencia['ID_Ocorrencia'] . ")'>Fechar</button>";
        echo "</div>";
    }
    ?>
</div>



</body>
</html>



<?php
include "abreconexao.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['localidade'])) {
    $localidade = $_GET['localidade'];

    $sql = "SELECT Ocorrencia.*, 
                   Categoria.nome AS categoria_nome,
                   Subcategoria.nome AS subcategoria_nome,
                   Estado.nome AS estado_nome
            FROM Ocorrencia
            LEFT JOIN Categoria ON Ocorrencia.categoria_id = Categoria.id
            LEFT JOIN Subcategoria ON Ocorrencia.subcategoria_id = Subcategoria.id
            LEFT JOIN Estado ON Ocorrencia.estado_id = Estado.id
            WHERE Ocorrencia.localidade = '$localidade'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Exibir detalhes da ocorrência
            exibirDetalhesOcorrencia($row);
        }
    } else {
        echo "Não foi encontrada nenhuma ocorrência na morada especificada.";
    }
} elseif(isset($_GET['morada'])) {
    $morada = $_GET['morada'];

    $sql = "SELECT Ocorrencia.*, 
                   Categoria.nome AS categoria_nome,
                   Subcategoria.nome AS subcategoria_nome,
                   Estado.nome AS estado_nome
            FROM Ocorrencia
            LEFT JOIN Categoria ON Ocorrencia.categoria_id = Categoria.id
            LEFT JOIN Subcategoria ON Ocorrencia.subcategoria_id = Subcategoria.id
            LEFT JOIN Estado ON Ocorrencia.estado_id = Estado.id
            WHERE Ocorrencia.morada LIKE '%$morada%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Exibir detalhes da ocorrência
            exibirDetalhesOcorrencia($row);
        }
    } else {
        echo "Não foi encontrada nenhuma ocorrência na morada especificada.";
    }
} elseif(isset($_GET['categoria'])) {
    $categoria_nome = $_GET['categoria'];

    // Buscar o ID da categoria
    $sql_categoria_id = "SELECT id FROM Categoria WHERE nome = '$categoria_nome'";
    $result_categoria_id = $conn->query($sql_categoria_id);
    if ($result_categoria_id->num_rows > 0) {
        $row_categoria_id = $result_categoria_id->fetch_assoc();
        $categoria_id = $row_categoria_id['id'];

        $sql = "SELECT Ocorrencia.*, 
                       Categoria.nome AS categoria_nome,
                       Subcategoria.nome AS subcategoria_nome,
                       Estado.nome AS estado_nome
                FROM Ocorrencia
                LEFT JOIN Categoria ON Ocorrencia.categoria_id = Categoria.id
                LEFT JOIN Subcategoria ON Ocorrencia.subcategoria_id = Subcategoria.id
                LEFT JOIN Estado ON Ocorrencia.estado_id = Estado.id
                WHERE Ocorrencia.categoria_id = '$categoria_id'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                exibirDetalhesOcorrencia($row);
            }
        } else {
            echo "Não foram encontradas ocorrências na categoria especificada.";
        }
    } else {
        echo "Não foi possível encontrar esta categoria.";
    }
} elseif(isset($_GET['subcategoria'])) {
    $subcategoria_nome = $_GET['subcategoria'];

    $sql_subcategoria_id = "SELECT id FROM Subcategoria WHERE nome = '$subcategoria_nome'";

    $result_subcategoria_id = $conn->query($sql_subcategoria_id);

    if ($result_subcategoria_id->num_rows > 0) {
        $row_subcategoria_id = $result_subcategoria_id->fetch_assoc();
        $subcategoria_id = $row_subcategoria_id['id'];

        $sql = "SELECT Ocorrencia.*, 
                       Categoria.nome AS categoria_nome,
                       Subcategoria.nome AS subcategoria_nome,
                       Estado.nome AS estado_nome
                FROM Ocorrencia
                LEFT JOIN Categoria ON Ocorrencia.categoria_id = Categoria.id
                LEFT JOIN Subcategoria ON Ocorrencia.subcategoria_id = Subcategoria.id
                LEFT JOIN Estado ON Ocorrencia.estado_id = Estado.id
                WHERE Ocorrencia.subcategoria_id = '$subcategoria_id'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                exibirDetalhesOcorrencia($row);
            }
        } else {
            echo "Não foram encontradas ocorrências na subcategoria especificada.";
        }
    } else {
        echo "Não foi possível encontrar esta subcategoria.";
    }
} elseif(isset($_GET['estado'])) {
    $estado_nome = $_GET['estado'];

    // Buscar o ID do estado
    $sql_estado_id = "SELECT id FROM Ocorrencia WHERE nome = '$estado_nome'";
    $result_estado_id = $conn->query($sql_estado_id);
    if ($result_estado_id->num_rows > 0) {
        $row_estado_id = $result_estado_id->fetch_assoc();
        $estado_id = $row_estado_id['id'];

        $sql = "SELECT Ocorrencia.*, 
                       Categoria.nome AS categoria_nome,
                       Subcategoria.nome AS subcategoria_nome,
                       Estado.nome AS estado_nome
                FROM Ocorrencia
                LEFT JOIN Categoria ON Ocorrencia.categoria_id = Categoria.id
                LEFT JOIN Subcategoria ON Ocorrencia.subcategoria_id = Subcategoria.id
                LEFT JOIN Estado ON Ocorrencia.estado_id = Estado.id
                WHERE Ocorrencia.estado_id = '$estado_id'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Exibir detalhes da ocorrência
                exibirDetalhesOcorrencia($row);
            }
        } else {
            echo "Não foram encontradas ocorrências no estado especificada.";
        }
    } else {
        echo "Não foi possível encontrar este estado.";
    }
} else {
    echo "Atenção nenhuma categoria, subcategoria, estado, localidade ou morada especificado.";
}


function obterTodasOcorrencias() {
    global $conn;
    $ocorrencias = array();

   
    $sql = "SELECT * FROM Ocorrencia";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $ocorrencias[] = $row;
        }
    }

    return $ocorrencias;
}


function exibirDetalhesOcorrenciaCompleta($ocorrencia) {
    echo "<div>";
    echo "<p>ID: " . $ocorrencia["ID_Ocorrencia"] . "</p>";
    echo "<p>Categoria: " . $ocorrencia["categoria"] . "</p>";
    echo "<p>Subcategoria: " . $ocorrencia["subCategoria"] . "</p>";
    echo "<p>Localização: " . $ocorrencia["localizacao"] . "</p>";
    echo "<p>Estado: " . $ocorrencia["estado"] . "</p>";
    echo "<p>Título: " . $ocorrencia["titulo"] . "</p>";
    echo "<p>Descrição: " . $ocorrencia["descricao"] . "</p>";
    echo "<p>Data de Início: " . $ocorrencia["data_inicio"] . "</p>";
    echo "<p>Data de Fim: " . $ocorrencia["data_fim"] . "</p>";
    echo "<p>Tempo de Conclusão: " . $ocorrencia["tempo_conclusao"] . "</p>";
    echo "</div>";
}


function obterEstatisticasOcorrencias() {
    global $conn;
    $estatisticas = array();

    // Qual a localizacao com mais ocorrências:
    $sqlLocalizacao = "SELECT localizacao, COUNT(*) AS total FROM Ocorrencia GROUP BY localizacao ORDER BY total DESC LIMIT 1";
    $resultLocalizacao = $conn->query($sqlLocalizacao);
    $estatisticas['localizacao'] = ($resultLocalizacao->num_rows > 0) ? $resultLocalizacao->fetch_assoc()['localizacao'] : "Não foi encontrada nenhuma ocorrência.";

    // Qual a categoria mais escolhida:
    $sqlCategoria = "SELECT categoria, COUNT(*) AS total FROM Ocorrencia GROUP BY categoria ORDER BY total DESC LIMIT 1";
    $resultCategoria = $conn->query($sqlCategoria);
    $estatisticas['categoria'] = ($resultCategoria->num_rows > 0) ? $resultCategoria->fetch_assoc()['categoria'] : "Não foi encontrada nenhuma ocorrência.";

    // Qual a subcategoria mais escolhida:
    $sqlSubcategoria = "SELECT subCategoria, COUNT(*) AS total FROM Ocorrencia GROUP BY subCategoria ORDER BY total DESC LIMIT 1";
    $resultSubcategoria = $conn->query($sqlSubcategoria);
    $estatisticas['subCategoria'] = ($resultSubcategoria->num_rows > 0) ? $resultSubcategoria->fetch_assoc()['subCategoria'] : "Não foi encontrada nenhuma ocorrência.";

    return $estatisticas;
}


function resolveOcorrencia($ocorrencia_id) {
    require 'abreconexao.php';
    if (isset($_POST['ocorrencia_id'])) {
        $ocorrencia_id = $_POST['ocorrencia_id'];
        
        
        $sqlUpdate = "UPDATE Ocorrencia SET estado = 'Resolvido' WHERE ID_Ocorrencia = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("i", $ocorrencia_id);
        $stmt->execute();
        $stmt->close();
    
        $sqlSelect = "SELECT data_inicio FROM Ocorrencia WHERE ID_Ocorrencia = ?";
        $stmt = $conn->prepare($sqlSelect);
        $stmt->bind_param("i", $ocorrencia_id);
        $stmt->execute();
        $stmt->bind_result($data_inicio);
        $stmt->fetch();
        $stmt->close();
        
        
        $data_fim = date('Y-m-d H:i:s'); 
        $resolution_time = strtotime($data_fim) - strtotime($data_inicio); 
        
        $sqlUpdate = "UPDATE Ocorrencia SET data_fim = ? WHERE ID_Ocorrencia = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("si", $data_fim, $ocorrencia_id);
        $stmt->execute();
        $stmt->close();
        
        
        echo $resolution_time;
    }
}


$conn->close();
?>

