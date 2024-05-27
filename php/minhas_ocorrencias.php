<?php
session_start(); // Starting the session

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <title>OCORRENCIAS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/ocorrencias.css">
    <link rel="stylesheet" href="../css/background.css">
    <link rel="stylesheet" href="../css/paginacao.css">
    <link rel="stylesheet" href="../css/pesquisa.css">
    <link rel="stylesheet" href="../css/botao.css">
</head>
<body class="w3-khaki">

<div class="panel">
    <form action="ocorrencias.php" method="GET">
        <label for="categoria">Categoria</label>
        <select id="categoria" name="categoria" required>
            <option value="">Select Categoria</option>
            <option value="Passeios e Acessibilidades">Passeios e Acessibilidades</option>
            <option value="Higiene Urbana">Higiene Urbana</option>
            <option value="Iluminação Pública">Iluminação Pública</option>
            <!-- Other options omitted for brevity -->
        </select>

        <label for="subCategoria">Subcategoria</label>
        <select id="subCategoria" name="subCategoria">
            <option value="">Select Subcategoria</option>
        </select>

        <p>Data: <input type="text" name="data" pattern="\d{4}-\d{2}-\d{2}" title="Data"></p>

        <label for="localizacao">Localização</label>
        <input type="text" id="localizacao" name="localizacao">
        <button type="submit">Pesquisar</button>
    </form>
    <script src="../scripts/subcategoria.js"></script>
</div>
<?php include_once "navbar.php"; ?>

<div class="projcard-container">
    <?php
    include "abreconexao.php";

    $cardsPerPage = 3;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $cardsPerPage;

    $userEmail = $conn->real_escape_string($_SESSION['email']);
    $query = "SELECT * FROM Ocorrencia WHERE estado = 'Ativo' AND ID_utilizador = '$userEmail'";


    $totalRowsQuery = "SELECT COUNT(*) AS total FROM Ocorrencia WHERE estado = 'Ativo'";
    if (isset($_SESSION['email'])) {
        $userEmail = $conn->real_escape_string($_SESSION['email']);
        $totalRowsQuery .= " AND ID_utilizador = '$userEmail'";
    }

    $resultTotalRows = $conn->query($totalRowsQuery);
    $rowTotalRows = $resultTotalRows->fetch_assoc();
    $totalRows = $rowTotalRows['total'];
    $resultTotalRows->free();

    $totalPages = ceil($totalRows / $cardsPerPage);

    $query .= " LIMIT $cardsPerPage OFFSET $offset";

    // Execute the final query
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo '<a href="mostra_ocorrencia.php?ID_Ocorrencia=' . $row['ID_Ocorrencia'] . '">';
            echo '<div class="projcard">';
            echo '<div class="projcard-content">';
            echo '<img class="projcard-img" src="Imagens/' . $row['foto'] . '" alt="Card Image">';
            echo '</div>';
            echo '<div class="projcard-textbox">';
            echo '<div class="projcard-title">' . $row['titulo'] . '</div>';
            echo '<div class="projcard-subtitle">' . $row['categoria'] . ' | ' . $row['subCategoria'] . '</div>';
            echo '<div class="projcard-description">' . $row['descricao'] . '</div>';
            echo '<div class="description">' . "Localização: " . $row['localizacao'] . '</div>';
            echo '<div class="projcard-description">' . 'Data do registo: ' . $row['data_inicio'] . '</div>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
        }

        echo '<div class="pagination">';
        if ($page > 1) {
            echo '<a href="?page=' . ($page - 1) . '">Previous</a>';
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<a href="?page=' . $i . '">' . $i . '</a>';
        }
        if ($page < $totalPages) {
            echo '<a href="?page=' . ($page + 1) . '">Next</a>';
        }
        echo '</div>';
    } else {
        echo '<h3>Nenhuma ocorrência encontrada</h3>';
    }

    $conn->close();
    ?>
</div>

<div class="fixed-button-container">
    <a href="formulario_ocorrencia.php"><button class="fixed-button">+ Nova Ocorrência</button></a>
</div>

</body>
</html>
