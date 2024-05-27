<?php
require_once "../lib/nusoap.php";

function ListaOcorrencias($CatOcorr, $EstadoOcorr)
{
    include "abreconexao.php";

    $CatOcorr = mysqli_real_escape_string($conn, $CatOcorr);
    $EstadoOcorr = mysqli_real_escape_string($conn, $EstadoOcorr);

    $query = "SELECT descricao, foto, subcategoria, localizacao FROM Ocorrencia WHERE categoria = '$CatOcorr' AND estado = '$EstadoOcorr'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $occurrences = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $occurrences[] = $row;
        }

        return $occurrences;
    } else {
        return "No occurrences found for the provided category and state.";
    }
}

$server = new soap_server();


$server->configureWSDL('ocorrenciaswsdl', 'urn:ocorrenciaswsdl');


$server->register(
    "ListaOcorrencias",
 
    array('CatOcorr' => 'xsd:string', 'EstadoOcorr' => 'xsd:string'),

    array('return' => 'xsd:Array'),

    'urn:ocorrenciaswsdl',
    
    'urn:ocorrenciaswsdl#ListaOcorrencias',

    'rpc',

    'encoded'
);

@$server->service(file_get_contents("php://input"));
?>
