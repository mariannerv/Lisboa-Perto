<?php
session_start(); // Add session_start() here
?>

<div class="w3-top">
    <div class="w3-bar w3-yellow w3-card w3-left-align w3-large" style="position: relative;">
        <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-yellow"
            href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i
                class="fa fa-bars"></i></a>
        <?php
        if (isset($_SESSION["ID_funcionario"])) {
            echo '<a href="minhas_ocorrencias.php" class="w3-bar-item w3-button w3-padding-large w3-white">As Minhas ocorrências</a>';
        } else {
            echo '<a href="homepage.php" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>';
        }
        echo '<a href="ocorrencias.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Todas as ocorrências</a>';
        ?>
        <a href="about.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Sobre</a>
        <a href="feedback.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Feedback</a>

        <?php
        if (isset($_SESSION["ID_funcionario"])) {
            echo '<a href="funcionarios_CML.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white w3-right" style="position: absolute; top: 0; right: 0;">Funcionário</a>';
        } elseif (isset($_SESSION["email"])) {
            $userEmail = $_SESSION['email'];
            echo '<a href="exibe_usuario.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white w3-right" style="position: absolute; top: 0; right: 0;">' . $userEmail .  '</a>';
        } else {
            echo '<a href="login.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-white w3-right">Login</a>';
            echo '<a href="registo.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-white w3-right">Registo</a>';
        }
        ?>
    </div>

    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
        <?php
        if (isset($_SESSION["ID_funcionario"])) {
            echo '<a href="minhas_ocorrencias.php" class="w3-bar-item w3-button w3-padding-large">As Minhas ocorrências</a>';
        } else {
            echo '<a href="homepage.php" class="w3-bar-item w3-button w3-padding-large">Home</a>';
        }
        echo '<a href="ocorrencias.php" class="w3-bar-item w3-button w3-padding-large">Todas as ocorrências</a>';
        ?>
        <a href="about.php" class="w3-bar-item w3-button w3-padding-large">Sobre</a>
        <a href="feedback.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Feedback</a>


        <?php
        if (isset($_SESSION["ID_funcionario"])) {
            echo '<a href="funcionarios_CML.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white w3-right" style="position: absolute; top: 0; right: 0;">Funcionário</a>';
        } elseif (isset($_SESSION["email"])) {
            $userEmail = $_SESSION['email'];
            echo '<a href="exibe_usuario.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-hover-white w3-right" style="position: absolute; top: 0; right: 0;">' . $userEmail .  '</a>';
        } else {
            echo '<a href="login.php" class="w3-bar-item w3-button w3-padding-large">Login</a>';
            echo '<a href="registo.php" class="w3-bar-item w3-button w3-padding-large">Registo</a>';
        }
        ?>
    </div>
</div>
