<?php

include "abreconexao.php";

// Prepare the UPDATE statement
$stmt = $conn->prepare("UPDATE Projeto SET nome = ?, idade = ?, email = ?, telemovel = ? WHERE nif = ?");
if (!$stmt) {
    die('Erro na preparação da declaração: ' . $conn->error);
}

$stmt->bind_param("sssss", $nome, $idade, $email, $telemovel, $nif);

$nome = $_POST['nome'];
$idade = $_POST['idade'];
$email = $_POST['email'];
$telemovel = $_POST['telemovel'];
$nif = $_POST['nif'];

$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Utilizador atualizado com sucesso!";
} else {
    echo "Nenhum utilizador foi atualizado. Verifique se o NIF está correto.";
}

$stmt->close();
$conn->close();

?>
