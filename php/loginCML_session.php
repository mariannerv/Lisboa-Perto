<?php
include "abreconexao.php";
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);


$idCML = htmlspecialchars($_POST["idCML"]);
$password = htmlspecialchars($_POST["password"]);

$sql = "SELECT * FROM FuncionarioCML WHERE ID_funcionario = '$idCML'";
$result = $conn->query($sql);

if ($result && $result->num_rows == 0) {
    
    echo "Credenciais erradas ou utilizador não existe.";

} else {

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $_SESSION["idCML"] = $idCML;
        $_SESSION["logged_in"] = true;
        $_SESSION["start_time"] = time();
        header("Location: funcionarios_CML.php");
        exit();
    } else {
        echo("Não foi possivel realizar o login.");
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
