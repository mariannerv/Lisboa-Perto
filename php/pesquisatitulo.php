<?php
// Include database connection file
include_once "abreconexao.php";

$searchTerm = $_GET['search'];

$searchTerm = $conn->real_escape_string($searchTerm);


$query = "SELECT * FROM Ocorrencia WHERE estado = 'Ativo' AND titulo LIKE '%$searchTerm%'";


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
} else {

    echo '<h3>Nenhuma ocorrência encontrada</h3>';
}


$conn->close();
?>
