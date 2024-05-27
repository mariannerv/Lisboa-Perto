<?php
include "abreconexao.php";

$categories = [];

$categoryQuery = "SELECT Nome FROM Categoria";
$result = $conn->query($categoryQuery);
while ($row = $result->fetch_assoc()) {
    $categories[$row['Nome']] = [];
}

$subcategoryQuery = "SELECT Categoria, Nome FROM Subcategoria";
$result = $conn->query($subcategoryQuery);
while ($row = $result->fetch_assoc()) {
    $categories[$row['Categoria']][] = $row['Nome'];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($categories);
?>
