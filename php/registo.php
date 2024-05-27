<!DOCTYPE html>
<html lang="pt">

<head>
  <title>Registo</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" type="text/css" href="../css/registo.css" />
</head>

<body>
  
    

    <?php
    include "abreconexao.php";

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if passwords match
        if ($_POST['pass'] !== $_POST['confirmPass']) {
            $error_message = "As passwords não coincidem.";
        } else {
            // Prepare the INSERT statement
            $stmt = $conn->prepare("INSERT INTO Projeto (nome, idade, email, pass, telemovel, nif) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                die('Erro na preparação da declaração: ' . $conn->error);
            }

            $stmt->bind_param("ssssss", $nome, $idade, $email, $pass, $telemovel, $nif);

            $nome = $_POST['nome'];
            $idade = $_POST['idade'];
            $email = $_POST['email'];
            $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
            $telemovel = $_POST['telemovel'];
            $nif = $_POST['nif'];

            // Verificar se o email já existe na base de dados.
            $check_stmt = $conn->prepare("SELECT email FROM Projeto WHERE email = ?");
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                $error_message = "Este email já está registrado. Por favor, use um email diferente.";
            } else {
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    header("Location: homepage.php");
                    exit(); 
                    $success_message = "Utilizador registado com sucesso!";
                } else {
                    $error_message = "Erro ao registar utilizador.";
                }
            }

            $stmt->close();
            $check_stmt->close();
        }
    }

    $conn->close();
    ?>


  
 <?php include_once "navbar.php"; ?>
  
  <div class="container">

    <?php if (isset($error_message)) { ?>
      <p class="error_message"><?php echo $error_message; ?></p>
    <?php } elseif (isset($success_message)) { ?>
      <p><?php echo $success_message; ?></p>
    <?php } ?>
    
   

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form_registo">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required class="input_field"><br><br>

      <label for="idade">Idade:</label>
      <input type="number" id="idade" name="idade" required class="input_field"><br><br>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required class="input_field"><br><br>

      <label for="pass">Senha:</label>
      <input type="password" minlength="8" id="pass" name="pass" required class="input_field"><br><br>

      <label for="confirmPass">Confirmar Senha:</label>
      <input type="password" minlength="8" id="confirmPass" name="confirmPass" required class="input_field"><br><br>

      <label for="telemovel">Telemóvel:</label>
      <input type="text" id="telemovel" name="telemovel" required class="input_field"><br><br>

      <label for="nif">NIF:</label>
      <input type="text" id="nif" name="nif" required class="input_field"><br><br>

      <input type="submit" value="Registar" class="submit_button">
    </form>

</div>
</body>
</html>
