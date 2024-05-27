<?php
session_start();

// Your validation logic here
$valid_email = "testeteste123@gmail.com";
$valid_password = "12345678";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($email === $valid_email && $password === $valid_password) {
        $_SESSION["logged_in"] = true;
        $_SESSION["start_time"] = time();
        $_SESSION["email"] = $email; // Set the email session variable
        header("Location: homepage.php");
        exit();
    } else {
        echo '<p class="w3-text-red">Invalid email or password.</p>';
    }
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