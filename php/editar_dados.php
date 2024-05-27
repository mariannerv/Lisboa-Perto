<?php
include "abreconexao.php";

// Prepare the UPDATE statement
$stmt = $conn->prepare("UPDATE Ocorrencia SET gravidade = ?, urgencia = ?, estado = ? WHERE ID_Ocorrencia = ?");
if (!$stmt) {
    die('Erro na preparação da declaração: ' . $conn->error);
}

$stmt->bind_param("ssss", $nova_gravidade, $nova_urgencia, $novo_estado, $ID_Ocorrencia);

$nova_gravidade = $_POST['nova_gravidade'];
$nova_urgencia = $_POST['nova_urgencia'];
$novo_estado = $_POST['novo_estado'];
$ID_Ocorrencia = $_POST['ocorrencia_id'];

$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: gereOcorrencias.php");
    echo "Ocorrência atualizada com sucesso!";
} else {
    header("Location: gereOcorrencias.php");
    echo "Nenhuma ocorrência foi atualizada. Verifique se o ID está correto.";
}

$stmt->close();
$conn->close();
?>
