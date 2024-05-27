<?php
session_start();
include "abreconexao.php";

$chat_id = $conn->real_escape_string($_POST['chat_id']);

$sql = "DELETE FROM chat WHERE chat_id = '$chat_id'";
$result = $conn->query($sql);

if ($result) {
    echo "Chat terminated successfully!";
} else {
    echo "Error terminating chat: " . $conn->error;
}

$conn->close();
?>
