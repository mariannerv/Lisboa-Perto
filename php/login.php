<?php
include "abreconexao.php";
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);

$email = "";
$password = "";
$error_message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    $sql = "SELECT * FROM Projeto WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password_from_db = $row["pass"]; 

       
        if (password_verify($password, $hashed_password_from_db)) {
            
            $_SESSION["email"] = $email;
            $_SESSION["logged_in"] = true;
            $_SESSION["start_time"] = time();
            header("Location: homepage.php");
            exit();
        } else {
            $error_message = "Password incorrecta.";
        }
    } else {
        $error_message = "Credenciais erradas ou utilizador não existe.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

<?php include "navbar.php"; ?>

<div class="w3-container w3-half w3-margin-top w3-display-middle">
    <form class="w3-container w3-card-4" method="post" id="form_login" action="">
        <h1 class="w3-container w3-teal" style="width:90%">Bem vindo!</h1>
        
        <?php if (!empty($error_message)): ?>
        <div class="w3-panel w3-red">
            <p><?php echo $error_message; ?></p>
        </div>
        <?php endif; ?>
        
        <p>
            <input class="w3-input" type="text" style="width:90%" name="email" id="email" placeholder="Email" required>
        </p>
        <p>
            <input class="w3-input" type="password" style="width:90%" name="password" id="password" placeholder="Password" required>
        </p>
        <p>
            <button class="w3-btn w3-section w3-teal w3-ripple" type="submit">Log in</button>
        </p>
        <p>
            <a href="registo.php">Ainda não tens conta?</a>
        </p>
    </form>
</div>

</body>
</html>
