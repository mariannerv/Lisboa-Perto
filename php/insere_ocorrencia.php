<?php
include 'abreconexao.php';
session_start(); 

// ######## DETEÇÃO DE ERROS ########
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$categoria = $_POST["categoria"];
$subCategoria = $_POST["subCategoria"];
$photo_name = pathinfo($_FILES['foto']['name'], PATHINFO_FILENAME); 
$photo_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION); 
$localizacao = htmlspecialchars($_POST["localizacao"]);
$descricao = htmlspecialchars($_POST["descricao"]);
$titulo = htmlspecialchars($_POST["titulo"]);
$Latitude = $_POST['Latitude'];
$Longitude = $_POST['Longitude'];
$userEmail = $_SESSION['email'];

$ID_ocorrencias = generateRandomString();
$date = date('Y-m-d H:i:s');
$estado = "Ativo";
$data_fim = null;
$tempo_de_conclusao = null;

$caminho = "Imagens/" . $_FILES['foto']['name'];

if (!$categoria) {
    die("É necessário escolher uma categoria.");
}

if (!$subCategoria) {
    die("É necessário escolher uma sub-categoria.");
}

if (!$localizacao) {
    die("É obrigatório inserir a localização da ocorrência.");
}

if (!$titulo) {
    die("É obrigatório inserir um titulo para a ocorrência.");
}

if (!$descricao) {
    die("É necessária uma descrição do problema.");
}

if (isset($_POST["estado"])) {
    $estado = $_POST["estado"];
}

if (isset($_POST["data_fim"])) {
    $data_fim = $_POST["data_fim"];
}

if (isset($_POST["tempo_de_conclusao"])) {
    $tempo_de_conclusao = $_POST["tempo_de_conclusao"];
}

$photo_fullname = "logo.png"; //se não for passada nenhuma foto, usa-se uma imagem por default

if (!empty($_FILES['foto']['name'])) {
    $photo_fullname = $photo_name . '.' . $photo_extension;
    $caminho = "Imagens/" . $photo_fullname;
}

$stmt = $conn->prepare("INSERT INTO Ocorrencia (ID_Ocorrencia, categoria, subCategoria, foto, localizacao, Latitude, Longitude, estado, titulo, descricao, data_inicio, data_fim, tempo_de_conclusao, ID_utilizador) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die('Erro na preparação da declaração: ' . $conn->error);
}

$stmt->bind_param("ssssssssssssss", $ID_ocorrencias, $categoria, $subCategoria, $photo_fullname, $localizacao, $Latitude, $Longitude, $estado, $titulo, $descricao, $date, $data_fim, $tempo_de_conclusao, $userEmail);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    move_uploaded_file($_FILES['foto']['tmp_name'], $caminho);
    header("Location: homepage.php");
    echo "Ocorrencia registada com sucesso";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
