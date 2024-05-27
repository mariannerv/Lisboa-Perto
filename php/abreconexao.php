  <?php
  $servername = "appserver-01.alunos.di.fc.ul.pt";
  $username = "asw24";
  $password = "grupo2424";
  $dbname = "asw24";
  // Cria a ligação à BD
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset("utf8");
  // Verifica a ligação à BD
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  ?>