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
        <form id="filterForm" action="ocorrencias.php" method="GET">
        
        <div class="search-bar">
            <input type="text" id="search" name="search" placeholder="Pesquisar por título" onkeyup="showOccurrences()">
        </div>
        <label for="categoria">Categoria</label>
        <select id="categoria" name="categoria">
            <option value="">Select Categoria</option>
        </select>

        <label for="subCategoria">Subcategoria</label>
        <select id="subCategoria" name="subCategoria">
            <option value="">Select Subcategoria</option>
        </select>

        <p>Data: (YYYY-MM-DD) <input type="text" name="data" pattern="\d{4}-\d{2}-\d{2}" title="Data"></p>

        <label for="localizacao">Localização</label>
        <input type="text" id="localizacao" name="localizacao">
        <button type="submit">Pesquisar</button>
        <button type="button" onclick="clearFilters()">Limpar Filtros</button>
        </form>
        <script src="../scripts/subcategoria.js"></script> 
    </div>
    <?php include_once "navbar.php"; ?>

    <div class="projcard-container" id="occurrences-container">
<?php
include "abreconexao.php";

$cardsPerPage = 3;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $cardsPerPage;

// Base query for fetching occurrences
$query = "SELECT * FROM Ocorrencia WHERE (estado = 'Ativo' OR estado = 'Em Análise')";

// Apply filters
if (isset($_GET['categoria']) && $_GET['categoria'] !== '') {
    $categoria = $conn->real_escape_string($_GET['categoria']);
    $query .= " AND categoria = '$categoria'";
}

if (isset($_GET['subCategoria']) && $_GET['subCategoria'] !== '') {
    $subCategoria = $conn->real_escape_string($_GET['subCategoria']);
    $query .= " AND subCategoria = '$subCategoria'";
}

if (isset($_GET['data']) && $_GET['data'] !== '') {
    $data = $conn->real_escape_string($_GET['data']);
    $query .= " AND data_inicio = '$data'";
}

if (isset($_GET['localizacao']) && $_GET['localizacao'] !== '') {
    $localizacao = $conn->real_escape_string($_GET['localizacao']);
    $query .= " AND localizacao = '$localizacao'";
}

// Query for counting total rows
$totalRowsQuery = "SELECT COUNT(*) AS total FROM Ocorrencia WHERE (estado = 'Ativo' OR estado = 'Em Análise')";
if (isset($_GET['categoria']) && $_GET['categoria'] !== '') {
    $totalRowsQuery .= " AND categoria = '$categoria'";
}

if (isset($_GET['subCategoria']) && $_GET['subCategoria'] !== '') {
    $totalRowsQuery .= " AND subCategoria = '$subCategoria'";
}

if (isset($_GET['data']) && $_GET['data'] !== '') {
    $totalRowsQuery .= " AND data_inicio = '$data'";
}

if (isset($_GET['localizacao']) && $_GET['localizacao'] !== '') {
    $totalRowsQuery .= " AND localizacao = '$localizacao'";
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

    // Pagination
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

    <div class="fixed-button-container">
        <a href="formulario_ocorrencia.php"><button class="fixed-button">+ Nova Ocorrência</button></a>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('getCategorias.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log data for debugging
            var categoriaDropdown = document.getElementById("categoria");
            var subCategoriaDropdown = document.getElementById("subCategoria");

            // Populate the category dropdown
            for (var categoria in data) {
                var option = document.createElement("option");
                option.value = categoria;
                option.textContent = categoria;
                categoriaDropdown.appendChild(option);
            }

            // Add event listener for category change
            categoriaDropdown.addEventListener("change", function() {
                var selectedCategoria = this.value;
                subCategoriaDropdown.innerHTML = "<option value=''>Select Subcategoria</option>";
                
                if (selectedCategoria && data[selectedCategoria]) {
                    data[selectedCategoria].forEach(function(subCategoria) {
                        var option = document.createElement("option");
                        option.value = subCategoria;
                        option.textContent = subCategoria;
                        subCategoriaDropdown.appendChild(option);
                    });
                }
            });
        })
        .catch(error => console.error('Error fetching categories:', error));
    });


    function fetchSubCategories(categoria) {
        var subCategoriaDropdown = document.getElementById("subCategoria");
        subCategoriaDropdown.innerHTML = "<option value=''>Select Subcategoria</option>";

        if (categoria) {
            fetch(`scripts/getSubCategorias.php?categoria=${encodeURIComponent(categoria)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log(data); // Log data for debugging

                data.forEach(function(subCategoria) {
                    var option = document.createElement("option");
                    option.value = subCategoria;
                    option.textContent = subCategoria;
                    subCategoriaDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching subcategories:', error));
        }
}

    function showOccurrences() {
        var searchTerm = document.getElementById("search").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("occurrences-container").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "pesquisatitulo.php?search=" + searchTerm, true);
        xhttp.send();
    }

    function clearFilters() {
        window.location.href = "ocorrencias.php";
    }
    </script>

</body>
</html>