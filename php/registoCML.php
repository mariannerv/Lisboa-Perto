<?php
include "abreconexao.php";


if ($_POST['pass'] !== $_POST['confirmPass']) {
    $error_message = "As passwords não coincidem.";
} else {

    $stmt = $conn->prepare("INSERT INTO FuncionarioCML (ID_funcionario, MediaDeRating, passwd) VALUES (?, ?, ?)");
    if (!$stmt) {
        die('Erro na preparação da declaração: ' . $conn->error);
    }

    $stmt->bind_param("sss", $ID_funcionario, $MediaDeRating, $passwd);

    $ID_funcionario = $_POST['idCML'];
    $passwd = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $MediaDeRating = 0.0;

    // Verificar se o ID já existe na base de dados.
    $check_stmt = $conn->prepare("SELECT ID_Funcionario FROM FuncionarioCML WHERE ID_Funcionario = ?");
    $check_stmt->bind_param("s", $ID_funcionario);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $error_message = "Este ID já está associado a outro funcionário. Por favor, use um ID diferente.";
    } else {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $success_message = "Utilizador registado com sucesso!";
            header("Location: funcionarios_CML.php");
            exit(); 
        } else {
            $error_message = "Erro ao registar utilizador.";
        }
    }

    $stmt->close();
    $check_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/form_cml.css" />
    <title>Registo</title>
</head>
<body>
<div class="container">
    <h1>Registo de funcionário</h1>

    <?php if (isset($error_message)) { ?>
        <p class="error_message"><?php echo $error_message; ?></p>
    <?php } elseif (isset($success_message)) { ?>
        <p><?php echo $success_message; ?></p>
    <?php } ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form_funcionarios">
        <label for="idCML">ID de funcionário</label>
        <input type="text" id="idCML" name="idCML" value="<?php echo isset($_POST['idCML']) ? $_POST['idCML'] : ''; ?>" required class="input_field"><br><br>

        <label for="pass">Password:</label>
        <input type="password" minlength="8" id="pass" name="pass" required class="input_field"><br><br>

        <label for="confirmPass">Confirmar Password:</label>
        <input type="password" minlength="8" id="confirmPass" name="confirmPass" required class="input_field"><br><br>

        <input type="submit" value="Registar" class="submit_button">
    </form>
</div>
</body>
</html>
