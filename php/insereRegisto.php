<?php


include "abreconexao.php";

// Prepare the INSERT statement
$stmt = $conn->prepare("INSERT INTO Projeto (nome, idade, email, pass, telemovel, nif) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die('Erro na preparação da declaração: ' . $conn->error);
}

$stmt->bind_param("ssssss", $nome, $idade, $email, $pass, $telemovel, $nif);


$nome = $_POST['nome'];
$idade = $_POST['idade'];
$email = $_POST['email'];
$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
$telemovel = $_POST['telemovel'];
$nif = $_POST['nif'];

// Verificar se o email já existe na base de dados.
$check_stmt = $conn->prepare("SELECT email FROM Projeto WHERE email = ?");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
  
    echo "Este email já está registrado. Por favor, use um email diferente.";
} else {

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Utilizador registado com sucesso!";
    } else {
        echo "Erro ao registar utilizador.";
    }
}


$stmt->close();
$check_stmt->close();


$conn->close();
?>
