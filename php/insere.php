  <?php
  echo "Inserir-se como utilizador<br>";
  // Estabelece uma ligação com a base de dados usando o programa abreconexao.php
  // A variável $conn é inicializada com a ligação estabelecida
  
  include "abreconexao.php";
  // prepare and bind
  
  $stmt = $conn->prepare( "INSERT INTO utilizador55945 (nome, idade, email, passwd) VALUES (?, ?, ?, ?)" );
  $stmt->bind_param("siss",$nome,$idade,$email,$passwd);
  
  // Bind variables to the prepared statement as parameters
  

  /* Set the parameters values and execute
  the statement again to insert another row */
  $nome = htmlspecialchars($_POST["nome"]);
  $idade = htmlspecialchars($_POST["idade"]);
  $email = htmlspecialchars($_POST["email"]); 
  $passwd = htmlspecialchars($_POST["passwd"]);
  
    if (!$nome) {
        die("Nome de utilizador obrigatorio");
    }

    if (!$idade) {
        die("Idade de utilizador obrigatoria");
    }

    if (!$email) {
        die("Email de utilizador obrigatorio");
    }

    if (!$passwd) {
        die("Password de utilizador obrigatoria");
    }




  $passwd = password_hash($passwd, PASSWORD_BCRYPT);

  $stmt->execute();
  
  
  $stmt->close();

  
  $conn->close();
  
  ?>