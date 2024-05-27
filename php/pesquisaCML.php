<?php
// Include database connection file
include_once "abreconexao.php";

$searchTerm = $_GET['search'];

$searchTerm = $conn->real_escape_string($searchTerm);


$query = "SELECT * FROM Ocorrencia WHERE estado = 'Ativo' AND titulo LIKE '%$searchTerm%'";


$result = $conn->query($query);


if ($result && $result->num_rows > 0) {
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
            echo "<option value='Em Análise'>Em Análise</option>";
            echo "<option value='Ativo'>Ativo</option>";
            echo "</select>";
            echo "<input type='submit' value='confirmar'>";
            echo "<input type='button' value='voltar' onclick='ocultarFormulario(\"" . $row["ID_Ocorrencia"] . "\")'>";
            echo "</form>";
            echo "</div>";
            echo "<button id='button_editar_" . $row["ID_Ocorrencia"] . "' onclick='mostrarFormulario(\"" . $row["ID_Ocorrencia"] . "\")' style='text-decoration: none; margin-left: 0; margin-top: 5px; cursor: pointer; border-radius: 5px;'>editar</button>";
        }
} else {

    echo '<h3>Nenhuma ocorrência encontrada</h3>';
}


$conn->close();
?>
