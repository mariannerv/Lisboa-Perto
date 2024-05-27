<?php
include "abreconexao.php"; 
session_start();

$ocorrencia_id = $_POST['ocorrencia_id'];
$mensagem = $_POST['mensagem'];
$enviada_por = $_POST['sender'];
$hora = date('Y-m-d H:i:s'); // Data e hora atual
$chat_id = $_POST['chat_id'];
$employee = $_POST['employee'];

// Initialize variables for query
$id_utilizador = null;
$id_funcionario = null;

if ($employee == 1) {
    $id_funcionario = 1; // Set some ID for employee
    $enviada_por = 'employee';
} else {
    $id_utilizador = 1; // Set some ID for user
    $enviada_por = 'user';
}

// Insert the message into the chat table
$sql = "INSERT INTO chat (hora, id_utilizador, id_funcionario, mensagem, enviada_por, ocorrencia_id, chat_id) 
        VALUES ('$hora', '$id_utilizador', '$id_funcionario', '$mensagem', '$enviada_por', '$ocorrencia_id', '$chat_id')";

if ($conn->query($sql) === TRUE) {
    // Determine the sender's name based on the URL parameter
    $sender_name = $employee == 1 ? 'Funcionário' : 'Você';

    echo "<div class='chat-message " . ($employee == 1 ? 'other' : 'own') . "'>
            <span class='time-date'>$hora</span><span class='sender'><strong> $sender_name</strong>: </span>
            <span class='message'>$mensagem</span>
          </div>";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
