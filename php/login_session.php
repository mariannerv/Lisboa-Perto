<?php
include "abreconexao.php";

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);

$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);

$sql = "SELECT * FROM Projeto WHERE email = '$email'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password_from_db = $row["pass"]; // Assuming your password column is named "password" in the database

    // Verify the password
    if (password_verify($password, $hashed_password_from_db)) {
        // Password is correct
        $_SESSION["email"] = $email;
        $_SESSION["logged_in"] = true;
        $_SESSION["start_time"] = time();
        header("Location: homepage.php");
        exit();
    } else {
        // Password is incorrect
        echo "Credenciais erradas.";
    }
} else {
    // User does not exist
    echo "Credenciais erradas ou utilizador não existe.";
}

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    if (time() - $_SESSION["start_time"] > 3600) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

?>
