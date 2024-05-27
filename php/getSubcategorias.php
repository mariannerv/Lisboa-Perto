<?php
include "abreconexao.php";
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

if (!empty($categoria)) {
    $stmt = $conn->prepare("SELECT Nome FROM Subcategoria WHERE Categoria = ?");
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $subcategories = [];
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row['Nome'];
    }
    
    echo json_encode($subcategories);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
