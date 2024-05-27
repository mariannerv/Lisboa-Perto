<?php

include "abreconexao.php";


$cardsPerPage = 3;


$page = isset($_GET['page']) ? intval($_GET['page']) : 1;


$offset = ($page - 1) * $cardsPerPage;


$query = "SELECT titulo, categoria, subCategoria, descricao, foto FROM Ocorrencia LIMIT $cardsPerPage OFFSET $offset";


$result = $conn->query($query);


if ($result) {
  
    while ($row = $result->fetch_assoc()) {
        echo '<link rel="stylesheet" href="../css/ocorrencias.css">';
        echo '<div class="projcard">';
        echo '<img src="Imagens/' . $row['foto'] . '" alt="Card Image">';
        echo '<div class="projcard-textbox">';
        echo '<div class="projcard-title">' . $row['titulo'] . '</div>';
        echo '<div class="projcard-subtitle">' . $row['categoria'] . '|' . $row['subCategoria'] . '</div>';
        echo '<div class="projcard-description">' . $row['descricao'] . '</div>';
        echo '</div>';
        echo '</div>';
    }

    
    $totalRows = $result->num_rows;
    $totalPages = ceil($totalRows / $cardsPerPage);

    
    echo '<div class="pagination">';
    if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '">Previous</a>';
    }
    if ($page < $totalPages) {
        echo '<a href="?page=' . ($page + 1) . '">Next</a>';
    }
    echo '</div>';

    // Free the result set
    $result->free();
} else {
    // Error handling if the query fails
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
