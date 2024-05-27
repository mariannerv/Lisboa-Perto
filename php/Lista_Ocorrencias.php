<?php
require_once "../../nusoap/lib/nusoap.php";
function saudacao($nome)
{	$horas=intval(date("H"));
	if ($horas> 6 AND $horas <12)
	{
		$s= "Bom Dia ";
	} elseif ($horas>=12 AND $horas<20) {
		$s= "Boa Tarde ";
	} else
	{
		$s="Boa Noite ";
	}
	return $s."<strong>".$nome.
		"</strong>! <br> Cumprimentos de <br> <strong>nome-de-quem-presta-o-serviço</strong>";
}

$server = new soap_server();

// Vamos inserir aqui mais uma linha, na pergunta II-4

$server->register("saudacao", // nome metodo
	array('nome' => 'xsd:string'), // input
	array('return' => 'xsd:string'), // output
	'uri:cumpwsdl', // namespace
	'urn:cumpwsdl#saudacao', // SOAPAction
	'rpc', // estilo
	'encoded' // uso
);

@$server->service(file_get_contents("php://input"));

?>