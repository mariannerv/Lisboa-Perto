<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Funcionários CML</title>

</head>
<?php

session_start();

require 'abreconexao.php'; 

include_once "navbar_CML.php"; 

$sqlChats = "SELECT DISTINCT c.chat_id, o.titulo, o.ID_Ocorrencia 
             FROM chat c
             JOIN Ocorrencia o ON c.ocorrencia_ID = o.ID_Ocorrencia";

                 
$resultChats = $conn->query($sqlChats);
    
if ($resultChats && $resultChats->num_rows > 0) {
    echo "<br> <br> ";
    echo "<br> <br> ";
    echo "<div class='success'>Chats abertos:</div>";
    while ($row = $resultChats->fetch_assoc()) {
        $id = $row['chat_id'];
        $ocorrencia_ID = $row['ID_Ocorrencia'];
        
        echo "<div class='w3-container'>";
        echo "<span class='titulo'>" . $row['titulo'] . "</span>";
        echo "<a href='http://appserver-01.alunos.di.fc.ul.pt/~asw24/projeto/php/chat_TESTE.php?ID_Ocorrencia=$ocorrencia_ID&chat_id=$id&employee=1'>";
        echo "<button class='w3-button w3-green chat-button'>Entrar como Funcionário</button>";
        echo "</a>";
        echo "<br> <br> ";
        echo "</div>";
    }
} else {
    echo "<br> <br> ";
    echo "<br> <br> ";
    echo "<div class='w3-center w3-red error'> Não há nenhum chat ativo.</div>";
}

?>
</html>
