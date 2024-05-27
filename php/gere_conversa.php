<?php
session_start();

include "navbar_CML.php";



$nome = $_SESSION['nome'];
$utilizador_nif = $_SESSION['nif'];

$ocorrencia_id = $_GET['ocorrencia_id'];

include "abreconexao.php";

$sql = "SELECT * FROM chat WHERE ocorrencia_id = $ocorrencia_id ORDER BY hora ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Responder Mensagem</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/ocorrencias.css">
        <link rel="stylesheet" href="../css/background.css">
        <link rel="stylesheet" href="../css/paginacao.css">
        <link rel="stylesheet" href="../css/pesquisa.css">
        <link rel="stylesheet" href="../css/botao.css">


        <style>




        </style>

    </head>
    <body>
    <div class="w3-row-padding w3-padding-64 w3-container">
        <div class="chat-box" id="chat-box">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="chat-message <?php echo $row['enviada_por'] == $utilizador_nif ? 'own' : 'other'; ?>">
                        <span class="sender"><?php echo $row['enviada_por'] == $utilizador_nif ? 'Você' : 'Funcionário'; ?>:</span>
                        <span class="message"><?php echo $row['mensagem']; ?></span>
                        <span class="time-date"><?php echo $row['hora']; ?></span>
                    </div>
                <?php }
            } else {
                echo "<p>Nenhuma mensagem ainda. Seja o primeiro a enviar uma mensagem!</p>";
            }
            ?>
        </div>
        <form id="chat-form" class="w3-container w3-padding-16 w3-light-grey">
            <input type="hidden" id="ocorrencia_id" name="ocorrencia_id" value="<?php echo $ocorrencia_id; ?>">
            <input type="hidden" id="ID_utilizador" name="ID_utilizador" value="<?php echo $utilizador_nif; ?>">
            <input type="hidden" id="sender" name="sender" value="<?php echo $nome; ?>">
            <input class="w3-input w3-border" type="text" id="mensagem" name="mensagem" placeholder="Escreva a sua mensagem" required>
            <button class="w3-button w3-blue w3-margin-top" type="submit">Enviar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#chat-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'enviar_mensagem.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#mensagem').val('');
                        $('#chat-box').append(response);
                    }
                });
            });

            // Função para carregar novas mensagens
            function carregarMensagens() {
                $.ajax({
                    url: 'carregar_mensagens.php',
                    data: { ocorrencia_id: <?php echo json_encode($ocorrencia_id); ?> },
                    success: function(response) {
                        $('#chat-box').html(response);
                    }
                });
            }

            // Carregar novas mensagens a cada 5 minutos
            setInterval(carregarMensagens, 300000);
        });

    </script>
    </body>
</html>

<?php $conn->close(); ?>
