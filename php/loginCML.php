<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "abreconexao.php";

session_start();

$error_message = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID_funcionario = htmlspecialchars($_POST["ID_funcionario"]);
    $password = htmlspecialchars($_POST["password"]);

    $sql = "SELECT * FROM FuncionarioCML WHERE ID_funcionario = '$ID_funcionario'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password_from_db = $row["passwd"]; 

        if (password_verify($password, $hashed_password_from_db)) {
            $_SESSION["ID_funcionario"] = $ID_funcionario;
            $_SESSION["logged_in"] = true;
            $_SESSION["start_time"] = time();
            header("Location: funcionarios_CML.php");
            exit();
        } else {
            $error_message = "Password incorreta.";
        }
    } else {
        $error_message = "Credenciais erradas ou utilizador não existe.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login CML</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

<div class="w3-container w3-half w3-margin-top w3-display-middle">
    <form class="w3-container w3-card-4" method="post" action="">
        <p>
            <input class="w3-input" type="text" style="width:90%" name="ID_funcionario" id="ID_funcionario" placeholder="ID de funcionario" required>
        </p>
        <p>
            <input class="w3-input" type="password" style="width:90%" name="password"  id="password" placeholder="Password" required>
        </p>
        <p>
            <button class="w3-btn w3-section w3-teal w3-ripple" type="submit">Log in</button>
        </p>
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <p>
            <a href="registoCML.php">Registar novo utilizador</a>
        </p>
    </form>
</div>

</body>
</html>
