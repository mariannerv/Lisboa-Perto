<?php
// Start the session
session_start();

// Include the database connection file
require 'abreconexao.php'; 

$userEmail = $_SESSION['email'];

$sql = "SELECT nome, idade, email, telemovel, nif FROM Projeto WHERE email = '$userEmail'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .user-card {
            width: 80%;
            flex-grow: 1;
            margin: 20px auto 0; 
            padding-top: 70px; 
        }

        .footer {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .warning {
            color: orange;
            font-weight: bold;
        }

        .user-info {
            margin-top: 20px;
        }

        .user-info ul {
            list-style-type: none;
            padding: 0;
        }

        .user-info li {
            margin-left: 20px;
        }

        .chat-container {
            margin-top: 20px;
        }

        .chat-id {
            margin-left: 20px;
        }

        .chat-button {
            margin-left: 10px;
        }
        
    </style>
</head>
<body>

<?php include_once "navbar.php"; ?>

<div class="w3-container user-card">
<?php


// Check Session Variable
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
} else {
    

    if ($result && $result->num_rows > 0) {
        // Retrieve user data
        $userData = $result->fetch_assoc();
?>
    <div class="w3-card-4">
        <header class="w3-container w3-yellow">
            <h1>User Information</h1>
        </header>

        <div class="w3-container user-info">
            <ul>
                <li><strong>Nome:</strong> <?php echo htmlspecialchars($userData['nome']); ?></li>
                <li><strong>Idade:</strong> <?php echo htmlspecialchars($userData['idade']); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></li>
                <li><strong>Telemovel:</strong> <?php echo htmlspecialchars($userData['telemovel']); ?></li>
                <li><strong>NIF:</strong> <?php echo htmlspecialchars($userData['nif']); ?></li>
            </ul>
        </div>

        <footer class="w3-container w3-yellow">
            <p>Logged in as: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            <a href="logout.php" class="w3-button w3-red">Logout</a>
        </footer>
    </div>
<?php
    } else {
        echo "<div class='error'>User information could not be found.</div>";
    }
}
?>
</div>

<!-- Chat Container -->
<div class="w3-container w3-center chat-container">
    <?php
    
    $sqlChats = "SELECT DISTINCT c.chat_id, o.titulo, o.ID_Ocorrencia 
                 FROM chat c
                 JOIN Ocorrencia o ON c.ocorrencia_ID = o.ID_Ocorrencia
                 WHERE c.id_utilizador = '$userEmail'";
                 
    $resultChats = $conn->query($sqlChats);
    
    if ($resultChats && $resultChats->num_rows > 0) {
               
        echo "<div class='success'>Chats abertos:</div>";
        while ($row = $resultChats->fetch_assoc()) {
            $id = $row['chat_id'];
            $ocorrencia_ID = $row['ID_Ocorrencia'];
        
            echo "<div class='w3-container'>";
            echo "<span class='chat-id'>" . $row['chat_id'] . "</span>";
            echo "<span class='titulo'>" . $row['titulo'] . "</span>";
            // Wrap the button inside the anchor tag
            echo "<a href='http://appserver-01.alunos.di.fc.ul.pt/~asw24/projeto/php/chat_TESTE.php?ID_Ocorrencia=$ocorrencia_ID&chat_id=$id'>";
            echo "<button class='w3-button w3-green chat-button'>Entrar</button>";
            echo "</a>";
            echo "<br> <br> ";
            echo "</div>";
        }
    } else {
        echo "<div class='error'>Não tem nenhum chat ativo.</div>";
    }
    ?>
</div>


<div class="footer w3-yellow">
    <p>grupo24</p>
</div>
</body>
</html>
