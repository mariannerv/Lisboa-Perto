<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" type="text/css" href="../css/formulario_atualizar.css" />
<head>
  <title>Atualização informação Utilizador</title>
</head>
<body>
<div class="container">
  <h1>Atualiza a Informação de um utilizador</h1>

  <form action="executa_atualizacao.php" method="POST" class= "form_atualizar">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" ><br><br>

    <label for="idade">Idade:</label>
    <input type="number" id="idade" name="idade" ><br><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" ><br><br>


    <label for="telemovel">Telemóvel:</label>
    <input type="text" id="telemovel" name="telemovel" ><br><br>

    <label for="nif">NIF:</label>
    <input type="text" id="nif" name="nif" ><br><br>

    <input type="submit" value="Atualizar">
  </form>
</div>
</body>
</html>
