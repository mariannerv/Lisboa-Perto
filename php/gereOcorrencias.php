
<?php
session_start();



if (!isset($_SESSION['ID_funcionario'])) {
    
    header("Location: loginCML.php");
    exit();
}
?>

<?php include_once "navbar_CML.php"; ?>
<!DOCTYPE html>
<html>
<head> 
    <title>Pesquisa de Ocorrências</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    <link rel="stylesheet" href="../css/background.css">
    





<!-- 

<title>Pesquisa de Ocorrências</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 -->



    <style>
        /* body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
        .w3-row-padding img {margin-bottom: 12px}
        /* Set the width of the sidebar to 120px */
        /* .w3-sidebar {width: 120px;background: #005109;} */
        /* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
        /* .w3-sidebar a {
            color: white;
        }
        #main {margin-left: 120px} */
        /* Remove margins from "page content" on small screens */
        /* @media only screen and (max-width: 600px) {#main {margin-left: 0}} */ */

        form {
            margin-top: 50px;
            max-width: 1000px;
            border: 1px solid #ddd; 
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #fbf97c; 
            color: black; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3; 
            color: white; 
        }

        label, input, select {
            display: block;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .ocorrencia-container {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }


        .ocorrencia-container h3,
        .form-container h3 {
            margin-top: 1;
        }

    </style>
</head>
<body class="w3-white">

<h2 style="text-align: center;">Pesquisa de Ocorrências para Funcionários: </h2>
<br>


<div class="panel">
        <form id="filterForm" action="gereOcorrencias.php" method="GET">
        
        <div class="search-bar">
            <input type="text" id="search" name="search" placeholder="Pesquisar por título" onkeyup="showOccurrences()">
        </div>
        <label for="categoria">Categoria</label>
            <select id="categoria" name="categoria" >
                <option value="">Select Categoria</option>
                <option value="Passeios e Acessibilidades">Passeios e Acessibilidades</option>
                <option value="Higiene Urbana">Higiene Urbana</option>
                <option value="Iluminação Pública">Iluminação Pública</option>
                <option value="Estradas e Ciclovias">Estradas e Ciclovias</option>
                <option value="Árvores e espaços verdes">Árvores e espaços verdes</option>
                <option value="Equipamentos Municipais - Desporto">Equipamentos Municipais - Desporto</option>
                <option value="Segurança pública e ruído">Segurança pública e ruído</option>
                <option value="Saneamento">Saneamento</option>
                <option value="Habitação municipal">Habitação municipal</option>
                <option value="Animais em ambiente urbano">Animais em ambiente urbano</option>
                <option value="Equipamentos Municipais - cultura">Equipamentos Municipais - cultura</option>
                <option value="Equipamentos municipais - educação">Equipamentos municipais - educação</option>
            </select>

            <label for="subCategoria">Subcategoria</label>
            <select id="subCategoria" name="subCategoria">
                <option value="">Select Subcategoria</option>
            </select>

            <p>Data: (YYYY-MM-DD)  <input type="text" name="data" pattern="\d{4}-\d{2}-\d{2}" title="Data"></p>

            <label for="localizacao">Localização</label>
            <input type="text" id="localizacao" name="localizacao">
            <button type="submit">Pesquisar</button>
            <button type="button" onclick="clearFilters()">Limpar Filtros</button>
        </form>
        <script src="../scripts/subcategoria.js"></script> 
    </div>


<div class="projcard-container" id="ocorrencia-container">

<?php
include "abreconexao.php";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Ocorrencia WHERE 1=1";

    if (isset($_GET['categoria']) && $_GET['categoria'] !== '') {
        $categoria = $conn->real_escape_string($_GET['categoria']);
        $sql .= " AND categoria = '$categoria'";
    }

    if (isset($_GET['subCategoria']) && $_GET['subCategoria'] !== '') {
        $subCategoria = $conn->real_escape_string($_GET['subCategoria']);
        $sql .= " AND subCategoria = '$subCategoria'";
    }

    if (isset($_GET['data']) && $_GET['data'] !== '') {
        $data = $conn->real_escape_string($_GET['data']);
        $sql .= " AND data_inicio = '$data'";
    }

    if (isset($_GET['localizacao']) && $_GET['localizacao'] !== '') {
        $localizacao = $conn->real_escape_string($_GET['localizacao']);
        $sql .= " AND localizacao = '$localizacao'";
    }

  
    if(isset($_GET['estado']) && !empty($_GET['estado'])) {
        $estado = $_GET['estado'];
        $sql .= " AND estado = '$estado'";
    }


    if(isset($_GET['gravidade']) && !empty($_GET['gravidade'])) {
        $gravidade = $_GET['gravidade'];
        $sql .= " AND gravidade = '$gravidade'";
    }

    if(isset($_GET['urgencia']) && !empty($_GET['urgencia'])) {
        $urgencia = $_GET['urgencia'];
        $sql .= " AND urgencia = '$urgencia'";
    }

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $conn->real_escape_string($_GET['search']);
        $sql .= " AND titulo LIKE '%$searchTerm%'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Display occurrence details
            echo "<div class='ocorrencia-container'>";
            echo "<h3>ID: " . $row["ID_Ocorrencia"] . "</h3>";
            echo "<p>Localidade: " . $row["localizacao"] . "</p>";
            echo "<p>Gravidade: " . $row["gravidade"] . "</p>";
            echo "<p>Urgência: " . $row["urgencia"] . "</p>";
            echo "<p>Estado: " . $row["estado"] . "</p>";
            echo "<p>Descrição: " . $row["descricao"] . "</p>";

            // Query to get the name of the corresponding state
            $sqlEstado = "SELECT nome FROM estado WHERE id = " . $row["estado"];
            $resultEstado = $conn->query($sqlEstado);
            if ($resultEstado->num_rows > 0) {
                $rowEstado = $resultEstado->fetch_assoc();
                echo "<p>Estado: " . $rowEstado["nome"] . "</p>";
            }
            echo "</div>";
            // Adicionar botão para alterar o estado para "Resolvido"

            // Botão para editar dados

            echo "<div id='formulario_" . $row["ID_Ocorrencia"] . "' style='display: none;'>";
            echo "<form id='form_edicao_" . $row["ID_Ocorrencia"] . "' action='editar_dados.php' method='post'>";
            echo "<input type='hidden' name='ocorrencia_id' value='" . $row["ID_Ocorrencia"] . "'>";
            echo "<label for='nova_gravidade'>Nova Gravidade:</label>";
            echo "<select id='nova_gravidade' name='nova_gravidade' class='w3-select'>";
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
            echo "<option value='5'>5</option>";
            echo "</select>";
            echo "<label for='nova_urgencia'>Nova Urgência:</label>";
            echo "<select id='nova_urgencia' name='nova_urgencia' class='w3-select'>";
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
            echo "<option value='5'>5</option>";
            echo "</select>";
            echo "<label for='novo_estado'>Novo Estado:</label>";
            echo "<select id='novo_estado' name='novo_estado' class='w3-select'>";
            echo "<option value='Resolvido'>Resolvido</option>";
            echo "<option value='Em Analise'>Em Análise</option>";
            echo "<option value='Ativo'>Ativo</option>";
            echo "</select>";
            echo "<input type='submit' value='confirmar'>";
            echo "<input type='button' value='voltar' onclick='ocultarFormulario(\"" . $row["ID_Ocorrencia"] . "\")'>";
            echo "</form>";
            echo "</div>";
            echo "<button id='button_editar_" . $row["ID_Ocorrencia"] . "' onclick='mostrarFormulario(\"" . $row["ID_Ocorrencia"] . "\")' style='text-decoration: none; margin-left: 0; margin-top: 5px; cursor: pointer; border-radius: 5px;'>editar</button>";
        }


    } else {
        echo "Nenhuma ocorrência encontrada.";
    }

    $conn->close();
?>

<script>
function mostrarFormulario(id) {
    console.log("mostrarFormulario function called with ID: " + id);
    var formulario = document.getElementById("formulario_" + id);
    var confirmar = document.querySelector("#formulario_" + id + " input[type='submit']");
    var voltar = document.querySelector("#formulario_" + id + " input[type='button']");
    var editar = document.getElementById("button_editar_" + id);

    console.log("Formulario: ", formulario);
    console.log("Confirmar: ", confirmar);
    console.log("Voltar: ", voltar);
    console.log("Editar: ", editar);

    formulario.style.display = "block";
    confirmar.style.display = "inline-block";
    voltar.style.display = "inline-block";
    editar.style.display = "none";
}

function ocultarFormulario(id) {
    console.log("ocultarFormulario function called with ID: " + id);
    var formulario = document.getElementById("formulario_" + id);
    var confirmar = document.querySelector("#formulario_" + id + " input[type='submit']");
    var voltar = document.querySelector("#formulario_" + id + " input[type='button']");
    var editar = document.getElementById("button_editar_" + id);

    console.log("Formulario: ", formulario);
    console.log("Confirmar: ", confirmar);
    console.log("Voltar: ", voltar);
    console.log("Editar: ", editar);

    formulario.style.display = "none";
    confirmar.style.display = "none";
    voltar.style.display = "none";
    editar.style.display = "inline-block";
}

</script>
<script>
    function showOccurrences() {
        var searchTerm = document.getElementById("search").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ocorrencia-container").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "pesquisaCML.php?search=" + searchTerm, true);
        xhttp.send();
    }
</script>
<script>
    function clearFilters() {
        
         window.location.href = "gereOcorrencias.php";
        
    }
</script>
</body>
</html>