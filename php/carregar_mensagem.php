<?php
session_start();
include "abreconexao.php";

$ocorrencia_id = $conn->real_escape_string($_GET['ocorrencia_id']);
$chat_id = $conn->real_escape_string($_GET['chat_id']);
$last_timestamp = $_GET['last_timestamp'] ?? null;

$sql = "SELECT * FROM chat WHERE chat_id = '$chat_id' AND hora > '$last_timestamp' ORDER BY hora ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Determine the sender
        $sender = ($row['enviada_por'] === 'user') ? 'Você' : 'Funcionário';

        // Output the message in the desired format
        echo "<div class='chat-message " . ($row['enviada_por'] === 'user' ? 'own' : 'other') . "'>";
        echo "<span class='sender'>$sender:</span>";
        echo "<span class='message'>" . $row['mensagem'] . "</span>";
        echo "<span class='time-date'>" . $row['hora'] . "</span>";
        echo "</div>";
    }
} else {
    // If no new messages are found, return an empty response
    echo "";
}

$conn->close();
?>
