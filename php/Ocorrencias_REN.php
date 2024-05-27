<?php
require_once "../nusoap/lib/nusoap.php";
header('Content-Type: text/html; charset=utf-8');

$client = new nusoap_client('http://appserver-01.alunos.di.fc.ul.pt/~asw24/projeto/php/REN_Reparacoes.php');

$estado = isset($_POST['estado']) ? $_POST['estado'] : 'Ativo';

$dbhost = "appserver-01.alunos.di.fc.ul.pt";
$dbuser = "asw24";
$dbpass = "grupo2424";
$dbname = "asw24";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT Nome FROM Categoria";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

// Store Categoria options in an array
$categorias = array();
while ($row = mysqli_fetch_assoc($result)) {
    $categorias[] = $row['Nome'];
}

mysqli_close($conn);

$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';


$result = $client->call('ListaOcorrencias', array('categoria' => $categoria, 'estado' => $estado));
echo "<h2>Pedido</h2><pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Resposta</h2><pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REN-REPARAÇÕES Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .centered-image {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        /* Style for dropdown menus */
        .dropdown select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }
        /* Style for dropdown menus when focused */
        .dropdown select:focus {
            border-color: dodgerblue;
        }
        /* Style for the submit button */
        .submit-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: dodgerblue;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        /* Style for the submit button on hover */
        .submit-btn:hover {
            background-color: #007acc;
        }
    </style>
</head>
<body>
    <img src="Imagens/REN.png" alt="Centered Image" class="centered-image">
    <h2>Pedido</h2>
    
    <form method="post">
        <div class="container">
            <div class="dropdown">
                <select name="categoria">
                    <?php foreach ($categorias as $option): ?>
                        <option value="<?php echo htmlspecialchars($option); ?>" <?php if ($option === $categoria) echo 'selected'; ?>><?php echo htmlspecialchars($option); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="dropdown">
                <select name="estado">
                    
                    <option value="Ativo" <?php if ($estado === 'Ativo') echo 'selected'; ?>>Ativo</option>
                    <option value="Em Analise" <?php if ($estado === 'Em Analise') echo 'selected'; ?>>Em Análise</option>
                    <option value="Resolvido" <?php if ($estado === 'Resolvido') echo 'selected'; ?>>Resolvido</option>
                </select>
            </div>
            <input type="submit" class="submit-btn" value="Enviar">
        </div>
    </form>
    
    <?php
    if ($client->fault) {
     
        echo "<h2>Fault</h2><pre>" . print_r($result, true) . "</pre>";
    } else {
        $error = $client->getError(); 
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        } else {
            echo "<br>";
            echo "<h2>Ocorrencias</h2>";
            echo "<pre>" . print_r($result, true) . "</pre>";
        }
    }
    ?>
</body>
</html>
