<?php

include "abreconexao.php";

$stmt->bind_param("sssssss", $nome, $idade, $email, $pass, $telemovel, $nif, $emailParaAtualizar);

$nome = $_POST['nome'];
$idade = $_POST['idade'];
$email = $_POST['email'];
$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT); 
$telemovel = $_POST['telemovel'];
$nif = $_POST['nif'];


// Preparar a declaração de atualização
$stmt = $conn->prepare("UPDATE Projeto SET nome = ?, idade = ?, email = ?, pass = ?, telemovel = ?, nif = ? WHERE nif = ?");


if (!$stmt) {
    die('Erro na preparação da declaração: ' . $conn->error);
}


if ($stmt->execute()) {
    echo "Informações do utilizador atualizadas com sucesso!";
} else {
    echo "Erro ao atualizar as informações do utilizador.";
}

// Fechar a declaração e a conexão
$stmt->close();
$conn->close();

?>