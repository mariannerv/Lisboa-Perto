<?php
$dados_usuario = include 'busca_usuario.php';

if ($dados_usuario === false) {
    echo "Usuário não encontrado.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
</head>
<body>
    <header>
        <h1>Perfil do Usuário</h1>
    </header>
    <p>Nome: <?php echo htmlspecialchars($dados_usuario['nome']); ?></p>
    <p>Email: <?php echo htmlspecialchars($dados_usuario['email']); ?></p>
    <p>Idade: <?php echo htmlspecialchars($dados_usuario['idade']); ?></p>
    <p>NIF: <?php echo htmlspecialchars($dados_usuario['nif']); ?></p>
    <p>Telemóvel: <?php echo htmlspecialchars($dados_usuario['telemovel']); ?></p>
</body>
</html>