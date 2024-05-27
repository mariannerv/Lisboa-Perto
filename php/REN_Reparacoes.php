<?php
require_once "../nusoap/lib/nusoap.php";

function ListaOcorrencias($CatOcorr, $EstadoOcorr)
{
    $dbhost = "appserver-01.alunos.di.fc.ul.pt";
    $dbuser = "asw24";
    $dbpass = "grupo2424";
    $dbname = "asw24";

    // Create a database connection
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        return "Database connection failed: " . mysqli_connect_error();
    }

    // Execute the SQL query
    $sql = "SELECT descricao, foto, subCategoria, localizacao FROM Ocorrencia WHERE categoria = '$CatOcorr' AND estado = '$EstadoOcorr'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return "Error executing query: " . mysqli_error($conn);
    }

    // Initialize HTML string for the table
    $html = "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    $html .= "<tr>
                <th>Descrição</th>
                <th>Subcategoria</th>
                <th>Localização</th>
            </tr>";

    // Loop through each row in the result set
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { // Use MYSQLI_ASSOC to fetch associative array
        // Start a new table row
        $html .= "<tr>";
        // Output description, subcategory, and location in separate cells
        $html .= "<td>" . $row['descricao'] . "</td>";
        $html .= "<td>" . $row['subCategoria'] . "</td>";
        $html .= "<td>" . $row['localizacao'] . "</td>";
        // Close the table row
        $html .= "</tr>";

        // Output the image below the row
        $imagePath = 'Imagens/' . $row['foto'];

        // Output the image below the row
        $html .= "<tr><td colspan='3'><img src='" . $imagePath . "' alt='Foto'></td></tr>";
    }

    // Close the table
    $html .= "</table>";

    // Close database connection
    mysqli_close($conn);

    // Return the generated HTML
    return $html;
}


// Configure SOAP server
$server = new soap_server();
$server->configureWSDL('cumpwsdl', 'urn:cumpwsdl');
$server->register(
    "ListaOcorrencias", 
    array('categoria' => 'xsd:string', 'estado' => 'xsd:string'), 
    array('return' => 'xsd:string'), 
    'uri:cumpwsdl', 
    'urn:cumpwsdl#ListaOcorrencias', 
    'rpc', // Style
    'encoded' // Use
);

// Process SOAP request
@$server->service(file_get_contents("php://input"));
?>
