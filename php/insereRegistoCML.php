<?php


include "abreconexao.php";

// Prepare the INSERT statement
$stmt = $conn->prepare("INSERT INTO FuncionarioCML (ID_funcionario, MediaDeRating, passwd) VALUES (?, ?, ?)");
if (!$stmt) {
    die('Erro na preparação da declaração: ' . $conn->error);
}

$stmt->bind_param("ssssss", $ID_funcionario, $MediaDeRating, $passwd);


$ID_funcionario = $_POST['idCML'];
$passwd = password_hash($_POST['pass'], PASSWORD_BCRYPT);
$MediaDeRating = 0.0;

// Verificar se o email já existe na base de dados.
$check_stmt = $conn->prepare("SELECT ID_Funcionario FROM FuncionarioCML WHERE ID_Funcionario = ?");
$check_stmt->bind_param("s", $ID_Funcionario);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
  
    echo "Este ID já está associado a outro funcionário. Por favor, use um ID diferente.";
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
