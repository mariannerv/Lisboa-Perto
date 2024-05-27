<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Funcionários CML</title>
</head>
<body>
<?php
session_start();
require 'abreconexao.php';
include_once "navbar_CML.php";

$sql = "SELECT * FROM FeedBack";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<div class='w3-content w3-padding-64' id='feedbacks'>";
    echo "<h2 class='w3-center'>Feedbacks</h2>";
    echo "<div class='w3-row-padding'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='w3-third w3-margin-bottom'>";
        echo "<div class='w3-card-4'>";
        echo "<header class='w3-container w3-blue'>";
        echo "<h3>ID: " . htmlspecialchars($row['ID_feedback']) . "</h3>";
        echo "</header>";
        echo "<div class='w3-container'>";
        echo "<p><strong>Ocorrência ID:</strong> " . htmlspecialchars($row['ID_Ocorrencia']) . "</p>";
        echo "<p><strong>Data:</strong> " . htmlspecialchars($row['Data']) . "</p>";
        echo "<p><strong>Avaliação:</strong> " . htmlspecialchars($row['Avaliacao']) . "</p>";
        echo "<p><strong>Comentário:</strong> " . htmlspecialchars($row['Comentario']) . "</p>";
        echo "</div>";
        echo "<footer class='w3-container w3-blue'>";
        
        echo "</footer>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
} else {
    echo "<div class='w3-panel w3-red w3-padding-16'>Não existe nenhum feedback.</div>";
}

$conn->close();
?>
</body>
</html>
