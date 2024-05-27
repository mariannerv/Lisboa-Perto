<?php
include 'abreconexao.php';

$sql = "SELECT Latitude, Longitude, descricao, subCategoria, categoria, ID_utilizador FROM Ocorrencia";
$result = $conn->query($sql);

$ocorrencias = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ocorrencias[] = $row;
    }
}

echo json_encode(array('ocorrencia' => $ocorrencias));

$conn->close();
?>