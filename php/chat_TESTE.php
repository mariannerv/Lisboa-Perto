<?php include_once "navbar.php"; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/ocorrencias.css">
    <link rel="stylesheet" href="../css/background.css">
    <link rel="stylesheet" href="../css/paginacao.css">
    <link rel="stylesheet" href="../css/pesquisa.css">
    <link rel="stylesheet" href="../css/botao.css">
    <link rel="stylesheet" href="../css/chat.css">
</head>

<body>
<div class="w3-row-padding w3-padding-64 w3-container w3-center">
    <div class="chat-box w3-container w3-center" id="chat-box">
        <?php 
       
        include "abreconexao.php";
        session_start();
        
        $chat_id = $conn->real_escape_string($_GET['chat_id']);
        $ocorrencia_id = $conn->real_escape_string($_GET['ID_Ocorrencia']);

        // Obter mensagens do chat
        $sql = "SELECT * FROM chat WHERE ocorrencia_id = $ocorrencia_id ORDER BY hora ASC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { 
                $messageClass = $row['enviada_por'] == $nome ? 'own' : ($row['enviada_por'] == 'employee' ? 'employee' : 'other'); ?>
                <div class="chat-message <?php echo $messageClass; ?>">
                    <span class="sender"><?php echo $row['enviada_por'] == $nome ? 'Você' : 'Funcionário'; ?>:</span>
                    <span class="message"><?php echo $row['mensagem']; ?></span>
                    <span class="time-date"><?php echo $row['hora']; ?></span>
                </div>
            <?php } 
        } else {
            echo "<p>Conversa sobre a ocorrência com ID " . $ocorrencia_id . "</p>";
        }
        ?>
    </div>
    <div id="chat-form-container">
        <form id="chat-form" class="w3-light-grey w3-round-large w3-padding">
            <input type="hidden" id="ocorrencia_id" name="ocorrencia_id" value="<?php echo $ocorrencia_id; ?>">
            <input type="hidden" id="chat_id" name="chat_id" value="<?php echo $chat_id; ?>">
            <input type="hidden" id="sender" name="sender" value="<?php echo $nome; ?>">
            <input type="hidden" id="employee" name="employee" value="<?php echo $_GET['employee']; ?>">
            <input class="w3-input w3-border" type="text" id="mensagem" name="mensagem" placeholder="Escreva a sua mensagem" required>
            <button class="w3-button w3-blue w3-margin-top" type="submit">Enviar</button>
            <button id="terminate-chat-button" class="w3-button w3-red w3-margin-top" type="button">Terminar Chat</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var lastMessageTimestamp = '1970-01-01T00:00:00Z';

    $(document).ready(function() {
        // Function to load messages from the server
        function loadMessages() {
            $.ajax({
                url: 'carregar_mensagem.php',
                data: {
                    ocorrencia_id: '<?php echo $ocorrencia_id; ?>',
                    chat_id: '<?php echo $chat_id; ?>',
                    last_timestamp: lastMessageTimestamp
                },
                success: function(response) {
                    if (response.trim() !== '') {
                        // Remove duplicate messages before appending
                        $('#chat-box').html(response);
                        
                        // Update lastMessageTimestamp
                        var lastMessageDate = $('#chat-box').find('.time-date').last().text();
                        lastMessageTimestamp = new Date(lastMessageDate).toISOString();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error loading messages:", error);
                }
            });
        }

        // Load messages initially
        loadMessages();

        // Set interval to load messages every 2 seconds
        setInterval(loadMessages, 2000);

        // Submitting a message
        $('#chat-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'enviar_mensagem.php',
                data: $(this).serialize(),
                success: function(response) {
                    $('#mensagem').val('');
                    
                    // Append the new message
                    $('#chat-box').append(response);
                    
                    // Update lastMessageTimestamp
                    var lastMessageDate = $('#chat-box').find('.time-date').last().text();
                    lastMessageTimestamp = new Date(lastMessageDate).toISOString();
                }
            });
        });

        // Terminating the chat
        $('#terminate-chat-button').click(function() {
            var chatId = $('#chat_id').val();
            $.ajax({
                type: 'POST',
                url: 'terminar_chat.php',
                data: { chat_id: chatId },
                success: function(response) {
                    console.log("Chat terminated successfully");
                    window.location.href = 'ocorrencias.php';
                },
                error: function(xhr, status, error) {
                    console.error("Error terminating chat:", error);
                }
            });
        });
    });
</script>
</body>
</html>
