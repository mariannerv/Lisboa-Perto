<!DOCTYPE html>
<html>
<head> 
    <title>Feedback de Ocorrências Resolvidas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/background.css">

    <?php include "navbar.php"; ?>

    <style>
        form {
            margin-top: 200px;
            max-width: 1000px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #0056b3;
            border-radius: 5px;
            font-size: 18px;
            color: #555; 
            background-color: #f9f9f9;
            box-shadow: 0 0 5px #0056b3;
            transition: border-color 0.3s ease;
        }

        button[type="submit"] {
            background-color: #fbf97c;
            color: #000000;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
            color: #ffffff;
        }
        
    </style>
</head>

<body> 

<?php
session_start();
include "abreconexao.php";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['Ocorrencia']) && !empty($_POST['Comentario']) && !empty($_POST['Avaliacao'])) {
        // Obtém os dados do formulário
        $ocorrencia_id = $_POST['Ocorrencia']; // No need to convert to int since it's a string
        $comentario = $_POST['Comentario'];
        $avaliacao = intval($_POST['Avaliacao']); // Ensure it's an integer
        $data = date("Y-m-d"); // Obtém a data atual

        // Prepara a declaração SQL
        $stmt = $conn->prepare("INSERT INTO FeedBack (ID_Ocorrencia, Data, Avaliacao, Comentario) VALUES (?, ?, ?, ?)");

        // Verifica se a preparação da declaração SQL foi bem sucedida
        if ($stmt) {
            // Vincula os parâmetros
            $stmt->bind_param("ssss", $ocorrencia_id, $data, $avaliacao, $comentario);

            // Executa a declaração SQL
            if ($stmt->execute()) {
                $stmt->close();
                header("Location: homepage.php");
                exit;
            } else {
                $error_message = "Erro ao enviar feedback. Erro MySQL: " . $stmt->error;
            }
        } else {
            $error_message = "Ocorreu um erro ao preparar a declaração SQL.";
        }
    } else {
        $error_message = "Todos os campos são obrigatórios.";
    }
}
?>

<div class="w3-content w3-padding-64" id="feedback">
    <form action="feedback.php" method="POST">
        <label for="Ocorrencia">Selecione a ocorrência resolvida:</label>
        <select id="Ocorrencia" name="Ocorrencia" required>
            <?php
            $query = "SELECT * FROM Ocorrencia WHERE estado = 'Resolvido'";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['ID_Ocorrencia'] . "'>" . $row['descricao'] . "</option>";
                }
            } else {
                echo "<option disabled selected>Nenhuma ocorrência resolvida encontrada</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="Avaliacao">Como classifica a sua experiência de 0 a 5:</label>
        <input type="number" id="Avaliacao" name="Avaliacao" min="0" max="5" required>
        <br><br>
        <label for="Comentario">Deixe um comentário:</label>
        <textarea id="Comentario" name="Comentario" rows="4" cols="50" required></textarea>
        <br><br>
        <button type="submit">Enviar Feedback</button>
    </form>
    <?php if (!empty($error_message)): ?>
        <div class="w3-panel w3-red">
            <p><?php echo $error_message; ?></p>
        </div>
    <?php endif; ?>
</div>

<?php
$conn->close();
?>


</body>
</html>
